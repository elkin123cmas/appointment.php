<?php
require_once __DIR__ . '/../vendor/autoload.php';

require "functions.php";
require "config/database.php";

// Conectar a la base de datos
$db = conectarDB();

use App\ActiveRecords;

ActiveRecords::setDB($db);

// var_dump($galeria);
// Verificar si la clase Galeria se carga correctamente
// if (class_exists('App\ActiveRecords')) {
//     echo "La clase Galeria se ha cargado correctamente.";
// } else {
//     echo "Error al cargar la clase Galeria.";
// }
