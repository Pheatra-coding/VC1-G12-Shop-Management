<?php
class InputProductModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getAllProducts() {
        $query = "SELECT id, name, price, quantity FROM products";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($productId) {
        $query = "SELECT id, name, price, quantity FROM products WHERE id = :id";
        $stmt = $this->db->query($query, [":id" => $productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function updateProductQuantity($productId, $quantity) {
        $product = $this->getProductById($productId);
        if ($product && $product['quantity'] >= $quantity) {
            $newQuantity = $product['quantity'] - $quantity;
            $query = "UPDATE products SET quantity = :quantity WHERE id = :id";
            $this->db->query($query, [
                ":quantity" => $newQuantity,
                ":id" => $productId
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

    public function getSales() {
        $query = "SELECT sales.id, products.name, sales.quantity, sales.total_price, 
                         DATE_FORMAT(sales.sale_date, '%d %b %Y') AS sale_date
                  FROM sales
                  JOIN products ON sales.product_id = products.id";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }
}