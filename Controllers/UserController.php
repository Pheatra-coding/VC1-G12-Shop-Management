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
        $passwordEncrypt = password_hash($password, PASSWORD_BCRYPT);
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
    
    
}

