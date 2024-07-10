<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tattoo</title>
    <link rel="stylesheet" href="build/css/app.css" />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
  </head>
  <body>
    <div class="containGeneralFlex">
      <div class="containFormInit">
        <form action="" class="formInit">
          <h2 class="titleInit">Invikto</h2>
          <p class="dateLogin">Registrate con nosotros</p>
          <div class="input-container">
            <input type="text" placeholder="Nombre..." class="inputIntern" />
            <i class="fa-solid fa-user icon"></i>
          </div>
          <div class="input-container">
            <input
              type="text"
              placeholder="Apellido..."
              class="inputIntern"
            />
            <i class="fa-solid fa-user icon"></i>
          </div>
          <div class="input-container">
            <input
              type="number"
              placeholder="Teléfono..."
              class="inputIntern"
            />
            <i class="fa-solid fa-phone icon"></i>          </div>
          <div class="input-container">
            <input
              type="email"
              placeholder="Email..."
              class="inputIntern"
            />
            <i class="fa-solid fa-envelope icon"></i>
          </div>
          <div class="input-container">
            <input
              type="password"
              placeholder="Contraseña..."
              class="inputIntern"
            />
            <i class="fa-solid fa-lock icon"></i>
          </div>
        </form>
        <button class="btn-send">Regístrate</button>
        <div class="containForgot">
            <a class="register" href="index.php"
            >¿Ya tienes cuenta? Inicia Sesión</a
          >
          <a class="register" href="">¿Olvidaste tu contraseña?</a>
        </div>
      </div>
    </div>
  </body>
</html>
