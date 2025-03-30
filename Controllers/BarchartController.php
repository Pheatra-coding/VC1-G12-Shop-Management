<?php
require_once 'Models/BarchartModel.php';

class BarchartController extends BaseController {
    private $barchartModel;

    public function __construct() {
        $this->barchartModel = new BarchartModel();
    }

    // In BarchartController.php
    public function getMonthlySalesData($year = null) {
        return $this->barchartModel->getMonthlySalesData($year);
    }

}
