<?php
require_once 'Models/ProfitModel.php';

class ProfitController extends BaseController {
    private $ProfitModel;
    public $profit; // Public variable for navbar

    public function __construct() {
        $this->ProfitModel = new ProfitModel(new Database("localhost", "shop_management", "root", ""));
        $this->profit = $this->ProfitModel->getProfit('this_year'); // Get profit for the current year by default
    }

    public function index() {
        // Get profit data (can be filtered for Today, This Month, or This Year)
        $filter = 'this_year';  // You can dynamically change this based on user selection
        $profit = $this->ProfitModel->getProfit($filter);  // Get the profit based on the selected filter
        
        // Make sure you pass the data to the right view
        $this->view('profit/profit_view', [
            'profit' => $profit
        ]);
    }
}
