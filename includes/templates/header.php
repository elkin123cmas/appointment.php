<?php
// require 'includes/config/database.php';
// $db = conectarDB();

if (!isset($_SESSION)) {
  session_start();
}
$auth = $_SESSION['login'] ?? false;

// obtenemos  la ruta actual del archivo
$currentPath = $_SERVER['PHP_SELF'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Invikto</title>
  <link rel="stylesheet" href="/build/css/app.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <main class="containGeneralFlex appuntment">
    <div class="containImgLeft">
      <img src="/src/assets/image/imgSkull3.jpg" alt="Imagen Calavera" />
      <div class="effectText"></div>
      <h2 class="textEtern">Prepárate para lo eterno</h2>
    </div>
    <div class="containInfoAPP">
      <div class="containTitle ab">

        <?php
        // verificamos  si $nameAdmin es verdadero o falso y muestra el título correspondiente
        if ($nameAdmin) {
          echo '<h2 class="title">Bienvenido Administrador</h2>';
          echo '<p class="descripcion">¡Prepara tus sombras y afila tus agujas!</p>';
        } else {
          echo '<h2 class="title">Bienvenidos a Invikto</h2>';
          echo '<p class="descripcion">Elige el servicio que deseas consultar</p>';
        }
        ?>

      </div>
      <div class="cerrarSesion">
        <?php  ?>
        <h3 class="nameUser">Hola, Michael Jackson</h3>
        <?php if ($auth) : ?>
          <a class="clouseSession" href="../../cerrarSesion.php">Cerrar Sesión</a>

        <?php endif; ?>
      </div>
      <div class="infoBar barOption">

        <?php
        if ($nameAdmin) {
          $activeClassCrear = (strpos($currentPath, '/admin/propiedades/crear.php') !== false) ? 'changeActive' : '';
          $activeClassCreados = (strpos($currentPath, '/admin/index.php') !== false) ? 'changeActive' : '';

          echo '<a href="/admin/propiedades/crear.php" class="sectionInfo ' . $activeClassCrear . '">Crear</a>';
          echo '<a href="/admin/propiedades/actualizar.php" class="sectionInfo ' . $activeClassCreados . '">Creados</a>';
          echo '<a href="#" id="verCitas" class="sectionInfo">Ver citas</a>';
          echo '<a href="#" id="verServicios" class="sectionInfo">Ver servicios</a>';
          echo '<a href="#" id="nuevoServicio" class="sectionInfo">Nuevo servicio</a>';
        } else {
          echo '<a href="#" id="verCitas" class="sectionInfo">Ver citas</a>';
          echo '<a href="#" id="verServicios" class="sectionInfo">Ver servicios</a>';
          echo '<a href="#" id="nuevoServicio" class="sectionInfo">Nuevo servicio</a>';
        }
        ?>

      </div>

      <script src="/src/js/app.js"></script>