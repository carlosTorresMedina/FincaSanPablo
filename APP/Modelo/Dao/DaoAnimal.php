<?php

require_once 'Dao.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * la clase dao animal tiene como objetivo el acceso a la base de datos
 * especificamente a la tabla animales
 * esta clase representa al modulo gestion de animales
 *
 * @author carlos
 */
class DaoAnimal extends Dao {

    //put your code here

    function __construct() {
        
    }

    /**
     * elimina un determinado medicamento de los animales que lo tiene
     * @param type $AnimalDTO
     * @return type
     */
    public function quitarMedicamentoAnimal($AnimalDTO) {
        $this->conectar();
        $medicamento = $AnimalDTO->getMedicamento();

        $sql = "UPDATE animales SET MEDICAMENTO='ninguno'  WHERE MEDICAMENTO='$medicamento'";


        $valor = $this->actualizar($sql);
        $this->disconnect();

        return $valor;
    }

    /* consulta un animal en especifico
     * @param type $AnimalDTO
     * @return type
     */

    public function consultarAnimalEspecifico($AnimalDTO) {

        $this->conectar();
        $Tipo = $AnimalDTO->getTipo();
        $Id = $AnimalDTO->getId();
        $Compuesto = $Tipo . "-" . $Id;

        $sql = "SELECT id,tamano,peso,sexo,medicamento FROM animales WHERE ID='$Compuesto' ";
        $valor = $this->consulta($sql);
        $this->disconnect();


        if ($this->numero_de_filas($valor) > 0) {

            while ($tsArray = $this->fetch_assoc($valor)) {
                $data[] = $tsArray;
            }
            return $data;
        } else {
            return '';
        }
    }

    /**
     * consulta animal
     * @param type $AnimalDTO 
     * @return type
     */
    public function consultarAnimalGeneral($AnimalDTO) {

        $this->conectar();

        $Tipo = $AnimalDTO->getTipo();

        $sql = "SELECT id,tamano,peso,sexo,medicamento  FROM animales WHERE TIPO='$Tipo' ";

        $valor = $this->consulta($sql);
        $this->disconnect();
        if ($this->numero_de_filas($valor) > 0) {

            while ($tsArray = $this->fetch_assoc($valor)) {
                $data[] = $tsArray;
            }
            return $data;
        } else {
            return '';
        }
    }

  

    /**
     * modfica animal
     * @param type $AnimalDTO
     * @return type
     */
    public function modificarAnimal($AnimalDTO) {
        $this->conectar();
        $Id = $AnimalDTO->getID();
        $Tipo = $AnimalDTO->getTipo();

        $Tamano = $AnimalDTO->getTamano();
        $Peso = $AnimalDTO->getPeso();
        $Sexo = $AnimalDTO->getSexo();
        $Medicamento = $AnimalDTO->getMedicamento();

        $sql = "UPDATE animales SET TAMANO=$Tamano,PESO=$Peso,SEXO=$Sexo,MEDICAMENTO='$Medicamento' WHERE ID='$Id'";


        $valor = $this->actualizar($sql);
        $this->disconnect();

        return $valor;
    }

    /**
     * ELIMINA animal
     * @param type $AnimalDTO
     */
    public function eliminarAnimal($AnimalDTO) {
        $this->conectar();
        $Id = $AnimalDTO->getID();

        $sql = "DELETE FROM animales WHERE ID='$Id' ";

        $valor = $this->eliminar($sql);
        $this->disconnect();
        return $valor;
    }

    /**
     * registra animal
     * @param type $AnimalDTO
     */
    public function registrarAnimal($AnimalDTO) {
        $this->conectar();
        $Id = $AnimalDTO->getID();
        $Tipo = $AnimalDTO->getTipo();

        $compuesto = $Tipo . "-" . $Id;
        $Tamano = $AnimalDTO->getTamano();
        $Peso = $AnimalDTO->getPeso();
        $Sexo = $AnimalDTO->getSexo();
        $Medicamento = $AnimalDTO->getMedicamento();

        $sql = "INSERT INTO animales (id,tipo,tamano,peso,sexo,medicamento) VALUES('$compuesto','$Tipo',$Tamano,$Peso,'$Sexo','$Medicamento')";

        $valor = $this->registrar($sql);

        $this->disconnect();
        return $valor;
    }

    /**
     * consuta los tipos de animal
     * @return type retorna un array con los tipos de animales que hay registrado en la base de datos
     */
    public function consultarTipoAnimal() {
        $this->conectar();
        $sql = "SELECT tipo,cantidad FROM tipo_animal ";

        $consulta = $this->consulta($sql);
        $this->disconnect();
        if ($this->numero_de_filas($consulta) > 0) {

            while ($tsArray = $this->fetch_assoc($consulta))
                $data[] = $tsArray;

            return $data;
        } else {
            return '';
        }
    }

}

?>
