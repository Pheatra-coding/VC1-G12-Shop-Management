<?php
require_once 'Models/ImportModel.php';

class ImportController {
    public function import() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['excel_file'])) {
            header('Content-Type: application/json');
            
            try {
                $file = $_FILES['excel_file'];
                
                // Basic validation
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    throw new Exception("File upload error (Code: {$file['error']})");
                }

                // File type validation
                $allowedTypes = [
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                ];
                
                if (!in_array($file['type'], $allowedTypes)) {
                    throw new Exception("Invalid file type. Only Excel files are allowed.");
                }

                // File size validation (5MB max)
                if ($file['size'] > 5 * 1024 * 1024) {
                    throw new Exception("File size exceeds 5MB limit");
                }

                $importModel = new ImportModel();
                $result = $importModel->importProductsFromExcel($file['tmp_name']);

                if ($result['success']) {
                    echo json_encode([
                        'success' => true,
                        'imported' => $result['stats']['imported'],
                        'message' => "Successfully imported {$result['stats']['imported']} products"
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
        
        // If not POST request, show regular page (fallback)
        $this->showImportPage();
    }

    private function showImportPage() {
        include 'Views/products/import.php';
    }
}