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
        $result = $this->db->query("SELECT * FROM prodcuts WHERE id = :id", ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    // Functions add a new product
    public function addProduct($image, $name, $end_date, $barcode, $price, $quantity) {
        try {
            $this->db->query(
                "INSERT INTO products (image, name, end_date, barcode, price, quantity) VALUES (:image, :name, :end_date, :barcode, :price, :quantity)",
                [
                    ':image' => $image,
                    ':name' => $name,
                    ':end_date' => $end_date,
                    ':barcode' => $barcode,
                    ':price' => $price,
                    ':quantity' => $quantity
                ]
            );
        } catch (PDOException $e) {
            echo "Error adding product: " . $e->getMessage();
        }
    }

    // Function to update a product
    public function updateProduct($id, $image, $name, $end_date, $barcode, $price, $quantity) {
        $result = $this->db->query("SELECT * FROM prodcuts WHERE id = :id", ['id' => $id]);
        try {
            $this->db->query(
                "UPDATE products SET image = :image, name = :name, end_date = :end_date, barcode = :barcode, price = :price, quantity = :quantity WHERE id = :id",
                [
                    ':id' => $id,
                    ':image' => $image,
                    ':name' => $name,
                    ':end_date' => $end_date,
                    ':barcode' => $barcode,
                    ':price' => $price,
                    ':quantity' => $quantity
                ]
            );
        } catch (PDOException $e) {
            echo "Error updating product: " . $e->getMessage();
        }
    }


    
    // Function to delete a product
    public function deleteProduct($id) {
        $result = $this->db->query("DELETE FROM products WHERE id = :id", ['id' => $id]);
        return $result;
    }


   

}

