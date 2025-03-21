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

                // 🔹 Corrected: Using query() without placeholders
                $stmt = $pdo->query("SELECT price FROM products WHERE id = $productId");
                $product = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$product) {
                    die("Product not found!");
                }

                $price = $product['price'];
                $totalPrice = $price * $quantity;

                // 🔹 Updating quantity
                $pdo->query("UPDATE products SET quantity = quantity - $quantity WHERE id = $productId");

                // 🔹 Inserting sale record
                $pdo->query("INSERT INTO sales (product_id, quantity, total_price, sale_date, payment_method, status) 
                         VALUES ($productId, $quantity, $totalPrice, NOW(), 'Cash', 'Completed')");

                // Redirect to the sales page
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



}

