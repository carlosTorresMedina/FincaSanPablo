<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require 'Controlador/ControlAnimal.php';

$Controlador = new ControlAnimal();
session_start();


if (!empty($_SESSION)) {

    if (isset($_POST['consultarreporteanimal'])) {
        $tipo = $_POST['especie'];
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        return $Controlador->consultarReporteAnimal($tipo, $desde, $hasta);
    }

    if (isset($_POST['registrarreporteanimal'])) {
        $descripcion = $_POST['descripcion'];

        $tipo = $_POST['tipo'];

        $cantidad = $_POST['cantidad'];
        $i = 0;
        $adjunto = array();
        for (; $i < $cantidad; $i++) {
            $adjunto[$i] = array($_POST['idAnimal' . $i], $_POST['peso' . $i], $_POST['tamano' . $i]);
        }
        return $Controlador->registrarReporteAnimal($tipo, $descripcion, $adjunto);
    }


    if (isset($_POST['consultarAnimalesReporte'])) {

        $especie = $_POST['especie'];
        return $Controlador->consultarTipoAnimalReporte($especie);
    }

    if (isset($_POST['registrarReporteGeneral'])) {

        $camuro = array('camuro', $_POST['camuro']);
        $equino = array('equino', $_POST['equino']);
        $vaca = array('vaca', $_POST['vaca']);
        $vacuno = array('vacuno en crecimiento', $_POST['vacuno']);
        $total = array($camuro, $equino, $vaca, $vacuno);
        $descripcion = $_POST['descripcion'];
        return $Controlador->registrarReporteGeneral($total, $descripcion);
    }

    if (isset($_POST['consultarReporteGeneral'])) {
        $desde = $_POST['desde'];
        $hasta = $_POST['hasta'];
        return $Controlador->consultarReporteGeneral($desde, $hasta);
    }


    if (isset($_POST['registrarRgeneral'])) {

        return $Controlador->guiRegistrarReporteGeneral();
    }

    if (isset($_POST['consultarRgeneral'])) {

        return $Controlador->guiConsultarReportesGenerales();
    }

    if (isset($_POST['registrarRanimal'])) {

        return $Controlador->guiRegistrarReportesAnimales();
    }

    if (isset($_POST['consultarRanimal'])) {

        return $Controlador->guiConsultarReportesAnimales();
    }

    if (isset($_POST['registrar'])) {


        $Id = $_POST['idAnimal'];
        $Tipo = $_POST['especie'];
        $Tamano = $_POST['Tamano'];
        $Peso = $_POST['Peso'];
        $Sexo = $_POST['sexo'];
        $Medicamento = $_POST['medicamento'];
        return $Controlador->registrarAnimal($Id, $Tipo, $Tamano, $Peso, $Sexo, $Medicamento);
    }

    if (isset($_POST['eliminar'])) {

        $Id = $_POST['idAnimal'];

        return $Controlador->eliminarAnimal($Id);
    }

    if (isset($_POST['consultar'])) {


        $Tipo = $_POST['especie'];
        return $Controlador->consultarAnimal($Tipo);
    }

    if (isset($_POST['buscar'])) {

        $Id = $_POST['idAnimal'];
        $Tipo = $_POST['especie'];

        return $Controlador->buscarAnimalEliminar($Id, $Tipo);
    }

    if (isset($_POST['buscarModificar'])) {

        $Id = $_POST['idAnimal'];
        $Tipo = $_POST['especie'];

        return $Controlador->buscarAnimalModificar($Id, $Tipo);
    }

    if (isset($_POST['modificar'])) {
echo "<script type=\"text/javascript\">alert(\"holaaa \");</script>";
        $Id = $_POST['idAnimal'];

        $Tamano = $_POST['Tamano'];
        $Peso = $_POST['Peso'];

        $Sexo = $_POST['sexo'];
        $Medicamento = $_POST['medicamento'];

        return $Controlador->modificarAnimal($Id, $Tamano, $Peso, $Sexo, $Medicamento);
    }



    if ($_GET) {

        if ($_GET['action'] == 'registrar') {
            return $Controlador->guiRegistrarAnimal();
        }

        if ($_GET['action'] == 'modificar') {
            return $Controlador->guiModificarAnimal();
        }
        if ($_GET['action'] == 'eliminar') {
            return $Controlador->guiEliminarAnimal();
        }
        if ($_GET['action'] == 'consultar') {
            return $Controlador->guiConsultarAnimal();
        }
        if ($_GET['action'] == 'reportes') {
            return $Controlador->guiReportesGestionAnimal();
        }
    }
} else {
    echo "<script type=\"text/javascript\">alert(\"inicie session \");</script>";
    return $Controlador->Principal();
}
?>
