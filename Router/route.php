<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Models/UserModel.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/ProductController.php";
require_once "Controllers/UserController.php";


$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);

// Products
$route->get("/products", [ProductController::class, 'index']);
$route->get("/products/create", [ProductController::class, 'create']);
$route->post("/products/store", [ProductController::class, 'store']);

$route->route();
//users
$route->get("/users", [UserController::class, 'index']);
$route->get("/users/create", [UserController::class, 'create']);
$route->get("/users/store", [UserController::class, 'store']);
$route->get("/users/edit/{id}", [UserController::class, 'edit']);
$route->post("/users/update/{id}", [UserController::class, 'update']);
$route->route();
