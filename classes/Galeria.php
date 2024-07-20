<?php

namespace App;

class Galeria extends ActiveRecords
{
    protected static $tabla = 'galeriainicio';
    protected static $columnasDB = ['id', 'titulo', 'imagen'];

    public $id;
    public $titulo;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
    }
}
