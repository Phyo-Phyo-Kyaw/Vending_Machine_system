<?php
class TransactionLog {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function log($productId, $quantity, $totalPrice) {
        $sql = "INSERT INTO transaction_logs (product_id, quantity, total_price, date) VALUES (:product_id, :quantity, :total_price, NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':product_id' => $productId,
            ':quantity' => $quantity,
            ':total_price' => $totalPrice
        ]);
    }
}
