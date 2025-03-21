<?php

class ScanBarcodeModel {
    private $db;

    public function __construct() {
        // Initialize the Database connection (assuming you have a Database class to manage this)
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    // Function to find the product by barcode
    public function getProductByBarcode($barcode) {
        // Trim any spaces from the barcode in PHP
        $barcode = trim($barcode);

        // Log the barcode to check if it is being passed correctly
        error_log("Searching for barcode: " . $barcode);

        $query = "SELECT * FROM products WHERE TRIM(barcode) = :barcode LIMIT 1";
        $stmt = $this->db->query($query, [":barcode" => $barcode]);

        // Fetch and return the product if found, otherwise return null
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Log the fetched product for debugging
        if ($product) {
            error_log("Product found: " . print_r($product, true));
        } else {
            error_log("No product found for barcode: " . $barcode);
        }

        return $product ? $product : null; // Return null if no product is found
    }

    // Function to update the quantity of the product
    public function updateProductQuantity($barcode) {
        // Get the product by barcode
        $product = $this->getProductByBarcode($barcode);
        
        if ($product && $product['quantity'] > 0) {
            // Decrease the quantity by 1
            $newQuantity = $product['quantity'] - 1;

            // Update the quantity in the database
            $query = "UPDATE products SET quantity = :quantity WHERE barcode = :barcode";
            $stmt = $this->db->query($query, [
                ":quantity" => $newQuantity,
                ":barcode" => $barcode
            ]);
            
            // Return true if the quantity was updated successfully
            return true;
        }
        
        // Return false if product not found or quantity is 0
        return false;
    }
}
?>
