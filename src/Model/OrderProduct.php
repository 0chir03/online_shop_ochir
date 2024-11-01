<?php

namespace Model;
class OrderProduct extends Model
{
    private int $id;
    private int $orderId;
    private int $productId;
    private int $amount;
    private int $totalPrice;

    public static function create(int $orderId, int $productId, int $amount, int $totalPrice)
    {
        $stmt = self::getPDO()->prepare("INSERT INTO order_products (order_id, product_id, amount, total_price) VALUES (:orderId, :productId, :amount, :totalPrice)");
        $stmt->execute(['orderId' => $orderId, 'productId' => $productId, 'amount' => $amount, 'totalPrice' => $totalPrice]);
    }

    public static function getOrderProducts(int $productId, int $userId): ? array
    {
        $stmt = self::getPDO()->prepare("SELECT * FROM order_products INNER JOIN orders  ON order_products.order_id = orders.id WHERE order_products.product_id = :productId AND orders.user_id = :userId");
        $stmt->execute(['productId' => $productId, 'userId' => $userId] );
        $result = $stmt->fetchAll();

        if (empty($result)) {
            return null;
        }
        $array = [];
        foreach ($result as $item) {
            $obj = new self();
            $obj->id = $item['id'];
            $obj->orderId = $item['order_id'];
            $obj->productId = $item['product_id'];
            $obj->amount = $item['amount'];
            $obj->totalPrice = $item['total_price'];
            $array[] = $obj;
        }
        return $array;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

}