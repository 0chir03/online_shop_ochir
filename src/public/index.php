<?php

require_once './../Core/Autoload.php';

use Core\App;
use Core\Autoload;
use Controller\UserController;
use Controller\ProductController;
use Controller\CartController;
use Controller\OrderController;
use Controller\EndOrderController;

Autoload::registrate(__DIR__ . '/../');

$index = new App();

$index->addRoute('/login', 'GET', UserController::class, 'getLoginForm');
$index->addRoute('/login', 'POST', UserController::class, 'login');
$index->addRoute('/registrate', 'GET', UserController::class, 'getRegistrateForm');
$index->addRoute('/registrate', 'POST', UserController::class, 'registrate');
$index->addRoute('/catalog', 'GET', ProductController::class, 'getCatalog');
$index->addRoute('/catalog', 'POST', ProductController::class, 'addProduct');
$index->addRoute('/cart', 'GET', CartController::class, 'getCart');
$index->addRoute('/cart', 'POST', CartController::class, 'getOrder');
$index->addRoute('/order', 'GET', OrderController::class, 'getOrder');
$index->addRoute('/order', 'POST', OrderController::class, 'createOrder');
$index->addRoute('/end_order', 'GET', EndOrderController::class, 'getForm');

$index->run();

