<?php

namespace Model;
class OrderProduct extends Model
{
    public function create(int $order_id, int $product_id, int $amount, int $total_price)
    {
        $stmt = $this->pdo->prepare("INSERT INTO order_products (order_id, product_id, amount, total_price) VALUES (:order_id, :product_id, :amount, :total_price)");
        $stmt->execute(['order_id' => $order_id, 'product_id' => $product_id, 'amount' => $amount, 'total_price' => $total_price]);
    }
}