<?php
class BarchartModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    // In BarchartModel.php
public function getMonthlySalesData($year = null) {
    // Use current year if not specified
    if ($year === null) {
        $year = date('Y');
    }
    
    $sql = "SELECT 
                MONTH(sale_date) as month, 
                SUM(total_price) as total_sales 
            FROM 
                sales 
            WHERE 
                YEAR(sale_date) = ? AND 
                status = 'completed' 
            GROUP BY 
                MONTH(sale_date) 
            ORDER BY 
                month ASC";
    
    $result = $this->db->query($sql, [$year]);
    
    // Initialize an array with all months set to 0
    $monthlyData = array_fill(1, 12, 0);
    
    // Fill in actual data
    foreach ($result as $row) {
        $monthlyData[$row['month']] = floatval($row['total_sales']);
    }
    
    return array_values($monthlyData); // Convert to indexed array
}

   
}
