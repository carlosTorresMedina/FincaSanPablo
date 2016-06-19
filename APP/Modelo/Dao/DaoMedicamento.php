<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */require 'Modelo/dto/MedicamentoDTO.php';

/**
 * Description of DaoAnimal
 * la clase de medicamento tiene como funcion el acceso a la base de datos especificamente la tabla medicamento
 * esta clase representa al modulo gestion de medicamentos
 * @author carlos
 */
class DaoMedicamento extends Dao {
    //put your code here

    /**
     * gasta una determinada cantidad de medicamento de la base de datos
     * @param type $dto
     * @return type
     */
    public function gastarMedicamento($dto) {

        $this->conectar();
        $nombre = $dto->getNombre();
        $gasto = $dto->getCantidadU();

        $rr = $this->validarGasto($nombre, $gasto);

        if ($rr) {
            $sql = "UPDATE medicamento SET CANTIDAD_UTILIZADA=CANTIDAD_UTILIZADA+$gasto where NOMBRE='$nombre'";
            $valor = $this->actualizar($sql);

            return $valor;
        }
        return false;
    }

    /**
     * tiene como objetivo validad que el gasto no sea mayor que la cantiidad de medicamentos registrada en el sistema.
     * @param type $dto
     * @return boolean
     */
    public function validarGasto($dto) {

        $this->conectar();
        $nombre = $dto->getNombre();
        $gasto = $dto->getCantidadU();

        $sql = "SELECT cantida_existente,cantidad_utilizada FROM medicamento where nombre ='$nombre' ";
        $consulta = $this->consulta($sql);
        $this->disconnect();
        if ($this->numero_de_filas($consulta) > 0) {

            while ($tsArray = $this->fetch_assoc($consulta)) {
                $data[] = $tsArray;
            }
        }
        $v = $data[0];

        if ($v['cantida_existente'] >= ($v['cantidad_utilizada'] + $gasto)) {

            return true;
        } else {
            return false;
        }
    }

    /**
     * ingresa medicamentos a la base de datos
     * @param type $dto
     * @return type
     */
    public function ingresarMedicamento($dto) {
        $this->conectar();
        $nombre = $dto->getNombre();
        $ingreso = $dto->getCantidadE();
        $sql = "UPDATE medicamento SET CANTIDA_EXISTENTE=CANTIDA_EXISTENTE+$ingreso where NOMBRE='$nombre'";
        $valor = $this->actualizar($sql);
        $this->disconnect();

        return $valor;
    }

    /**
     * elimina un medicamento de la base de datos
     * @param type $dto
     * @return type
     */
    public function eliminarMedicamento($dto) {
        $nombre = $dto->getNombre();
        $this->conectar();
        $sql = "DELETE FROM medicamento WHERE NOMBRE='$nombre'";
        $valor = $this->eliminar($sql);
        $this->disconnect();

        return $valor;
    }

    /**
     * modifica un medicamento en la base de datos
     * @param type $dto
     * @return type
     */
    public function modificarMedicamento($dto) {

        $nombre = $dto->getNombre();
        $cantidadE = $dto->getCantidadE();
        $cantidadU = $dto->getCantidadU();
        $nomenclatura = $dto->getNomenclatura();

        $this->conectar();
        $sql = "UPDATE medicamento SET CANTIDA_EXISTENTE=$cantidadE,CANTIDAD_UTILIZADA=$cantidadU, NOMENCLATURA='$nomenclatura' WHERE NOMBRE='$nombre'";

        $consulta = $this->actualizar($sql);
        $this->disconnect();
        return $consulta;
    }

    /**
     * consulta un medicamento en la base de datos
     * @param type $dto
     * @return string
     */
    public function consultarMedicamentoEspecifico($dto) {

        $nombre = $dto->getNombre();

        $this->conectar();
        $sql = "SELECT nombre,cantida_existente,cantidad_utilizada,nomenclatura FROM medicamento where nombre ='$nombre' ";

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

    /**
     * permite la consulta de medicamentos a la base de datos de manera especifica
     * @return string
     */
    public function consultarMedicamentoGeneral() {


        $this->conectar();
        $sql = "SELECT nombre,cantida_existente,cantidad_utilizada FROM medicamento ";

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

    /**
     * registra un medicamento en la base de datos
     * @param type $dto
     * @return type
     */
    public function registrarMedicamento($dto) {

        $this->conectar();
        $nombre = $dto->getNombre();
        $cantidadE = $dto->getCantidadE();
        $cantidadU = $dto->getCantidadU();
        $nomenclatura = $dto->getNomenclatura();



        $sql = "INSERT INTO medicamento (nombre,cantida_existente,cantidad_utilizada,nomenclatura) VALUES('$nombre',$cantidadE,$cantidadU,'$nomenclatura')";
        $valor = $this->registrar($sql);
        $this->disconnect();
        return $valor;
    }

    /**
     * consuta los tipos de animal
     * @return type retorna un array con los tipos de animales que hay registrado en la base de datos
     */
    public function consultarNombreMedicamento() {
        $this->conectar();
        $sql = "SELECT nombre FROM medicamento ";

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