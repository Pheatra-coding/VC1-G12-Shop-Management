<?php
require_once "models/SaleModel.php";

class SaleController extends BaseController {
    private $saleModel;

    public function __construct() {
        $this->saleModel = new SaleModel();
    }

    public function getSalesSummary() {
        $daily = $this->saleModel->getDailySales();
        $weekly = $this->saleModel->getWeeklySales();
        $monthly = $this->saleModel->getMonthlySales();

        return [
            'daily' => $daily,
            'weekly' => $weekly,
            'monthly' => $monthly
        ];
    }
}
?>