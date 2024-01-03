<?php

namespace Model;

class Entrada extends ActiveRecord
{
    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'creado', 'autor', 'contenido', 'imagen', 'titulo'];
    //Atributos de la tabla
    public $id;
    public $creado;
    public $autor;
    public $contenido;
    public $imagen;
    public $titulo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->creado = date('Y/m/d');
        $this->autor = $args['autor'] ?? '';
        $this->contenido = $args['contenido'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
    }

    public function validar()
    {
        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un título";
        }
        if (!$this->autor) {
            self::$errores[] = "Debes añadir un autor";
        }
        if (strlen($this->contenido) < 50) {
            self::$errores[] = "El contenido es obligatorio y debe ser mayor a 50 carácteres";
        }
        if (!$this->imagen) {
            self::$errores[] = "Debes añadir una imagen";
        }

        return self::$errores;
    }
}
