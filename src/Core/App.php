<?php

namespace Core;

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

               $class = new $controllerClassName();
               return $class->$method();
           } else {
               echo "$requestMethod не поддерживается адресом $requestUri";
           }
        } else {
            require_once './../View/404.php';
        }
    }


    public function addRoute(string $route, string $method, string $className, string $methodName)
    {
       $this->routes[$route][$method] = [
            'class' => $className,
            'method' => $methodName,
        ];
    }
}