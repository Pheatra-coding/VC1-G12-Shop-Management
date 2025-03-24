<?php

require_once 'Models/InputProductModel.php'; // Make sure this path is correct for your environment

class InputProductController extends BaseController
{

    private $productModel;

    public function __construct()
    {
        $this->productModel = new InputProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts(); // Fetch products
        $sales = $this->productModel->getSales(); // Fetch sales
        $this->view('input_products/sold_product', ['products' => $products, 'sales' => $sales]);
    }


    /**
     * Process the sale of a product (subtract quantity and insert sale record).
     */
    public function processSale()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = (int) $_POST['product_id']; // Ensure it's an integer
            $quantity = (int) $_POST['quantity']; // Ensure it's an integer
    
            if ($productId <= 0 || $quantity <= 0) {
                die("Invalid product ID or quantity.");
            }
    
            try {
                $pdo = $this->productModel->getDBConnection();
    
                // 🔹 Get product details (price & available quantity)
                $stmt = $pdo->query("SELECT price, quantity FROM products WHERE id = $productId");
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if (!$product) {
                    die("Product not found!");
                }
    
                $price = $product['price'];
                $availableStock = (int) $product['quantity'];
                $totalPrice = $price * $quantity;
    
                // 🔹 Check if enough stock is available
                if ($quantity > $availableStock) {
                    echo "
                    <div class='alert alert-danger' style='margin-top: 15px;'>
                        <strong>⚠ Stock Error:</strong> Requested quantity ($quantity) exceeds available stock ($availableStock).
                    </div>";
                    exit;
                }
                
    
                // 🔹 Subtract quantity from stock
                $pdo->query("UPDATE products SET quantity = quantity - $quantity WHERE id = $productId");
    
                // 🔹 Insert sale record
                $pdo->query("INSERT INTO sales (product_id, quantity, total_price, sale_date, payment_method, status) 
                             VALUES ($productId, $quantity, $totalPrice, NOW(), 'Cash', 'Completed')");
    
                // Redirect to sales page
                header("Location: /input_products/sold_product");
                exit();
            } catch (PDOException $e) {
                die("Database Error: " . $e->getMessage());
            }
        }
    }
    
    


    
    public function deleteSale($id)
    {
        $this->productModel->deleteSale($id);  // Call the delete method in the model
        header("Location: /input_products/sold_product");  // Redirect to the sold products page
        exit();
    }


    public function editSale($id) {
        $sale = $this->productModel->getSaleById($id);
        $products = $this->productModel->getAllProducts();
        if (!$sale) {
            die("Sale not found!");
        }
        $this->view('input_products/edit', ['sale' => $sale, 'products' => $products]);
    }
    public function updateSale($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['_method']) && $_POST['_method'] === 'PUT') {
            $productId = htmlspecialchars($_POST['product_id']);
            $newQuantity = (int) htmlspecialchars($_POST['quantity']);
    
            if ($productId <= 0 || $newQuantity <= 0) {
                echo "Error: Product ID and quantity must be positive numbers.";
                return;
            }
    
            try {
                $pdo = $this->productModel->getDBConnection();
    
                // Fetch old sale data
                $oldSale = $this->productModel->getSaleById($id);
                if (!$oldSale) {
                    echo "Error: Sale not found!";
                    return;
                }
    
                $oldQuantity = (int) $oldSale['quantity'];
    
                // Fetch product details
                $stmt = $pdo->query("SELECT price, quantity FROM products WHERE id = $productId");
                $product = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$product) {
                    echo "Error: Product not found!";
                    return;
                }
    
                $price = $product['price'];
                $availableStock = (int) $product['quantity'];
                $totalPrice = $price * $newQuantity;
    
                // Calculate the stock adjustment
                $quantityDifference = $newQuantity - $oldQuantity;
    
                // Check if there's enough stock for the adjustment
                if ($quantityDifference > 0 && $quantityDifference > $availableStock) {
                    echo "Error: Not enough stock available!";
                    return;
                }
    
                // Adjust product stock
                $pdo->query("UPDATE products SET quantity = quantity - $quantityDifference WHERE id = $productId");
    
                // Update sale record
                if ($this->productModel->updateSale($id, $productId, $newQuantity, $totalPrice)) {
                    header("Location: /input_products/sold_product");
                    exit();
                } else {
                    echo "Failed to update sale.";
                }
            } catch (PDOException $e) {
                echo "Database Error: " . $e->getMessage();
            }
        }
    }
    
    
    
}

     
    
    
    
    


