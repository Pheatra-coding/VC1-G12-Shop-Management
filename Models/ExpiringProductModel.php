<?php
class ExpiringProductModel {
        private $db;
    
        public function __construct() {
            $this->db = new Database("localhost", "shop_management", "root", "");
        }
    
        public function getExpiringProducts() {
            // SQL query to select products with end_date less than 2025-03-24
            $query = "SELECT * 
                FROM products 
                WHERE end_date <= CURDATE() + INTERVAL 7 DAY 
                ORDER BY end_date ASC;

                ";
            
            // Execute the query and fetch results
            $result = $this->db->query($query);
            
            // Return the fetched products
            return $result->fetchAll(PDO::FETCH_ASSOC);
        }
    }
