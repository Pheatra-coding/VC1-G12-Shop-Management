<?php
class InventoryModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", ""); // Update as needed
    }

    // Function to get the total quantity of all products in stock
    public function getTotalQuantity($filter = null) {
        $query = "SELECT SUM(quantity) AS total_quantity FROM products";

        // If you have specific filtering (for example, by year), you can modify the query
        // Example: filter by specific time period or other criteria
        if ($filter == 'this_year') {
            $query .= " WHERE YEAR(created_at) = YEAR(CURDATE())";
        }

        $result = $this->db->query($query);
        $data = $result->fetch(PDO::FETCH_ASSOC);
        
        return $data['total_quantity'] ?? 0;
    }
}
