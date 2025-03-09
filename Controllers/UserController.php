<?php

require_once 'Models/UserModel.php';

class UserController extends BaseController {
    private $users;

    public function __construct() {
        $this->users = new UserModel();
    }

    public function index() {
        $users = $this->users->getUsers(); // Fetch users from the database
        $this->view('users/user_list', ['users' => $users]); // Pass data to the view
    }

    public function create() {
        $this->view("users/create");
    }

    public function store() {
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
        $user = $this->users->getUserById($id);
        if ($user) {
            $this->view("users/edit", ['user' => $user]); // Pass the user data to the edit view
        } else {
            // Handle user not found (e.g., redirect or show error)
            $this->redirect('/users');
        }
    }

    public function update($id) {
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
    // delete users
    public function delete($id) {
        $this->users->deleteUser($id);
        header("Location: /users");
    }


    //show login
    public function login() {
        $this->view("users/login");
    }
}