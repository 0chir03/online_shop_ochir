<?php

$autoload = function(string $className) {
    $path = require_once './../Controller/$className.php';
    if (file_exists($path)) {
        require_once $path;

        return true;
    }

    return false;
};

spl_autoload_register($autoload);

class App
{
    private array $routes = [
        '/login' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getLoginForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'login',
            ]
        ],
        '/registrate' => [
            'GET' => [
                'class' => 'UserController',
                'method' => 'getRegistrateForm',
            ],
            'POST' => [
                'class' => 'UserController',
                'method' => 'registrate',
            ]
        ],
        '/catalog' => [
            'GET' => [
                'class' => 'ProductController',
                'method' => 'getCatalog',
            ],
            'POST' => [
                'class' => 'ProductController',
                'method' => 'addProduct',
            ]
        ],
        '/cart' => [
            'GET' => [
                'class' => 'CartController',
                'method' => 'getCart',
            ],
            'POST' => [
                'class' => 'CartController',
                'method' => 'getOrder',
            ]
        ],
        '/order' => [
            'GET' => [
                'class' => 'OrderController',
                'method' => 'getOrder',
            ],
            'POST' => [
                'class' => 'OrderController',
                'method' => 'createOrder',
            ]
        ],
        '/end_order' => [
            'GET' => [
                'class' => 'EndOrderController',
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