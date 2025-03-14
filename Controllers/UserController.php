<?php

require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $users;

    public function __construct() {
        $this->users = new UserModel();
    }
    // show user list
    public function index() {
        session_start();
        $users = $this->users->getUsers();
        $this->view('users/user_list', ['users' => $users]);
    }

    // show create user form
    public function create() {
        session_start();
        $this->checkAdmin();
        $this->view("users/create");
    }

    // store user 
    public function store() {
        session_start();
        $this->checkAdmin();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $image = $this->handleImageUpload();
        
        // Check if the email already exists
        if ($this->users->emailExists($email)) {
            $_SESSION['errors']['email'] = "The user already exists.";
            $this->view("users/create", ['errors' => $_SESSION['errors']]);
            return; // Stop further execution
        }

        $this->users->addUser($name, $email, $password, $role, $image);
        $this->redirect('/users');
    }

    // edit users
    public function edit($id) {
        session_start();
        $this->checkAdmin();
        
        $user = $this->users->getUserById($id);
        $user ? $this->view("users/edit", ['user' => $user]) : $this->redirect('/users');
    }

    // update users
    public function update($id) {
        session_start();
        $this->checkAdmin();
        
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        
        $image = $this->handleImageUpload() ?? $this->users->getUserById($id)['image'];
        
        $this->users->updateUser($id, $name, $email, $password, $role, $image);
        $this->redirect('/users');
    }

    // login system
    public function login() {
        session_start();
        if (isset($_SESSION['user_role'])) {
            $this->redirect('/');
        }
        $this->view("users/login");
    }

    // after login show dashboard
    public function authenticate() {
        session_start();
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $_SESSION['old_email'] = $email;
        $_SESSION['errors'] = [];
    
        $user = $this->users->getUserByEmail($email);
    
        // Check if the email is valid
        if (!$user) {
            $_SESSION['errors']['email'] = "Email not found.";
        }
    
        // Check if the password is correct
        if ($user && !password_verify($password, $user['password'])) {
            $_SESSION['errors']['password'] = "Incorrect password.";
        }
    
        // If either email or password is incorrect, redirect back to the login page
        if (isset($_SESSION['errors']['email']) || isset($_SESSION['errors']['password'])) {
            header("Location: /users/login");
            exit();
        }
    
        // If login is successful, set session variables
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_image'] = $user['image'];
        $_SESSION['users'] = true;
        $_SESSION['logged_in_users'][$user['id']] = true;
        
        $this->redirect("/");
    }    
    
    // logout system 
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: /");
    }

    // check role 
    private function checkAdmin() {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Admin') {
            header("Location: /users");
            exit();
        }
    }

    // handle image upload
    private function handleImageUpload() {
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            return move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile) ? $_FILES['image']['name'] : null;
        }
        return null;
    }
    
    // delete users
    public function delete($id) {
        $this->users->deleteUser($id);
        header("Location: /users");
    }

    public function deletedUsers() {
        session_start();
        $users = $this->users->getDeletedUsers();
        $this->view('users/deleted_users', ['users' => $users]);
    }
}