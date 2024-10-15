<?php

class Products
{
    public function getProducts()
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getByUserId(int $user_id)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        return $data;
    }

    public function getPriceAndAmount(int $user_id)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT products.price, user_products.amount FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $price = $stmt->fetchAll();
        return $price;
    }
}