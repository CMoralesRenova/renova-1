<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class horas extends AW {

    var $id;
    var $id_empleado;
    var $fecha_registro;
    var $horas_extras;
    var $id_usuario_creador;
    var $id_usuario_autorizador;
    var $estatus;
    var $motivo;
    var $user_id;
    //marcar dias 

    //busqueda 
    var $fecha_inicial;
    var $fecha_final;
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
        $sql = "SELECT a.*, CASE WHEN a.estatus = 0 THEN
            'NO AUTORIZADO' 
            WHEN a.estatus = 1 THEN
            'EN ESPERA DE AUTORIZACION' 
            WHEN a.estatus = 2 THEN
            'AUTORIZADA' 
            WHEN a.estatus = 3 THEN
            'PAGADA' ELSE 'OTRO' 
        END AS est,
        CONCAT(IFNULL(b.nombres, ''), ' ',IFNULL(b.ape_paterno, ''), ' ',IFNULL(b.ape_materno,'') ) AS empleado 
    FROM
        horas_extras AS a
        LEFT JOIN empleados AS b ON a.id_empleado = b.id
        where fecha_registro between '{$this->fecha_inicial}' and '{$this->fecha_final}' ORDER BY a.id ASC";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }

    public function Informacion() {

        $sql = "select * from horas_extras where  id='{$this->id}'";
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
        $sql = "select id from horas_extras where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {
        $sql = "UPDATE `horas_extras`
        SET 
        `estatus` = '{$this->estatus}',
        `id_usuario_autorizador` = '{$this->id_usuario_autorizador}'
        WHERE `id` = '{$this->id}';";
        return $this->NonQuery($sql);
    }

    public function Autorizar() {

        $sql = "UPDATE `horas_extras`
        SET
        `estatus` = '{$this->estatus}',
        `id_usuario_autorizador` = '{$this->id_usuario_autorizador}'
        WHERE `id` = '{$this->id}';
        ";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {
        $sql = "INSERT INTO `horas_extras`
        (`id`, `id_empleado`,`fecha_registro`,`horas_extras`,`id_usuario_creador`, `estatus`,`motivo`)
        VALUES
        ('{$this->id}','{$this->id_empleado}','{$this->fecha_registro}','{$this->horas_extras}','{$this->user_id}','1','{$this->motivo}');
        ";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id from horas_extras order by id desc limit 1";
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