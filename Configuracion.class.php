<?php

/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 *  */
class Configuracion {
	protected $mysql_host;
	protected $mysql_user;
	protected $mysql_pass;
	protected $mysql_database;
    public $NombreSesion;
    protected $MasterKey;
    protected $RutaAbsoluta;

	public function __construct() {
        $this->mysql_database = "prueba";
        $this->mysql_host = "localhost";
        $this->mysql_user = "root";
        $this->mysql_pass = "";
        $this->NombreSesion = "AWSOFTWARE";
        $this->MasterKey = "aw";
        $this->RutaAbsoluta = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
	}

	protected function getRealIP() {
		if (! empty ( $_SERVER ['HTTP_CLIENT_IP'] ))
			return $_SERVER ['HTTP_CLIENT_IP'];

		if (! empty ( $_SERVER ['HTTP_X_FORWARDED_FOR'] ))
			return $_SERVER ['HTTP_X_FORWARDED_FOR'];

		return $_SERVER ['REMOTE_ADDR'];
	}
}

?>
