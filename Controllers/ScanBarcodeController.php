<?php
require_once 'Models/ScanBarcodeModel.php';

class ScanBarcodeController extends BaseController {

    // Display the barcode scanning page
    public function index() {
        // Show the scanning form with no initial product info
        $this->view('scan_barcodes/barcode');
    }

    // Handle the form submission for scanning the barcode
    public function scan() {
        // Check if barcode was submitted
        if (isset($_POST['barcode'])) {
            // Retrieve and normalize the barcode
            $barcode = trim($_POST['barcode']); 
            $barcode = strtolower($barcode);  

            // Create an instance of the model
            $model = new ScanBarcodeModel();

            // Get product information by barcode
            $productInfo = $model->getProductByBarcode($barcode);

            // Message to display based on the result
            if ($productInfo) {
                // If product is found, attempt to update the quantity
                $updateResult = $model->updateProductQuantity($barcode);

                if ($updateResult) {
                    // Successfully updated quantity
                    $message = "Product quantity updated successfully!";

                    // Insert a sale record into the sales table
                    $saleRecorded = $model->recordSale(
                        $productInfo['id'], // Product ID
                        1, // Quantity sold (assumed as 1 per scan)
                        $productInfo['price'], // Price per item
                        'Cash', // Default payment method
                        'Completed' // Default status
                    );

                    // Debugging: Log if sale is not recorded
                    if (!$saleRecorded) {
                        error_log("Failed to insert sale record for product ID: " . $productInfo['id']);
                    }
                } else {
                    $message = "Product not found or insufficient stock!";
                }
            } else {
                $message = "Product with the given barcode does not exist!";
            }

            // Pass product info and message to the view
            $this->view('scan_barcodes/barcode', ['productInfo' => $productInfo, 'message' => $message]);
        } else {
            $message = "Please scan or enter a barcode.";
            $this->view('scan_barcodes/barcode', ['message' => $message]);
        }
    }
}
?>
