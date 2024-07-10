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



<!-- seccion AGENDA -->
<div class="containSection">
  <div class="containTitle">
    <h2 class="title">Agenda tu cita</h2>
    <p class="descripcion">Ingresa tus datos y la fecha de tu cita</p>
    <div class="containFormInit appoun">
      <form action="" class="formInit">
        <div class="input-container">
          <input type="text" placeholder="Nombre..." class="inputIntern" />
          <i class="fa-solid fa-user icon"></i>
        </div>
        <div class="input-container inputDate">
          <input type="date" placeholder="Fecha..." class="inputIntern date" />
          <i class="fa-regular fa-calendar icon dates"></i>
        </div>
        <div class="input-container inputTime">
          <input type="time" placeholder="Hora..." class="inputIntern time" />
          <i class="fa-regular fa-clock icon times"></i>
        </div>
      </form>
    </div>
    <div class="containNextBack">
      <button id="back" class="btn-send back">Volver</button>
      <button id="next" class="btn-send ">Siguiente</button>
    </div>
  </div>
</div>

</div>
</main>
<script src="/src/js/app.js"></script>
</body>

</html>