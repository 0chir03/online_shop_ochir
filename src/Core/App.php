<?php

namespace Core;

use Request\Request;
use Service\Logger\LoggerServiceInterface;

class App
{
    private array $routes = [];
    private LoggerServiceInterface $loggerService;
    private Container $container;

    public function __construct(LoggerServiceInterface $loggerService, Container $container)
    {
        $this->loggerService = $loggerService;
        $this->container = $container;
    }
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

               $object = $this->container->get($controllerClassName);

               try {
                   return $object->$method($request);
               } catch (\Throwable $exception) {

                   $this->loggerService->error('Произошла ошибка при обработке запроса', [
                       'message' => $exception->getMessage(),
                       'file' => $exception->getFile(),
                       'line' => $exception->getLine(),
                   ]);

                   http_response_code(500);
                   require_once "./../View/500.php";
               }
           } else {
               echo "$requestMethod не поддерживается адресом $requestUri";
           }
        } else {
            http_response_code(404);
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