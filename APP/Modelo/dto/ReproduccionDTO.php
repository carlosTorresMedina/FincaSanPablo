<?php

/**
 * 
 */
class ReproduccionDTO {

    private $IdAnimal;
    private $FechaInseminacion;
    private $FechaParto;
    private $FechaInicioD;
    private $FechaFinD;

    /**
     * Constructor
     * */
    function ReproduccionDTO($IdAnimal, $FechaInseminacion, $FechaParto, $FechaInicioD, $FechaFinD) {
        $this->IdAnimal = $IdAnimal;
        $this->FechaInseminacion = $FechaInseminacion;
        $this->FechaParto = $FechaParto;
        $this->FechaInicioD = $FechaInicioD;
        $this->FechaFinD = $FechaFinD;
    }

    /**
     * Getters
     * */
    public function getIdAnimal() {
        return $this->IdAnimal;
    }

    public function getFechaInseminacion() {
        return $this->FechaInseminacion;
    }

    public function getFechaParto() {
        return $this->FechaParto;
    }

    public function getFechaInicioD() {
        return $this->FechaInicioD;
    }

    public function getFechaFinD() {
        return $this->FechaFinD;
    }

    /**
     * Setters
     * */
    public function setIdAnimal($value) {
        $this->IdAnimal = $value;
    }

    public function setFechaInseminacion($value) {
        $this->FechaInseminacion = $value;
    }

    public function setFechaParto($value) {
        $this->FechaParto = $value;
    }

    public function setFechaInicioD($value) {
        $this->FechaInicioD = $value;
    }

    public function setFechaFinD($value) {
        $this->FechaFinD = $value;
    }

}

?>