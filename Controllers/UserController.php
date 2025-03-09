<?php

require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $users;

    public function __construct() {
        $this->users = new UserModel();
    }

    public function index() {
        session_start();
        $users = $this->users->getUsers(); // Fetch users from the database
        $this->view('users/user_list', ['users' => $users]); // Pass data to the view
    }

    public function create() {
        session_start();
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /users"); 
            exit();
        }
        $this->view("users/create");
    }

    public function store() {
        session_start();
    
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /users");
            exit();
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $passwordEncrypt = password_hash($password, PASSWORD_DEFAULT);
        $role = $_POST['role'];

        // Handle Image Upload
        $image = $_FILES['image']['name'] ?? null;

        // Check if an image was uploaded
        if ($image) {
            $targetDir = "uploads/"; // Specify the directory where the image will be saved
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "The file has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Save the user data with image path
        $this->users->addUser($name, $email, $passwordEncrypt, $role, $image);

        // Redirect to the users list page
        $this->redirect('/users');
    }

    public function edit($id) {
        session_start();
        
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /users"); 
            exit();
        }

        $user = $this->users->getUserById($id);
        if ($user) {
            $this->view("users/edit", ['user' => $user]); // Pass the user data to the edit view
        } else {
            // Handle user not found (e.g., redirect or show error)
            $this->redirect('/users');
        }
    }

    public function update($id) {
        session_start();
        
        // Ensure user is an admin before allowing update
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header("Location: /users"); 
            exit();
        }

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password']; // Might be empty if not changing
        $role = $_POST['role'];
    
        // Handle Image Upload
        $image = $_FILES['image']['name'] ?? null;

        // Check if an image was uploaded
        if ($image) {
            $targetDir = "uploads/"; // Specify the directory where the image will be saved
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);

            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "The file has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            // If no new image is uploaded, you may want to keep the old one
            $existingUser = $this->users->getUserById($id);
            $image = $existingUser['image'];
        }

        // Update the user data
        $this->users->updateUser($id, $name, $email, $password, $role, $image);
    
        // Redirect to the users list page
        $this->redirect('/users');
    }

    //show login
    public function login() {
        session_start();
        if (isset($_SESSION['user_role'])) {
            $this->redirect('/');
        }
        $this->view("users/login");
    }

    public function authenticate() {
        session_start();
        
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        
        // Store the entered email for user experience
        $_SESSION['old_email'] = $email;
    
        // Initialize errors
        $_SESSION['errors'] = [];
        
        // Check if the email exists
        $user = $this->users->getUserByEmail($email);
        
        if (!$user) {
            $_SESSION['errors']['email'] = "This email is not registered.";
        } else {
            // Debugging the password
            var_dump($password); // The raw password entered by the user
            var_dump($user['password']); // The hashed password from the database
            var_dump(password_verify($password, $user['password'])); // Verify result (true/false)
    
            if (!password_verify($password, $user['password'])) {
                $_SESSION['errors']['password'] = "Incorrect password.";
            }
        }
    
        // If there are errors, redirect to login page
        if (!empty($_SESSION['errors'])) {
            header("Location: /users/login");
            exit();
        }
        
        // Successful login
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['users'] = true;
        
        $this->redirect("/");
    }
    
    

    public function logout() {
        session_start();
        session_unset();
        // Destroy the session
        session_destroy();
        header("Location: /");
    } 
}