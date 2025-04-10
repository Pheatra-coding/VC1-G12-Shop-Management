<?php
require_once 'Models/LowStockAlertModel.php';

class LowStockAlertController extends BaseController {
    private $lowStockModel;
    public $lowStockCount; // Public variable for navbar
    private $lastAlertTime = 0;
    private $alertInterval = 600; // 10 minutes

    public function __construct() {
        $this->lowStockModel = new LowStockAlertModel();
        $this->lowStockCount = $this->lowStockModel->countLowStockProducts(10); // Count products ≤ 10
    }

    public function index() {
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10);
        
        // Auto-send alerts
        $this->autoSendAlerts($lowStockProducts);
        
        // Make sure you pass the data to the right view
        $this->view('products_alert/low_stock_alert', [
            'products' => $lowStockProducts,
            'lowStockCount' => $this->lowStockCount
        ]);
    }
    
    private function autoSendAlerts($products) {
        $currentTime = time();
        if ($currentTime - $this->lastAlertTime >= $this->alertInterval && !empty($products)) {
            $this->sendLowStockAlert($products);
            $this->lastAlertTime = $currentTime;
        }
    }

    private function sendLowStockAlert($products) {
        $message = $this->formatTelegramAlert(
            $products,
            '⚠️ Low Stock Alert!',
            function($product) {
                $name = $product['name'] ?? 'Unknown Product';
                $stock = $product['stock'] ?? $product['quantity'] ?? 'N/A';
                return "• {$name} - Stock: {$stock}";
            }
        );
        
        $this->sendTelegramMessage($message);
    }
}
?>
