<?php
class ProductModel {
    private $db;
    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }
    // Function to get all products
    public function getProduct() {
        $result = $this->db->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to get a single product by its ID
    public function getProductById($id) {
        $result = $this->db->query("SELECT * FROM products WHERE id = :id", ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    
    // Check if the email already exists
    public function barcodelExists($barcode) {
        $query = "SELECT COUNT(*) FROM products WHERE barcode = :barcode";
        $result = $this->db->query($query, ['barcode' => $barcode]);
        return $result->fetchColumn() > 0; // Return true if count is greater than 0
    }

    // Functions add a new product
    public function addProduct($image, $name, $end_date, $barcode, $price, $quantity, $purchase_price) {
        try {
            $this->db->query(
                "INSERT INTO products (image, name, end_date, barcode, price, quantity, purchase_price) 
                 VALUES (:image, :name, :end_date, :barcode, :price, :quantity, :purchase_price)",
                [
                    ':image' => $image,
                    ':name' => $name,
                    ':end_date' => $end_date,
                    ':barcode' => $barcode,
                    ':price' => $price,
                    ':quantity' => $quantity,
                    ':purchase_price' => $purchase_price
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding product: " . $e->getMessage();
        }
    }
    
    // function to delete a products
    public function deleteProduct($id) {
        $result = $this->db->query("DELETE FROM products WHERE id = :id", ['id' => $id]);
        return $result;
    }

    // Function to update a product
    public function updateProduct($id, $image, $name, $end_date, $barcode, $price, $quantity, $purchase_price){
        $result = $this->db->query(
            "UPDATE products SET 
                image = :image, 
                name = :name, 
                end_date = :end_date, 
                barcode = :barcode, 
                price = :price, 
                quantity = :quantity,
                purchase_price = :purchase_price 
             WHERE id = :id",
            [
                ':id' => $id,
                ':image' => $image,
                ':name' => $name,
                ':end_date' => $end_date,
                ':barcode' => $barcode,
                ':price' => $price,
                ':quantity' => $quantity,
                ':purchase_price' => $purchase_price
            ]
        );
        return $result;
    }

    // Function to check if a barcode already exists
    public function getProductByBarcode($barcode, $currentProductId) {
        $stmt = $this->db->query("SELECT * FROM products WHERE barcode = :barcode AND id != :id", [
            ':barcode' => $barcode,
            ':id' => $currentProductId
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}