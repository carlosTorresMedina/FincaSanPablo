<?php

/**
 * 
 */
class ReporteDietaDTO {

    private $Dieta;
    private $TipoAnimal;
    private $Fecha;

    /**
     * Constructor
     * */
    function ReporteDietaDTO($Dieta, $TipoAnimal, $Fecha) {
        $this->Dieta = $Dieta;
        $this->TipoAnimal = $TipoAnimal;
        $this->Fecha = $Fecha;
    }

    /**
     * Getter
     * */
    public function getDieta() {
        return $this->Dieta;
    }

    public function getTipoAnimal() {
        return $this->TipoAnimal;
    }

    public function getFecha() {
        return $this->Fecha;
    }

    /**
     * Setter
     * */
    public function setDieta($value) {
        $this->Dieta = $value;
    }

    public function setTipoAnimal($value) {
        $this->TipoAnimal = $value;
    }

    public function setFecha($value) {
        $this->Fecha = $value;
    }

}

?>