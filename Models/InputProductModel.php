<?php
class InputProductModel {
    private $db;

    public function __construct() {
        try {
            // Database connection
            $this->db = new Database("localhost", "shop_management", "root", "");
        } catch (PDOException $e) {
            echo "Database connection failed: " . $e->getMessage();
            exit;
        }
    }
    public function getAllProducts() {
        try {
            $stmt = $this->db->query("SELECT id, name FROM products");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching products: " . $e->getMessage();
            return [];
        }
    }

    // Fetch all sales with product names
    public function getSales() {
        try {
            // Modify the SQL query to exclude 'status' and 'payment_method'
            $stmt = $this->db->query("SELECT sales.id, products.name, sales.quantity, sales.total_price, 
                                      DATE_FORMAT(sales.sale_date, '%d %b %Y') AS sale_date
                                      FROM sales
                                      JOIN products ON sales.product_id = products.id");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching sales: " . $e->getMessage();
            return [];
        }
    }
    
    
    // Method to get the database connection (pdo)
    public function getDBConnection() {
        return $this->db; // Return the database connection
    }
 
    // Method to get all products
    public function getProduct() {
        try {
            $result = $this->db->query("SELECT * FROM products");
            return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching products: " . $e->getMessage();
            return [];
        }
    }

    // Method to get sales data (example query)
    public function getSalesData() {
        try {
            $query = "
                SELECT products.name, sales.quantity, sales.total_price, sales.sale_date, sales.payment_method, sales.status
                FROM sales
                JOIN products ON sales.product_id = products.id
            ";
            $stmt = $this->db->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching sales data: " . $e->getMessage();
            return [];
        }
    }
}


