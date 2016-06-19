<?php

require_once 'Modelo/Fachada.php';
require 'Control.php';

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlDieta
 *
 * @author carlos
 */
class ControlDieta extends Control {
    //put your code here

    /**
     * consulta las dietas que se le dan en el tiempo a una especie de animal
     * @param type $dieta
     * @param type $desde
     * @param type $hasta
     * @return type
     */
    public function consultarReporteDieta($dieta, $desde, $hasta) {

        if ($desde == '' || $hasta == '') {
            echo "<script type=\"text/javascript\">alert(\"es necesario que escoja las dos fechas de busqueda  \");</script>";
            return $this->guiConsultarReporteDieta();
        }
        if ($desde > $hasta) {
            echo "<script type=\"text/javascript\">alert(\"la fecha inicial no debe ser mayor a la fecha final  \");</script>";
            return $this->guiConsultarReporteDieta();
        }

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();
        $ts1 = $fachada->consultarReporteDieta($dieta, $desde, $hasta);
        if (empty($ts1)) {

            echo "<script type=\"text/javascript\">alert(\"no existen reportes en ese rango de fecha  \");</script>";
        }
        $pagina = $this->load_template("CONSUTLAR REPORTE DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sConsultarReporteD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * registra un reporte de dietas en la base de datos
     * @param type $total vector que tiene la informacion de los animales. para 
     * registrar en el reporte
     * @return type
     */
    public function registrarReporteDieta($tipo, $dieta) {

        $fachada = new Fachada();
        $valor = $fachada->registrarReporteDieta($tipo, $dieta);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"registro reporte exitoso \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"ya se ha registrado un reporte con la fecha actual\");</script>";
        }
        return $this->guiRegistrarReporteDieta();
    }

    /**
     * modifica dietas en la base de datos
     * @param type $nombre  nombre de la dieta
     * @param type $descripcion descripcion de la dieta
     * @return type
     */
    public function ModificarDieta($nombre, $descripcion) {
        if (empty($descripcion)) {
            echo "<script type=\"text/javascript\">alert(\"la descripcion no puede ser vacia \");</script>";
            return $this->guiModificarDieta();
        }
        $fachada = new Fachada();
        $valor = $fachada->modificarDieta($nombre, $descripcion);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"modificacion exitosa \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"error en la modificacion\");</script>";
        }
        return $this->guiModificarDieta();
    }

    /**
     * tiene como funcion buscar las dietas y cargarlas en el formulario eliminar dietas
     * @param type $dieta
     * @return type
     */
    public function buscarDietaModificar($dieta) {
        if ($dieta == 'ninguno') {

            echo "<script type=\"text/javascript\">alert(\"escoja una dieta \");</script>";
            return $this->guiModificarDieta();
        }
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();
        $ts1 = $fachada->buscarDieta($dieta);
        if (empty($ts)) {
            echo "<script type=\"text/javascript\">alert(\"no existe \");</script>";
            return $this->guiEliminarDieta();
        }
        $pagina = $this->load_template("MODIFICAR DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sModificarD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * tiene como funcion buscar las dietas y cargarlas en el formulario eliminar dietas
     * @param type $dieta
     * @return type
     */
    public function buscarDietaEliminar($dieta) {
        if ($dieta == 'ninguno') {

            echo "<script type=\"text/javascript\">alert(\"escoja una dieta \");</script>";
            return $this->guiEliminarDieta();
        }
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();
        $ts1 = $fachada->buscarDieta($dieta);
        if (empty($ts)) {
            echo "<script type=\"text/javascript\">alert(\"no existe \");</script>";
            return $this->guiEliminarDieta();
        }
        $pagina = $this->load_template("ELIMINAR DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sEliminarD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * elimina dieta
     * @param type $Id identificador de la dieta
     */
    public function eliminarDieta($Id) {

        $fachada = new Fachada();
        $valor = $fachada->eliminarDieta($Id);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"eliminacion exitosa \");</script>";
        } else {

            echo "<script type=\"text/javascript\">alert(\"error al eliminar \");</script>";
        }
        return $this->guiEliminarDieta();
    }

    /**
     * registra dieta
     * @param type $Id identificador
     * @param type $Descripcion en que consiste la dieta
     * @return int retorna 1: datos vacios, 2: registro exitoso , 3: error en el registro
     */
    public function registrarDieta($Id, $Descripcion) {


        if ($Descripcion == '') {
            echo "<script type=\"text/javascript\">alert(\"para registrar dieta es necesario digitar una descripcion \");</script>";
            return $this->guiRegistrarDieta();
        }
        if ($Id == '') {

            echo "<script type=\"text/javascript\">alert(\"registre el nombre de la dieta \");</script>";
            return $this->guiRegistrarDieta();
        }
        $fachada = new Fachada();
        $valor = $fachada->registrarDieta($Id, $Descripcion);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"registro exitoso \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"ya existe dieta  \");</script>";
        }
        return $this->guiRegistrarDieta();
    }

    /**
     * muestra la gui de registrar dieta
     */
    public function guiRegistrarDieta() {
        $pagina = $this->load_template('REGISTRAR DIETA');
        $section = $this->load_page('Vista/seccion/dietas/sRegistrarD.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarDieta() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->consultarDietaGeneral();
        if (empty($ts)) {
            echo "<script type=\"text/javascript\">alert(\"no existen dietas \");</script>";
            return $this->guiConsultarDietaDieta();
        }
        $pagina = $this->load_template("CONSULTAR DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sConsultarD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiModificarDieta() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();
        $ts1 = null;
        if (empty($ts)) {
            echo "<script type=\"text/javascript\">alert(\"no existe \");</script>";
            return $this->guiModificarDietaDieta();
        }
        $pagina = $this->load_template("MODIFICAR DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sModificarD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiEliminarDieta() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();
        $ts1 = null;
        $pagina = $this->load_template("ELIMINAR DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sEliminarD.html";
        $section = ob_get_clean();
        //realiza el parseado    

        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiRegistrarReporteDieta() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();


        $pagina = $this->load_template("REGISTRAR REPORTE DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sRegistrarReporteD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarReporteDieta() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarNombreDieta();
        $ts1 = null;
        $pagina = $this->load_template("REGISTRAR REPORTE DIETA");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/dietas/sConsultarReporteD.html";
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

}
