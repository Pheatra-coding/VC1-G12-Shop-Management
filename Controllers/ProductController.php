<?php

    require_once 'Models/ProductModel.php';

    class ProductController extends BaseController {

    private $products;
    
    public function __construct() {
        $this->products = new ProductModel();
    }

    // get products
    public function index() {
        $products = $this->products->getProduct(); 
        $this->view('products/product_list', ['products' => $products]); 
    }
    
    public function getProduct() {
        $result = $this->db->query("SELECT * FROM products");
        return $result ? $result->fetchAll(PDO::FETCH_ASSOC) : [];
    }
    

    public function create() {
        $this->view("products/create");
    }

    public function store() {
        $image = htmlspecialchars($_POST['image']);
        $name = htmlspecialchars($_POST['name']);
        $end_date = htmlspecialchars($_POST['end_date']);
        $barcode = htmlspecialchars($_POST['barcode']);
        $price = htmlspecialchars($_POST['price']);
        $amount = htmlspecialchars($_POST['amount']);

        $this->products->createProduct($image, $name, $end_date, $barcode, $price, $amount);
        header("Location: /products");
    }
}