<?php

namespace Request;

class RegistrateRequest extends Request
{
    public function getName(): ?string
    {
        return $this->data['name'] ?? null;
    }
    public function getEmail(): ?string
    {
        return $this->data['email'] ?? null;
    }

    public function getPassword(): ?string

    {
     return $this->data['psw'] ?? null;
    }


    public function  validate(): array      //ВАЛИДАЦИЯ ДАННЫХ ПРИ РЕГИСТРАЦИИ
    {

        $data = $this->getData();
        $errors = [];

        if (isset($this->data['name'])) {
            $name = $this->data['name'];
            if (empty($name)) {
                $errors['name'] = 'Имя не может быть пустым';
            } elseif (strlen($name) < 2) {
                $errors['name'] = 'Не менее 2 символов';
            } elseif (is_numeric($name)) {                          //
                $errors['name'] = 'Имя не должен быть числом';      //Проверяет, что имя не является числом
            }                                                       //
        } else {
            $errors['name'] = 'Поле name не указано';
        }

        if (isset($this->data['email'])) {
            $email = $this->data['email'];
            if (empty($email)) {
                $errors['email'] = 'email не может быть пустым';
            } elseif (strpos($email, '@') === false) {
                $errors['email'] = 'неверный адрес';
            }
        } else {
            $errors['email'] = 'Поле email не указано';
        }

        if (isset($this->data['psw'])) {
            $password = $this->data['psw'];
            if (empty($password)) {
                $errors['password'] = 'Пароль не может быть пустым';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'Не менее 6 символов';
            }
        } else {
            $errors['password'] = "Поле password не указано";
        }

        if (isset($this->data['psw-repeat'])) {
            $passwordRep = $this->data['psw-repeat'];
            if ($passwordRep !== $password) {
                $errors['passwordRep'] = "Пароли не совпадают";
            }
        } else {
            $errors['passwordRep'] = 'Поле repeat password не указано';
        }
        return $errors;
    }

}