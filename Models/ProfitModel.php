<?php
class ProfitModel
{
    private $db;

    public function __construct()
    {
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

    // Helper method to get profit data and calculate change
    private function getProfitData($currentQuery, $previousQuery)
    {
        // Current period
        $stmt = $this->db->prepare($currentQuery);
        $stmt->execute();
        $current = $stmt->fetch(PDO::FETCH_ASSOC);
        $currentTotal = $current['total'] ?? 0;

        // Previous period for comparison
        $stmt = $this->db->prepare($previousQuery);
        $stmt->execute();
        $previous = $stmt->fetch(PDO::FETCH_ASSOC);
        $previousTotal = $previous['total'] ?? 0;

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

    public function getProfit($timePeriod)
    {
        // Adjusted query to join the sales table with products table and calculate profit
        $query = "
            SELECT SUM((p.price - p.purchase_price) * s.quantity) as total_profit 
            FROM sales s
            INNER JOIN products p ON s.product_id = p.id
            WHERE s.sale_date >= NOW() - INTERVAL $timePeriod
        ";
    
        // Execute the query
        $stmt = $this->db->query($query);
        
        // Fetch the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        // Return the total profit, or 0 if no result
        return $result ? $result['total_profit'] : 0;
    }
    
    

    public function getDailyProfit()
    {
        $currentQuery = "SELECT SUM((price - purchase_price) * quantity) AS total 
                        FROM sales 
                        WHERE DATE(created_at) = CURDATE()";

        $previousQuery = "SELECT SUM((price - purchase_price) * quantity) AS total 
                         FROM sales 
                         WHERE DATE(created_at) = DATE_SUB(CURDATE(), INTERVAL 1 DAY)";

        return $this->getProfitData($currentQuery, $previousQuery);
    }

    public function getWeeklyProfit()
    {
        $currentQuery = "SELECT SUM((price - purchase_price) * quantity) AS total 
                        FROM sales 
                        WHERE WEEK(created_at) = WEEK(CURDATE()) 
                        AND YEAR(created_at) = YEAR(CURDATE())";

        $previousQuery = "SELECT SUM((price - purchase_price) * quantity) AS total 
                         FROM sales 
                         WHERE WEEK(created_at) = WEEK(DATE_SUB(CURDATE(), INTERVAL 1 WEEK)) 
                         AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 WEEK))";

        return $this->getProfitData($currentQuery, $previousQuery);
    }

    public function getMonthlyProfit()
    {
        $currentQuery = "SELECT SUM((price - purchase_price) * quantity) AS total 
                        FROM sales 
                        WHERE MONTH(created_at) = MONTH(CURDATE()) 
                        AND YEAR(created_at) = YEAR(CURDATE())";

        $previousQuery = "SELECT SUM((price - purchase_price) * quantity) AS total 
                         FROM sales 
                         WHERE MONTH(created_at) = MONTH(DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
                         AND YEAR(created_at) = YEAR(DATE_SUB(CURDATE(), INTERVAL 1 MONTH))";

        return $this->getProfitData($currentQuery, $previousQuery);
    }
}
?>
