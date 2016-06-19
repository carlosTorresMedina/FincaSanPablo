<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'Controlador/ControlManejoSesion.php';



$controlador = new ControlManejoSesion();

//inicia sesion
session_start();

//verifica si existen variables de session v si no hay, f si  hay
if (empty($_SESSION)) {
    if (isset($_POST['ingresar'])) {

        $user = $_POST['usuario'];
        $contraseña = $_POST['contraseña'];
        $valor = $controlador->IniciarSesion($user, $contraseña);

        if ($valor == true) {
            $_SESSION['usuario'] = $user;

            return $controlador->Home();
        }
        echo "<script type=\"text/javascript\">alert(\"datos incorrectos\");</script>";
        $controlador->Principal();
    } else {

        return $controlador->Principal();
    }
} else {
    if ($_GET) {
        if ($_GET['action'] == 'cerrar') {

            unset($_SESSION['usuario']);
            unset($_SESSION['contraseña']);
            session_destroy();
            return $controlador->Principal();
        }
        if ($_GET['action'] == 'home') {

            ;
            return $controlador->Home();
        }
    }
    return $controlador->Home();
}
?>
