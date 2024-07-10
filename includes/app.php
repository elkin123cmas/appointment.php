<?php
require_once __DIR__ . '/../vendor/autoload.php';

require "functions.php";
require "config/database.php";

// Conectar a la base de datos
$db = conectarDB();

use App\Galeria;

Galeria::setDB($db);

// var_dump($galeria);
