<?php

class CartController
{
    public function getCart()       //ВЫВОД КОРЗИНЫ
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header("Location: ./../View/login.php");
        } else {
            $user_id = $_SESSION['user_id'];
            require_once './../Model/UserProduct.php';
            $userProduct = new UserProduct();
            $data = $userProduct->getByIdAndProductIdWhereUserId($user_id);
        }
        require_once "./../View/cart.php";
    }
}