<?php

class index
{
    public function indexPhp()
    {
        require_once './../Controller/UserController.php';
        require_once './../Controller/ProductController.php';
        require_once './../Controller/CartController.php';
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestUri === '/login') {
            if ($requestMethod === 'GET') {
                $userController = new UserController();
                $userController->getLoginForm();
            } elseif ($requestMethod === 'POST') {
                $userController = new UserController();
                $userController->login();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/registrate') {
            if ($requestMethod === 'GET') {
                $userController = new UserController();
                $userController->getRegistrateForm();
            } elseif ($requestMethod === 'POST') {
                $userController = new UserController();
                $userController->registrate();
            }  else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/catalog') {
            if ($requestMethod === 'GET') {
                $catalog = new ProductController();
                $catalog->getCatalog();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/add-product'){
            if ($requestMethod === "POST") {
                $catalog = new ProductController();
                $catalog->addProduct();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/cart') {
            if ($requestMethod === 'GET') {
                $cart = new CartController();
                $cart->getCart();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } else {
            require_once './../View/404.php';
        }
    }

}

$start = new index();
$start->indexPhp();