<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnimalDTO
 *
 * @author carlos
 */
class AnimalDTO {
    //put your code here

    /**
     * Atributos
     * */
    private $Id;
    private $Tipo;
    private $Tamano;
    private $Peso;
    private $Sexo;
    private $Medicamento;

    public function __construct($Id, $Tipo, $Tamano, $Peso, $Sexo, $Medicamento) {
        $this->Id = $Id;
        $this->Tipo = $Tipo;
        $this->Tamano = $Tamano;
        $this->Peso = $Peso;
        $this->Sexo = $Sexo;
        $this->Medicamento = $Medicamento;
    }

    /**
     * Geter
     * */
    public function getId() {
        return $this->Id;
    }

    public function getTipo() {
        return $this->Tipo;
    }

    public function getTamano() {
        return $this->Tamano;
    }

    public function getPeso() {
        return $this->Peso;
    }

    public function getSexo() {
        return $this->Sexo;
    }

    public function getMedicamento() {
        return $this->Medicamento;
    }

    /**
     * Setters
     * */
    public function setId($value) {
        $this->Id = $value;
    }

    public function setTamano($value) {
        $this->Tamano = $value;
    }

    public function setTipo($value) {
        $this->Tipo = $value;
    }

    public function setPeso($value) {
        $this->Peso = $value;
    }

    public function setSexo($value) {
        $this->Sexo = $value;
    }

    public function setMedicamento($value) {
        $this->Medicamento = $value;
    }

}
