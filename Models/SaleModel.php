<?php
class SaleModel {
    private $db;

    public function __construct() {
        try {
            // Direct PDO connection
            $this->db = new PDO(
                "mysql:host=localhost;dbname=shop_management",
                "root",
                "",
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    // Helper method to get sales data and calculate change
    private function getSalesData($currentQuery, $previousQuery) {
        // Current period
        $stmt = $this->db->prepare($currentQuery);
        $stmt->execute();
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentTotal = $current['total_price'] ?? 0;

        // Previous period for comparison
        $stmt = $this->db->prepare($previousQuery);
        $stmt->execute();
        $previous = $stmt->fetch(PDO::FETCH_ASSOC);
        $previousTotal = $previous['total_price'] ?? 0;

        // Calculate percentage change
        $percentage = 0;
        $trend = '';
        if ($previousTotal > 0) {
            $difference = $currentTotal - $previousTotal;
            $percentage = round(($difference / $previousTotal) * 100, 1);
            $trend = $percentage > 0 ? 'increase' : ($percentage < 0 ? 'decrease' : 'no-change');
        } else {
            $trend = $currentTotal > 0 ? 'increase' : 'no-change';
            $percentage = $currentTotal > 0 ? 100 : 0;
        }

        return [
            'total' => $currentTotal,
            'percentage' => abs($percentage),
            'trend' => $trend
        ];
    }

    public function getDailySales() {
        $currentQuery = "SELECT SUM(total_price) as total_price 
                        FROM sales 
                        WHERE DATE(sale_date) = CURDATE() 
                        AND status = 'completed'";
        
        $previousQuery = "SELECT SUM(total_price) as total_price 
                         FROM sales 
                         WHERE DATE(sale_date) = DATE_SUB(CURDATE(), INTERVAL 1 DAY) 
                         AND status = 'completed'";
        
        return $this->getSalesData($currentQuery, $previousQuery);
    }

    public function getWeeklySales() {
        $currentQuery = "SELECT SUM(total_price) as total_price 
                        FROM sales 
                        WHERE WEEK(sale_date) = WEEK(CURDATE()) 
                        AND YEAR(sale_date) = YEAR(CURDATE())
                        AND status = 'completed'";
        
        $previousQuery = "SELECT SUM(total_price) as total_price 
                         FROM sales 
                         WHERE WEEK(sale_date) = WEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK)) 
                         AND YEAR(sale_date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 WEEK))
                         AND status = 'completed'";
        
        return $this->getSalesData($currentQuery, $previousQuery);
    }

    public function getMonthlySales() {
        $currentQuery = "SELECT SUM(total_price) as total_price 
                        FROM sales 
                        WHERE MONTH(sale_date) = MONTH(CURDATE()) 
                        AND YEAR(sale_date) = YEAR(CURDATE())
                        AND status = 'completed'";
        
        $previousQuery = "SELECT SUM(total_price) as total_price 
                         FROM sales 
                         WHERE MONTH(sale_date) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                         AND YEAR(sale_date) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))
                         AND status = 'completed'";
        
        return $this->getSalesData($currentQuery, $previousQuery);
    }
}
?>