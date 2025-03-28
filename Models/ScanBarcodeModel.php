<?php
class ScanBarcodeModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getProductByBarcode($barcode) {
        $query = "SELECT * FROM products WHERE TRIM(barcode) = :barcode LIMIT 1";
        $stmt = $this->db->query($query, [":barcode" => $barcode]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateProductQuantity($barcode) {
        $product = $this->getProductByBarcode($barcode);
        if ($product && $product['quantity'] > 0) {
            $newQuantity = $product['quantity'] - 1;
            $query = "UPDATE products SET quantity = :quantity WHERE barcode = :barcode";
            $this->db->query($query, [
                ":quantity" => $newQuantity,
                ":barcode" => $barcode
            ]);
            return true;
        }
        return false;
    }

    public function saveSale($product_id, $quantity, $total_price, $status) {
        $query = "INSERT INTO sales (product_id, quantity, total_price, sale_date, payment_method, status) 
                 VALUES (:product_id, :quantity, :total_price, NOW(), 'qr_code', :status)";
        $this->db->query($query, [
            ":product_id" => $product_id,
            ":quantity" => $quantity,
            ":total_price" => $total_price,
            ":status" => $status
        ]);
    }

    public function updateSalesStatus($status) {
        $query = "UPDATE sales SET status = :status WHERE status = 'pending'";
        $this->db->query($query, [":status" => $status]);
    }
}