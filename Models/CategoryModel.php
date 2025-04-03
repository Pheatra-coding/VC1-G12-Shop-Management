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

}
