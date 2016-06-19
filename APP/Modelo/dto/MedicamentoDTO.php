<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MedicamentoDTO
 *
 * @author carlos
 */
class MedicamentoDTO {

    //put your code here

    private $Nombre;
    private $CantidadE;
    private $CantidadU;
    private $Nomenclatura;

    /**
     * constructor
     * */
    function MedicamentoDTO($Nombre, $CantidadE, $CantidadU, $Nomenclatura) {
        $this->Nombre = $Nombre;
        $this->CantidadE = $CantidadE;
        $this->CantidadU = $CantidadU;
        $this->Nomenclatura = $Nomenclatura;
    }

    public function getNombre() {
        return $this->Nombre;
    }

    public function getCantidadE() {
        return $this->CantidadE;
    }

    public function getCantidadU() {
        return $this->CantidadU;
    }

    public function getNomenclatura() {
        return $this->Nomenclatura;
    }

    /**
     * Setter
     * */
    public function setNombre($value) {
        $this->Nombre = $value;
    }

    public function setCantidadE($value) {
        $this->CantidadE = $value;
    }

    public function setCantidadU($value) {
        $this->CantidadU = $value;
    }

    public function setNomenclatura($value) {
        $this->Nomenclatura = $value;
    }

}
