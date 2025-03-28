<?php
require_once 'Models/SalesModel.php';

class SalesController extends BaseController {
    private $salesModel;

    public function __construct() {
        $this->salesModel = new SalesModel();
    }

    public function getSales() {
        $period = $_GET['period'] ?? 'today';
        
        $currentData = $this->salesModel->getSalesData($period);
        $previousData = $this->salesModel->getPreviousSalesData($period);

        // Calculate percentage change
        $percentage = 0;
        if ($previousData['total_amount'] > 0) {
            $difference = $currentData['total_amount'] - $previousData['total_amount'];
            $percentage = round(($difference / $previousData['total_amount']) * 100, 2);
        }

        $response = [
            'total_amount' => number_format($currentData['total_amount'], 2),
            'total_sold' => $currentData['total_sold'],
            'percentage' => abs($percentage)
        ];

        header('Content-Type: application/json');
        echo json_encode($response);
    }
}