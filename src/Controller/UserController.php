<?php

namespace Controller;

use Model\User;
use Request\RegistrateRequest;
use Request\LoginRequest;
use Service\AuthService;

class UserController
{
    private AuthService $authService;
    public function __construct()
    {
        $this->authService = new AuthService();
    }

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
            User::create($name, $email, $hash);
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

            if ($this->authService->login($login, $password) === false) {
                $errors['login'] = "Неверный логин или пароль";
            }
            header("Location: ./catalog");
        }
        require_once './../View/login.php';
    }
}