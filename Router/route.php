<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Models/UserModel.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/ProductController.php";
require_once "Controllers/UserController.php";
require_once "Controllers/InputProductController.php";
require_once "Controllers/LowStockAlertController.php";
require_once "Controllers/TopSellingController.php";
require_once "Controllers/LowSellingController.php";
require_once "Controllers/DeletedEmployeeController.php";
require_once "Controllers/ScanBarcodeController.php";
require_once "Controllers/ExpiringProductController.php";
require_once "Controllers/SaleController.php";
require_once "Controllers/ExpenseController.php";
require_once "Controllers/ProfitController.php";
require_once "Controllers/ProfitController.php";
require_once "Controllers/SoldHistoryController.php";
require_once "Controllers/InventoryController.php";
require_once "Controllers/SalesController.php";
require_once "Controllers/CategoryController.php";

$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);

// Products
$route->get("/products", [ProductController::class, 'index']);
$route->get("/products/create", [ProductController::class, 'create']);
$route->post("/products/store", [ProductController::class, 'store']);
$route->get("/products/edit/{id}", [ProductController::class, 'edit']);
$route->put("/products/update/{id}", [ProductController::class, 'update']);
$route->delete("/products/delete/{id}", [ProductController::class, 'delete']);
$route->get("/products/product_expiring", [ExpiringProductController::class, 'expiring']);

//users
$route->get("/users", [UserController::class, 'index']);
$route->get("/users/create", [UserController::class, 'create']);
$route->post("/users/store", [UserController::class, 'store']);
$route->get("/users/edit/{id}", [UserController::class, 'edit']);
$route->put("/users/update/{id}", [UserController::class, 'update']);
$route->delete("/users/delete/{id}", [UserController::class, 'delete']);

// Login routes 
$route->get("/users/login", [UserController::class, 'login']);
$route->post("/users/authenticate", [UserController::class, 'authenticate']);
$route->get("/users/logout", [UserController::class, 'logout']);
$route->get("/users/profile", [UserController::class, 'viewProfile']);


// sold products
$route->get("/input_products/sold_product", [InputProductController::class, 'index']);
$route->post("/input_products/scan", [InputProductController::class, 'scan']);
$route->post("/input_products/submit", [InputProductController::class, 'submit']);
$route->post("/input_products/confirm", [InputProductController::class, 'confirm']);



 
//display deleted users
$route->get("/users/deleted", [DeletedEmployeeController::class, 'index']);
$route->post("/users/permanently_delete/{id}", [DeletedEmployeeController::class, 'permanentlyDelete']);
$route->get("/users/restore/{id}", [DeletedEmployeeController::class, 'restore']);
$route->post("/users/bulk_permanently_delete", [DeletedEmployeeController::class, 'bulkPermanentlyDelete']);
$route->post("/users/bulk_restore", [DeletedEmployeeController::class, 'bulkRestore']);

//display scan barcode
$route->get("/scan_barcodes/barcode", [ScanBarcodeController::class, 'index']);
$route->post("/scan_barcodes/scan", [ScanBarcodeController::class, 'scan']);
$route->post("/scan_barcodes/submit", [ScanBarcodeController::class, 'submit']);
$route->post("/scan_barcodes/confirm", [ScanBarcodeController::class, 'confirm']);
$route->get("/scan_barcodes/customer", [ScanBarcodeController::class, 'customerView']);


//low stock alert 
$route->get("/products/low-stock-alert", [LowStockAlertController::class, 'index']);

// sales
$route->get("/sales/top_selling", [TopSellingController::class, 'index']);
$route->get("/sales/low_selling", [lowSellingController::class, 'index']);

// Sold History
$route->get("/sold_history/sold_history", [SoldHistoryController::class, 'index']);
$route->get("/sold_history/delete/{id}", [SoldHistoryController::class, 'delete']);
// category
$route->get("/categories", [CategoryController::class, 'index']);
$route->get("/categories/create", [CategoryController::class, 'create']);
$route->post("/categories/store", [CategoryController::class, 'store']);
$route->get("/categories/edit/{id}", [CategoryController::class, 'edit']);
$route->put("/categories/update/{id}", [CategoryController::class, 'update']);
$route->delete("/categories/delete/{id}", [CategoryController::class, 'delete']);

$route->route();
