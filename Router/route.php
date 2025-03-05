<?php
require_once "Router.php";
require_once "Controllers/BaseController.php";
require_once "Database/Database.php";
require_once "Controllers/WelcomeController.php";
require_once "Controllers/UserController.php";


$route = new Router();
$route->get("/", [WelcomeController::class, 'welcome']);

//users
$route->get("/users", [UserController::class, 'index']);

$route->route();