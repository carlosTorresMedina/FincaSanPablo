<?php

require 'Control.php';
require_once 'Modelo/Fachada.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlMedicamento
 *
 * @author carlos
 */
class ControlMedicamento extends Control {

    /**
     * consulta reportes de medicamentos segunn el rango de fecha
     * @param type $nombre  nombre del medicamento
     * @param type $fechaI  fecha inicial
     * @param type $fechaF fecha final
     * @return type
     */
    public function consultarReporteMedicamento($nombre, $fechaI, $fechaF) {
        if ($nombre == 'ninguno') {
            echo "<script type=\"text/javascript\">alert(\"escoja un medicamento  \");</script>";
            return $this->guiConsultarReporteMedicamento();
        }
        if ($fechaI == '' || $fechaF == '') {
            echo "<script type=\"text/javascript\">alert(\"es necesario que escoja las dos fechas de busqueda  \");</script>";
            return $this->guiConsultarReporteMedicamento();
        }
        if ($fechaI > $fechaF) {
            echo "<script type=\"text/javascript\">alert(\"la fecha inicial no debe ser mayor a la fecha final  \");</script>";
            return $this->guiConsultarReporteMedicamento();
        }

        $fachada = new Fachada();
        $ts1 = $fachada->consultarReporteMedicamento($nombre, $fechaI, $fechaF);
        //obtiene  los registros de la base de datos
        if ($ts1 == '') {
            echo "<script type=\"text/javascript\">alert(\"no existen reportes en ese rango de fecha  \");</script>";
            return $this->guiConsultarReporteMedicamento();
        }

        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $ts1 = $fachada->consultarReporteMedicamento($nombre, $fechaI, $fechaF);
        if ($ts1 == '') {
            echo "<script type=\"text/javascript\">alert(\"no existen reportes en ese rango de fecha  \");</script>";
        }

        $pagina = $this->load_template("CONSULTAR REPORTE MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sConsultarReportesM.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function gastarMedicamento($nombre, $cantidadU, $responsable) {

        if ($nombre == 'ninguno') {
            echo "<script type=\"text/javascript\">alert(\"escoja un medicamento  \");</script>";
            return $this->guiRegistrarGastoMedicamento();
        }
        if ($cantidadU == '') {
            echo "<script type=\"text/javascript\">alert(\"datos vacios  \");</script>";
            return $this->guiRegistrarGastoMedicamento();
        }
        if ($cantidadU < 0) {
            echo "<script type=\"text/javascript\">alert(\"no puede ingresar dato negativo  \");</script>";
            return $this->guiRegistrarGastoMedicamento();
        }
        if (!is_numeric($cantidadU)) {
            echo "<script type=\"text/javascript\">alert(\"digite un numero en gasto \");</script>";
            return $this->guiRegistrarGastoMedicamento();
        }

        $fachada = new Fachada();
        $valor = $fachada->gastarMedicamento($nombre, $cantidadU, $responsable);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"se ha generado reporte de gasto con exito  \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"el gasto que ingresa es mayor a la cantidad existente \");</script>";
        }
        return $this->guiRegistrarGastoMedicamento();
    }

