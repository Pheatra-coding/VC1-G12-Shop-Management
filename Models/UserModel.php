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

    // Check if the email already exists
    public function emailExists($email) {
        $query = "SELECT COUNT(*) FROM users WHERE email = :email";
        $result = $this->db->query($query, ['email' => $email]);
        return $result->fetchColumn() > 0; // Return true if count is greater than 0
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

    public function updateUser($id, $name, $email, $password, $role, $image) {
        try {
            // Prepare the SQL update statement
            $query = "UPDATE users SET name = :name, email = :email, role = :role, image = :image WHERE id = :id";
            $params = [
                ':id' => $id,
                ':name' => $name,
                ':email' => $email,
                ':role' => $role,
                ':image' => $image
            ];

            // Only update the password if provided
            if (!empty($password)) {
                $query = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, image = :image WHERE id = :id";
                $params[':password'] = password_hash($password, PASSWORD_DEFAULT); // Hash the password
            }

            // Execute the query
            $this->db->query($query, $params);
        } catch (PDOException $e) {
            echo "Error updating user: " . $e->getMessage();
        }
    }

    public function deleteUser($id) {
        $result = $this->db->query("DELETE FROM users WHERE id = :id", ['id' => $id]);
        return $result;
    }
}