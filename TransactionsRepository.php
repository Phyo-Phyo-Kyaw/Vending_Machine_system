<?php

class TransactionsRepository extends BaseRepository {
    public function logTransaction($userId, $productId, $quantity, $totalPrice) {
        $data = [
            'user_id' => $userId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'total_price' => $totalPrice
        ];
        return $this->create('Transactions', $data);
    }
}
