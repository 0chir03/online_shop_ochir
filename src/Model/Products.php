<?php

namespace Model;
class Products extends Model
{
    public function getProducts(): array|false
    {
        $stmt = $this->pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getByUserId(int $user_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT * FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getByProductId(int $product_id): array|false
    {
        $stmt = $this->pdo->prepare("SELECT price FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $data = $stmt->fetch();
        return $data;
    }

}