<?php

namespace Controller;

use Model\Product;
use Service\AuthService;

class CartController
{
    private AuthService $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }
    public function getCart()       //ВЫВОД КОРЗИНЫ
    {
        $userId = $this->authService->getCurrentUser()->getId();
        if (!isset($userId)) {
            header("Location: ./login");
        } else {
            $products = new Product();
            $data = $products->getByUserId($userId);
        }
        require_once "./../View/cart.php";
    }

    public function getOrder()       //ФОРМА ОФОРМЛЕНИЯ ЗАКАЗА
    {
        header("Location: ./order");
    }
}