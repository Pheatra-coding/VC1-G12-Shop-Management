<?php

class ScanBarcodeModel {
    private $db;

    public function __construct() {
        // Initialize the Database connection
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    // Function to find the product by barcode
    public function getProductByBarcode($barcode) {
        $barcode = trim($barcode);
        error_log("Searching for barcode: " . $barcode);
        $query = "SELECT * FROM products WHERE TRIM(barcode) = :barcode LIMIT 1";
        $stmt = $this->db->query($query, [":barcode" => $barcode]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($product) {
            error_log("Product found: " . print_r($product, true));
        } else {
            error_log("No product found for barcode: " . $barcode);
        }
        return $product ? $product : null;
    }

    // Function to update the quantity and total price dynamically
    public function updateProductQuantity($barcode) {
        $product = $this->getProductByBarcode($barcode);
        
        if ($product && $product['quantity'] > 0) {
            $newQuantity = $product['quantity'] - 1;
            $query = "UPDATE products SET quantity = :quantity WHERE barcode = :barcode";
            $stmt = $this->db->query($query, [
                ":quantity" => $newQuantity,
                ":barcode" => $barcode
            ]);
            
            return [
                "name" => $product['name'],
                "price" => $product['price'],
                "new_quantity" => $newQuantity,
                "total_price" => $product['price']
            ];
        }
        return false;
    }

    // NEW FUNCTION: Insert sale record into sales table
    public function recordSale($productId, $quantity, $totalPrice, $paymentMethod, $status) {
        $query = "INSERT INTO sales (product_id, quantity, total_price, sale_date, payment_method, status) 
                  VALUES (:product_id, :quantity, :total_price, NOW(), :payment_method, :status)";
        
        $params = [
            ":product_id" => $productId,
            ":quantity" => $quantity,
            ":total_price" => $totalPrice,
            ":payment_method" => $paymentMethod,
            ":status" => $status
        ];
    
        $stmt = $this->db->query($query, $params);
        
        return $stmt ? true : false;
    }
}    

?>
