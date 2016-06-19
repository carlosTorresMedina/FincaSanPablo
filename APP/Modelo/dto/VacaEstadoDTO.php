<?php

/**
 * 
 */
class VacaEstadoDTO {

    private $Id;
    private $Estado;

    public function VacaEstadoDTO($id, $estado) {
        $this->Id = $id;
        $this->Estado = $estado;
    }

    /**
     * Getters
     * */
    public function getID() {
        return $this->Id;
    }

    /**
     * Setters
     * */
    public function setID($id) {
        $this->Id = $id;
    }

    /**
     * Getters
     * */
    public function getEstado() {
        return $this->Estado;
    }

    /**
     * Setters
     * */
    public function setEstado($Estado) {
        $this->Estado = $Estado;
    }

}

?>