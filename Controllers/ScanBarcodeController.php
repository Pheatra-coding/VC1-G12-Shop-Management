<?php
require_once 'Models/ScanBarcodeModel.php';

class ScanBarcodeController extends BaseController {

    public function index() {
        $this->view('scan_barcodes/barcode', [
            'reset' => isset($_GET['reset']) // Pass reset flag if present
        ]);
    }
    
    public function scan() {
        if (isset($_POST['barcode'])) {
            $barcode = trim(strtolower($_POST['barcode']));
            $model = new ScanBarcodeModel();
            $productInfo = $model->getProductByBarcode($barcode);

            if ($productInfo) {
                $updateResult = $model->updateProductQuantity($barcode);
                $message = $updateResult ? 
                    "Product scanned successfully!" : 
                    "Insufficient stock!";
            } else {
                $message = "Product not found!";
            }

            $this->view('scan_barcodes/barcode', [
                'productInfo' => $productInfo,
                'message' => $message
            ]);
        } else {
            $this->view('scan_barcodes/barcode', [
                'message' => "Please scan a barcode"
            ]);
        }
    }

    public function submit() {
        if (isset($_POST['cart_data'])) {  // Check if 'cart_data' exists in the POST data
            $model = new ScanBarcodeModel();
            $cart = json_decode($_POST['cart_data'], true);
    
            // Save to sales table
            foreach ($cart as $barcode => $item) {
                $model->saveSale(
                    $item['product_id'],
                    $item['quantity'],
                    $item['price'] * $item['quantity'],
                    'pending'
                );
            }
    
            // Store cart data in session for all tabs
            $_SESSION['cart'] = $cart;  // Store the cart in session
    
            // Clear cart flag and render receipt view
            $this->view('scan_barcodes/receipt', [
                'cart' => $cart,
                'total' => array_sum(array_map(function($item) {
                    return $item['price'] * $item['quantity'];
                }, $cart)),
                'clear_cart' => true
            ]);
        } else {
            // If there's no cart data, redirect back to the scan page
            header("Location: /scan_barcodes/barcode");
            exit();
        }
    }
    
    

    public function confirm() {
        $model = new ScanBarcodeModel();
        $model->updateSalesStatus('completed');
        
        // Redirect to scan page with a fresh start
        header("Location: /scan_barcodes/barcode?reset=true");
        exit();
    }


}