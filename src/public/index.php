<?php

require_once './../Core/Autoload.php';

use Core\App;
use Core\Autoload;
use Controller\UserController;
use Controller\ProductController;
use Controller\CartController;
use Controller\OrderController;
use Controller\EndOrderController;
use Request\RegistrateRequest;
use Request\LoginRequest;
use Request\AddProductRequest;
use Request\CreateOrderRequest;

Autoload::registrate(__DIR__ . '/../');

$index = new App();

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

$index->run();

