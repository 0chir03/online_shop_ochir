<?php

class UserProduct
{
    public function getProducts()
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->query("SELECT * FROM products");
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getByUserIdAndProductId(int $userId, int $productId)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId AND product_id = :productId");
        $stmt->execute(['userId' => $userId, 'productId' => $productId]);
        $result = $stmt->fetchAll();
        return $result;
    }

    public function insertValues(int $userId, int $productId, int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
        $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
    }

    public function updateValues(int $amount)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("UPDATE user_products SET amount = amount + :amount ");
        $stmt->execute(['amount' => $amount]);
    }

    public function getByIdAndProductIdWhereUserId(int $user_id)
    {
        $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
        $stmt = $pdo->prepare("SELECT * FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.user_id = :user_id");
        $stmt->execute(['user_id' => $user_id]);
        $data = $stmt->fetchAll();
        return $data;
    }
}