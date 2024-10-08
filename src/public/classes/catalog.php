<?php

class catalog
{
    public function getCatalog()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /get_login.php");
        } else {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->query("SELECT * FROM products");
            $products = $stmt->fetchAll();
        }

        require_once "./get_catalog.php";
    }


    public function getAddProduct()
    {
        session_start();
        $errors = [];

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        } else {
            $userId = $_SESSION['user_id'];
        }

        if (empty($_POST['product_id'])) {
            $errors['product_id'] = 'Выберите продукт';
        } else {
            $productId = $_POST['product_id'];
        }

        if (empty($_POST['amount'])) {
            $errors['amount'] = 'Укажите необходимое количество продукта';
        } else {
            $amount = $_POST['amount'];
        }

        if (empty($errors)) {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM user_products WHERE user_id = :userId AND product_id = :productId");
            $stmt->execute(['userId' => $userId, 'productId' => $productId]);
            $result = $stmt->fetchAll();

            if (empty($result)) {
                $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:userId, :productId, :amount)");
                $stmt->execute(['userId' => $userId, 'productId' => $productId, 'amount' => $amount]);
                header("Location: ./cart");
            } else {
                $stmt = $pdo->prepare("UPDATE user_products SET amount = amount + :amount ");
                $stmt->execute(['amount' => $amount]);
                header("Location: ./cart");
            }

        }
    }
}