<?php

namespace Controller;

use Model\Product;
use Request\AddProductRequest;
use Service\Auth\AuthServiceInterface;
use Service\Auth\AuthSessionService;
use Service\CartService;


class ProductController
{

    private CartService $cartService;
    private AuthServiceInterface $authService;

    public function __construct(AuthServiceInterface $authService, CartService $cartService)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
    }

    public function getCatalog()        //ВЫВОД КАТАЛОГА
    {
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