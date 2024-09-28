<?php

$name = $_GET['name'];
$email = $_GET['email'];
$password = $_GET['psw'];
$passwordRep = $_GET['psw-repeat'];



$pdo = new PDO( 'pgsql:host=postgres;port=5432;dbname=mydb', 'user', 'pass');
$pdo->exec("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");

$result = $pdo->query("SELECT * FROM users ORDER BY id DESC");
print_r($result->fetch());