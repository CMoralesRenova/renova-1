<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class horarios extends AW {

    var $id;
    var $nombre;
    var $estatus;
    var $user_id;
    //marcar dias 
    var $A;
    var $B;
    var $C;
    var $D;
    var $E;
    var $F;
    var $G;
    //entradas
    var $entrada_1;
    var $entrada_2;
    var $entrada_3;
    var $entrada_4; 
    var $entrada_5; 
    var $entrada_6; 
    var $entrada_7;
    //entradas
    var $salida_1;
    var $salida_2; 
    var $salida_3; 
    var $salida_4; 
    var $salida_5;
    var $salida_6;
    var $salida_7; 



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
        $sql = "SELECT * FROM horarios  ";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from horarios where  id='{$this->id}'";
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
        $sql = "select id from horarios where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "UPDATE `renova`.`horarios`
        SET 
        `nombre` = '{$this->nombre}',
        `A` = '{$this->A}',
        `B` = '{$this->B}',
        `C` = '{$this->C}',
        `D` = '{$this->D}',
        `E` = '{$this->E}',
        `F` = '{$this->F}',
        `G` = '{$this->G}',
        `entrada_1` = '{$this->entrada_1}',
        `salida_1` = '{$this->salida_1}',
        `entrada_2` = '{$this->entrada_2}',
        `salida_2` = '{$this->salida_2}',
        `entrada_3` = '{$this->entrada_3}',
        `salida_3` = '{$this->salida_3}',
        `entrada_4` = '{$this->entrada_4}',
        `salida_4` = '{$this->salida_4}',
        `entrada_5` = '{$this->entrada_5}',
        `salida_5` = '{$this->salida_5}',
        `entrada_6` = '{$this->entrada_6}',
        `salida_6` = '{$this->salida_6}',
        `entrada_7` = '{$this->entrada_7}',
        `salida_7` = '{$this->salida_7}',
        `estatus` = '{$this->estatus}'
        WHERE `id` = '{$this->id}';";
        return $this->NonQuery($sql);
    }

    public function Desactivar() {

        $sql = "UPDATE `renova`.`horarios`
        SET
        `estatus` = '{$this->estatus}'
        WHERE `id` = '{$this->id}';
        ";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {


        $sql = "INSERT INTO `renova`.`horarios`
        (`id`,`nombre`,
        `A`,`B`,`C`,`D`,`E`,`F`,`G`,
        `entrada_1`,`salida_1`,`entrada_2`,`salida_2`,`entrada_3`,`salida_3`,`entrada_4`,`salida_4`,`entrada_5`,`salida_5`,`entrada_6`,`salida_6`,`entrada_7`,`salida_7`,`estatus`)        
        VALUES        ('{$this->id}','{$this->nombre}',
        '{$this->A}','{$this->B}','{$this->C}','{$this->D}','{$this->E}','{$this->F}','{$this->G}',
        '{$this->entrada_1}','{$this->salida_1}'>,
        '{$this->entrada_2}','{$this->salida_2}',
        '{$this->entrada_3}' ,'{$this->salida_3}',
        '{$this->entrada_4}' ,'{$this->salida_4}',
        '{$this->entrada_5}' ,'{$this->salida_5}',
        '{$this->entrada_6}' ,'{$this->salida_6}',
        '{$this->entrada_7}' ,'{$this->salida_7}',
        '1')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id from horarios order by id desc limit 1";
        $res = $this->Query($sql1);
        
        $this->id = $res[0]->id;

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