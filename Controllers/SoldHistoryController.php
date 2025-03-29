<?php

require_once 'Models/TransactionModel.php'; // Assuming you have a TransactionModel to interact with the database

class SoldHistoryController extends BaseController {
    private $transactions;

    public function __construct() {
        $this->transactions = new TransactionModel(); // Interacts with the database to get transaction data
    }

    public function index()
{
    $transactions = $this->transactions->getAllTransactions();
    $this->view('sold_history/sold_history', ['transactions' => $transactions]);
}
}

?>
