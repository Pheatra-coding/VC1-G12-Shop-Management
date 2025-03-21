<?php
require_once 'Models/TopSellingModel.php';

class TopSellingController extends BaseController {
    // Get top-selling products
    public function index() {
        $model = new TopSellingModel();
        $topSellingProducts = $model->getTopSellingProducts();
        
        // Pass the data to the view
        $this->view('sales/top_selling', [
            'products' => $topSellingProducts,
        ]);
    }
}