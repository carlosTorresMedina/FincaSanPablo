<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * esta clase tiene como objetivo el acceso a la base de datos especificamente a la tabla reproduccion 
 * esta clase representa el modulo control de reproducciono bovino
 * @author carlos
 */
class DaoReproduccion extends Dao {
    //put your code here

    /**
     * actualiza las fechas por default segun la fecha de modificacion nueva
     * @param type $dtoR dto de reproduccion  de la vaca
     * @param type $dtoE dto de estado de la vaca
     * @return type
     */
    public function actualizarFecha($dtoR, $dtoE) {

        $this->conectar();
        $id = $dtoR->getIdAnimal();
        $estado = $dtoE->getEstado();
        $data = $this->obtenerUltimoRegistroFecha($dtoR);
        foreach ($data as $r) {
            $fecha = $r['PK_FECHA_INSEMINACION'];

            $valor = date("Y") . "-" . date("m") . "-" . date("d");
            if ($estado == 'produccion') {
                $sql = "UPDATE `reproduccion` SET `FECHA_DE_PARTO`=NOW(),`INICIO_DESCANSO`=DATE_ADD(CURDATE(), INTERVAL 8 MONTH),`FIN_DESCANSO`=DATE_ADD(CURDATE(), INTERVAL 9 MONTH)  WHERE `PK_ID_ANIMAL`='$id' and `PK_FECHA_INSEMINACION`='$fecha'";
                $valor = $this->actualizar($sql);
                return $valor;
            }

            if ($estado == 'tiempo muerto') {
                $sql = "UPDATE `reproduccion` SET  `INICIO_DESCANSO`=NOW(),`FIN_DESCANSO`=DATE_ADD(CURDATE(), INTERVAL 1 MONTH)   WHERE `PK_ID_ANIMAL`='$id' and `PK_FECHA_INSEMINACION`='$fecha'";
                $valor = $this->actualizar($sql);

                return $valor;
            } if ($estado == 'ninguno') {

                if ($valor <= $r['FECHA_DE_PARTO']) {


                    $sql = "UPDATE reproduccion SET  FECHA_DE_PARTO='00-00-00',INICIO_DESCANSO='00-00-00',FIN_DESCANSO=NOW()   WHERE PK_ID_ANIMAL='$id' and `PK_FECHA_INSEMINACION`='$fecha'";
                    $valor = $this->actualizar($sql);

                    return $valor;
                }

                if ($valor <= $r['INICIO_DESCANSO']) {

                    $sql = "UPDATE reproduccion SET  INICIO_DESCANSO='00-00-00',FIN_DESCANSO=NOW()   WHERE PK_ID_ANIMAL=$id and `PK_FECHA_INSEMINACION`='$fecha'";
                    $valor = $this->actualizar($sql);

                    return $valor;
                } if ($valor <= $r['FIN_DESCANSO']) {
                    $sql = "UPDATE reproduccion SET  FIN_DESCANSO=NOW()  WHERE PK_ID_ANIMAL=$id and `PK_FECHA_INSEMINACION `='$fecha'";
                }
                $valor = $this->actualizar($sql);

                return $valor;
            }
        }
    }

    /**
     * obtiene el ultimo registro de reproduccion segun el id del animal
     * @param type $dto dto del animal
     * @return string
     */
    private function obtenerUltimoRegistroFecha($dto) {


        $id = $dto->getIdAnimal();

        $sql = "SELECT PK_ID_ANIMAL ,PK_FECHA_INSEMINACION ,FECHA_DE_PARTO, INICIO_DESCANSO,FIN_DESCANSO FROM reproduccion WHERE PK_ID_ANIMAL='$id' order by PK_FECHA_INSEMINACION DESC LIMIT 1";
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
     * consulta fechas de manejo de proceso de reproduccion de la una determinada vaca.
     * @return string
     */
    public function consultarFechas($dto) {

        $this->conectar();
        $id = $dto->getIdAnimal();

        $sql = "SELECT  PK_ID_ANIMAL ,PK_FECHA_INSEMINACION ,FECHA_DE_PARTO, INICIO_DESCANSO,FIN_DESCANSO   FROM reproduccion WHERE PK_ID_ANIMAL='$id' order by PK_FECHA_INSEMINACION DESC";
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
     * elimnina el historial de una determinada vaca
     * @param type $dto
     * @return type
     */
    public function eliminarReproduccion($dto) {
        $this->conectar();
        if ($dto instanceof ReproduccionDTO) {
            $Id = $dto->getIdAnimal();
            $sql = "DELETE FROM `reproduccion` WHERE `PK_ID_ANIMAL`='$Id' ";

            $valor = $this->eliminar($sql);
            $this->disconnect();
            return $valor;
        }
    }

    /**
     * ingresa vaca en el proceso de reproduccion y  acomoda las fechas por default
     * @param type $dto dto del animal especificamente una vaca
     * @return type
     */
    public function ingresarReproduccion($dto) {
        $this->conectar();
        $Id = $dto->getIdAnimal();
        $sql = "INSERT INTO `reproduccion` (`PK_ID_ANIMAL`, `PK_FECHA_INSEMINACION`, `FECHA_DE_PARTO`, `INICIO_DESCANSO`, `FIN_DESCANSO`) VALUES ('$Id',NOW(),DATE_ADD(CURDATE(), INTERVAL 9 MONTH),DATE_ADD(CURDATE(), INTERVAL 17 MONTH),DATE_ADD(CURDATE(), INTERVAL 18 MONTH))";
        $valor = $this->registrar($sql);
        $this->disconnect();
        return $valor;
    }

}

?>