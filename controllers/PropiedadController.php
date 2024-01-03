<?php

namespace Controllers;

use MVC\Router;
use Model\Propiedad;
use Model\Vendedor;
use Intervention\Image\ImageManagerStatic as Image;

class PropiedadController
{
    public static function index(Router $router)
    {
        $propiedades = Propiedad::all();
        $vendedores = Vendedor::all();
        $resultado = $_GET['resultado'] ?? null;
        $router->render('propiedades/admin', [
            'propiedades' => $propiedades,
            'resultado' => $resultado,
            'vendedores' => $vendedores
        ]);
    }

    public static function crear(Router $router)
    {
        //Obtener todas las propiedades y vendedores de la base de datos
        $propiedad = new Propiedad;
        $vendedores = Vendedor::all();
        //Obtener errores del formulario
        $errores = Propiedad::getErrores();


        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            //Crea una instancia de la clase Propiedad con el contenido del formulario
            $propiedad = new Propiedad($_POST);


            //Genera un nombre único 
            $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";

            if ($_FILES['imagen']['tmp_name']) {
                //Realiza un resize a la imagen con Intervention
                $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                //Setear la imagen 
                $propiedad->setImagen($nombreImagen);
            }


            //Validar errores
            $errores = $propiedad->validar();
            //errores
            //Revisar que el arreglo este vacío
            if (empty($errores)) {


                /**Subida de archivos */
                //Crear Carpeta para imagenes
                if (!is_dir(CARPETA_IMAGENES)) {
                    mkdir(CARPETA_IMAGENES);
                }

                //Guarda la imagen en el servidor
                $image->save(CARPETA_IMAGENES . $nombreImagen);

                //Guarda en la base de datos
                $propiedad->guardar();
            }
            //Insertar en la base de datos

        }
        $router->render('propiedades/crear', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function actualizar(Router $router)
    {
        $idPropiedad = validarORedireccionar('/admin');
        //Query para obtener datos de la propiedad
        $propiedad = Propiedad::find($idPropiedad);
        $vendedores = Vendedor::all();

        $errores = [];
        if ($_SERVER["REQUEST_METHOD"] === 'POST') {
            //Leer datos del POST y sincronizar
            $args = [];
            foreach ($_POST as $key => $value) {
                $args[$key] = $value ?? null;
            }
            $propiedad->sincronizar($args);
            //Validacion
            $errores = $propiedad->validar();

            if (empty($errores)) {
                //Subida de archivos
                //Genera un nombre único
                $nombreImagen = md5(uniqid(rand(), true)) . ".jpg";
                if ($_FILES['imagen']['tmp_name']) {
                    //Realiza un resize a la imagen con Intervention
                    $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 600);
                    //Setear la imagen 
                    $propiedad->setImagen($nombreImagen);
                    $image->save(CARPETA_IMAGENES . $nombreImagen);
                }
                //Guarda la imagen en el servidor

                $propiedad->guardar();
            }
        }
        $router->render('propiedades/actualizar', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
            'errores' => $errores
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);

            if ($id) {

                $tipo = $_POST['tipo'];
                if (validarTipoContenido($tipo)) {
                    $propiedad = Propiedad::find($id);
                    $propiedad->eliminar();
                }
            }
        }
    }
}
