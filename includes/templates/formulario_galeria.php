<h3 class="titleCrear">Titulo del estilo</h3>
<div class="input-container">
    <input id="titulo" type="text" value="<?php echo s($galeria->titulo); ?>" placeholder="Nombre del estilo..." class="inputIntern" id="nombreEstilo" name="titulo" />
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