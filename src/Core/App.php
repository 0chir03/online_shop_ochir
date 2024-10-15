<?php


require_once './../Controller/UserController.php';
require_once './../Controller/ProductController.php';
require_once './../Controller/CartController.php';
require_once './../Controller/OrderController.php';

class App
{
    public function run()
    {
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
            } elseif ($requestMethod === "POST") {
                    $catalog = new ProductController();
                    $catalog->addProduct();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/cart') {
            if ($requestMethod === 'GET') {
                $cart = new CartController();
                $cart->getCart();
            } elseif ($requestMethod === 'POST') {
                $cart = new CartController();
                $cart->getOrder();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/order') {
            if ($requestMethod === 'POST') {
                $order = new OrderController();
                $order->createOrder();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }


        }
        else {
            require_once './../View/404.php';
        }
    }
}