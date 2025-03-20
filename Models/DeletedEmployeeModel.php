<?php

class DeletedEmployeeModel {

    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getAllDeletedUsers() {
        $query = "SELECT * FROM `deleted_users` ORDER BY `deleted_at` ASC";
        return $this->db->query($query);
    }

    public function permanentlyDeleteUser($id) {
        $query = "DELETE FROM `deleted_users` WHERE `id` = ?";
        return $this->db->query($query, [$id]); 
    }

    public function restoreUser($id) {
        // Insert user data from deleted_users table to users table (excluding password)
        $query = "INSERT INTO `users` (id, name, email, role)
                  SELECT id, name, email, role
                  FROM `deleted_users` WHERE `id` = ?";
        $this->db->query($query, [$id]);
    
        // After restoring, delete the user from deleted_users table
        $deleteQuery = "DELETE FROM `deleted_users` WHERE `id` = ?";
        $this->db->query($deleteQuery, [$id]);
    }
    
    
    
}
?>
