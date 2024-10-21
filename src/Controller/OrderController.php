<?php

namespace Controller;

use DTO\CreateOrderDTO;
use Model\Product;
use Request\CreateOrderRequest;
use Service\OrderService;


class OrderController
{

    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
    }
    public function getOrder()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        $user_id = $_SESSION['user_id'];
        $products = new Product();
        $array = $products->getByUserId($user_id);
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
            $user_id = $_SESSION['user_id'];
            $contact_name = $request->getName();
            $contact_phone = $request->getPhone();
            $address = $request->getAddress();

            $dto = new CreateOrderDTO($contact_name, $contact_phone, $address, $user_id);

            $this->orderService->create($dto);

            header('Location: ./end_order');
        }
        require_once './../View/order.php';
    }
}

