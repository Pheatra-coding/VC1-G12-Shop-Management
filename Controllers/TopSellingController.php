<?php
require_once 'Models/TopSellingModel.php';

class TopSellingController extends BaseController 
{
    private $lastAlertTime = 0;
    private $alertInterval = 600; // 10 minutes

    public function index() 
    {
        $model = new TopSellingModel();
        $topSellingProducts = $model->getTopSellingProducts();
        
        // Auto-send alerts
        $this->autoSendAlerts($topSellingProducts);
        
        $this->view('sales/top_selling', [
            'products' => $topSellingProducts
        ]);
    }

    private function autoSendAlerts($products) 
    {
        $currentTime = time();
        if ($currentTime - $this->lastAlertTime >= $this->alertInterval && !empty($products)) {
            $this->sendTopSellingAlert($products);
            $this->lastAlertTime = $currentTime;
        }
    }

    private function sendTopSellingAlert($products) 
    {
        $message = $this->formatTelegramAlert(
            $products,
            '🚀 Top Selling Products Alert!',
            function($product) {
                $name = $product['name'] ?? 'Unknown Product';
                $sold = $product['sold'] ?? $product['total_sold'] ?? $product['quantity_sold'] ?? 'N/A';
                return "• {$name} - Sold: {$sold}";
            }
        );
        
        $this->sendTelegramMessage($message);
    }
}