<?php
require_once "models/ProfitModel.php";  // Include the ProfitModel

class ProfitController extends BaseController {
    private $profitModel;

    // Constructor to initialize the ProfitModel
    public function __construct() {
        $this->profitModel = new ProfitModel();  // Instantiate the ProfitModel
    }

}
?>
