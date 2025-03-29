<?php
class WelcomeController extends BaseController
{
    private $lowStockModel;
    private $topSellingModel;
    private $saleModel;
    private $expenseModel;
    private $profitModel;
    private $saleQuantityModel;

    public function __construct()
    {
        $this->lowStockModel = new LowStockAlertModel();
        $this->topSellingModel = new TopSellingModel();
        $this->saleModel = new SaleModel();
        $this->expenseModel = new ExpenseModel();
        $this->profitModel = new ProfitModel();
    }

    public function welcome()
    {
        // Existing data retrieval...
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10);
        $lowStockCount = $this->lowStockModel->countLowStockProducts(10);
        $topSellingProducts = $this->topSellingModel->getTopSellingProducts();
        $dailySales = $this->saleModel->getDailySales();
        $weeklySales = $this->saleModel->getWeeklySales();
        $monthlySales = $this->saleModel->getMonthlySales();
        $profitToday = $this->profitModel->getProfit('today');
        $profitThisWeek = $this->profitModel->getProfit('this_week');
        $profitThisMonth = $this->profitModel->getProfit('this_month');
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
            'monthlyExpenses' => $monthlyExpenses,
            'profitToday' => $profitToday,
            'profitThisWeek' => $profitThisWeek,
            'profitThisMonth' => $profitThisMonth,
            'dailySalesQuantity' => $dailySalesQuantity,

        ]);
    }
}