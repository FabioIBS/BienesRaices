<?php

namespace Model;

use mysqli_sql_exception;

class ActiveRecord
{
    //Base de datos
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';
    //Errores 
    protected static $errores = [];

    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $vendedor_id;
    public $nombre;
    public $apellido;
    public $telefono;

    public static function setDB($database)
    {
        self::$db = $database;
    }

    public function guardar()
    {
        if (!is_null($this->id)) {
            $this->actualizar();
        } else {
            $this->crear();
        }
    }
    //Guardar nuevo registro en la BD
    public function crear()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        //Insertar a la base de datos
        $query = "INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "') ";
        $resultado = self::$db->query($query);
        if ($resultado) {
            echo 'Insertado correctamente';
            header('location: /admin?resultado=1');
        } else {
            echo 'Hubo un error';
        }
    }
    //Actualizar nuevo registro en la BD
    public function actualizar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        $valores = [];
        //Generar string con la forma $key = '$value' para el query a la BD
        foreach ($atributos as $key => $value) {
            $valores[] = "$key = '$value'";
        }
        $valores = join(', ', $valores);
        //Query a la BD
        $query = "UPDATE " . static::$tabla . " SET $valores WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        //Si la query pasa regresar al index.php con mensaje resultado 2
        if ($resultado) {
            header('Location: /admin?resultado=2');
        }
    }
    //Identificar y unir los atributos de la DB
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
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
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    //Subida de archivos
    public function setImagen($imagen)
    {
        //Eliminar imagen previa
        if (!is_null($this->id)) {
            $this->borrarImagen();
        }

        //Asignar al atributo el nombre de la imagen
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }
    //Eliminar el archivo
    public function borrarImagen()
    {
        //Comprobar si existe el archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }
    //Validacion 
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores = [];
        return static::$errores;
    }

    //Listar todos los elementos de la tabla
    public static function all($limite = NULL)
    {
        if (is_null($limite)) {
            $query = "SELECT * FROM " . static::$tabla;
            $resultado = self::consultarSQL($query);
            return $resultado;
        } else {
            $query = "SELECT * FROM " . static::$tabla . " LIMIT " . $limite;
            $resultado = self::consultarSQL($query);
            return $resultado;
        }
    }
    //Busca un registro por su id
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    //Eliminar propiedad
    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        try {
            $resultado = self::$db->query($query);
        } catch (mysqli_sql_exception $th) {
            header('location: /admin?resultado=4');
        }
        if ($resultado) {
            $this->borrarImagen();
            header('Location: /admin?resultado=3');
        }
    }

    public static function consultarSQL($query)
    {
        //Consultar la base de datos
        $resultado = self::$db->query($query);

        //Iterar los resultados 
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //Liberar la memoria 
        $resultado->free();

        //Retornar los resultados

        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;
        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    //Sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}
