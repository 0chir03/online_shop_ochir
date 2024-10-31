<?php

namespace Controller;

use Model\Product;
use Model\OrderProduct;
use Request\AddProductRequest;
use Request\AddReviewRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Model\Review;


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
            $data = Product::getProducts();
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

    public function getProduct(AddProductRequest $request)        //ПЕРЕЙТИ К ОПИСАНИЮ ПРОДУКТА
    {
        if (!$this->authService->check()) {
            header("Location: ./login");
        } else {
            $productId = $request->getProductId();
            $data = Product::getByProdId($productId);
            $array = Review::getByProdId($productId);
            $sum = 0;
            if ($array !== null) {
                foreach ($array as $item) {
                    $sum = $sum + $item->getRating();
                }
                $count = count($array);
                $averageRating = $sum/$count;
            } else {
                $averageRating = 0;
            }
        }
       require_once "./../View/product.php";
    }

    public function addReview(AddReviewRequest $request)        //ДОБАВИТЬ ОТЗЫВ О ПРОДУКТЕ
    {
        if (!$this->authService->check()) {
            header("Location: ./login");
        } else {
            $errors = $request->validate();
            if (empty($errors)) {
                $productId = $request->getProductId();
                $array = OrderProduct::getOrderProducts($productId);
                if (!empty($array)) {
                        foreach ($array as $item) {
                                $product = $item->getProductId();
                                if (empty($product)) {
                                    echo "Для того, чтобы оставить отзыв, необходимо сделать заказ";
                                }
                            }
                        $userId = $this->authService->getCurrentUser()->getId();
                        $comment = $request->getComment();
                        $rating = $request->getRating();
                        $date = date("Y-m-d");
                        Review::create($userId, $productId, $date, $rating, $comment);
                        echo "Благодарим за отзыв";
                } else {
                    echo "Для того, чтобы оставить отзыв, необходимо приборести наш продукт";
                }
            }
        }
    }
}