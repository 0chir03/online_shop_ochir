<?php

$requestUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestUri === '/login') {
    if ($requestMethod === 'GET') {
        require_once './get_login.php';
    } elseif ($requestMethod === 'POST') {
        require_once './classes/user.php';
        $userLog = new user;
        $userLog->validateLog();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif ($requestUri === '/registrate') {
    if ($requestMethod === 'GET') {
        require_once './get_registration.php';
    } elseif ($requestMethod === 'POST') {
        require_once './classes/user.php';
        $userReg = new user;
        $userReg->validateReg();
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
        require_once './get_add_product.php';
    } elseif ($requestMethod === "POST") {
        require_once './classes/catalog.php';
        $addProduct = new catalog;
        $addProduct->getAddProduct();
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} elseif ($requestUri === '/cart') {
    if ($requestMethod === 'GET') {
        require_once './get_cart.php';
    } else {
        echo "$requestMethod не поддерживается адресом $requestUri";
    }
} else {
    require_once './404.php';
}