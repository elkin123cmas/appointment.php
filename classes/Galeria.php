<?php

namespace App;

class Galeria
{
    // Base de datos
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'imagen'];

    public $id;
    public $titulo;
    public $imagen;

    // Errores o validación
    protected static $errores = [];

    // Definir conexión a la base de datos
    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }

    public function guardar()
    {
        // Sanitizar datos
        $atributos = $this->sanitizarAtributos();

        // Crear consulta
        $query = "INSERT INTO galeriainicio (";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";

        $resultado = self::$db->query($query);

        if ($resultado) {
            // Redimensionar la imagen
            $this->redimensionarImagen();

            return true;
        } else {
            self::$errores[] = "Error: " . self::$db->error;
            return false;
        }
    }

    protected function redimensionarImagen()
    {
        // Ruta de la imagen
        $rutaImagen = '../../imagenes/' . $this->imagen;

        // Obtener las dimensiones originales de la imagen
        list($ancho, $alto) = getimagesize($rutaImagen);

        // Dimensiones máximas permitidas
        $anchoMaximo = 800;
        $altoMaximo = 600;

        // Redimensionar solo si excede las dimensiones máximas
        if ($ancho > $anchoMaximo || $alto > $altoMaximo) {
            // Calcular nuevas dimensiones manteniendo la proporción
            $proporcion = $ancho / $alto;
            if ($ancho / $anchoMaximo > $alto / $altoMaximo) {
                $nuevoAncho = $anchoMaximo;
                $nuevoAlto = $anchoMaximo / $proporcion;
            } else {
                $nuevoAlto = $altoMaximo;
                $nuevoAncho = $altoMaximo * $proporcion;
            }

            // Crear una nueva imagen
            $imagenNueva = imagecreatetruecolor($nuevoAncho, $nuevoAlto);

            // Dependiendo del tipo de archivo, crear la imagen desde el archivo original
            switch (mime_content_type($rutaImagen)) {
                case 'image/jpeg':
                case 'image/jpg':
                    $imagenOriginal = imagecreatefromjpeg($rutaImagen);
                    break;
                case 'image/png':
                    $imagenOriginal = imagecreatefrompng($rutaImagen);
                    break;
                default:
                    self::$errores[] = "Tipo de imagen no soportado.";
                    return;
            }

            // Redimensionar la imagen original a la nueva imagen con las dimensiones calculadas
            imagecopyresampled($imagenNueva, $imagenOriginal, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

            // Guardar la imagen redimensionada
            switch (mime_content_type($rutaImagen)) {
                case 'image/jpeg':
                case 'image/jpg':
                    imagejpeg($imagenNueva, $rutaImagen);
                    break;
                case 'image/png':
                    imagepng($imagenNueva, $rutaImagen);
                    break;
                default:
                    self::$errores[] = "Tipo de imagen no soportado.";
                    break;
            }

            // Liberar memoria
            imagedestroy($imagenNueva);
            imagedestroy($imagenOriginal);
        }
    }

    public function atributos()
    {
        $atributos = [];
        foreach (self::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->real_escape_string($value);
        }

        return $sanitizado;
    }

    // Validación
    public static function getErrores()
    {
        return self::$errores;
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir el titulo del estilo";
        }
        if (!$this->imagen) {
            self::$errores[] = "La imagen es obligatoria";
        }
        // Validar por tamaño de imagen
        // $medida = 2000 * 2000;
        // if ($imagen['size'] > $medida) {
        //     $errores[] = "La imagen es muy pesada";
        // }
        ///

        return self::$errores;
    }
}
