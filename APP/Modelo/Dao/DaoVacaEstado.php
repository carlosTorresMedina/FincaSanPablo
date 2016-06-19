<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * esta clase tiene como objetivo el acceso a la base de datos especificamente a la tabla vaca_estado
 * esta clase representa el modulo control de reproducciono bovino
 * @author carlos
 */
class DaoVacaEstado extends Dao {
    //put your code here

    /**
     * consulta el estado actual de la vaca.
     * @param type $dto
     * @return type
     */
    public function consultarEstado($dto) {
        $id = $dto->getID();
        $this->conectar();
        $sql = "SELECT ID,ESTADO FROM vaca_estado WHERE ID='$id'";
        $valor = $this->consulta($sql);

        if ($this->numero_de_filas($valor) > 0) {
            while ($tsArray = $this->fetch_assoc($valor)) {
                $data[] = $tsArray;
            }
        }
        return $data;
    }

    /**
     * consulta una vaca y retorna su estado proximo en el proceso de reproduccion bovino
     * @param type $dto
     * @return string
     */
    public function consultarVacaEstadoProximo($dto) {
        $this->conectar();
        $ID = $dto->getID();
        $sql = "SELECT ID,ESTADO FROM vaca_estado WHERE ID='$ID'";
        $valor = $this->consulta($sql);
        $this->disconnect();
        if ($this->numero_de_filas($valor) > 0) {
            while ($tsArray = $this->fetch_assoc($valor)) {
                $data[] = $tsArray;
            }
            foreach ($data as $ar) {

                if ($ar['ESTADO'] == 'gestacion') {

                    $ar['ESTADO'] = 'produccion';
                } elseif ($ar['ESTADO'] == 'produccion') {

                    $ar['ESTADO'] = 'tiempo muerto';
                } elseif ($ar['ESTADO'] == 'tiempo muerto') {
                    $ar['ESTADO'] = 'ninguno';
                }
            }
            $data[0] = $ar;
            return $data;
        } else {
            return '';
        }
    }

    /**
     * actualiza el estado de la vaca en la tabla vaca estado.
     * @param type $dto
     * @return type
     */
    public function actualizarEstado($dto) {

        $this->conectar();
        $ID = $dto->getID();

        $estado = $dto->getEstado();
        $sql = "UPDATE vaca_estado set ESTADO='$estado' WHERE ID='$ID'";
        $valor = $this->actualizar($sql);
        $this->disconnect();
        return $valor;
    }

    /**
     * carga las vacas que  estan en el proceso de reproduccion bovino.
     * @return string
     */
    public function cargarVacaNoEstadoNinguno() {
        $this->conectar();
        $sql = "SELECT ID FROM vaca_estado WHERE ESTADO <> 'ninguno'";
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
     * carga las vacas que no estan en el proceso de reproduccin bovino
     * @return string
     */
    public function cargarVacaEstadoNinguno() {

        $this->conectar();
        $sql = "SELECT ID FROM vaca_estado WHERE ESTADO='ninguno'";
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
     * elimina a una vaca de la tabla vaca_estado
     * @param type $VacaEstadoDTO
     * @return type
     */
    public function eliminarVacaEstado($VacaEstadoDTO) {
        $this->conectar();
        $ID = $VacaEstadoDTO->getID();


        $sql = "DELETE FROM vaca_estado WHERE ID='$ID'";


        $valor = $this->eliminar($sql);
        $this->disconnect();

        return $valor;
    }

   

}

?>