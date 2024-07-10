<?php
function conectarDB(): mysqli
{
    $db = new mysqli('localhost', 'root', 'root', 'tattoo_crud');
    if ($db->connect_error) {
        echo "No se pudo conectar a la base de datos. Error: " . $db->connect_error;
        exit;
    }
    return $db;
}
