<?php
//importar bd
// require 'includes/config/database.php';
$db = conectarDB();
//consultar
$query = "SELECT * FROM galeriainicio";

//obetenr resultado
$resultado = mysqli_query($db, $query);

?>


<div class="containGridServices">
    <?php while ($consulta = mysqli_fetch_assoc($resultado)) : ?>
        <a href="../../galeria.php?id=/<?php echo $consulta['id']; ?>">

            <div class="gridIntern" id="change">
                <div class="containImgGrid">
                    <img src="/imagenes/<?php echo $consulta['imagen']; ?>" alt="" class="imgGrid" />
                </div>
                <div class="descriptionServices">
                    <h2 class="descriptionServicesText"><?php echo $consulta['titulo']; ?></h2>
                </div>
            </div>
        </a>

    <?php endwhile; ?>

</div>

<?php
mysqli_close($db);
?>