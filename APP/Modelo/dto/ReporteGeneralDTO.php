<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ReporteGeneralDTO
 *
 * @author carlos
 */
class ReporteGeneralDTO {

    //put your code here
    private $fecha;
    private $observacion;

    function ReporteGeneralDTO($fecha, $observacion) {
        $this->fecha = $fecha;
        $this->observacion = $observacion;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getObservacion() {
        return $this->observacion;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setObservacion($observacion) {
        $this->observacion = $observacion;
    }

}
