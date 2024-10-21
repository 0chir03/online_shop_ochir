<?php

namespace Controller;

use Model\Product;
use Request\AddProductRequest;
use Service\AddProductService;
use DTO\CreateAddProductDTO;

class ProductController
{

    private AddProductService $addProductService;

    public function __construct()
    {
        $this->addProductService = new AddProductService();
    }
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

            $dto = new CreateAddProductDTO($userId, $productId, $amount);

            $this->addProductService->add($dto);

            header("Location: ./cart");
        }
        require_once "./../View/catalog.php";
    }

}