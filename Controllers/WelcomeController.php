<?php

// WelcomeController.php
class WelcomeController extends BaseController {
    private $lowStockModel;
    private $topSellingModel;
    private $salesModel;

    public function __construct() {
        // Initialize models to access data
        $this->lowStockModel = new LowStockAlertModel();
        $this->topSellingModel = new TopSellingModel();
        $this->salesModel = new SalesModel();
    }

    public function welcome() {
        // Get low stock data
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10); // Adjust threshold as needed
        $lowStockCount = $this->lowStockModel->countLowStockProducts(10); // Count low stock items
        
        // Get top-selling products
        $topSellingProducts = $this->topSellingModel->getTopSellingProducts();

        // Get sales data for all periods
        $salesToday = $this->getSalesDataWithTrend('today');
        $salesWeek = $this->getSalesDataWithTrend('week');
        $salesMonth = $this->getSalesDataWithTrend('month');
        
        // Pass the data to the view
        $this->view('welcome/welcome', [
            'lowStockProducts' => $lowStockProducts,
            'lowStockCount' => $lowStockCount,
            'topSellingProducts' => $topSellingProducts,
            'salesToday' => $salesToday,
            'salesWeek' => $salesWeek,
            'salesMonth' => $salesMonth
        ]);
    }

    private function getSalesDataWithTrend($period) {
        $currentData = $this->salesModel->getSalesData($period);
        $previousData = $this->salesModel->getPreviousSalesData($period);

        $percentage = 0;
        if ($previousData['total_quantity'] > 0) {
            $difference = $currentData['total_quantity'] - $previousData['total_quantity'];
            $percentage = round(($difference / $previousData['total_quantity']) * 100, 2);
        }

        return [
            'total_quantity' => $currentData['total_quantity'],
            'percentage' => abs($percentage),
            'trend' => $currentData['total_quantity'] > $previousData['total_quantity'] ? 'increase' : 
                      ($currentData['total_quantity'] < $previousData['total_quantity'] ? 'decrease' : 'no-change')
        ];
    }

}
