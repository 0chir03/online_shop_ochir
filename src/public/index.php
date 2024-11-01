<?php

require_once './../Core/Autoload.php';

use Controller\CartController;
use Controller\EndOrderController;
use Controller\OrderController;
use Controller\ProductController;
use Controller\UserController;
use Controller\ReviewController;
use Core\App;
use Core\Autoload;
use Request\AddProductRequest;
use Request\CreateOrderRequest;
use Request\LoginRequest;
use Request\RegistrateRequest;
use \Request\AddReviewRequest;

Autoload::registrate(__DIR__ . '/../');

$container = new \Core\Container();

$container->set(CartController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);

    return new CartController($authService);
});

$container->set(OrderController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $orderService = new \Service\OrderService();

    return new OrderController($authService, $orderService);
});

$container->set(ProductController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);
    $cartService = new \Service\CartService();
    $ratingService = new \Service\RatingService();
    $getReviewService = new \Service\GetReviewService();
    $addReviewService = new \Service\AddReviewService();

    return new ProductController($authService, $cartService, $ratingService, $getReviewService, $addReviewService);
});

$container->set(UserController::class, function (\Core\Container $container) {
    $authService = $container->get(\Service\Auth\AuthServiceInterface::class);

    return new UserController($authService);
});

$container->set(\Service\CartService::class, function (\Core\Container $container) {
    $userProduct = $container->get(\Service\CartService::class);

    return new \Service\CartService($userProduct);
});

$container->set(\Service\CartService::class, function (\Core\Container $container) {
    $userProduct = $container->get(\Service\CartService::class);

    return new \Service\CartService($userProduct);
});

$container->set(\Service\Logger\LoggerServiceInterface::class, function () {
    return new \Service\Logger\LoggerFileService();
});

$container->set(\Service\Auth\AuthServiceInterface::class, function () {
    return new \Service\Auth\AuthSessionService();
});

$loggerService = $container->get(\Service\Logger\LoggerServiceInterface::class);

$index = new App($loggerService, $container);

$index->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$index->addRoute('/login', 'POST', UserController::class, 'login', LoginRequest::class);
$index->addRoute('/registrate', 'GET', UserController::class, 'getRegistrateForm');
$index->addRoute('/registrate', 'POST', UserController::class, 'registrate', RegistrateRequest::class);
$index->addRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$index->addRoute('/catalog', 'POST', ProductController::class, 'addProduct', AddProductRequest::class);
$index->addRoute('/cart', 'GET', CartController::class, 'getCart');
$index->addRoute('/cart', 'POST', CartController::class, 'getOrder');
$index->addRoute('/order', 'GET', OrderController::class, 'getOrder');
$index->addRoute('/order', 'POST', OrderController::class, 'createOrder', CreateOrderRequest::class);
$index->addRoute('/end_order', 'GET', EndOrderController::class, 'getForm');
$index->addRoute('/product', 'POST', ProductController::class, 'getProduct', AddProductRequest::class);
$index->addRoute('/add_review', 'POST', ProductController::class, 'addReview', AddReviewRequest::class);

$index->run();

