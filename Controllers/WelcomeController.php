<?php
class WelcomeController extends BaseController
{
    private $lowStockModel;
    private $topSellingModel;
    private $saleModel;
    private $ProfitModel;

    public function __construct()
    {
        $this->lowStockModel = new LowStockAlertModel();
        $this->topSellingModel = new TopSellingModel();
        $this->saleModel = new SaleModel();
        $this->ProfitModel = new ProfitModel();
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


        // Get profit data
        $dailyProfit = $this->ProfitModel->getProfit('1 DAY');
        $weeklyProfit = $this->ProfitModel->getProfit('7 DAY');
        $monthlyProfit = $this->ProfitModel->getProfit('30 DAY');

        // Pass the data to the view
        $this->view('welcome/welcome', [
            'lowStockProducts' => $lowStockProducts,
            'lowStockCount' => $lowStockCount,
            'topSellingProducts' => $topSellingProducts,
            'dailySales' => $dailySales,
            'weeklySales' => $weeklySales,
            'monthlySales' => $monthlySales,
            'dailyProfit' => $dailyProfit,
            'weeklyProfit' => $weeklyProfit,
            'monthlyProfit' => $monthlyProfit
        ]);
    }
}
