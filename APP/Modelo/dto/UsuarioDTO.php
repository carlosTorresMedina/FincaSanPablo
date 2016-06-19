<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UsuarioDTO
 *
 * @author carlos 
 * 
 */
class UsuarioDTO {

    //put your code here
    private $usuario;
    private $password;

    function _construct() {
        
    }

    /**
     * get usuario
     * @return type
     */
    public function getUsuario() {
        return $this->usuario;
    }

    /**
     * get password
     * @return type
     */
    public function getPassword() {
        return $this->password;
    }

    /**
     * set usuario
     * @param type $usuario
     */
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    /**
     * set password
     * @param type $password
     */
    public function setPassword($password) {
        $this->password = $password;
    }

}
