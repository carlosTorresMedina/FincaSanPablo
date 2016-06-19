<?php

/**
 * 
 */
class DietaDTO {

    private $Nombre;
    private $Descripcion;

    /**
     * constructor
     * */
    function DietaDTO($Nombre, $Descripcion) {
        $this->Nombre = $Nombre;
        $this->Descripcion = $Descripcion;
    }

    /**
     * Getters
     * */
    public function getNombre() {
        return $this->Nombre;
    }

    public function getDescripcion() {
        return $this->Descripcion;
    }

    /**
     * Setters
     * */
    public function setNombre($value) {
        $this->Nombre = $value;
    }

    public function setDescripcion($value) {
        $this->Descripcion = $value;
    }

}

?>