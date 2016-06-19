<?php

/**
 * 
 */
class ReporteTipoDTO {

    private $id;
    private $Fecha;
    private $Tipo;
    private $Observacion;

    /**
     * Constructor
     * */
    function ReporteTipoDTO($id, $Fecha, $Tipo, $Observacion) {
        $this->id = $id;
        $this->Fecha = $Fecha;
        $this->Tipo = $Tipo;
        $this->Observacion = $Observacion;
    }

    /**
     * Getters
     * */
    public function getId() {
        return $this->id;
    }

    public function getFecha() {
        return $this->Fecha;
    }

    public function getTipo() {
        return $this->Tipo;
    }

    public function getObservacion() {
        return $this->Observacion;
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

    public function setObservacion($value) {
        $this->Observacion = $value;
    }

}

?>