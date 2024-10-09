<?php

class index
{
    public function indexPhp()
    {
        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if ($requestUri === '/login') {
            if ($requestMethod === 'GET') {
                require_once './get_login.php';
            } elseif ($requestMethod === 'POST') {
                require_once './classes/user.php';
                $userLog = new user;
                $userLog->log();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/registrate') {
            if ($requestMethod === 'GET') {
                require_once './get_registration.php';
            } elseif ($requestMethod === 'POST') {
                require_once './classes/user.php';
                $userReg = new user;
                $userReg->reg();
            }  else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/catalog') {
            if ($requestMethod === 'GET') {
                require_once './classes/catalog.php';
                $catalog = new catalog;
                $catalog->getCatalog();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/add-product'){
            if ($requestMethod === 'GET') {
                require_once './get_catalog.php';
            } elseif ($requestMethod === "POST") {
                require_once './classes/catalog.php';
                $addProduct = new catalog;
                $addProduct->addProduct();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } elseif ($requestUri === '/cart') {
            if ($requestMethod === 'GET') {
                require_once './classes/catalog.php';
                $cart = new catalog;
                $cart->getCart();
            } else {
                echo "$requestMethod не поддерживается адресом $requestUri";
            }
        } else {
            require_once './404.php';
        }
    }

}

$start = new index();
$start->indexPhp();


