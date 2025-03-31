<?php
    require_once 'Models/LowStockAlertModel.php';
    require_once 'Models/TopSellingModel.php';
    require_once 'Models/SaleModel.php';
    require_once 'Models/ProfitModel.php';
    require_once 'Controllers/BarchartController.php'; // Add this line

class WelcomeController extends BaseController
{
    private $lowStockModel;
    private $topSellingModel;
    private $saleModel;
    private $expenseModel;
    private $profitModel;
    private $inventoryModel; // Inventory model
    private $barchartController; // Add this property

    public function __construct()
    {
        $this->lowStockModel = new LowStockAlertModel();
        $this->topSellingModel = new TopSellingModel();
        $this->saleModel = new SaleModel();
        $this->expenseModel = new ExpenseModel();
        $this->profitModel = new ProfitModel();
        $this->inventoryModel = new InventoryModel();
        $this->barchartController = new BarchartController(); // Initialize here
    }

    public function welcome()
    {
        // Get low stock data
        $lowStockProducts = $this->lowStockModel->getLowStockProducts(10);
        $lowStockCount = $this->lowStockModel->countLowStockProducts(10);

        // Get top-selling products
        $topSellingProducts = $this->topSellingModel->getTopSellingProducts();

        // Get sales data
        $dailySales = $this->saleModel->getDailySales();
        $weeklySales = $this->saleModel->getWeeklySales();
        $monthlySales = $this->saleModel->getMonthlySales();
        
        // Profit
        $profitToday = $this->profitModel->getProfit('today');
        $profitThisWeek = $this->profitModel->getProfit('this_week');
        $profitThisMonth = $this->profitModel->getProfit('this_month');
        
        // Get bar chart data
        $monthlySalesData = $this->barchartController->getMonthlySalesData();

        // New expense data
        $dailyExpenses = $this->expenseModel->getDailyExpenses();
        $weeklyExpenses = $this->expenseModel->getWeeklyExpenses();
        $monthlyExpenses = $this->expenseModel->getMonthlyExpenses();

        // Inventory
        $totalInventoryQuantity = $this->inventoryModel->getTotalQuantity('this_year');

        // Pass the data to the view
        $this->view('welcome/welcome', [
            'lowStockProducts' => $lowStockProducts,
            'lowStockCount' => $lowStockCount,
            'topSellingProducts' => $topSellingProducts,
            'dailySales' => $dailySales,
            'weeklySales' => $weeklySales,
            'monthlySales' => $monthlySales,
            'profitToday' => $profitToday,
            'dailyExpenses' => $dailyExpenses,
            'weeklyExpenses' => $weeklyExpenses,
            'monthlyExpenses' => $monthlyExpenses,
            'profitToday' => $profitToday, 
            'profitThisWeek' => $profitThisWeek,
            'profitThisMonth' => $profitThisMonth,
            'totalInventoryQuantity' => $totalInventoryQuantity,
            'monthlySalesData' => $monthlySalesData, // Add this line
        ]);
    }
}