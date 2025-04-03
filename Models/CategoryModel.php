<?php

class CategoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    // Get all categories with their products
    public function getCategories() {
        $query = "SELECT * FROM categories";
        $categories = $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($categories as &$category) {
            $category['products'] = $this->getProductsByCategoryId($category['id']);
        }

        return $categories;
    }

    // Get products by category ID
    public function getProductsByCategoryId($categoryId) {
        $query = "SELECT * FROM products WHERE category_id = :category_id";
        return $this->db->query($query, [':category_id' => $categoryId])->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getCategoryById($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        return $this->db->query($query, [':id' => $id])->fetch(PDO::FETCH_ASSOC);
    }
    public function addCategory($name) {
        $query = "INSERT INTO categories (category_name) VALUES (:category_name)";
        return $this->db->query($query, [':category_name' => $name]);
    }
    
    public function updateCategory($id, $name) {
        $query = "UPDATE categories SET category_name = :category_name WHERE id = :id";
        return $this->db->query($query, [':id' => $id, ':category_name' => $name]);
    }
    // Delete category
    public function deleteCategory($id) {
        $query = "DELETE FROM categories WHERE id = :id";
        return $this->db->query($query, [':id' => $id]);
    }

}
