<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class ahorros extends AW {

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
        $sql = "SELECT a.*, CASE WHEN a.estatus = 0 THEN 'AHORRO DETENIDO' WHEN a.estatus = 1 THEN 'AHORRANDO'
    ELSE 'OTRO' END AS est,
    b.nombres, b.ape_paterno, b.ape_materno
    FROM ahorros AS a LEFT JOIN empleados AS b ON a.id_empleado = b.id
    ORDER BY a.id ASC";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }
    public function Listado_nomina() {
        $sql = "SELECT a.*, b.*, c.*, WEEK ( a.fecha ) AS semana,d.horas FROM ahorros a 
            LEFT JOIN nomina_detalle b ON a.id = b.id_nomina
            LEFT JOIN empleados c ON b.id_empleado = c.id LEFT JOIN ( SELECT horas_extras.id_empleado, horas_extras AS horas FROM horas_extras WHERE estatus = 2 ) d ON c.id = d.id_empleado 
        WHERE a.id ='{$this->id}'";
        //echo nl2br($sql);
        return $this->Query($sql);
        
    }
    public function Pagar() {
        $sql = "update
                    ahorros
                set
                estatus = '1',
                fecha_pago = ".date("Y-m-d")."
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Informacion() {

        $sql = "select * from ahorros where  id='{$this->id}'";
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
        $sql = "select id from ahorros where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar() {

        $sql = "update
                    ahorros
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
                    ahorros
                set
                estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
                 // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar() {


        $sql = "insert into ahorros
                (`id`,`fecha`,`estatus`)
                values
                ('0','{$this->fecha}','0')";
        $bResultado = $this->NonQuery($sql);
        
        $sql1 = "select id from ahorros order by id desc limit 1";
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