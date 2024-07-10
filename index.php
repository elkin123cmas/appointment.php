<?php
require 'includes/app.php';
$db = conectarDB();
//autenticar usuario

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // echo "<pre>";
  // var_dump($_POST);
  // echo "</pre>";

  $email = mysqli_real_escape_string($db, filter_var($_POST['email'], FILTER_VALIDATE_EMAIL));
  // var_dump($email);
  $token = mysqli_real_escape_string($db, $_POST['token']);

  if (!$email) {
    $errores[] = "El email es obligatorio o no es válido";
  }
  if (!$token) {
    $errores[] = "El password es obligatorio o no es válido";
  }
  // echo "<pre>";
  // var_dump($errores);
  // echo "</pre>";
  // exit;
  if (empty($errores)) {
    $query = "SELECT * FROM usuarios WHERE email = '{$email}'";
    $resultado = mysqli_query($db, $query);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
      $usuario = mysqli_fetch_assoc($resultado);
      $auth = password_verify($token, $usuario['token']);

      if ($auth) {
        session_start();
        $_SESSION['usuarios'] = $usuario['email'];
        $_SESSION['login'] = true;

        // Redirigir al administrador
        header('Location: /admin/index.php');
        exit;
      } else {
        $errores[] = "El password es incorrecto";
      }
    } else {
      $errores[] = "El usuario no existe";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tattoo</title>
  <link rel="stylesheet" href="build/css/app.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
</head>

<body>
  <div class="containGeneralFlex">
    <div class="containFormInit">
      <?php foreach ($errores as $error) : ?>
        <div class="alerta error">
          <?php echo $error; ?>
        </div>

      <?php endforeach; ?>
      <form method="POST" action="" class="formInit" novalidate>
        <h2 class="titleInit">InVikto</h2>
        <p class="dateLogin">Inicia sesión con tus datos</p>
        <div class="input-container">
          <input type="email" placeholder="Email..." class="inputIntern" name="email" required />
          <i class="fa-solid fa-envelope icon"></i>
        </div>
        <div class="input-container">
          <input type="password" placeholder="Contraseña..." class="inputIntern" name="token" required />
          <i class="fa-solid fa-lock icon"></i>
        </div>
        <input type="submit" class="btn-send" value="Iniciar Sesion">

      </form>
      <div class="containForgot">
        <a class="register" href="register.php">¿Aún no tienes cuenta? Regístrate</a>
        <a class="register" href="">¿Olvidaste tu contraseña?</a>
      </div>
    </div>
  </div>
</body>

</html>