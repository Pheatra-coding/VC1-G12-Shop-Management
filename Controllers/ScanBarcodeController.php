<?php
require_once 'Models/ScanBarcodeModel.php';

class ScanBarcodeController extends BaseController {

    // Handle the form submission for scanning the barcode
    public function scan() {
        // Check if barcode was submitted
        if (isset($_POST['barcode'])) {
            // Retrieve the barcode and normalize it
            $barcode = trim($_POST['barcode']); // Trim any leading/trailing spaces
            $barcode = strtolower($barcode);   // Convert barcode to lowercase for consistency

            // Create an instance of the model
            $model = new ScanBarcodeModel();

            // Get the product information by barcode
            $productInfo = $model->getProductByBarcode($barcode);

            // Message to display based on the result
            if ($productInfo) {
                // If product is found, attempt to update the quantity
                $updateResult = $model->updateProductQuantity($barcode);

                if ($updateResult) {
                    // Successfully updated the quantity
                    $message = "Product quantity updated successfully!";
                } else {
                    // If no quantity left or another issue
                    $message = "Product not found or insufficient stock!";
                }
            } else {
                // Product not found
                $message = "Product with the given barcode does not exist!";
            }

            // Pass the product info and message to the view
            $this->view('scan_barcodes/barcode', ['productInfo' => $productInfo, 'message' => $message]);
        } else {
            // If barcode wasn't submitted
            $message = "Please scan or enter a barcode.";
            $this->view('scan_barcodes/barcode', ['message' => $message]);
        }
    }

    // Display the barcode scanning page
    public function index() {
        // Show the scanning form with no initial product info
        $this->view('scan_barcodes/barcode');
    }
}
?>
