<?php

namespace Controller;

use Model\Product;
use Model\UserProduct;
use Request\AddProductRequest;

class ProductController
{

    public function getCatalog()        //ВЫВОД КАТАЛОГА
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: ./login");
        } else {
          $products = new Product();
          $data = $products->getProducts();
        }

        require_once "./../View/catalog.php";
    }

    public function addProduct(AddProductRequest $request)        //ДОБАВЛЕНИЕ ПРОДУКТА В КОРЗИНУ
    {
        session_start();
        $errors = $request->validate();
        if (empty($errors)) {
            $userId = $_SESSION['user_id'];
            $productId = $request->getProductId();
            $amount = $request->getAmount();
            $userProduct = new UserProduct();
            $result = $userProduct->getByUserIdAndProductId($userId, $productId);
            if ($result === null) {
                $userProduct->insert($userId, $productId, $amount);
            } else {
                $userProduct->updateAmount($userId, $productId, $amount);
            }
            header("Location: ./cart");
        }
        require_once "./../View/catalog.php";
    }

}