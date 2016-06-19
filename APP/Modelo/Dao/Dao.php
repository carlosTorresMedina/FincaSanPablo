<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Dao
 * la clase dao tiene como objetivo el acceso directo a la base de datos
 * @author carlos
 */
class Dao {

    //put your code here

    private $conexion = null;

    /**
     * conecta a la base de datos
     */
    public function conectar() {
        if (!isset($this->conexion)) {
            $this->conexion = (mysql_connect("localhost", "root", "")) or die("SERVIDOR" . mysql_error());
//            $this->conexion = (mysql_connect("localhost", "root", "")) or die("SERVIDOR" . mysql_error());
//            mysql_select_db("finca", $this->conexion) or die("BASE DE DATOS" . mysql_error());
            mysql_select_db("finca", $this->conexion) or die("BASE DE DATOS" . mysql_error());
        }
    }

    /**
     * consulta en la base de datos
     * @param type $sql sentencia sql
     * @return type retorna array con datos de consulta
     */
    public function consulta($sql) {
        $resultado = mysql_query($sql, $this->conexion);

        if (!$resultado) {
            echo mysql_error();
            exit;
        }
        return $resultado;
    }

    /**
     * registra en la base de datos
     * @param type $sql sentecia en sql
     * @return type true si hay un registro exitoso; false si hay un error
     */
    public function registrar($sql) {
        $resultado = mysql_query($sql, $this->conexion);

        if (!$resultado) {

            return false;
        }
        return true;
    }

    /**
     * actualiza en la base de datos
     * @param type $sql sentencia sql
     * @return type true si hay una actualizacion exitoso; false si hay un error
     */
    public function actualizar($sql) {
        $resultado = mysql_query($sql, $this->conexion);

        if (!$resultado) {


            echo 'ERROR AL ACTUALIZAR: ' . mysql_error();
        }

        return $resultado;
    }

    /**
     * METODO PARA ELIMINAR
     * @param type $sql codigo sql para ejecutar  la consulta
     * @return type  $result
     */
    public function eliminar($sql) {
        $resultado = mysql_query($sql, $this->conexion);

        if (!$resultado) {
            echo 'ERROR ELIMINAR: ' . mysql_error();
            exit;
        }
        return $resultado;
    }

    /**
     * METODO PARA CONTAR EL NUMERO DE RESULTADOS
     * @param type $result
     * @return  cantidad de registros encontrados
     */
    function numero_de_filas($result) {
        if (!is_resource($result))
            return false;
        return mysql_num_rows($result);
    }

    /**
     *  METODO PARA CREAR ARRAY DESDE UNA CONSULTA
     * @param type $result
     * @return array con los resultados de una consulta
     */
    function fetch_assoc($result) {
        if (!is_resource($result))
            return false;
        return mysql_fetch_assoc($result);
    }

    /**
     * cierra la conexioin
     */
    public function disconnect() {

        mysql_close();
    }

}

?>
