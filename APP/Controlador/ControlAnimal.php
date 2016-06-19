
<?php

require_once 'Modelo/Fachada.php';
require 'Control.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ControlAnimal
 *
 * @author carlos
 */
class ControlAnimal extends Control {

    //put your code here


    public function consultarReporteAnimal($especie, $fechaI, $fechaF) {
        if ($fechaI == '' || $fechaF == '') {
            echo "<script type=\"text/javascript\">alert(\"es necesario que escoja las dos fechas de busqueda  \");</script>";
            return $this->guiConsultarReportesAnimales();
        }
        if ($fechaI > $fechaF) {
            echo "<script type=\"text/javascript\">alert(\"la fecha inicial no debe ser mayor a la fecha final  \");</script>";
            return $this->guiConsultarReportesAnimales();
        }

        $fachada = new Fachada();
        $ts = $fachada->consultarReporteAnimal($especie, $fechaI, $fechaF);
        //obtiene  los registros de la base de datos    

        ob_start();
        //realiza consulta al modelo      
        if ($ts == '') {
            echo "<script type=\"text/javascript\">alert(\"no existen reportes en ese rango de fecha  \");</script>";
            return $this->guiConsultarReportesAnimales();
        }


        $pagina = $this->load_template("CONSULTAR REPORTE ANIMAL");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sConsultarReporteA.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * registra un reporte de animal segun el tipo
     * @param type $tipo
     * @param type $descripcion
     * @param type $adjunto
     */
    public function registrarReporteAnimal($tipo, $descripcion, $adjunto) {

        if (empty($adjunto)) {
            echo "<script type=\"text/javascript\">alert(\"debe primero consultar el tipo de animal al que  desea realizar el reporte  \");</script>";
            return $this->guiRegistrarReportesAnimales();
        }

        if ($descripcion == 'Ingrese Observación') {
            $descripcion = '';
        }

        $fachada = new Fachada();
        $valor = $fachada->registrarReporteAnimal($tipo, $descripcion, $adjunto);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"registro de reporte exitoso  \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"ya se ha realizado un reporte el dia de hoy  \");</script>";
        }
        return $this->guiRegistrarReportesAnimales();
    }

