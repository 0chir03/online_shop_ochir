<?php

namespace Controller;

use Model\Product;
use Service\Auth\AuthServiceInterface;

class CartController
{
    private AuthServiceInterface $authService;
    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }
    public function getCart()       //ВЫВОД КОРЗИНЫ
    {
        $userId = $this->authService->getCurrentUser()->getId();
        if (!isset($userId)) {
            header("Location: ./login");
        } else {
            $data = Product::getByUserId($userId);
        }
        require_once "./../View/cart.php";
    }

    public function getOrder()       //ФОРМА ОФОРМЛЕНИЯ ЗАКАЗА
    {
        header("Location: ./order");
    }
}