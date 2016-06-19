<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'Controlador/ControlReproduccion.php';

$Controlador = new ControlReproduccion();
session_start();
if (!empty($_SESSION)) {

    if (isset($_POST['ingresar'])) {
        $vaca = $_POST['vaca'];
        return $Controlador->ingresarProceso($vaca);
    }

    if (isset($_POST['buscarVacaEstado'])) {
        $nombre = $_POST['nombre'];
        return $Controlador->buscarVacaEstado($nombre);
    }

    if (isset($_POST['actualizar'])) {
        $idvaca = $_POST['idVaca'];
        $estado = $_POST['estado'];
        return $Controlador->actualizarEstado($idvaca, $estado);
    }

    if (isset($_POST['consultar'])) {
        $id = $_POST['vaca'];
        return $Controlador->consultarProceso($id);
    }

    if ($_GET) {
        if ($_GET['action'] == 'ingresarProceso') {

            return $Controlador->guiIngresarProceso();
        }
        if ($_GET['action'] == 'actualizarEstado') {
            return $Controlador->guiActualizarEstado();
        }
        if ($_GET['action'] == 'consultarProceso') {
            return $Controlador->guiConsultarProceso();
        }
    }
} else {
    echo "<script type=\"text/javascript\">alert(\"inicie session \");</script>";
    return $Controlador->Principal();
}
?>
