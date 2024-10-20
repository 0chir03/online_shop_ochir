<?php

namespace Controller;

use Model\Product;

class CartController
{
    public function getCart()       //ВЫВОД КОРЗИНЫ
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header("Location: ./login");
        } else {
            $products = new Product();
            $data = $products->getByUserId($user_id);
        }
        require_once "./../View/cart.php";
    }

    public function getOrder()       //ФОРМА ОФОРМЛЕНИЯ ЗАКАЗА
    {
        header("Location: ./order");
    }
}