    /**
     * consulta los animales registrados  en la base de datos segun la especie
     * @param type $especie
     * @return type
     */
    public function consultarTipoAnimalReporte($especie) {
        $fachada = new Fachada();

        $ts = $fachada->consultarAnimal($especie);
        $cantidad = count($ts);
        if (empty($ts)) {

            echo "<script type=\"text/javascript\">alert(\"no existen animales de ese tipo  \");</script>";
            return $this->guiRegistrarReportesAnimales();
        }

        ob_start();
        $pagina = $this->load_template("REGISTRAR REPORTE ANIMAL");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sRegistrarReportesA.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * consulta los reportes generales en la base de datos
     * @param type $fechaI
     * @param type $fechaF
     * @return type
     */
    public function consultarReporteGeneral($fechaI, $fechaF) {
        if ($fechaI == '' || $fechaF == '') {
            echo "<script type=\"text/javascript\">alert(\"es necesario que escoja las dos fechas de busqueda  \");</script>";
            return $this->guiConsultarReportesGenerales();
        }
        if ($fechaI > $fechaF) {
            echo "<script type=\"text/javascript\">alert(\"la fecha inicial no debe ser mayor a la fecha final  \");</script>";
            return $this->guiConsultarReportesGenerales();
        }

        $fachada = new Fachada();
        $ts = $fachada->consultarReporteGeneral($fechaI, $fechaF);
        //obtiene  los registros de la base de datos        
        ob_start();
        //realiza consulta al modelo      
        if ($ts == '') {
            echo "<script type=\"text/javascript\">alert(\"no existen reportes en ese rango de fecha  \");</script>";

            return $this->guiConsultarReportesAnimales();
        }

        $pagina = $this->load_template("CONSULTAR REPORTE GENERAL");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sConsultarReporteGeneral.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * registra reportes generales a a finca
     * @param type $total
     * @param string $observacion
     * @return type
     */
    public function registrarReporteGeneral($total, $observacion) {
        if ($observacion == 'Ingrese Observación') {
            $observacion = '';
        }
        $fachada = new Fachada();
        $valor = $fachada->registrarReporteGeneral($total, $observacion);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"registro exitoso \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"ya se ha registrado un reporte hoy \");</script>";
        }
        return $this->guiRegistrarReporteGeneral();
    }

    public function buscarAnimalModificar($Id, $Tipo) {

        if ($Id == '' || $Tipo == '') {
            echo "<script type=\"text/javascript\">alert(\"digite un id de animal \");</script>";
            return $this->guiModificarAnimal();
        }
        $fachada = new Fachada();

        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo

        $ts = $fachada->BuscarAnimal($Tipo, $Id);
        if (empty($ts)) {

            echo "<script type=\"text/javascript\">alert(\"no existe \");</script>";
            return $this->guiModificarAnimal();
        }
        $ts2 = $fachada->cargarNombreMedicamento();

        $pagina = $this->load_template("MODIFICAR ANIMAL");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sModificarA.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /* busca un animal enn especifico para eliminar
     * @param type $Id identificador
     * @param type $Tipo especie
     */

    public function buscarAnimalEliminar($Id, $Tipo) {


        if ($Id == '' || $Tipo == '') {

            $this->guiEliminarAnimal();
        } else {
            $fachada = new Fachada();

            //obtiene  los registros de la base de datos
            ob_start();
            //realiza consulta al modelo

            $ts = $fachada->BuscarAnimal($Tipo, $Id);
            if (empty($ts)) {

                echo "<script type=\"text/javascript\">alert(\"no existe \");</script>";
                return $this->guiEliminarAnimal();
            }


            $pagina = $this->load_template("ELIMINAR ANIMAL");
            //carga la tabla de la seccion de VIEW
            include "Vista/seccion/animales/sEliminarA.html";
            $section = ob_get_clean();

            //realiza el parseado   
            $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
            $this->view_page($pagina);
        }
    }

    /**
     * consulta todos los animales de  una base de datos segun su tipo
     * @param type $Tipo
     */
    public function consultarAnimal($Tipo) {
        //se debe acomodar con el front end
        $fachada = new Fachada();
        ob_start();
        if ($Tipo == 'vaca') {
            $ts = null;
            $ts1 = $fachada->consultarVaca();
            if (empty($ts1)) {

                echo "<script type=\"text/javascript\">alert(\"no existen animales de ese tipo \");</script>";
                return $this->guiConsultarAnimal();
            }
        } else {

            $ts1 = null;
            $ts = $fachada->consultarAnimal($Tipo);
            if (empty($ts)) {

                echo "<script type=\"text/javascript\">alert(\"no existen animales de ese tipo \");</script>";
                return $this->guiConsultarAnimal();
            }
        }



        $pagina = $this->load_template("CONSULTAR ANIMAL");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sConsultarA.html";
        $section = ob_get_clean();

        //realiza el parseado   
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    /**
     * 
     * registra animal
     * @param type $Id identificador del animal
     * @param type $Tipo tipo de animal
     * @param type $Tamano tamaño ddel animaml
     * @param type $Peso peso del animal
     * @param type $Sexo sexo del animal
     * @param type $Medicamento medicamento que se le esta aplicando al animal actualmente 
     * @return int retorna 1: datos vacios, 2: registro exitoso , 3: error en el registro
     */
    public function modificarAnimal($Id, $Tamano, $Peso, $Sexo, $Medicamento) {
        if ($Id == '' || $Tamano == '' || $Peso == '' || $Sexo == '' || $Medicamento == '' || $Sexo == 'Sexo' || !is_numeric($Tamano) || !is_numeric($Peso)) {
            echo "<script type=\"text/javascript\">alert(\"no se pueden dejar datos vacios \");</script>";
            return $this->guiModificarAnimal();
        }
        $Sexo = $this->acomodarSexo($Sexo);
        $fachada = new Fachada();
        $valor = $fachada->modificarAnimal($Id, $Tamano, $Peso, $Sexo, $Medicamento);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"modificacion exitosa \");</script>";
        } else {
            echo "<script type=\"text/javascript\">alert(\"error en la modificacion\");</script>";
        }
        return $this->guiModificarAnimal();
    }

    /**
     * elimina animal
     * @param type $Id identificador del animal
     * @param type $Tipo especie del animal
     * @return int retorna 1: datos vacios, 2: registro exitoso , 3: error en el registro
     */
    public function eliminarAnimal($Id) {

        if ($Id == '') {

            echo "<script type=\"text/javascript\">alert(\"datos vacios \");</script>";
            return $this->guiEliminarAnimal();
        }
        $fachada = new Fachada();
        $valor = $fachada->eliminarAnimal($Id);

        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"eliminacin exitosa \");</script>";
        } else {

            echo "<script type=\"text/javascript\">alert(\"ese animal no esta registrado \");</script>";
        }
        return $this->guiEliminarAnimal();
    }

    /**
     * regista animal
     */
    public function registrarAnimal($Id, $Tipo, $Tamano, $Peso, $Sexo, $Medicamento) {


        if ($Id == '' || $Tipo == '' || $Tamano == '' || $Peso == '' || $Sexo == '' || $Medicamento == '' || $Sexo == 'Sexo' || !is_numeric($Tamano) || !is_numeric($Peso)) {
            echo "<script type=\"text/javascript\">alert(\"datos vacios \");</script>";
            return $this->guiRegistrarAnimal();
        }
        $Sexo = $this->acomodarSexo($Sexo);
        $fachada = new Fachada();
        $valor = $fachada->registrarAnimal($Id, $Tipo, $Tamano, $Peso, $Sexo, $Medicamento);
        if ($valor) {
            echo "<script type=\"text/javascript\">alert(\"registro exitoso \");</script>";
            return $this->guiRegistrarAnimal();
        }

        echo "<script type=\"text/javascript\">alert(\"ya esta registrado \");</script>";
        return $this->guiRegistrarAnimal();
    }

    /**
     * acomoda el sexo a numero
     * @param type $Sexo
     * @return int 1 macho 0 hembra
     */
    private function acomodarSexo($Sexo) {
        if ($Sexo == 'Macho') {
            return 1;
        } else {
            return 0;
        }
    }

    /**

      /**
     * carga interfaz para registrar animales.
     */
    public function guiRegistrarAnimal() {

        $fachada = new Fachada();

        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $ts2 = $fachada->cargarNombreMedicamento();

        $pagina = $this->load_template("REGISTRAR ANIMAL");

        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sRegistrarA.html";
        $section = ob_get_clean();
        //realiza el parseado    

        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiModificarAnimal() {

        $pagina = $this->load_template("REGISTRAR ANIMAL");
        $section = $this->load_page('Vista/seccion/animales/sModificarA.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarAnimal() {

        $ts1 = null;
        $ts = null;
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo


        $pagina = $this->load_template("CONSULTAR ANIMAL");

        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sConsultarA.html";
        $section = ob_get_clean();
        //realiza el parseado    

        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiEliminarAnimal() {
        echo "holaaa";
        $pagina = $this->load_template("ELIMINAR ANIMAL");
        $section = $this->load_page('Vista/seccion/animales/sEliminarA.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiReportesGestionAnimal() {

        $pagina = $this->load_template("GESTION ANIMAL");
        $section = $this->load_page('Vista/seccion/animales/sReportesGestionA.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiRegistrarReporteGeneral() {

        $fachada = new Fachada();
        //obtiene  los registros de la base de datos
        ob_start();
        //realiza consulta al modelo
        $vector = $fachada->cargarReporteGeneral();
        $camuro = $vector[0];

        $equino = $vector[1];
        $vaca = $vector[2];
        $vacuno = $vector[3];

        $pagina = $this->load_template("REGISTRAR REPORTE ANIMAL");
        //carga la tabla de la seccion de VIEW
        include "Vista/seccion/animales/sRegistrarReporteGeneral.html";
        $section = ob_get_clean();
        //realiza el parseado    
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarReportesGenerales() {
        ob_start();
        $ts = null;
        $pagina = $this->load_template("CONSULTAR REPORTE GENERAL ");

        include 'Vista/seccion/animales/sConsultarReporteGeneral.html';
        $section = ob_get_clean();
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiRegistrarReportesAnimales() {

        $pagina = $this->load_template("CONSULTAR REPORTE GENERAL ANIMAL");
        $section = $this->load_page('Vista/seccion/animales/sRegistrarReportesA.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

    public function guiConsultarReportesAnimales() {

        ob_start();
        $ts = null;
        $pagina = $this->load_template("CONSULTAR REPORTE  ANIMAL");
        include 'Vista/seccion/animales/sConsultarReporteA.html';
        $section = ob_get_clean();
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

}

?>