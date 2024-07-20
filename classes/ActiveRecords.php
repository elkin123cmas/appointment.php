<?php


namespace App;

class ActiveRecords
{
    // Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

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

    public function eliminar()
    {
        $query = "DELETE FROM galeriainicio WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);

        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin/?resultado=3');
            exit;
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

    public function borrarImagen()
    {
        $filePath = '../imagenes/' . $this->imagen;
        if (is_file($filePath)) {
            if (unlink($filePath)) {
                echo "Imagen eliminada con éxito.";
            } else {
                echo "Error al eliminar la imagen.";
            }
        } else {
            echo "Error: No es un archivo válido.";
        }
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

        return self::$errores;
    }

    public static function all()
    {
        $query = "SELECT * FROM galeriainicio";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function find($id)
    {
        $consulta = "SELECT * FROM galeriainicio WHERE id = {$id}";
        $resultado = self::consultarSQL($consulta);
        return array_shift($resultado);
    }

    public static function consultarSQL($query)
    {
        $resultado = self::$db->query($query);
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }
        $resultado->free();
        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
