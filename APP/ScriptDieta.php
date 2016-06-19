<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'Controlador/ControlDieta.php';

$Controlador = new ControlDieta();
session_start();
if (!empty($_SESSION)) {





    if (isset($_POST['registrar'])) {
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $Controlador->registrarDieta($nombre, $descripcion);
    }

    if (isset($_POST['buscarEliminar'])) {
        $dieta = $_POST['dieta'];
        return $Controlador->buscarDietaEliminar($dieta);
    }

    if (isset($_POST['eliminar'])) {
        $dieta = $_POST['nombre'];
        return $Controlador->eliminarDieta($dieta);
    }

    if (isset($_POST['buscarModificar'])) {

        $dieta = $_POST['dieta'];
        return $Controlador->buscarDietaModificar($dieta);
    }

    if (isset($_POST['modificar'])) {

        $dieta = $_POST['dieta'];
        $descripcion = $_POST['descripcion'];

        return $Controlador->ModificarDieta($dieta, $descripcion);
    }

    if (isset($_POST['registrarReporte'])) {
        $animal = $_POST['animal'];
        $dieta = $_POST['dieta'];
        return $Controlador->registrarReporteDieta($animal, $dieta);
    }

    if (isset($_POST['consultar'])) {

        $dieta = $_POST['dieta'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        return $Controlador->consultarReporteDieta($dieta, $desde, $hasta);
    }


    if ($_GET) {
        if ($_GET['action'] == 'registrar') {
            return $Controlador->guiRegistrarDieta();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'consultar') {
            return $Controlador->guiConsultarDieta();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'modificar') {
            return $Controlador->guiModificarDieta();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'eliminar') {
            return $Controlador->guiEliminarDieta();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'registrarReporte') {
            return $Controlador->guiRegistrarReporteDieta();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'consultarReporte') {
            return $Controlador->guiConsultarReporteDieta();
        }
    }
} else {
    echo "<script type=\"text/javascript\">alert(\"inicie session \");</script>";
    return $Controlador->Principal();
}
?>
