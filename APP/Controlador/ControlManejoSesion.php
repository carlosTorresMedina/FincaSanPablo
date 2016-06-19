<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Modelo/Fachada.php';
require 'Control.php';

/**
 * Description of Fachada
 *
 * @author carlos torres
 */
class ControlManejoSesion extends Control {

    function ControlManejoSesion() {
        
    }

    /**
     * inicia session
     * @param type $usuario
     * @param type $contraseña
     * @return boolean true inicia session , false datos erroneos
     */
    public function IniciarSesion($usuario, $contraseña) {

        $fachada = new Fachada();
        return $fachada->iniciarSesion($usuario, $contraseña);
    }

    /**
     * divide el archivo usuario.txt para comprobar el inicio de session
     * @return lista de variables con el usuario y la contaseña
     */
    private function dividirArchivo() {

        $path = "Controlador/Util/usuario.txt";
        if (!file_exists($path))
            exit("File not found");

        $file = fopen($path, "r");
        if ($file) {
            $line = fgets($file);
            if (!feof($file)) {
                echo "Error: EOF not found\n";
            }
            fclose($file);
        }

        return list ($user, $pass) = explode("||", $line);
    }

}
