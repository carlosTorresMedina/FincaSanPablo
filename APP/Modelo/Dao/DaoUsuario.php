<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DaoUsuario
 *
 * @author carlos
 */
class DaoUsuario extends Dao {
    //put your code here

    /**
     * metodo que consulta el usuario registrado en el sistema
     * true: esta registrado, false: no esta registrado
     * @param type $UsuarioDTO
     * @return boolea
     */
    public function iniciarSesion($UsuarioDTO) {
        $this->conectar();

        $usuario = $UsuarioDTO->getUsuario();
        $password = $UsuarioDTO->getPassword();



        $sql = "SELECT usuario,password FROM usuario WHERE usuario='$usuario' and password='$password'";


        $valor = $this->consulta($sql);
        $this->disconnect();


        if ($this->numero_de_filas($valor) > 0) {
            return true;
        } else {
            return false;
        }
    }

}
