<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoReporteGeneral
 * esta clase tiene como objetivo el acceso a las base de datos especificamente a la tabla reporte_general 
 * esta clase representa el modulo gestion de animales
 * @author carlos
 */
class DaoReporteGeneral extends Dao {

    //put your code here

    public function consultarReporteGeneral($dto1, $dto2) {
        if ($dto1 instanceof ReporteGeneralDTO) {
            $fechaI = $dto1->getFecha();
            $fechaF = $dto2->getFecha();
            $this->conectar();
            $sql = "SELECT PK_FECHA,OBSERVACIONES FROM `reporte_general` WHERE `PK_FECHA` BETWEEN '$fechaI' AND '$fechaF'";
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

    /**
     * registra reporte general.
     * @param type $dto
     * @return type
     */
    public function registrarReporteGeneral($dto) {
        $observacion = $dto->getObservacion();
        $this->conectar();


        $sql = "INSERT INTO reporte_general (PK_FECHA,OBSERVACIONES) VALUES(NOW(),'$observacion')";


        $valor = $this->registrar($sql);

        $this->disconnect();
        return $valor;
    }

}
