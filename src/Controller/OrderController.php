<?php

namespace Controller;

use DTO\CreateOrderDTO;
use Model\Product;
use Request\CreateOrderRequest;
use Service\AuthService;
use Service\OrderService;


class OrderController
{

    private OrderService $orderService;
    private AuthService $authService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        $this->authService = new AuthService();
    }
    public function getOrder()
    {
        if (!$this->authService->check()) {
            header('Location: ./login');
        }

        $userId = $this->authService->getCurrentUser()->getId();
        $products = new Product();
        $array = $products->getByUserId($userId);
        $sum = 0;
        foreach ($array as $key) {
            $sum = $sum + $key->getPrice() * $key->getAmount();
        }
        require_once './../View/order.php';
    }
    public function createOrder(CreateOrderRequest $request)
    {
        session_start();
        $errors = $request->validate();
        if (empty($errors)) {
            $userId = $this->authService->getCurrentUser()->getId();
            $contactName = $request->getName();
            $contactPhone = $request->getPhone();
            $address = $request->getAddress();

            $dto = new CreateOrderDTO($contactName, $contactPhone, $address, $userId);

            $this->orderService->create($dto);

            header('Location: ./end_order');
        }
        require_once './../View/order.php';
    }
}

