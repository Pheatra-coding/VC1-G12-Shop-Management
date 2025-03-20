<?php


class TopSellingController extends BaseController {

    // get all products
    public function index() {
        $this->view('sales/top_selling');
    }
    
   
}