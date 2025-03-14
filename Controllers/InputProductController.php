<?php

require_once 'Models/InputProductModel.php';

class InputProductController extends BaseController {
          
     // View input sold products
    public function index() {
        $this->view('input_products/sold_product');
    }
}
          
    