<?php
require '../../includes/app.php';

use App\Galeria;

estaAutenticado();

// Conexión a la base de datos
$db = conectarDB();
Galeria::setDB($db);

$galeria = new Galeria();
$errores = Galeria::getErrores();
$titulo = ''; // Inicializamos la variable $titulo

// Ejecutar código después de que el usuario envíe el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asignar files a una variable
    $imagen = $_FILES['imagen'];
    $titulo = $_POST['titulo'] ?? '';

    $galeria = new Galeria([
        'titulo' => $titulo,
        'imagen' => $imagen['name']
    ]);

    $errores = $galeria->validar();

    // Validar tipos de archivo permitidos
    $tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png'];
    if (!in_array($imagen['type'], $tiposPermitidos)) {
        $errores[] = "Formato de imagen no válido. Sube una imagen JPEG o PNG.";
    }

    // Revisar que se inserte a la BD si el array de errores está vacío
    if (empty($errores)) {
        // Subida de archivos
        // Crear carpeta de imágenes si no existe
        $carpetaImagenes = '../../imagenes/';
        if (!is_dir($carpetaImagenes)) {
            mkdir($carpetaImagenes);
        }

        // Generar nombre único para la imagen
        $nombreImagen = md5(uniqid(rand(), true)) . "." . pathinfo($imagen['name'], PATHINFO_EXTENSION);

        // Guardar archivo en la carpeta de imágenes
        if (move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen)) {
            // Éxito al subir la imagen
            echo "Imagen subida correctamente: " . $nombreImagen;

            // Asignar el nombre de la imagen al objeto Galeria
            $galeria->imagen = $nombreImagen;

            // Guardar en la base de datos
            if ($galeria->guardar()) {
                $mensaje = "Estilo creado correctamente";
                header('Location: /admin/index.php');
                exit;
            } else {
                $errores = Galeria::getErrores();
            }
        } else {
            $errores[] = "Error al subir la imagen.";
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
    <form action="/admin/propiedades/crear.php" method="POST" class="formInit" enctype="multipart/form-data">
        <h3 class="titleCrear">Titulo del estilo</h3>
        <div class="input-container">
            <input id="titulo" type="text" value="<?php echo htmlspecialchars($titulo); ?>" placeholder="Nombre del estilo..." class="inputIntern" id="nombreEstilo" name="titulo" />
        </div>
        <h3 class="titleCrear">Imagen del estilo</h3>
        <div class="input-container">
            <input accept="image/jpeg, image/png" type="file" id="fileInput" class="inputIntern file" id="imagenEstilo" name="imagen" />
            <label for="fileInput" class="custom-file-label">
                Subir Archivo...
            </label>
        </div>
        <?php
        // Obtiene la ruta actual del archivo
        $currentPath = $_SERVER['PHP_SELF'];
        $isCrearPage = strpos($currentPath, 'crear.php') !== false;
        ?>
        <input type="submit" class="btn-send crearBtn <?php echo $isCrearPage ? 'styleDeffect' : ''; ?>" value="CREAR ESTILO">
    </form>
    <?php if (!empty($mensaje)) : ?>
        <div class="alerta error" id="resultado">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
</main>

<script src="../../src/js/app.js"></script>