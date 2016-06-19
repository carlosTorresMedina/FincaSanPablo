<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of control
 *
 * @author carlos
 */
abstract class Control {

    /**
     * muestra la pagina inicio de sesion.
     */
    public function Principal() {

        $pagina = $this->load_page('Vista/principal.html');
        $this->view_page($pagina);
    }

    //put your code here

    /* METODO QUE CARGA LAS PARTES PRINCIPALES DE LA PAGINA WEB
     */

    function load_template($title = 'Sin Titulo') {
        $pagina = $this->load_page('Vista/home.html');
        $header = $this->load_page('Vista/header.html');
        $pagina = $this->replace_content('/\#header\#/ms', $header, $pagina);
        $pagina = $this->replace_content('/\#TITLE\#/ms', $title, $pagina);
        $footer = $this->load_page('Vista/footer.html');
        $pagina = $this->replace_content('/\#footer\#/ms', $footer, $pagina);
        return $pagina;
    }

    /* METODO QUE CARGA UNA PAGINA DE LA SECCION VIEW Y LA MANTIENE EN MEMORIA

     */

    function load_page($page) {
        return file_get_contents($page);
    }

    /* METODO QUE ESCRIBE EL CODIGO PARA QUE SEA VISTO POR EL USUARIO

     */

    function view_page($html) {
        echo $html;
    }

    /* PARSEA LA PAGINA CON LOS NUEVOS DATOS ANTES DE MOSTRARLA AL USUARIO

     */

    function replace_content($in = '/\#CONTENIDO\#/ms', $out, $pagina) {
        return preg_replace($in, $out, $pagina);
    }

    /**
     * muestra el home de inicio de session.
     */
    public function Home() {

        $pagina = $this->load_template("HOME");
        $section = $this->load_page('Vista/seccion/seccionHome.html');
        $pagina = $this->replace_content('/\#section\#/ms', $section, $pagina);
        $this->view_page($pagina);
    }

}
