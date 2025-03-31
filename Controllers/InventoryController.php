<?php
require_once 'Models/InventoryModel.php';

class InventoryController extends BaseController {
    private $inventoryModel;

    public function __construct() {
        $this->inventoryModel = new InventoryModel(); // Initialize inventory model
    }

    public function index() {
        // Get total inventory quantity (no filter needed)
        $totalInventoryQuantity = $this->inventoryModel->getTotalQuantity(); 

        // Pass the data to the view
        $this->view('inventory/inventory_view', [
            'totalInventoryQuantity' => $totalInventoryQuantity,
        ]);
    }
}
