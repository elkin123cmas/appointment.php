<?php
//importar la conexion
// require 'includes/config/database.php';
require 'includes/app.php';
$db = conectarDB();
//crear un email y password
$email = "correo@correo.com";
$token = "123456";

$tokenHash = password_hash($token, PASSWORD_DEFAULT);
// var_dump($tokenHash);

//query para crear el usuario
$query = "INSERT INTO usuarios (email, token) VALUES ('{$email}', '{$tokenHash}')";
echo $query;
exit;

//agregarlos a la base de datos
mysqli_query($db, $query);
