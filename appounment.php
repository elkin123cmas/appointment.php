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

<div class="containSectionEstilos ">
  <div class="containTitle">
    <h2 class="title">Estilos</h2>
    <p class="descripcion">Marca tu piel con la oscuridad de tu alma.</p>
  </div>
  <?php
  include 'includes/templates/anuncios.php';
  ?>
</div>


</div>
</main>
<script src="/src/js/app.js"></script>
</body>

</html>