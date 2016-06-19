<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * esta clase tiene como objetivo el acceso a la base de datos especificamente a la tabla reporte_medicamento
 * esta clase representa el modulo gestion de medicamentos
 * @author carlos
 */
class DaoReporteMedicamento extends Dao {
    //put your code here

    /**
     * consulta reporte medicamentos segun un rango determinado de fecha de un medicamento en especifico
     * @param type $dtoI
     * @param type $dtoF
     * @return string
     */
    public function consultarReporteMedicamento($dtoI, $dtoF) {
        $this->conectar();
        $nombre = $dtoI->getNombre();
        $fechaI = $dtoI->getFecha();
        $fechaF = $dtoF->getFecha();
        $fechaF = $fechaF . " 23:59:56";
        $sql = "SELECT `FK_NOMBRE_MEDICAMENTO`, `fecha`, `responsable`, `cantidad_utilizada` FROM `reporte_medicamento` WHERE `FK_NOMBRE_MEDICAMENTO`='$nombre' AND FECHA BETWEEN '$fechaI' AND '$fechaF'";
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
     * elimina un reporte de medicamento registrado en la base de datos
     * @param type $dto
     * @return type
     */
    public function eliminarReporteMedicamento($dto) {

        $this->conectar();
        $nombre = $dto->getNombre();
        $sql = "DELETE FROM reporte_medicamento WHERE `FK_NOMBRE_MEDICAMENTO` = '$nombre'";
        $valor = $this->eliminar($sql);
        $this->disconnect();
        return $valor;
    }

    /**
     * registra un reporte de medicamentos
     * @param type $dto
     * @return type
     */
    public function registrarReporteMedicamento($dto) {

        $this->conectar();
        $nombre = $dto->getNombre();
        $responsable = $dto->getResponsable();
        $gasto = $dto->getCantidadU();

//        $hoy = time();
//        $fecha=strftime( "%Y-%m-%d %H:%M:%S", $hoy);
//        $v = Date($hoy = date("Y-m-d H:i:s"), $hoy);
//        echo $v;
        $sql = "INSERT INTO `reporte_medicamento` (`FK_NOMBRE_MEDICAMENTO`, `FECHA`, `RESPONSABLE`, `CANTIDAD_UTILIZADA`) VALUES ('$nombre', NOW(), '$responsable', $gasto);";
        $valor = $this->registrar($sql);
        $this->disconnect();
        return $valor;
    }

}

?>