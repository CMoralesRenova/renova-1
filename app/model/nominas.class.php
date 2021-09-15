<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class nominas extends AW {

    var $id;
    var $fecha;
    var $estatus;
    var $user_id;


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
        $sql = "SELECT nominas.fecha, nominas.id,CONCAT('$',sum( nomina_detalle.total )) AS total_nomina,CASE WHEN nominas.estatus = 0 THEN 'NO PAGADA' WHEN nominas.estatus = 1 THEN
        'PAGADA' ELSE 'OTRO'END AS estatus, WEEK ( nominas.fecha ) AS semana FROM nominas LEFT JOIN nomina_detalle ON nominas.id = nomina_detalle.id_nomina 
        where fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' GROUP BY nominas.fecha, nominas.id 
        ORDER BY fecha ASC  ";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }
    public function Listado_nomina() {
        $sql = "SELECT a.*, b.*, c.*, WEEK ( a.fecha ) AS semana,d.horas FROM nominas a 
            LEFT JOIN nomina_detalle b ON a.id = b.id_nomina
            LEFT JOIN empleados c ON b.id_empleado = c.id LEFT JOIN ( SELECT horas_extras.id_empleado, horas_extras AS horas FROM horas_extras WHERE estatus = 2 ) d ON c.id = d.id_empleado 
        WHERE a.id ='{$this->id}'";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }
    public function Pagar() {
        $sql = "update
                    nominas
                set
                estatus = '1',
                fecha_pago = ".date("Y-m-d")."
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Informacion() {

        $sql = "select * from nominas where  id='{$this->id}'";
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
        $sql = "select id from nominas where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    nominas
                set
                nombre = '{$this->nombre}',
                placa = '{$this->placa}',
                ano = '{$this->ano}',
                marca='{$this->marca}',
                usuario_edicion = '{$this->user_id}',
                fecha_modificacion = now()
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Desactivar() {

        $sql = "update
                    nominas
                set
                estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {


        $sql = "insert into nominas
                (`id`,`fecha`,`estatus`)
                values
                ('0','{$this->fecha}','0')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id from nominas order by id desc limit 1";
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