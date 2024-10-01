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

    if (password_verify($password, $data['password'])) {
        echo "GOOD!!!";
    } else {
        $errors['password'] = 'Неверный логин или пароль';
    }
}

require_once './get_login.php';