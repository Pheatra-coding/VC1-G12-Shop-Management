<?php

// WelcomeController.php
class WelcomeController extends BaseController {
    private $lowStockModel;
    private $topSellingModel;

    public function __construct() {
        // Initialize models to access data
        $this->lowStockModel = new LowStockAlertModel();
        $this->topSellingModel = new TopSellingModel();
    }

    public function welcome() {
        // Get low stock data
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10); // Adjust threshold as needed
        $lowStockCount = $this->lowStockModel->countLowStockProducts(10); // Count low stock items
        
        // Get top-selling products
        $topSellingProducts = $this->topSellingModel->getTopSellingProducts();
        
        // Pass the data to the view
        $this->view('welcome/welcome', [
            'lowStockProducts' => $lowStockProducts,
            'lowStockCount' => $lowStockCount,
            'topSellingProducts' => $topSellingProducts,
        ]);
    }
}
