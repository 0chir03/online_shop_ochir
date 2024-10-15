<?php

class ProductController
{

    public function getCatalog()        //ВЫВОД КАТАЛОГА
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: ./login");
        } else {
          require_once "./../Model/Products.php";
          $products = new Products();
          $data = $products->getProducts();
        }

        require_once "./../View/catalog.php";
    }

    public function addProduct()        //ДОБАВЛЕНИЕ ПРОДУКТА В КОРЗИНУ
    {
        session_start();
        $errors = $this->validateProduct();
        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $productId = $_POST['product_id'];
            $amount = $_POST['amount'];
            require_once "./../Model/UserProduct.php";
            $userProduct = new UserProduct();
            $result = $userProduct->getByUserIdAndProductId($userId, $productId);
            if (empty($result)) {
                $userProduct->insert($userId, $productId, $amount);
            } else {
                $userProduct->updateAmount($userId, $productId, $amount);
            }
            header("Location: ./cart");
        }
        require_once "./../View/catalog.php";
    }

    private function validateProduct()       //ВАЛИДАЦИЯ ПРОДУКТА
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