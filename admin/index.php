<?php
require '../includes/app.php';
// $auth = estaAutenticado();
estaAutenticado();

use App\Galeria;
// if (!$auth) {
//     header('Location: /');
//     exit;
// };
//importar conexion
// require '../includes/config/database.php';
// $db = conectarDB();

//implementar un metodo  para tener todas las propiedades
$galeria = Galeria::all();
// debuguear($galeria);
//escribir query
$query = "SELECT * FROM galeriainicio";
$resultado = $_GET['resultado'] ?? null;
//consultar la db
$resultadoConsulta = mysqli_query($db, $query);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);



    if ($id) {
        // Eliminar el archivo
        $query = "SELECT imagen FROM galeriainicio WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);
        $consulta = mysqli_fetch_assoc($resultado);

        if ($consulta && isset($consulta['imagen']) && !empty($consulta['imagen'])) {
            $filePath = '../imagenes/' . $consulta['imagen'];
            if (is_file($filePath)) {
                unlink($filePath);
            } else {
                // Manejar el error si no es un archivo
                echo "Error: No es un archivo válido.";
            }
        } else {
            // Manejar el error si la consulta no devuelve resultados
            echo "Error: No se encontró la imagen.";
        }

        // Eliminar estilo
        $query = "DELETE FROM galeriainicio WHERE id = {$id}";
        $resultado = mysqli_query($db, $query);

        if ($resultado) {
            header('Location: index.php');
            exit;
        }
    }
}


//incluye el template
incluir_template('header', $nameAdmin = true);
?>

<table class="containTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Titulo</th>
            <th>Imagen</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <!-- mostrar resultados -->
    <tbody>
        <?php foreach ($galeria as $clasificado) : ?>
            <tr class="spacer-row">
                <td colspan="4"></td>
            </tr>
            <tr>
                <th><?php echo $clasificado->id; ?></th>
                <th><?php echo $clasificado->titulo; ?></th>
                <th><img src="/imagenes/<?php echo $clasificado->imagen; ?>" class="imagenTabla" alt=""></th>
                <th class="flexLink">
                    <form method="POST">
                        <input type="hidden" name="id" value="<?php echo $clasificado->id; ?>">
                        <input class="btnDelete" type="submit" value="Eliminar">
                    </form>
                    <a href="propiedades/actualizar.php?id=<?php echo $clasificado->id; ?>" class="btnUpdate">Actualizar</a>
                </th>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


<script src="../src/js/app.js"></script>
<?php
//cerrar la conexion

mysqli_close($db);
?>