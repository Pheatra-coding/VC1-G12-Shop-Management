<?php
class TopSellingModel {
    private $db;
    
    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }
    
    // TopSelling
    public function getTopSellingProducts() {
        $sql = "
            SELECT p.id, p.name, p.image, p.price, p.quantity, 
                IFNULL(SUM(s.quantity), 0) as total_sold, 
                MAX(s.sale_date) as last_sale_date
            FROM products p
            LEFT JOIN sales s ON p.id = s.product_id
            GROUP BY p.id, p.name, p.image, p.price, p.quantity
            HAVING total_sold > 50
            ORDER BY total_sold DESC
        ";
        
        // Fetch and return the results as an associative array
        return $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    
}