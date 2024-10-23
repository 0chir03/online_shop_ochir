<?php

namespace Controller;

use Model\Product;
use Request\AddProductRequest;
use Service\AuthService;
use Service\CartService;


class ProductController
{

    private CartService $cartService;
    private AuthService $authService;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->authService = new AuthService();
    }

    public function getCatalog()        //ВЫВОД КАТАЛОГА
    {
        session_start();

        if (!$this->authService->check()) {
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
            $userId = $this->authService->getCurrentUser()->getId();
            $productId = $request->getProductId();
            $amount = $request->getAmount();

            $this->cartService->add($userId, $productId, $amount);

            header("Location: ./cart");
        }
        require_once "./../View/catalog.php";
    }

}