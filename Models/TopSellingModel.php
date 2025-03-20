<?php
class TopSellingModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }
    
    
}