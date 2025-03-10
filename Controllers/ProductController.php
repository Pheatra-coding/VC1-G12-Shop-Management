<?php

require_once 'Models/ProductModel.php';

class ProductController extends BaseController {
    private $products;

    public function __construct() {
        $this->products = new ProductModel();
    }

    // Get all products
    public function index() {
        $products = $this->products->getProduct(); // Fetch products from the model
        $this->view('products/product_list', ['products' => $products]); // Pass data to the view
    }
    
    // view create product form
    public function create() {
        $this->view("products/create");
    }

    public function store() {
        // Sanitize inputs
        $name = htmlspecialchars($_POST['name']);
        $end_date = htmlspecialchars($_POST['end_date']);
        $barcode = htmlspecialchars($_POST['barcode']);
        $price = htmlspecialchars($_POST['price']);
        $quantity = htmlspecialchars($_POST['quantity']);
    
        // Handle Image Upload
        $image = $_FILES['image']['name'] ?? null;
        $targetDir = "uploads/";
    
        // Create uploads directory if it doesn’t exist
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true); // Create directory with full permissions
        }
    
        // Check if an image was uploaded
        if ($image) {
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "The file has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                return; // Prevent proceeding if upload fails
            }
        }
    
        // Save the product data with image path
        $this->products->addProduct($image, $name, $end_date, $barcode, $price, $quantity);
    
        // Redirect to the products list page
        $this->redirect('/products');
    }
    
    // function to delete a product 
    public function delete($id) {
        $this->products->deleteProduct($id);
        header("Location: /products");
    }

    // view edit product form
    public function edit($id) {
        $product = $this->products->getProductById($id);
        $this->view("products/edit", ['product' => $product]);
    }
    
    // function to update a product
    public function update($id) {
        $name = htmlspecialchars($_POST['name']);
        $end_date = htmlspecialchars($_POST['end_date']);
        $barcode = htmlspecialchars($_POST['barcode']);
        $price = htmlspecialchars($_POST['price']);
        $quantity = htmlspecialchars($_POST['quantity']);
        
        // Handle Image Upload
        $image = $_FILES['image']['name'] ?? null;
        $targetDir = "uploads/";
    
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    
        // Check if a new image is uploaded
        if ($image) {
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                echo "The file has been uploaded.";
            } else {
                echo "Sorry, there was an error uploading your file.";
                return;
            }
        } else {
            // If no new image uploaded, retain the old one
            $product = $this->products->getProductById($id);
            $image = $product['image'];
        }
    
        // Update product with image
        $this->products->updateProduct($id, $image, $name, $end_date, $barcode, $price, $quantity);
        header("Location: /products");
    }
    
}