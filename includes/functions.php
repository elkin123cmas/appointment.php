<?php

// require "app.php";

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCTIONS_URL', __DIR__ . 'functions.php');

function incluir_template(string $nombre, bool $nameAdmin = false, bool $delete = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

// function estaAutenticado(): bool
// {
//     session_start();
//     $auth = $_SESSION['login'];

//     if ($auth) {
//         return true;
//     }
//     return false;
// }
function estaAutenticado(): bool
{
    session_start();
    return isset($_SESSION['login']) && $_SESSION['login'];
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
