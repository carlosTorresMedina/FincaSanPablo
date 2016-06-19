<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * esta clase tiene como objetivo el acceso a la base de datos especificamente a la tabla reporte_tipo
 * esta clase representa el modulo gestion de animales
 * @author carlos
 */
class DaoReporteTipo extends Dao {
    //put your code here

    /**
     * consulta los reportes tipo los cuales indican los reportes que se realizan a cada animal
     * @param type $dto1
     * @param type $dto2
     */
    public function consultarReporteTipo($dto1, $dto2) {
        $tipo = $dto1->getTipo();
        $fechaI = $dto1->getFecha();
        $fechaF = $dto2->getFecha();
        $this->conectar();
        $sql = "SELECT ID,FECHA,PK_TIPO,OBSERVACIONES FROM `reporte_tipo` WHERE PK_TIPO='$tipo' and `FECHA` BETWEEN '$fechaI' AND '$fechaF'";
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
     * registra un reporte tipo
     * @param type $dto
     * @return type
     */
    public function registrarReporteTipo($dto) {
        $id = $dto->getId();
        $Fecha = $dto->getFecha();
        $Tipo = $dto->getTipo();
        $Observacion = $dto->getObservacion();

        $this->conectar();
        $sql = "INSERT INTO reporte_tipo(ID,FECHA,PK_TIPO,OBSERVACIONES) values('$id','$Fecha','$Tipo','$Observacion')";

        $valor = $this->registrar($sql);
        $this->disconnect();
        return $valor;
    }

}

?>