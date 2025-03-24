<?php

// WelcomeController.php
class WelcomeController extends BaseController {
    private $lowStockModel;

    public function __construct() {
        // Initialize LowStockAlertModel to access low stock data
        $this->lowStockModel = new LowStockAlertModel();
    }

    public function welcome() {
        // Get low stock data
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10); // Adjust threshold as needed
        $lowStockCount = $this->lowStockModel->countLowStockProducts(10); // Count low stock items
        
        // Pass the low stock data to the view along with other data
        $this->view('welcome/welcome', [
            'lowStockProducts' => $lowStockProducts,
            'lowStockCount' => $lowStockCount
        ]);
    }
}
