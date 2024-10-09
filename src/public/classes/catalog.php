<?php

class catalog
{
    public function getCatalog()        //ВЫВОД КАТАЛОГА
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


    public function validateProduct()       //ВАЛИДАЦИЯ ПРОДУКТА
    {
        $errors = [];

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        if (empty($_POST['product_id'])) {
            $errors['product_id'] = 'Выберите продукт';
        }

        if (empty($_POST['amount'])) {
            $errors['amount'] = 'Укажите необходимое количество продукта';
        }
        return $errors;
    }
    public function addProduct()        //ДОБАВЛЕНИЕ ПРОДУКТА В КОРЗИНУ
    {
        session_start();
        $errors = $this->validateProduct();
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];
        $amount = $_POST['amount'];
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


    public function getCart()       //ВЫВОД КОРЗИНЫ
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: /get_login.php");
        } else {
            $user_id = $_SESSION['user_id'];
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
            $stmt = $pdo->prepare("SELECT * FROM products INNER JOIN user_products ON products.id = user_products.product_id WHERE user_products.user_id = :user_id");
            $stmt->execute(['user_id' => $user_id]);
            $data = $stmt->fetchAll();
        }
        require_once "./get_cart.php";
    }
}