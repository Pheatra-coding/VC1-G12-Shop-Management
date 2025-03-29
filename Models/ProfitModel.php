<?php
class ProfitModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    // Function to calculate profit based on time filter
    public function getProfit($filter) {
        $query = "";
        $params = [];

        switch ($filter) {
            case 'today':
                $query = "SELECT SUM(s.total_price) - SUM(p.purchase_price * s.quantity) AS profit
                          FROM sales s
                          JOIN products p ON s.product_id = p.id
                          WHERE DATE(s.sale_date) = CURDATE()";
                break;
            case 'this_week':
                $query = "SELECT SUM(s.total_price) - SUM(p.purchase_price * s.quantity) AS profit
                          FROM sales s
                          JOIN products p ON s.product_id = p.id
                          WHERE WEEK(s.sale_date) = WEEK(CURDATE()) AND YEAR(s.sale_date) = YEAR(CURDATE())";
                break;
            case 'this_month':
                $query = "SELECT SUM(s.total_price) - SUM(p.purchase_price * s.quantity) AS profit
                          FROM sales s
                          JOIN products p ON s.product_id = p.id
                          WHERE MONTH(s.sale_date) = MONTH(CURDATE()) AND YEAR(s.sale_date) = YEAR(CURDATE())";
                break;
            case 'this_year':
                $query = "SELECT SUM(s.total_price) - SUM(p.purchase_price * s.quantity) AS profit
                          FROM sales s
                          JOIN products p ON s.product_id = p.id
                          WHERE YEAR(s.sale_date) = YEAR(CURDATE())";
                break;
            default:
                return 0; // No filter provided or invalid filter
        }

        $result = $this->db->query($query, $params);
        $profit = $result->fetch(PDO::FETCH_ASSOC);
        return $profit['profit'] ?? 0;
    }
}


?>