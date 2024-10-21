<?php

namespace Request;

class AddProductRequest extends Request
{
    public function getProductId(): ?string
    {
        return $this->data['product_id'] ?? null;
    }

    public function getAmount(): ?string

    {
        return $this->data['amount'] ?? null;
    }

    public function validate()       //ВАЛИДАЦИЯ ПРОДУКТА
    {
        $errors = [];

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        if (empty($this->data['product_id'])) {
            $errors['product_id'] = 'Выберите продукт';
        }

        if (empty($this->data['amount'])) {
            $errors['amount'] = 'Укажите необходимое количество продукта';
        }
        return $errors;
    }

}