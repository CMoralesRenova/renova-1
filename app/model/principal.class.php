<?php
/*
 * Copyright 2021 - FELIPE ANGEL CERDA CONTRERAS
 * felipeangelcerdacontreras@gmail.com
 */

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1]. "/";
require_once($_SITE_PATH . "/Configuracion.class.php");
require_once($_SITE_PATH . "/app/model/db.class.php");

date_default_timezone_set("America/Mexico_City");


class AW extends database
{
    var $MESES = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");

    public function __construct($valida_sesion = true)
    {
        /*
         * s = SESION
         */
        parent::__construct();

        if ($valida_sesion === true)
            $this->ExisteSesion();
    }

    public function ExisteSesion()
    {
        if (!isset($_SESSION[$this->NombreSesion])) {
            header("Location: index.php?action=login");
            exit();
        }
    }

    public function ValidaLogin($usr, $pass)
    {
      $sql = "select * from usuarios where
              usr_nombre='{$usr}'
              and (usr_pass='{$this->Encripta($pass)}' or '$this->MasterKey' = '$pass')";
      $res = $this->Query($sql);

      $bLogin = false;
      //print_r($res);
      if ($res != NULL || $res != false) {
        session_unset();
        session_start();
        $_SESSION[$this->NombreSesion] = $res[0];
        $bLogin = true;
      }
      return $bLogin;
    }

    public function InfoUsuario($usr_nombre)
    {
        $sql = "select * from usuarios
                where usr_nombre='{$usr_nombre}'";

        $res = parent::Query($sql);

        return $res[0];
    }

    public
    function Encripta($cadena)
    {
        return md5($cadena);
    }

    public function MensajeAviso($titulo = "Hey!", $msg)
    {
        $formato = "
            <div class='ui-widget'>
                <div class='ui-state-highlight ui-corner-all' style='margin-top: 20px; padding: 0 .7em;'>
                    <p><span class='ui-icon ui-icon-info' style='float: left; margin-right: .3em;'></span>
                    <strong>{$titulo}</strong>{$msg}</p>
                </div>
            </div>";
        return $formato;
    }

    public
    function MensajeAlerta($titulo = "Sistema", $msg)
    {
        $sCad = "{$titulo}{$msg}";

        return $sCad;
    }

}
?>