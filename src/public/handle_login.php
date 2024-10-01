<?php

$login = $_POST['login'];
$password = $_POST['password'];
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
    $result = $pdo->prepare("SELECT password FROM users WHERE email = :login");
    $result->execute(['login' => $login]);
    $stmt = $result->fetch();
}

if (empty($stmt[0])) {
    $errors['login'] = "Неверный логин";
    } elseif (password_verify($password, $stmt[0])) {
    echo "GOOD!!!";
} else {
    $errors['password'] = 'Неверный пароль';
}

require_once './get_login.php';