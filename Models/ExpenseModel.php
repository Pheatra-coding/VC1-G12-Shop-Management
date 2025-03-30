<?php
class ExpenseModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getDailyExpenses() {
        $query = "SELECT SUM(purchase_price * quantity) as total 
                 FROM products 
                 WHERE DATE(created_at) = CURDATE()";
        $result = $this->db->query($query)->fetch();
        
        return [
            'total' => $result['total'] ?? 0,
            'percentage' => $this->calculatePercentage('daily'),
            'trend' => $this->calculateTrend('daily')
        ];
    }

    public function getWeeklyExpenses() {
        $query = "SELECT SUM(purchase_price * quantity) as total 
                 FROM products 
                 WHERE WEEK(created_at) = WEEK(CURDATE()) 
                 AND YEAR(created_at) = YEAR(CURDATE())";
        $result = $this->db->query($query)->fetch();
        
        return [
            'total' => $result['total'] ?? 0,
            'percentage' => $this->calculatePercentage('weekly'),
            'trend' => $this->calculateTrend('weekly')
        ];
    }

    public function getMonthlyExpenses() {
        $query = "SELECT SUM(purchase_price * quantity) as total 
                 FROM products 
                 WHERE MONTH(created_at) = MONTH(CURDATE()) 
                 AND YEAR(created_at) = YEAR(CURDATE())";
        $result = $this->db->query($query)->fetch();
        
        return [
            'total' => $result['total'] ?? 0,
            'percentage' => $this->calculatePercentage('monthly'),
            'trend' => $this->calculateTrend('monthly')
        ];
    }

    private function calculatePercentage($period) {
        // Simple percentage calculation comparing to previous period
        // You might want to adjust this logic based on your needs
        $current = $this->getCurrentPeriodTotal($period);
        $previous = $this->getPreviousPeriodTotal($period);
        
        if ($previous == 0) return '0';
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function calculateTrend($period) {
        $current = $this->getCurrentPeriodTotal($period);
        $previous = $this->getPreviousPeriodTotal($period);
        return $current >= $previous ? 'increase' : 'decrease';
    }

    private function getCurrentPeriodTotal($period) {
        $query = "SELECT SUM(purchase_price * quantity) as total FROM products WHERE ";
        switch($period) {
            case 'daily':
                $query .= "DATE(created_at) = CURDATE()";
                break;
            case 'weekly':
                $query .= "WEEK(created_at) = WEEK(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
                break;
            case 'monthly':
                $query .= "MONTH(created_at) = MONTH(CURDATE()) AND YEAR(created_at) = YEAR(CURDATE())";
                break;
        }
        return $this->db->query($query)->fetch()['total'] ?? 0;
    }

    private function getPreviousPeriodTotal($period) {
        $query = "SELECT SUM(purchase_price * quantity) as total FROM products WHERE ";
        switch($period) {
            case 'daily':
                $query .= "DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";
                break;
            case 'weekly':
                $query .= "WEEK(created_at) = WEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK))";
                break;
            case 'monthly':
                $query .= "MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";
                break;
        }
        return $this->db->query($query)->fetch()['total'] ?? 0;
    }
}
?>