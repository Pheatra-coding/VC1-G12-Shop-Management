<?php
require_once 'Models/InputProductModel.php';

class InputProductController extends BaseController {
    private $productModel;

    public function __construct() {
        $this->productModel = new InputProductModel();
    }

    public function index() {
        $products = $this->productModel->getAllProducts();
        $this->view('input_products/sold_product', [
            'products' => $products,
            'reset' => isset($_GET['reset'])
        ]);
    }

    public function scan() {
        if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
            $productId = (int)$_POST['product_id'];
            $quantity = (int)$_POST['quantity'];
            $products = $this->productModel->getAllProducts();
            
            $productInfo = $this->productModel->getProductById($productId);

            if ($productInfo) {
                $updateResult = $this->productModel->updateProductQuantity($productId, $quantity);
                $message = $updateResult ? 
                    "Product added successfully!" : 
                    "Insufficient stock!";
            } else {
                $message = "Product not found!";
            }

            $this->view('input_products/sold_product', [
                'products' => $products,
                'productInfo' => $productInfo,
                'quantity' => $quantity,
                'message' => $message
            ]);
        } else {
            $this->index();
        }
    }

    public function submit() {
        if (isset($_POST['cart_data'])) {
            $model = new InputProductModel();
            $cart = json_decode($_POST['cart_data'], true);

            foreach ($cart as $productId => $item) {
                $model->saveSale(
                    $item['product_id'],
                    $item['quantity'],
                    $item['price'] * $item['quantity'],
                    'pending'
                );
            }

            $_SESSION['cart'] = $cart;
            
            // Send Telegram alert about the sale
            $this->sendSaleAlert($cart);

            $this->view('input_products/receipt', [
                'cart' => $cart,
                'total' => array_sum(array_map(function($item) {
                    return $item['price'] * $item['quantity'];
                }, $cart)),
                'clear_cart' => true
            ]);
        } else {
            header("Location: /input_products/sold_product");
            exit();
        }
    }
    
    /**
     * Send Telegram alert about completed sale
     */
    protected function sendSaleAlert($cart) {
        if (empty($cart)) {
            return;
        }
        
        $totalItems = array_sum(array_column($cart, 'quantity'));
        $totalAmount = array_sum(array_map(function($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));
        
        $message = "<b>💰 New Manual Sale Completed</b>\n";
        $message .= "🛒 Items Sold: $totalItems\n";
        $message .= "💵 Total Amount: $" . number_format($totalAmount, 2) . "\n\n";
        $message .= "<b>Items:</b>\n";
        
        foreach ($cart as $productId => $item) {
            $message .= "➡️ {$item['name']} ({$item['quantity']} × \${$item['price']})\n";
        }
        
        $this->sendTelegramMessage($message);
    }

    public function confirm() {
        $model = new InputProductModel();
        $model->updateSalesStatus('completed');
        
        header("Location: /input_products/sold_product?reset=true");
        exit();
    }
}