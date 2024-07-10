<?php
require 'includes/app.php';

// $auth = estaAutenticado();

// if (!$auth) {
//     header('Location: /');
// };
if (!estaAutenticado()) {
  header('Location: /index.php');
  exit;
}
incluir_template('header');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Galeria</title>
  <link rel="stylesheet" href="build/css/app.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <main class=" appuntment">
    <div class="containImgLeft">
      <img src="src/assets/image/imgReal.jpg" alt="Imagen Calavera" />
      <div class="effectText"></div>
      <h2 class="textEtern">Prepárate para lo eterno</h2>
    </div>
    <div class="contenidoGaleriaOpciones">
      <div class="containTitle ab">
        <h2 class="title">¡Bienvenidos a nuestro santuario del arte sin fin!</h2>
        <p class="descripcion">
          Aquí, cada tatuaje susurra relatos oscuros y enigmáticos, eternamente sellados en la piel.
        </p>
      </div>




      <?php
      include 'includes/templates/galeriaTotal.php';
      ?>






      <div class="containNextBack">
        <button id="back-appoun" class="btn-send back" style="margin: 5rem auto 0 auto; ">Volver</button>
      </div>
    </div>

  </main>
  <div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
  </div>
  <script src="/src/js/app.js"></script>
</body>

</html>