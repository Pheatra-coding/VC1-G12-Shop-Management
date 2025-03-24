<?php
require_once 'Models/ExpiringProductModel.php';
class ExpiringProductController extends BaseController {
    public function expiring() {
        $model = new ExpiringProductModel(); // Use the correct model class
        $expiringProducts = $model->getExpiringProducts();

        $this->view('products/product_expiring', [
            'products' => $expiringProducts
        ]);
    }
}                               