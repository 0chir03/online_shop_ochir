<?php

class CartController
{
    public function getCart()       //ВЫВОД КОРЗИНЫ
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        if (!isset($user_id)) {
            header("Location: ./login");
        } else {
            require_once './../Model/Products.php';
            $products = new Products();
            $data = $products->getByUserId($user_id);
        }
        require_once "./../View/cart.php";
    }

    public function getOrder()       //ФОРМА ОФОРМЛЕНИЯ ЗАКАЗА
    {
        session_start();
        $user_id = $_SESSION['user_id'];
        require_once './../Model/Products.php';
        $products = new Products();
        $array = $products -> getPriceAndAmount($user_id);
        $sum = 0;
        foreach ($array as $key) {
            $sum = $sum + $key['price'] * $key['amount'];
        }
        require_once './../View/order.php';
    }
}