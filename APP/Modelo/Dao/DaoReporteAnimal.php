<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoAnimal
 * se encarga de manejar la informacion de los reportes de animales.
 * esta clase representa al modulo gestion de animales
 * @author carlos
 */
class DaoReporteAnimal extends Dao {

    //put your code here
    public function eliminarReporteAdjuntoEspecifico($dto) {
        $id = $dto->getIdAnimal();
        $this->conectar();
        $sql = "DELETE FROM reporte_animal WHERE ID='$id'";
        $valor = $this->eliminar($sql);
        $this->disconnect();
        return $valor;
    }

    public function consultarReporteAnimalAdjunto($dto) {
        $id = $dto->getIdRerporteTipo();
        $this->conectar();

        $sql = "SELECT ID,ID_REPORTE,TAMANO,PESO  FROM `reporte_animal` WHERE `ID_REPORTE`='$id'";
        $consulta = $this->consulta($sql);

        if ($this->numero_de_filas($consulta) > 0) {

            while ($tsArray = $this->fetch_assoc($consulta)) {
                $data[] = $tsArray;
            }

            return $data;
        } else {

            return '';
        }
    }

    /**
     * retistra los valores al reportes adjunto de tipo
     * @param type $dto
     * @return type
     */
    public function registrarReporteAnimalAdjunto($dto) {
        $IdAnimal = $dto->getIdAnimal();
        $IdRerporte = $dto->getIdRerporteTipo();
        $Tamano = $dto->getTamano();
        $Peso = $dto->getPeso();

        $this->conectar();
        $sql = "INSERT INTO reporte_animal (ID,ID_REPORTE,TAMANO,PESO) VALUES('$IdAnimal','$IdRerporte','$Tamano','$Peso')";
        $valor = $this->registrar($sql);
        return $valor;
    }

}

?>