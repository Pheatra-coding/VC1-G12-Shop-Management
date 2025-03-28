<?php
class SalesModel {
    private $db;

    public function __construct() {
        try {
            $this->db = new PDO("mysql:host=localhost;dbname=shop_management", "root", "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getSalesData($period) {
        $query = "SELECT SUM(quantity) as total_quantity 
                 FROM sales WHERE sale_date >= :date_start";
        $params = [];

        if ($period === 'today') {
            $params[':date_start'] = date('Y-m-d 00:00:00');
        } elseif ($period === 'week') {
            $params[':date_start'] = date('Y-m-d 00:00:00', strtotime('-7 days'));
        } elseif ($period === 'month') {
            $params[':date_start'] = date('Y-m-01 00:00:00');
        } else {
            return ['total_quantity' => 0];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? ['total_quantity' => 0];
    }

    public function getPreviousSalesData($period) {
        $query = "SELECT SUM(quantity) as total_quantity 
                 FROM sales WHERE sale_date BETWEEN :start AND :end";
        $params = [];

        if ($period === 'today') {
            $params[':start'] = date('Y-m-d 00:00:00', strtotime('-1 day'));
            $params[':end'] = date('Y-m-d 23:59:59', strtotime('-1 day'));
        } elseif ($period === 'week') {
            $params[':start'] = date('Y-m-d 00:00:00', strtotime('-14 days'));
            $params[':end'] = date('Y-m-d 23:59:59', strtotime('-7 days'));
        } elseif ($period === 'month') {
            $params[':start'] = date('Y-m-01 00:00:00', strtotime('-1 month'));
            $params[':end'] = date('Y-m-t 23:59:59', strtotime('-1 month'));
        } else {
            return ['total_quantity' => 0];
        }

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?? ['total_quantity' => 0];
    }
}