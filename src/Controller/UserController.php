<?php

namespace Controller;

use Model\User;
use Request\RegistrateRequest;
use Request\LoginRequest;

class UserController
{

    public function getRegistrateForm()
    {
        require_once './../View/registrate.php';
    }
    public function registrate(RegistrateRequest $request)        //РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ (ДОБАВЛЕНИЕ ДАННЫХ В БД)
    {

        $errors = $request->validate();
        if (empty($errors)) {
            $name = $request->getName();
            $email = $request->getEmail();
            $password = $request->getPassword();
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $user = new User();
            $user->create($name, $email, $hash);
            header("Location: /login");
        }
        require_once './../View/registrate.php';
    }

    public function getLoginForm()
    {
        require_once './../View/login.php';
    }
    public function login(LoginRequest $request)       //АУТЕНТИФИКАЦИЯ ПОЛЬЗОВАТЕЛЯ
    {
        $errors = $request->validate();
        if (empty($errors)) {
            $login = $request->getLogin();
            $password = $request->getPassword();
            $user = new User();
            $data=$user->getByLogin($login);
            if ($data === null) {
                $errors['login'] = "Неверный логин или пароль";
            } else {
                $passwordFromDb = $data->getPassword();

                if (password_verify($password, $passwordFromDb)) {
                    session_start();
                    $_SESSION['user_id'] = $data->getId();
                    header("Location: ./catalog");
                } else {
                    $errors['password'] = 'Неверный пароль';
                }
            }
        }
        require_once './../View/login.php';
    }


}