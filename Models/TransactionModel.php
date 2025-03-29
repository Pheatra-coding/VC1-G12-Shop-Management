<?php

class TransactionModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getAllTransactions() {
        // Join sales table with products table to get the product name
        $sql = "SELECT s.product_id, p.name AS product_name, s.quantity, s.total_price, s.sale_date 
                FROM sales s
                JOIN products p ON s.product_id = p.id
                ORDER BY s.sale_date DESC";
        $stmt = $this->db->query($sql);
        $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Format the sale_date in the required format
        foreach ($transactions as &$transaction) {
            $transaction['sale_date'] = (new DateTime($transaction['sale_date']))->format('d F Y');
        }

        return $transactions; // Return the formatted results
    }
}




?>
