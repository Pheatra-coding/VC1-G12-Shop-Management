<?php
class LowSellingModel {
        private $db;
    
        public function __construct() {
            $this->db = new Database("localhost", "shop_management", "root", "");
        }
    
        public function getLowSellingProducts() {
            // SQL query to select products with quantity less than or equal to 100
            $query = "SELECT * FROM products WHERE quantity <= 100 ORDER BY quantity ASC";
            
            // Execute the query and fetch results
            $result = $this->db->query($query);
            
            // Return the fetched products
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }
