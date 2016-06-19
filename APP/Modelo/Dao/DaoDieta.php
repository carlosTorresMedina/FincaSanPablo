<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require_once 'Dao.php';

/**
 * Description of DaoAnimal
 * la clase dao dieta tiene como objetivo el acceso a la base de datos 
 * especificamente a la tabla dieta
 * esta clase representa al modulo gestion de dietas
 * @author carlos
 */
class DaoDieta extends Dao {

    public function consultarDietaGeneral() {

        $this->conectar();

        $sql = "SELECT ID_DIETA,DESCRIPCION FROM dieta where ID_DIETA <> 'ninguno'";
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
     * modifica una determinada dieta en la base de datos
     * @param type $dto
     * @return type
     */
    public function modificarDieta($dto) {

        $this->conectar();
        $nombre = $dto->getNombre();
        $descripcion = $dto->getDescripcion();
        $sql = "UPDATE dieta SET DESCRIPCION='$descripcion' WHERE ID_DIETA='$nombre'";
        $valor = $this->actualizar($sql);
        $this->disconnect();
        return $valor;
    }

    /**
     * busca determinada dieta en la base de datos
     * @param type $dto
     * @return string
     */
    public function buscarDieta($dto) {
        $this->conectar();
        $nombre = $dto->getNombre();
        $sql = "SELECT ID_DIETA,DESCRIPCION FROM dieta WHERE ID_DIETA='$nombre'";
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
     * carga todos los nombres de las dietas
     * @return string
     */
    public function cargarNombreDieta() {
        $this->conectar();

        $sql = "SELECT ID_DIETA FROM dieta";
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
     * elimina una dieta de la base de datos
     * @param type $DietaDTO
     * @return type
     */
    public function eliminarDieta($DietaDTO) {
        $this->conectar();
        $Id = $DietaDTO->getNombre();
        $sql = "DELETE FROM dieta WHERE ID_DIETA='$Id'";
        $valor = $this->eliminar($sql);
        $this->disconnect();

        return $valor;
    }

    /**
     * registra una dieta en la base de datos
     * @param type $DietaDTO
     * @return type verdadero registro exitos, false error al registrar
     */
    public function registrarDieta($DietaDTO) {

        $this->conectar();
        $Id = $DietaDTO->getNombre();
        $Descripcion = $DietaDTO->getDescripcion();

        $sql = "INSERT INTO dieta  (ID_DIETA,DESCRIPCION) VALUES('$Id','$Descripcion')";
        $valor = $this->registrar($sql);
        $this->disconnect();

        return $valor;
    }

}

?>