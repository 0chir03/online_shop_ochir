<?php

class OrderController
{
    public function createOrder()
    {
        session_start();
        $errors = $this->validateOrder();
        if (empty($errors)) {
            $user_id = $_SESSION['user_id'];
            $contact_name = $_POST['name'];
            $contact_phone = $_POST['phone'];
            $address = $_POST['address'];
            $sum = $_POST['sum'];
            require_once "./../Model/Order.php";
            $order ->create($contact_name, $contact_phone, $address, $sum, $user_id);
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

