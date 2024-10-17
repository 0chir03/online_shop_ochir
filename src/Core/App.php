<?php

namespace Core;

use Controller\UserController;
use Controller\ProductController;
use Controller\CartController;
use Controller\OrderController;
use Controller\EndOrderController;

class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getLoginForm',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'login',
            ]
        ],
        '/registrate' => [
            'GET' => [
                'class' => UserController::class,
                'method' => 'getRegistrateForm',
            ],
            'POST' => [
                'class' => UserController::class,
                'method' => 'registrate',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => ProductController::class,
                'method' => 'getCatalog',
            ],
            'POST' => [
                'class' => ProductController::class,
                'method' => 'addProduct',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => CartController::class,
                'method' => 'getCart',
            ],
            'POST' => [
                'class' => CartController::class,
                'method' => 'getOrder',
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => OrderController::class,
                'method' => 'getOrder',
            ],
            'POST' => [
                'class' => OrderController::class,
                'method' => 'createOrder',
            ]
        ],
        '/end_order' => [
            'GET' => [
                'class' => EndOrderController::class,
                'method' => 'getForm',
            ],
        ],
    ];


    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (array_key_exists($requestUri, $this->routes)) {
            if (array_key_exists($requestMethod, $this->routes[$requestUri])) {
                $class = new $this->routes[$requestUri][$requestMethod]['class'];
                $method = $this->routes[$requestUri][$requestMethod]['method'];
                $class->$method();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } else {
            require_once './../View/404.php';
        }
    }
}