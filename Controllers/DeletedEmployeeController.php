<?php

require_once 'Models/DeletedEmployeeModel.php';

class DeletedEmployeeController extends BaseController {

    private $DeletedEmployeeModel;

    public function __construct() {
        $this->DeletedEmployeeModel = new DeletedEmployeeModel();
    }

    public function index() {
        // Get the deleted users from the model
        $deletedUsers = $this->DeletedEmployeeModel->getAllDeletedUsers();

        // Pass the deleted users data to the view
        $this->view('users/deleted_users', ['deletedUsers' => $deletedUsers]);
    }

    public function permanentlyDelete($id) {
        if ($this->DeletedEmployeeModel->permanentlyDeleteUser($id)) {
            $_SESSION['success'] = "User deleted permanently!";
        } else {
            $_SESSION['error'] = "Failed to delete user.";
        }

        // Redirect back to the deleted users page
        header("Location: /users/deleted?page=" . ($_POST['page'] ?? 1));
        exit();
    }
    
    public function restore($id) {
        $this->DeletedEmployeeModel->restoreUser($id);
        header('Location: /users/deleted');
        exit;
    }
    
    
}
?>
