<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * esta clase tiene como objetio el acceso a la base de datos especificamente a la tabla reporte_general
 * esta clase representa al modulo gestion de animales
 * @author carlos
 */
class DaoReporteGeneralAnimal extends Dao {

    //put your code here
    public function consultarReporteGeneral($dto) {
        $fecha = $dto->getFecha();
        $this->conectar();
        $sql = "SELECT PK_TIPO ,CANTIDAD, PK_FECHA  FROM `reporte_general_animal` WHERE `PK_FECHA`='$fecha'";
        $consulta = $this->consulta($sql);
        if ($this->numero_de_filas($consulta) > 0) {

            while ($tsArray = $this->fetch_assoc($consulta))
                $data[] = $tsArray;

            return $data;
        } else {

            return '';
        }

        return $valor;
    }

    public function adjuntarReporteGeneral($dto) {
        $tipo = $dto->getTipo();
        $cantidad = $dto->getCantidad();
        $this->conectar();


        $sql = "INSERT INTO reporte_general_animal ( PK_TIPO ,PK_FECHA,CANTIDAD  ) VALUES('$tipo',NOW(),'$cantidad')";
        $valor = $this->registrar($sql);


        return $valor;
    }

}

?>