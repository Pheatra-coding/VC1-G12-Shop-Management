<?php
class LowStockAlertModel {
    private $db;

    public function __construct() {
        $this->db = new Database("localhost", "shop_management", "root", "");
    }

    public function getLowStockProducts($threshold = 10) {
        $sql = "SELECT * FROM products WHERE quantity <= ?";
        $result = $this->db->query($sql, [$threshold])->fetchAll(PDO::FETCH_ASSOC);
        if (empty($result)) {
            error_log("LowStockAlertModel: No low stock products found.");
        }
        
        return $result;
    }

    public function countLowStockProducts($threshold = 10) {
        $sql = "SELECT COUNT(*) as count FROM products WHERE quantity <= ?";
        $result = $this->db->query($sql, [$threshold])->fetch(PDO::FETCH_ASSOC);
        return $result['count'] ?? 0;
    }
}
?>
