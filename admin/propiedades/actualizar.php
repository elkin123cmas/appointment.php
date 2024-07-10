<?php
require '../../includes/functions.php';
if (!estaAutenticado()) {
    header('Location: /index.php');
    exit;
}
//validar la url por id valido
$id = $_GET['id'];
$id = filter_var($id, FILTER_VALIDATE_INT);

if (!$id) {
    header('Location: /admin/index.php');
}
//Conexion base de datos
require '../../includes/config/database.php';
$db = conectarDB();
// var_dump($db);

//obtener los datos de la galeriaimagen
$consulta = "SELECT * FROM galeriainicio WHERE id = {$id}";
// echo $consulta;
$resultado = mysqli_query($db, $consulta);
$clasificado = mysqli_fetch_assoc($resultado);
// echo "<pre>";
// var_dump($clasificado);
// echo "</pre>";




//arreglo con mensajes de errores
$errores = [];
$titulo = $clasificado['titulo'];
$imagenGaleria = $clasificado['imagen'];


//ejecutar codigo despues de que el usuario envie el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_FILES);
    // echo "</pre>";

    $titulo = mysqli_real_escape_string($db, $_POST['titulo']);

    //asignar files a una variable

    $imagen = $_FILES['imagen'];

    if (!$titulo) {
        $errores[] = "Debes añadir el titulo del estilo";
    }


    //validar por tamaño de imagen

    $medida = 1000 * 1000;
    if ($imagen['size'] > $medida) {
        $errores[] = "La imagen es muy pesada";
    }

    // echo "<pre>";
    // var_dump($errores);
    // echo "</pre>";
    // exit;

    //revisar que se inserte a la bd si el array de errores esta vacio
    if (empty($errores)) {
        // crear carpeta de imagenes
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        $nombreImagen = '';

        ///SUBIDA DE ARCHIVOS
        if ($imagen['name']) {
            //eliminar imagen anterior
            unlink($carpetaImagenes . $clasificado['imagen']);
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            //subir la imagen
            move_uploaded_file($imagen['tmp_name'], $carpetaImagenes .  $nombreImagen);
        } else {
            $nombreImagen =  $clasificado['imagen'];
        }

        //genera nombre unico


        //insertar en la base de datos
        $query = "UPDATE galeriainicio SET titulo = '{$titulo}', imagen = '{$nombreImagen}' WHERE id= {$id}";
        // echo $query;
        // exit;
        $mensaje = '';
        $resultado = mysqli_query($db, $query);
        if ($resultado) {
            $mensaje = "Actualizado correctamente";
            // header('Location:/admin');
        }
    }
}

incluir_template('header', $nameAdmin = true);
?>

<?php foreach ($errores as $error) : ?>
    <div class="alerta error">
        <?php echo $error; ?>
    </div>
<?php endforeach; ?>

<main class="contain-main">
    <form method="POST" class="formInit" enctype="multipart/form-data">

        <h3 class="titleCrear">Actualiza el titulo del estilo</h3>
        <div class="input-container">
            <input id="titulo" type="text" value="<?php echo $titulo; ?>" placeholder="Nombre del estilo..." class="inputIntern" id="nombreEstilo" name="titulo" />
            <!-- <i class="fa-solid fa-user icon"></i> -->
        </div>
        <h3 class="titleCrear">Actualiza la imagen del estilo</h3>

        <div class="input-container">
            <input accept="image/jpeg, image/png" type="file" id="fileInput" class="inputIntern file" id="imagenEstilo" name="imagen" />

            <label for="fileInput" class="custom-file-label">
                Subir Archivo...
            </label>
            <img class="imagenSmall" src="/imagenes/<?php echo $imagenGaleria; ?>" alt="">

        </div>

        <input id="actualizar" type="submit" class="btn-send crearBtn" value="ACTUALIZAR ">
    </form>
    <?php if (!empty($mensaje)) : ?>
        <div class="alerta error" id="resultado">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>


</main>

<script src="../../src/js/app.js"></script>