<?php

namespace Controller;

use Model\Products;
use Model\Order;
use Model\UserProduct;
use Model\OrderProduct;


class OrderController
{
    public function getOrder()
    {
        session_start();

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        $user_id = $_SESSION['user_id'];
        $products = new Products();
        $array = $products->getByUserId($user_id);
        $sum = 0;
        foreach ($array as $key) {
            $sum = $sum + $key['price'] * $key['amount'];
        }
        require_once './../View/order.php';
    }
    public function createOrder()
    {
        session_start();
        $errors = $this->validateOrder();
        if (empty($errors)) {
            $user_id = $_SESSION['user_id'];
            $contact_name = $_POST['name'];
            $contact_phone = $_POST['phone'];
            $address = $_POST['address'];

            $products = new Products();
            $array = $products->getByUserId($user_id);
            $sum = 0;
            foreach ($array as $key) {
                $sum = $sum + $key['price'] * $key['amount'];
            }
            $order = new Order();
            $result = $order->create($contact_name, $contact_phone, $address, $sum, $user_id);
            $order_id = $result['id'];
            $user_products = new UserProduct();
            $product = $user_products->getByUserId($user_id);
            $total_price = 0;
            foreach ($product as $key) {
                $product_id = $key['product_id'];
                $amount = $key['amount'];

                $data = $products->getByProductId($product_id);
                $price = $data['price'];
                $total_price = $price * $amount;

                $order_product = new OrderProduct();
                $order_product->create($order_id, $product_id, $amount, $total_price);

            }
            $user_products->deleteByUserId($user_id);
            header('Location: ./end_order');
        }
        require_once './../View/order.php';
    }

    private function validateOrder()       //ВАЛИДАЦИЯ ЗАКАЗА
    {
        $errors = [];

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        if (empty($_POST['name'])) {
            $errors['name'] = 'Укажите своё имя';
        } elseif (strlen($_POST['name']) < 2) {
            $errors['name'] = 'Не менее 2 символов';
        } elseif (is_numeric($_POST['name'])) {                          //
            $errors['name'] = 'Имя не должен быть числом';      //Проверяет, что имя не является числом
        }

        if (strlen($_POST['phone']) < 9) {
            $errors['phone'] = 'Не менее 9 символов';
        }

        if (empty($_POST['address'])) {
            $errors['address'] = 'Укажите адрес доставки';
        }
        return $errors;
    }
}

