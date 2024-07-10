<?php
//importar bd
// require 'includes/config/database.php';
$db = conectarDB();
//consultar
$query = "SELECT * FROM galeriainicio";

//obetenr resultado
$resultado = mysqli_query($db, $query);

?>

<div class="containGallery">
    <?php while ($consulta = mysqli_fetch_assoc($resultado)) : ?>

        <div class="gridInternGallery">
            <div class="containImgGrid">
                <img src="/imagenes/<?php echo $consulta['imagen']; ?>" alt="" class="imgGrid" />
            </div>
            <div class="descriptionServices">
                <h2 class="descriptionServicesText"><?php echo $consulta['titulo']; ?></h2>
            </div>
        </div>
    <?php endwhile; ?>

</div>
<?php
mysqli_close($db);
?>