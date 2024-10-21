<?php

namespace Core;

use Request\Request;

class App
{
    private array $routes = [];

    public function run()
    {

        $requestUri = $_SERVER['REQUEST_URI'];
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (isset($this->routes[$requestUri])) {
           $route = $this->routes[$requestUri];

           if (isset($route[$requestMethod])) {
               $controllerClassName = $route[$requestMethod]['class'];
               $method = $route[$requestMethod]['method'];
               $requestClass = $route[$requestMethod]['request'];

               if (!empty($requestClass)) {
                   $request = new $requestClass($requestUri, $requestMethod, $_POST);
               } else {
                   $request = new Request($requestUri, $requestMethod, $_POST);
               }

               $class = new $controllerClassName();

               return $class->$method($request);
           } else {
               echo "$requestMethod не поддерживается адресом $requestUri";
           }
        } else {
            require_once './../View/404.php';
        }
    }


    public function addRoute(string $route, string $method, string $className, string $methodName, string $requestClass = null)
    {
       $this->routes[$route][$method] = [
            'class' => $className,
            'method' => $methodName,
            'request' => $requestClass,
        ];
    }
}