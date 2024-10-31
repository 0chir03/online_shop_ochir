<?php

namespace Request;

class AddReviewRequest extends Request
{
    public function getProductId(): ? int
    {
        return $this->data['product_id'] ?? null;
    }

    public function getComment(): ?string
    {
        return $this->data['comment'] ?? null;
    }

    public function getRating(): ?string

    {
        return $this->data['rating'] ?? null;
    }

    public function validate()       //ВАЛИДАЦИЯ ПРОДУКТА
    {
        $errors = [];

        if (!isset($_SESSION['user_id'])) {
            header('Location: ./login');
        }

        if (empty($this->data['comment'])) {
            $errors['comment'] = 'Напишите отзыв';
        }

        return $errors;
    }
}

