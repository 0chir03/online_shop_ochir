<?php

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

if (empty($errors)) {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :login");
    $stmt->execute(['login' => $login]);
    $data = $stmt->fetch();

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

require_once './get_login.php';