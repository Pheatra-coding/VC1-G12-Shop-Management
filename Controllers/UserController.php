<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php'; // Ensure PHPMailer is included
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

    //store user 
    public function store() {
        session_start();
        $this->checkAdmin();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $role = $_POST['role'];
        $image = $this->handleImageUpload();
        
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

    //update users
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

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['errors']['login'] = "Invalid email or password.";
            header("Location: /users/login");
            exit();
        }
        
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_role'] = $user['role'];
        $_SESSION['user_image'] = $user['image'];
        $_SESSION['users'] = true;
        
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
    

    public function forgotPassword() {
        session_start();
        $this->view("users/forgotPassword", [
            'success' => $_SESSION['success'] ?? null,
            'error' => $_SESSION['error'] ?? null
        ]);
        unset($_SESSION['success'], $_SESSION['error']);
    }
     
    public function resetPassword() {
        session_start();
        
        if (!isset($_GET['token'])) {
            $_SESSION['error'] = "Invalid or missing reset token.";
            header("Location: /forgotPassword");
            exit();
        }
    
        // Check if the token exists in the database
        $user = $this->users->getUserByToken($_GET['token']);
        
        if (!$user) {
            $_SESSION['error'] = "Invalid reset token.";
            header("Location: /forgotPassword");
            exit();
        }
    
        // Show reset password form
        $this->view("users/resetPassword", ['token' => $_GET['token']]);
    }
    
    public function sendResetLink() {
        session_start();
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $_SESSION['emailOne'] = $email;
    
            $userModel = new UserModel();
    
            // Check if user exists
            if (!$userModel->getUserByEmail($email)) {
                $_SESSION['error'] = "No user found with this email.";
                header("Location: /forgotPassword");
                exit();
            }
    
            // Generate a unique reset token
            $resetToken = bin2hex(random_bytes(50));
    
            // Save reset token to the database
            $userModel->saveResetToken($email, $resetToken);
    
            // Create reset link
            $resetLink = "http://yourdomain.com/resetPassword?token=" . $resetToken;
    
            // Send Email
            $mail = new PHPMailer(true);
            try {
                // SMTP Settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com';
                $mail->SMTPAuth   = true;
                $mail->Username   = 'your_email@gmail.com'; // Use .env for security
                $mail->Password   = 'your_app_password'; 
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port       = 465;
    
                // Recipients
                $mail->setFrom('your_email@gmail.com', 'POS SYSTEM');
                $mail->addAddress($email, 'User');
    
                // Email Content
                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body    = "
                    <h1>Hello,</h1>
                    <p>Click the link below to reset your password:</p>
                    <a href='$resetLink'>$resetLink</a>
                    <p>If you did not request this, ignore this email.</p>
                ";
    
                $mail->send();
                $_SESSION['success'] = "Reset link sent to your email!";
                header("Location: /forgotPassword");
                exit();
            } catch (Exception $e) {
                $_SESSION['error'] = "Failed to send email. Error: {$mail->ErrorInfo}";
                header("Location: /forgotPassword");
                exit();
            }
        } else {
            header("Location: /forgotPassword");
            exit();
        }
    }
    
    

}

