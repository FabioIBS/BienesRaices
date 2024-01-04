<?php

namespace Controllers;

use Model\Propiedad;
use MVC\Router;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController
{

    public static function index(Router $router)
    {
        $limite = 3;
        $propiedades = Propiedad::all($limite);
        $inicio = true;
        $router->render('paginas/index', [
            'propiedades' => $propiedades,
            'inicio' => $inicio
        ]);
    }
    public static function nosotros(Router $router)
    {
        $router->render('paginas/nosotros', []);
    }
    public static function anuncios(Router $router)
    {
        $propiedades = Propiedad::all();
        $router->render('paginas/anuncios', [
            'propiedades' => $propiedades
        ]);
    }
    public static function anuncio(Router $router)
    {
        $id = validarORedireccionar($_GET['id']);
        $propiedad = Propiedad::find($id);
        $router->render('paginas/anuncio', [
            'propiedad' => $propiedad
        ]);
    }
    public static function blog(Router $router)
    {
        $router->render('paginas/blog', []);
    }
    public static function entrada(Router $router)
    {
        $router->render('paginas/entrada', []);
    }
    public static function contacto(Router $router)
    {
        $mensaje = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //Crea una instancia de PHPMailer
            $respuestas = $_POST;
            $mail = new PHPMailer();
            //Configurar SMTP
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = 'd6e28d5aad8be0';
            $mail->Password = 'db8661e4adbf45';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 2525;

            //Configurar contenido del email
            $mail->setFrom('admin@bienesraices.com'); //Remitente
            $mail->addAddress('admin@bienesraices.com', 'BienesRaices.com'); //Destinatario
            $mail->Subject = 'Tienes Un Nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';
            //Definir contenido
            $contenido = '<html>';
            $contenido .= '<p>Tienes un nuevo mensaje </p> ';
            $contenido .= '<p> Nombre: ' . $respuestas['nombre'] . '</p>';

            //Enviar de forma condicional algunos campos de email o telefono
            if ($respuestas['contacto'] === 'telefono') {
                $contenido .= '<p> Eligió ser contactado por teléfono </p>';
                $contenido .= '<p> Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p> Fecha en la que prefiere ser contactado: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p> Hora en la que prefiere ser contactado: ' . $respuestas['hora'] . '</p>';
            } else {
                //Es email
                $contenido .= '<p> Eligió ser contactado por email </p>';
                $contenido .= '<p> Email: ' . $respuestas['email'] . '</p>';
            }
            $contenido .= '<p> Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p> Intención: ' . $respuestas['compra_venta'] . '</p>';
            $contenido .= '<p> Presupuesto: $' . $respuestas['precio'] . '</p>';
            $contenido .= '</html>';
            $mail->Body = $contenido;
            $mail->AltBody = 'Texto alternativo sin HTML';
            //Enviar el email
            if ($mail->send()) {
                $mensaje = "Mensaje Enviado Correctamente";
            } else {
                $mensaje = "Hubo un error";
            }
        }
        $router->render('paginas/contacto', [
            'mensaje' => $mensaje
        ]);
    }
    public static function propiedades(Router $router)
    {
        echo 'Desde Propiedades';
    }

    public static function login(Router $router)
    {
        $router->render('paginas/login', []);
    }
}
