<?php
require_once 'Models/LowSellingModel.php';

class LowSellingController extends BaseController {
        public function index() {
            $model = new LowSellingModel();
            $lowSellingProducts = $model->getLowSellingProducts();
    
            $this->view('sales/low_selling', [
                'products' => $lowSellingProducts
            ]);
        }
    }
