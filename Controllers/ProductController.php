<?php

require_once 'Models/ProductModel.php';

class ProductController extends BaseController {
    private $products;

    public function __construct() {
        $this->products = new ProductModel();
    }

    // get all products
    public function index() {
        $products = $this->products->getProduct(); 
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
    $purchase_price = htmlspecialchars($_POST['purchase_price']);

    // Ensure required fields are not empty
    if (empty($name) || empty($end_date) || empty($barcode) || empty($price) || empty($quantity)) {
        $_SESSION['errors']['general'] = "All fields are required.";
        $this->view("products/create", ['errors' => $_SESSION['errors']]);
        return;
    }

    // Check if the barcode already exists
    if ($this->products->barcodelExists($barcode)) {
        $_SESSION['errors']['barcode'] = "The barcode already exists.";
        $this->view("products/create", ['errors' => $_SESSION['errors']]);
        return;
    }

    // Handle Image Upload
    $image = "No Image"; // Default value if no image is uploaded
    $targetDir = "views/uploads/";

    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = basename($_FILES["image"]["name"]);
        $targetFile = $targetDir . $image;
        
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $_SESSION['errors']['image'] = "Error uploading image.";
            $this->view("products/create", ['errors' => $_SESSION['errors']]);
            return;
        }
    }

    // Insert product into database
    $this->products->addProduct($image, $name, $end_date, $barcode, $price, $quantity, $purchase_price);

    // Redirect to prevent form resubmission
    header("Location: /products");
    exit();
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
        $purchase_price = htmlspecialchars($_POST['purchase_price']);
    
        // Check if the new barcode is already in use (excluding the current product)
        $existingProduct = $this->products->getProductByBarcode($barcode, $id);
    
        if ($existingProduct) {
            // If the barcode already exists, set an error message
            $errors['barcode'] = "The barcode is already used by another product.";
            $product = $this->products->getProductById($id); // Fetch the product again to re-render the form with the previous data
            $this->view("products/edit", ['product' => $product, 'errors' => $errors]);
            return;
        }
    
        // Prevent negative numbers
        if ($price < 0 || $quantity < 0) {
            echo "Error: Price and Quantity must be positive numbers.";
            return;
        }
    
        // Handle Image Upload
        $image = $_FILES['image']['name'] ?? null;
        $targetDir = "views/uploads/";
    
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
        $this->products->updateProduct($id, $image, $name, $end_date, $barcode, $price, $quantity, $purchase_price );
        header("Location: /products");
    }
}