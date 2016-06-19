<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * la clase dao reporte dieta tiene como objetivo el acceso a la base de datos
 * especificamente a la tabla reporte_dieta
 * esta clase representa al modulo gestion de dietas
 * @author carlos
 */
class DaoReporteDieta extends Dao {
    //put your code here

    /**
     * consulta todas las dietas que  se le han aplicado a un tipo de animal en el tiempo
     * @param type $dtoI
     * @param type $dtoF
     * @return string
     */
    public function consultarReporteDieta($dtoI, $dtoF) {
        $this->conectar();
        $nombre = $dtoI->getDieta();
        $fechaI = $dtoI->getFecha();
        $fechaF = $dtoF->getFecha();

        $sql = "SELECT `FK_ID_DIETA`, `FK_TIPO_ANIMAL`, `FECHA` FROM `reporte_dieta` WHERE `FK_ID_DIETA`='$nombre' AND FECHA BETWEEN '$fechaI' AND '$fechaF'";
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
     * elimina todos los reportes de la dieta especificada
     * @param type $dto
     * @return type
     */
    public function eliminarReporteDieta($dto) {

        $this->conectar();

        $dieta = $dto->getDieta();

        $sql = "DELETE FROM reporte_dieta WHERE FK_ID_DIETA='$dieta'";
        $valor = $this->eliminar($sql);
        $this->disconnect();

        return $valor;
    }

    /**
     * registra la dieta que se le esta dando a un tipo de animal con la fecha actual
     * @param type $dto
     * @return type
     */
    public function registrarReporteDieta($dto) {

        $this->conectar();
        $tipo = $dto->getTipoAnimal();
        $dieta = $dto->getDieta();

        $sql = "INSERT INTO reporte_dieta (FK_ID_DIETA ,FK_TIPO_ANIMAL,FECHA ) VALUES('$dieta','$tipo',NOW())";
        $valor = $this->registrar($sql);
        $this->disconnect();
        return $valor;
    }

}

?>