<?php

namespace Request;

class LoginRequest extends Request
{
    public function getLogin(): ?string
    {
        return $this->data['login'] ?? null;
    }

    public function getPassword(): ?string

    {
        return $this->data['password'] ?? null;
    }

    public function validate(): array       //ВАЛИДАЦИЯ ДАННЫХ ПРИ АУТЕНТИФИКАЦИИ
    {
        $errors = [];

        if (isset($this->data['login'])) {
            $login = $this->data['login'];
            if (empty($login)) {
                $errors['login'] = 'Login не может быть пустым';
            } elseif (strpos($login, '@') === false) {
                $errors['login'] = 'неверный login';
            }
        }
        if (isset($this->data['password'])) {
            $password = $this->data['password'];
            if (empty($password)) {
                $errors['password'] = 'Password не может быть пустым';
            }
        }
        return $errors;
    }

}