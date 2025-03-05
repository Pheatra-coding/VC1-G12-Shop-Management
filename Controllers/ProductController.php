<?php

class ProductController extends BaseController {
    public function index() {
        $this->view('products/product_list');
    }
}