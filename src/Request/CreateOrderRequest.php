<?php

namespace Request;

class CreateOrderRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }

    public function getPhone(): ?string

    {
        return $this->data['phone'] ?? null;
    }

    public function getAddress(): ?string

    {
        return $this->data['address'] ?? null;
    }

    public function validate()       //ВАЛИДАЦИЯ ЗАКАЗА
    {
        $errors = [];

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        if (empty($this->data['name'])) {
            $errors['name'] = 'Укажите своё имя';
        } elseif (strlen($this->data['name']) < 2) {
            $errors['name'] = 'Не менее 2 символов';
        } elseif (is_numeric($this->data['name'])) {
            $errors['name'] = 'Имя не должен быть числом';      //Проверяет, что имя не является числом
        }

        if (strlen($this->data['phone']) < 9) {
            $errors['phone'] = 'Не менее 9 символов';
        }

        if (empty($this->data['address'])) {
            $errors['address'] = 'Укажите адрес доставки';
        }
        return $errors;
    }

}