<?php

namespace Controller;

use Model\Product;
use Request\AddProductRequest;
use Request\AddReviewRequest;
use Service\Auth\AuthServiceInterface;
use Service\CartService;
use Model\Review;
use Service\RatingService;
use Service\GetReviewService;
use Service\AddReviewService;

class ProductController
{

    private CartService $cartService;
    private AuthServiceInterface $authService;
    private RatingService $ratingService;
    private GetReviewService $getReviewService;
    private AddReviewService $addReviewService;

    public function __construct(AuthServiceInterface $authService,
                                CartService $cartService,
                                RatingService $ratingService,
                                GetReviewService $getReviewService,
                                AddReviewService $addReviewService)
    {
        $this->cartService = $cartService;
        $this->authService = $authService;
        $this->ratingService = $ratingService;
        $this->getReviewService = $getReviewService;
        $this->addReviewService = $addReviewService;
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
            $reviews = Review::getByProdId($productId);
            $averageRating = $this->ratingService->get($reviews);
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
                $userId = $this->authService->getCurrentUser()->getId();
                $productId = $request->getProductId();
                $this->addReviewService->add($productId, $userId, $request);
            }
        }
        //require_once "./../View/product.php";
    }
}