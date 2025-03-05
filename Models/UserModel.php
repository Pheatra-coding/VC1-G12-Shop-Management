<?php
class UserModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getUsers() {
        $result = $this->db->query("SELECT * FROM users");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $result = $this->db->query("SELECT * FROM users WHERE id = :id", ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function addUser($name, $email, $password, $role, $image) {
        try {
            $this->db->query(
                "INSERT INTO users (name, email, password, role, image) VALUES (:name, :email, :password, :role, :image)",
                [
                    ':name' => $name,
                    ':email' => $email,
                    ':password' => $password,
                    ':role' => $role,
                    ':image' => $image
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding user: " . $e->getMessage();
        }
    }
}
