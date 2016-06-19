<?php

/**
 * 
 */
class ReporteMedicamentoDTO {

    private $Nombre;
    private $Fecha;
    private $Responsable;
    private $CantidadE;
    private $CantidadU;

    /**
     * Constructor
     * */
    function ReporteMedicamentoDTO($Nombre, $Fecha, $Responsable, $CantidadU) {
        $this->Nombre = $Nombre;
        $this->Fecha = $Fecha;
        $this->Responsable = $Responsable;

        $this->CantidadU = $CantidadU;
    }

    /**
     * Getter
     * */
    public function getNombre() {
        return $this->Nombre;
    }

    public function getFecha() {
        return $this->Fecha;
    }

    public function getResponsable() {
        return $this->Responsable;
    }

    public function getCantidadU() {
        return $this->CantidadU;
    }

    /**
     * Setter
     * */
    public function setNombre($value) {
        $this->Nombre = $value;
    }

    public function setFecha($value) {
        $this->Fecha = $value;
    }

    public function setResponsable($value) {
        $this->Responsable = $value;
    }

    public function setCantidadU($value) {
        $this->CantidadU = $value;
    }

}

?>