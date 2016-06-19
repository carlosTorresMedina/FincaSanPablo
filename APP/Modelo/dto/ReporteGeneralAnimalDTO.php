<?php

/**
 * 
 */
class ReporteGeneralAnimalDTO {

    private $Fecha;
    private $Tipo;
    private $Cantidad;

    function __construct($Fecha, $Tipo, $Cantidad) {
        $this->Fecha = $Fecha;
        $this->Tipo = $Tipo;
        $this->Cantidad = $Cantidad;
    }

    /**
     * Getters
     * */
    public function getFecha() {
        return $this->Fecha;
    }

    public function getTipo() {
        return $this->Tipo;
    }

    public function getCantidad() {
        return $this->Cantidad;
    }

    /**
     * Setters
     * */
    public function setFecha($value) {
        $this->Fecha = $value;
    }

    public function setTipo($value) {
        $this->Tipo = $value;
    }

    public function setCantidad($value) {
        $this->Cantidad = $value;
    }

}

?>