<?php
class WelcomeController extends BaseController {
    private $lowStockModel;
    private $topSellingModel;
    private $saleModel;
    private $expenseModel;

    public function __construct() {
        $this->lowStockModel = new LowStockAlertModel();
        $this->topSellingModel = new TopSellingModel();
        $this->saleModel = new SaleModel();
        $this->expenseModel = new ExpenseModel();
    }

    public function welcome() {
        // Existing data
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10);
        $lowStockCount = $this->lowStockModel->countLowStockProducts(10);
        $topSellingProducts = $this->topSellingModel->getTopSellingProducts();
        $dailySales = $this->saleModel->getDailySales();
        $weeklySales = $this->saleModel->getWeeklySales();
        $monthlySales = $this->saleModel->getMonthlySales();

        // New expense data
        $dailyExpenses = $this->expenseModel->getDailyExpenses();
        $weeklyExpenses = $this->expenseModel->getWeeklyExpenses();
        $monthlyExpenses = $this->expenseModel->getMonthlyExpenses();

        // Pass the data to the view
        $this->view('welcome/welcome', [
            'lowStockProducts' => $lowStockProducts,
            'lowStockCount' => $lowStockCount,
            'topSellingProducts' => $topSellingProducts,
            'dailySales' => $dailySales,
            'weeklySales' => $weeklySales,
            'monthlySales' => $monthlySales,
            'dailyExpenses' => $dailyExpenses,
            'weeklyExpenses' => $weeklyExpenses,
            'monthlyExpenses' => $monthlyExpenses
        ]);
    }
}
?>