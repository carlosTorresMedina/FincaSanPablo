<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require 'Controlador/ControlMedicamento.php';

$Controlador = new ControlMedicamento();

session_start();
if (!empty($_SESSION)) {

    if (isset($_POST['CReporteMedicamento'])) {

        $nombre = $_POST['medicamento'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];

        return $Controlador->consultarReporteMedicamento($nombre, $desde, $hasta);
    }

    if (isset($_POST['gasto'])) {


        $nombre = $_POST['medicamento'];
        $cantidadu = $_POST['Gasto'];
        $responsable = $_POST['Responsable'];
        return $Controlador->gastarMedicamento($nombre, $cantidadu, $responsable);
    }

    if (isset($_POST['ingresar'])) {

        $nombre = $_POST['medicamento'];
        $ingreso = $_POST['Ingreso'];
        return $Controlador->IngresarMedicamento($nombre, $ingreso);
    }

    if (isset($_POST['eliminar'])) {

        $nombre = $_POST['nombre'];
        return $Controlador->eliminarMedicamento($nombre);
    }

    if (isset($_POST['registrar'])) {

        $nombre = $_POST['nombre'];
        $Cantidad = $_POST['Cantidad'];
        $Nomenclatura = $_POST['Nomenclatura'];

        return $Controlador->registrarMedicamento($nombre, $Cantidad, $Nomenclatura);
    }

    if ((isset($_POST['buscarEliminar']))) {

        $nombre = $_POST['medicamento'];
        return $Controlador->buscarMedicamentoEliminar($nombre);
    }

    if (isset($_POST['modificar'])) {

        $nombre = $_POST['nombre'];
        $CantidadE = $_POST['cExistente'];
        $CantidadU = $_POST['cUtilizada'];
        $Nomenclatura = $_POST['nomenclatura'];

        return $Controlador->modificarMedicamento($nombre, $CantidadE, $CantidadU, $Nomenclatura);
    }

    if (isset($_POST['buscar'])) {

        $nombre = $_POST['medicamento'];
        return $Controlador->consultarMedicamentoEspecifico($nombre);
    }








    if ($_GET) {
        if ($_GET['action'] == 'registrar') {
            return $Controlador->guiRegistrarMedicamento();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'consultar') {
            return $Controlador->consultarMedicamentoGeneral();
        }
    }
    if ($_GET) {

        if ($_GET['action'] == 'modificar') {
            return $Controlador->guiModificarMedicamento();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'eliminar') {
            return $Controlador->guiEliminarMedicamento();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'registrarIngreso') {
            return $Controlador->guiRegistrarIngresoMedicamento();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'resgistrarGasto') {
            return $Controlador->guiRegistrarGastoMedicamento();
        }
    }
    if ($_GET) {
        if ($_GET['action'] == 'consultarReporte') {
            return $Controlador->guiConsultarReporteMedicamento();
        }
    }
} else {
    echo "<script type=\"text/javascript\">alert(\"inicie session \");</script>";
    return $Controlador->Principal();
}
?>
