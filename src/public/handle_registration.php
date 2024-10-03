<?php

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

if (empty($errors)) {
    $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
    header("Location: ./login");
}

require_once './get_registration.php';


