<?php

session_start();
$errors = [];

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    if (!empty($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
                 if (!empty($_POST['amount'])) {
                    $amount = $_POST['amount'];
                    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
                    $stmt = $pdo->prepare("INSERT INTO user_products (user_id, product_id, amount) VALUES (:user_id, :product_id, :amount)");
                    $stmt->execute(['user_id' => $user_id, 'product_id' => $product_id, 'amount' => $amount]);
                    header("Location: ./card");
                } else {
                     $errors['amount'] = 'Укажите необходимое количество продукта';
                  }
            } else {
                $errors['product_id'] = 'Выберите продукт';
         }
    } else {
        header('Location: ./login');
}

require_once './get_add_product.php';
