<?php

/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * cerda@redzpot.com
 *  */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/controllers/mvc.controller.php");
require_once($_SITE_PATH . "/app/model/principal.class.php");

class mvc_controller_default extends mvc_controller {

    public function __construct() {
        parent::__construct();
        /*
         * Constructor de la clase
         */
    }
    public function bienvenida() {
        include_once("app/views/default/modules/m.bienvenida.php");
    }
    public function clientes () {
        include_once("app/views/default/modules/catalogos/clientes/m.clientes.php");
    }
    public function marcas () {
        include_once("app/views/default/modules/catalogos/marcas/m.marcas.php");
    }
    public function registro () {
        include_once("app/views/default/modules/modulos/registro/m.registro.php");
    }
}

?>
