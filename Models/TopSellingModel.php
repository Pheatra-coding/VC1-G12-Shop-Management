<?php
class TopSellingModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }
    
    public function getTopSellingProducts() {
        // SQL query to get products with total quantity sold > 50
        $sql = "
            SELECT p.id, p.name, p.image, p.price, IFNULL(SUM(s.quantity), 0) as total_sold
            FROM products p
            LEFT JOIN sales s ON p.id = s.product_id
            GROUP BY p.id, p.name, p.image, p.price
            HAVING IFNULL(SUM(s.quantity), 0) > 50
            ORDER BY total_sold DESC
        ";
        
        // Execute query and return the results
        return $this->db->query($sql);
    }
}