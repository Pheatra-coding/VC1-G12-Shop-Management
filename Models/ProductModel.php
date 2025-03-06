<?php
class ProductModel {
    private $db;
    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getProduct() {
        $result = $this->db->query("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductById($id) {
        $result = $this->db->query("SELECT * FROM prodcuts WHERE id = :id", ['id' => $id]);
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function addProduct($image, $name, $end_date,  $barcode, $price, $amount ) {
              $result = $this->db->query("INSERT INTO products (image, name, end_date, barcode, price, amount) VALUES (:image, :name, :end_date, :barcode, :price, :amount)", [
                  'image' => $image,
                  'name' => $name,
                  'end_date' => $end_date,
                  'barcode' => $barcode,
                  'price' => $price,
                  'amount' => $amount,
              ]);
        return $result;
    }

}

