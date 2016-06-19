<?php

/**
 * 
 */
class ReporteAnimalDTO {

    private $IdAnimal;
    private $IdRerporteTipo;
    private $Tamano;
    private $Peso;

    /**
     * Constructor
     * */
    function ReporteAnimalDTO($IdAnimal, $IdRerporteTipo, $Tamano, $Peso) {
        $this->IdAnimal = $IdAnimal;
        $this->IdRerporteTipo = $IdRerporteTipo;
        $this->Tamano = $Tamano;
        $this->Peso = $Peso;
    }

    /**
     * Getters
     * */
    public function getIdAnimal() {
        return $this->IdAnimal;
    }

    public function getIdRerporteTipo() {
        return $this->IdRerporteTipo;
    }

    public function getTamano() {
        return $this->Tamano;
    }

    public function getPeso() {
        return $this->Peso;
    }

    /**
     * Setters
     * */
    public function setIdAnimal($value) {
        $this->IdAnimal = $value;
    }

    public function setIdRerporteTipo($value) {
        $this->IdRerporteTipo = $value;
    }

    public function setTamano($value) {
        $this->Tamano = $value;
    }

    public function setPeso($value) {
        $this->Peso = $value;
    }

}

?>