    /**
     * ingresa una determinada cantidad de medicammentos de un determinado tipo
     * @param type $nombre
     * @param type $ingreso
     * @return type
     */
    public function IngresarMedicamento($nombre, $ingreso) {


        if ($nombre == '' || !is_numeric($ingreso)) {

            echo "<script type=\"text/javascript\">alert(\"ingrese datos  \");</script>";
            return $this->guiRegistrarIngresoMedicamento();
        }
        if ($ingreso < 0) {
            echo "<script type=\"text/javascript\">alert(\"no puede ingresar valores negativos \");</script>";
            return $this->guiRegistrarIngresoMedicamento();
        }

        $fachada = new Fachada();
        $valor = $fachada->ingresarMedicamento($nombre, $ingreso);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"ingreso exitoso \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"error en el ingreso  \");</script>";
        }
        return $this->guiRegistrarIngresoMedicamento();
    }

    public function eliminarMedicamento($nombre) {

        if ($nombre == 'ninguno') {
            return $this->guiEliminarMedicamento();
        }

        $fachada = new Fachada();
        $valor = $fachada->eliminarMedicamento($nombre);

        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"eliminacion exitosa \");</script>";
        } else {

            echo "<script type=\"text/javascript\">alert(\"no existe ese medicamento en la base de datos \");</script>";
        }
        return $this->guiEliminarMedicamento();
    }

    public function buscarMedicamentoEliminar($nombre) {
        if ($nombre == 'ninguno') {

            return $this->guiEliminarMedicamento();
        }

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $ts1 = $fachada->consultarMedicamentoEspecifico($nombre);
        $pagina = $this->load_template("ELIMINAR MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sEliminarM.html";
        $section = ob_get_clean();
        //realiza el parseado    
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function modificarMedicamento($nombre, $CantidadE, $CantidadU, $Nomenclatura) {
        if ($nombre == '') {

            echo "<script type=\"text/javascript\">alert(\"primero debe consultar un medicamento \");</script>";
            return $this->guiModificarMedicamento();
        }
        if ($nombre == '' || $CantidadE == '' || $CantidadU == '' || $Nomenclatura == '' || !is_numeric($CantidadE) || !is_numeric($CantidadU)) {
            echo "<script type=\"text/javascript\">alert(\"campos vacios \");</script>";
            return $this->guiModificarMedicamento();
        }
        if ($CantidadU > $CantidadE) {
            echo "<script type=\"text/javascript\">alert(\"la cantidad utilizada no puede ser mayor a la cantidad existente \");</script>";
            return $this->guiModificarMedicamento();
        }
        $fachada = new Fachada();
        $valor = $fachada->modificarMedicamento($nombre, $CantidadE, $CantidadU, $Nomenclatura);

        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"modificacion exitosa \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"error en la modificacion\");</script>";
        }
        return $this->guiModificarMedicamento();
    }

    /**
     * consulta medicamentos en la base de datos de manera especifica
     * @param type $nombre lo consulta por el nombre
     * @return type
     */
    public function consultarMedicamentoEspecifico($nombre) {

        if ($nombre == 'ninguno') {
            echo "<script type=\"text/javascript\">alert(\"escoja un medicamento\");</script>";
            return $this->guiModificarMedicamento();
        }

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts1 = $fachada->consultarMedicamentoEspecifico($nombre);
        $ts = $fachada->consultarMedicamentoGeneral();

        $pagina = $this->load_template("MODIFICAR MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sModificarM.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * permite consultar medicamentos en la base de datos de manera general
     * @return type
     */
    public function consultarMedicamentoGeneral() {


        $fachada = new Fachada();
        ob_start();
        $ts = $fachada->consultarMedicamentoGeneral();
        if (empty($ts)) {

            echo "<script type=\"text/javascript\">alert(\"no existen medicamentos \");</script>";
            return $this->guiConsultarMedicamento();
        }
        $pagina = $this->load_template("CONSULTAR MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sConsultarM.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * premite registrar medicamentos
     * @param type $nombre
     * @param type $Cantidad
     * @param type $Nomenclatura
     * @return type
     */
    public function registrarMedicamento($nombre, $Cantidad, $Nomenclatura) {

        if ($nombre == '' || $Cantidad == '' || $Nomenclatura == '' || !is_numeric($Cantidad)) {
            echo "<script type=\"text/javascript\">alert(\"datos vacios \");</script>";
            return $this->guiRegistrarMedicamento();
        }
        $fachada = new Fachada();
        $valor = $fachada->registrarMedicamento($nombre, $Cantidad, $Nomenclatura);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"registro exitosa \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"ya esta registrado\");</script>";
        }
        return $this->guiRegistrarMedicamento();
    }

    public function guiRegistrarMedicamento() {
        $pagina = $this->load_template('REGISTRAR DIETA');
        $section = $this->load_page('Vista/seccion/medicamentos/sRegistrarM.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarMedicamento() {


        $pagina = $this->load_template('CONSULTAR DIETA');
        $section = $this->load_page('Vista/seccion/medicamentos/sConsultarM.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiModificarMedicamento() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $ts1 = null;
        $pagina = $this->load_template("MODIFICAR MEDICAMENTO");

        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sModificarM.html";
        $section = ob_get_clean();
        //realiza el parseado    

        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiEliminarMedicamento() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $ts1 = null;
        $pagina = $this->load_template("ELIMINAR MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sEliminarM.html";
        $section = ob_get_clean();
        //realiza el parseado    
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiRegistrarIngresoMedicamento() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $pagina = $this->load_template("REGISTRAR INGRESO MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sRegistrarIngresoM.html";
        $section = ob_get_clean();
        //realiza el parseado    
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiRegistrarGastoMedicamento() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $pagina = $this->load_template("REGISTRAR GASTO DE MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sRegistrarGastoM.html";
        $section = ob_get_clean();
        //realiza el parseado    
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarReporteMedicamento() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreMedicamento();
        $ts1 = null;
        $pagina = $this->load_template("CONSULTAR REPORTE MEDICAMENTO");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/medicamentos/sConsultarReportesM.html";
        $section = ob_get_clean();
        //realiza el parseado    
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

}
