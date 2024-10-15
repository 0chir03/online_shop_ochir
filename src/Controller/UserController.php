<?php

class UserController
{

    public function getRegistrateForm()
    {
        require_once './../View/registrate.php';
    }
    public function registrate()        //РЕГИСТРАЦИЯ ПОЛЬЗОВАТЕЛЯ (ДОБАВЛЕНИЕ ДАННЫХ В БД)
    {
        $errors = $this->validateReg();
        if (empty($errors)) {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['psw'];
            $hash = password_hash($password, PASSWORD_DEFAULT);
            require_once './../Model/User.php';
            $user = new User();
            $user->create($name, $email, $hash);
            header("Location: /login");
        }
        require_once './../View/registrate.php';
    }

    private function  validateReg()      //ВАЛИДАЦИЯ ДАННЫХ ПРИ РЕГИСТРАЦИИ
    {
        $errors = [];

        if (isset($_POST['name'])) {
            $name = $_POST['name'];
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

        if (isset($_POST['email'])) {
            $email = $_POST['email'];
            if (empty($email)) {
                $errors['email'] = 'email не может быть пустым';
            } elseif (strpos($email, '@') === false) {
                $errors['email'] = 'неверный адрес';
            }
        } else {
            $errors['email'] = 'Поле email не указано';
        }

        if (isset($_POST['psw'])) {
            $password = $_POST['psw'];
            if (empty($password)) {
                $errors['password'] = 'Пароль не может быть пустым';
            } elseif (strlen($password) < 6) {
                $errors['password'] = 'Не менее 6 символов';
            }
        } else {
            $errors['password'] = "Поле password не указано";
        }

        if (isset($_POST['psw-repeat'])) {
            $passwordRep = $_POST['psw-repeat'];
            if ($passwordRep !== $password) {
                $errors['passwordRep'] = "Пароли не совпадают";
            }
        } else {
            $errors['passwordRep'] = 'Поле repeat password не указано';
        }
        return $errors;
    }

    public function getLoginForm()
    {
        require_once './../View/login.php';
    }
    public function login()       //АУТЕНТИФИКАЦИЯ ПОЛЬЗОВАТЕЛЯ
    {
        $errors = $this->validateLog();
        if (empty($errors)) {
            $login = $_POST['login'];
            $password = $_POST['password'];
            require_once './../Model/User.php';
            $user = new User();
            $data=$user->getByLogin($login);
            if ($data === false) {
                $errors['login'] = "Неверный логин или пароль";
            } else {
                $passwordFromDb = $data['password'];

                if (password_verify($password, $passwordFromDb)) {
                    session_start();
                    $_SESSION['user_id'] = $data['id'];
                    header("Location: ./catalog");
                } else {
                    $errors['password'] = 'Неверный пароль';
                }
            }
        }
        require_once './../View/login.php';
    }

    private function validateLog()       //ВАЛИДАЦИЯ ДАННЫХ ПРИ АУТЕНТИФИКАЦИИ
    {
        $errors = [];

        if (isset($_POST['login'])) {
            $login = $_POST['login'];
            if (empty($login)) {
                $errors['login'] = 'Login не может быть пустым';
            } elseif (strpos($login, '@') === false) {
                $errors['login'] = 'неверный login';
            }
        }
        if (isset($_POST['password'])) {
            $password = $_POST['password'];
            if (empty($password)) {
                $errors['password'] = 'Password не может быть пустым';
            }
        }
        return $errors;
    }
}