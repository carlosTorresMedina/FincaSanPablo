<?php

require 'Control.php';
require_once 'Modelo/Fachada.php';

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlReproduccion
 *
 * @author carlos
 */
class ControlReproduccion extends control {

    /**
     * consulta las fechas de una vaca en el proceso de reproduccion.
     * @param type $tipo
     */
    public function consultarProceso($id) {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->consultarAnimal('vaca');
        $ts1 = $fachada->consultarProceso($id);
        if (empty($ts1)) {
            echo "<script type=\"text/javascript\">alert(\"no existe un control de reproduccion para la vaca  \");</script>";
        }
        $pagina = $this->load_template("CONSULTAR vaca");
        //carga la tabla de la seccion de VIEW
        include 'Vista/seccion/reproduccion/sConsultarProcesoR.html';
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * actualiza el estado de la vaca en la base de datos
     * @param type $nombre
     * @param type $etapa
     * @return type
     */
    public function actualizarEstado($nombre, $etapa) {
        if ($nombre == '') {
            echo "<script type=\"text/javascript\">alert(\"debe consultar primero una vaca \");</script>";
            return $this->guiActualizarEstado();
        }

        $fachada = new Fachada();
        $valor = $fachada->actualizarEstado($nombre, $etapa);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"actualizacion exitosa \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"error en la actualizacon \");</script>";
        }
        return $this->guiActualizarEstado();
    }

    /**
     * busca una vaca en la base de datos y carga su nombre y  su etapa proxima en el proceso de reproduccion
     * @param type $nombre
     * @return type
     */
    public function buscarVacaEstado($nombre) {
        echo "<script type=\"text/javascript\">alert(\"escoja una vaca \");</script>";
        if ($nombre == 'ninguno') {
            return $this->guiActualizarEstado();
        }


        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts1 = $fachada->cargarEtapaProximaVaca($nombre);
        $ts = $fachada->cargarVacaNoEstadoNinguno();

        if (empty($ts1)) {
            echo "<script type=\"text/javascript\">alert(\"hay un error \");</script>";
            return $this->guiIngresarProceso();
        }
        $pagina = $this->load_template("ACTUALIZAR ESTADO");
        //carga la tabla de la seccion de VIEW
        include 'Vista/seccion/reproduccion/sActualizarEstadoR.html';
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    //put your code here
    public function ingresarProceso($vaca) {
        if ($vaca == 'ninguno') {
            echo "<script type=\"text/javascript\">alert(\"escoja una vaca para ingresar al proceso \");</script>";
            return $this->guiIngresarProceso();
        }
        $fachada = new Fachada();
        $valor = $fachada->ingresarProceso($vaca);
        if ($valor == 1) {
            echo "<script type=\"text/javascript\">alert(\"ingreso exitoso \");</script>";
        } elseif ($valor == 2) {
            echo "<script type=\"text/javascript\">alert(\"la vaca ya ha sido ingresada hoy en el proceso de reproduccion \");</script>";
        } elseif ($valor == 3) {
            echo "<script type=\"text/javascript\">alert(\"error en el ingreso \");</script>";
        }
        return $this->guiIngresarProceso();
    }

    public function guiIngresarProceso() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
//realiza consulta al modelo
        $ts = $fachada->cargarVacaEstadoNinguno();

        if (empty($ts)) {

            echo "<script type=\"text/javascript\">alert(\"no hay vacas en estado ninguno \");</script>";
        }
        $pagina = $this->load_template("INGRESAR EN EL PROCESO");
        //carga la tabla de la seccion de VIEW
        include 'Vista/seccion/reproduccion/sRegistrarIngresarProcesoR.html';
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiActualizarEstado() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->cargarVacaNoEstadoNinguno();
        $ts1 = null;
        if (empty($ts)) {
            echo "<script type=\"text/javascript\">alert(\"no existen vacas en el proceso de reproduccion \");</script>";
        }
        $pagina = $this->load_template("ACTUALIZAR ESTADO");
        //carga la tabla de la seccion de VIEW
        include 'Vista/seccion/reproduccion/sActualizarEstadoR.html';
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarProceso() {
        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts = $fachada->consultarAnimal('vaca');
        $ts1 = null;
        if (empty($ts)) {
            echo "<script type=\"text/javascript\">alert(\"no existen vacas en el proceso de reproduccion \");</script>";
        }
        $pagina = $this->load_template("CONSULTAR ESTADO");
        //carga la tabla de la seccion de VIEW
        include 'Vista/seccion/reproduccion/sConsultarProcesoR.html';
        $section = ob_get_clean();
        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

}

?>
