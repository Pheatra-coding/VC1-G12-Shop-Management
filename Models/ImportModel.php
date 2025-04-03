<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportModel {
    private $db;
    private $log = [];

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function importProductsFromExcel($filePath) {
        try {
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();

            // Remove header row
            array_shift($data);

            $results = [
                'total' => count($data),
                'imported' => 0,
                'skipped' => 0,
                'errors' => []
            ];

            foreach ($data as $rowIndex => $row) {
                try {
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        $results['skipped']++;
                        continue;
                    }

                    $product = $this->validateProductRow($row, $rowIndex);
                    
                    if ($this->barcodeExists($product['barcode'])) {
                        $results['skipped']++;
                        $this->log[] = "Row " . ($rowIndex + 2) . ": Skipped - Duplicate barcode";
                        continue;
                    }

                    $this->addProduct($product);
                    $results['imported']++;
                    $this->log[] = "Row " . ($rowIndex + 2) . ": Successfully imported";

                } catch (Exception $e) {
                    $results['errors'][] = "Row " . ($rowIndex + 2) . ": " . $e->getMessage();
                    $results['skipped']++;
                    $this->log[] = "Row " . ($rowIndex + 2) . ": Error - " . $e->getMessage();
                }
            }

            return [
                'success' => true,
                'stats' => $results,
                'log' => $this->log
            ];

        } catch (Exception $e) {
            error_log("Import failed: " . $e->getMessage());
            return [
                'success' => false,
                'message' => "File processing error: " . $e->getMessage(),
                'log' => $this->log
            ];
        }
    }

    private function validateProductRow($row, $rowIndex) {
        $product = [
            'name' => trim($row[0] ?? ''),
            'price' => $this->parseNumber($row[1] ?? 0),
            'purchase_price' => $this->parseNumber($row[2] ?? 0),
            'supplier_id' => is_numeric($row[3] ?? null) ? (int)$row[3] : null,
            'barcode' => trim($row[4] ?? ''),
            'image' => $row[5] ?? null,
            'quantity' => $this->parseQuantity($row[6] ?? 0),
            'end_date' => $this->parseDate($row[7] ?? null)
        ];
        error_log("Processed quantity: " . $product['quantity']);

        

        // Validate required fields
        if (empty($product['name'])) {
            throw new Exception("Product name is required");
        }

        if (empty($product['barcode'])) {
            throw new Exception("Barcode is required");
        }

        return $product;
    }

    private function parseNumber($value) {
        if (is_numeric($value)) return $value;
        
        // Remove currency symbols and thousands separators
        $cleaned = preg_replace('/[^0-9.-]/', '', $value);
        return (float)$cleaned;
    }
    private function parseQuantity($value) {
        if (is_numeric($value)) return (int)$value;
        return (int)preg_replace('/[^0-9]/', '', $value);
    }

    private function parseDate($value) {
        if (empty($value)) return null;

        try {
            if (is_numeric($value)) {
                // Convert Excel date to PHP DateTime
                return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)
                    ->format('Y-m-d');
            }
            return date('Y-m-d', strtotime($value));
        } catch (Exception $e) {
            return null;
        }
    }

    private function barcodeExists($barcode) {
        if (empty($barcode)) return false;
        
        // Modified to work with your Database::query() method
        $result = $this->db->query(
            "SELECT COUNT(*) FROM products WHERE barcode = ?", 
            [$barcode]
        )->fetchColumn();
        
        return $result > 0;
    }

    private function addProduct($product) {
        // Modified to work with your Database::query() method
        $this->db->query(
            "INSERT INTO products 
            (name, price, purchase_price, supplier_id, barcode, image, quantity, end_date, created_at, updated_at) 
            VALUES 
            (:name, :price, :purchase_price, :supplier_id, :barcode, :image, :quantity, :end_date, NOW(), NOW())",
            $product
        );
    }
}