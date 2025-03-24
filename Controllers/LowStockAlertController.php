<?php
require_once 'Models/LowStockAlertModel.php';

class LowStockAlertController extends BaseController {
    private $lowStockModel;
    public $lowStockCount; // Public variable for navbar

    public function __construct() {
        $this->lowStockModel = new LowStockAlertModel();
        $this->lowStockCount = $this->lowStockModel->countLowStockProducts(10); // Count products ≤ 10
    }

    public function index() {
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10);
        // Make sure you pass the data to the right view
        $this->view('products_alert/low_stock_alert', [
            'products' => $lowStockProducts,
            'lowStockCount' => $this->lowStockCount
        ]);
    }
    
}
?>
