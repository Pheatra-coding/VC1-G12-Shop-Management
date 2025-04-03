<?php
require_once 'models/ImportModel.php';

class ImportController {
    private $importModel;

    public function __construct() {
        $this->importModel = new ImportModel();
    }

    public function index() {
        include 'views/products/import.php';
    }

    public function import() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
            header('Content-Type: application/json');
            
            try {
                $file = $_FILES['excel_file'];
                
                // Validate file
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception("File upload error: " . $file['error']);
                }
    
                $importModel = new ImportModel();
                $result = $importModel->importProductsFromExcel($file['tmp_name']);
    
                if ($result['success']) {
                    echo json_encode([
                        'success' => true,
                        'imported' => $result['stats']['imported'],
                        'message' => "Imported {$result['stats']['imported']} products"
                    ]);
                } else {
                    throw new Exception($result['message']);
                }
                
            } catch (Exception $e) {
                http_response_code(400);
                echo json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
            exit;
        }
        
        // If not POST request, show regular import page (fallback)
        $this->index();
    }
}