<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class usuarios extends AW {

    var $usr_id;
    var $usr_pass;
    var $usr_nombre;

    var $age_nom_empresa;

    public function __construct($sesion = true, $datos = NULL) {
        parent::__construct($sesion);

        if (!($datos == NULL)) {
            if (count($datos) > 0) {
                foreach ($datos as $idx => $valor) {
                    if (gettype($valor) === "array") {
                        $this->{$idx} = $valor;
                    } else {
                        $this->{$idx} = addslashes($valor);
                    }
                }
            }
        }
    }

    public function Listado() {
        $sql = "SELECT * FROM usuarios  ";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from usuarios where  usr_id='{$this->usr_id}'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res [0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Existe() {
        $sql = "select usr_id from usuarios where usr_id='{$this->usr_id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {
        $sqlPass = "";
        if (!empty($this->usr_pass)) {
            $sqlPass = ", usr_pass='{$this->Encripta($this->usr_pass)}'";
        }

        $sql = "update
                    usuarios
                set
                  usr_nombre='{$this->usr_nombre}'
                  {$sqlPass}
                where
                  usr_id='{$this->usr_id}'";
        return $this->NonQuery($sql);
    }

    public function Agregar() {

        $sql = "insert into usuarios
                (usr_id,usr_pass, usr_nombre)
                values
                ('0','{$this->Encripta($this->usr_pass)}', '{$this->usr_nombre}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select usr_id from usuarios order by usr_id desc limit 1";
        $res = $this->Query($sql1);

        $this->usr_id = $res[0]->usr_id;

        return $bResultado;
    }

    public function Guardar() {

        $bRes = false;
        if ($this->Existe() === true) {
            $bRes = $this->Actualizar();
        } else {
            $bRes = $this->Agregar();
        }

        return $bRes;
    }
}