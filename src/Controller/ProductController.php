<?php

class ProductController
{

    public function getCatalog()        //ВЫВОД КАТАЛОГА
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: ./../View/login.php");
        } else {
          require_once "./../Model/UserProduct.php";
          $userProduct = new UserProduct();
          $products = $userProduct->getProducts();
        }

        require_once "./../View/catalog.php";
    }

    public function addProduct()        //ДОБАВЛЕНИЕ ПРОДУКТА В КОРЗИНУ
    {
        session_start();
        $errors = $this->validateProduct();
        $userId = $_SESSION['user_id'];
        $productId = $_POST['product_id'];
        $amount = $_POST['amount'];
        if (empty($errors)) {
            require_once "./../Model/UserProduct.php";
            $userProduct = new UserProduct();
            $result = $userProduct->getByUserIdAndProductId($userId, $productId);
            if (empty($result)) {
                $userProduct->insertValues($userId, $productId, $amount);
                header("Location: ./cart");
            } else {
                $userProduct->updateValues($amount);
                header("Location: ./cart");
            }
        }
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

}