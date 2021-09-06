<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class otros extends AW
{

    var $id;
    var $id_empleado;
    var $numero_semanas;
    var $monto;
    var $fecha_registro;
    var $estatus;
    var $monto_por_semana;
    var $monto_pagar;



    public function __construct($sesion = true, $datos = NULL)
    {
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

    public function Listado()
    {
        $sql = "SELECT
        a.*, CASE
    WHEN a.estatus = 0 THEN
        'LIQUIDADO'
    WHEN a.estatus = 1 THEN
        'PAGANDO'
    ELSE
        'OTRO'
    END AS est,
     b.nombres, b.ape_paterno, b.ape_materno
    FROM
        otros AS a
    LEFT JOIN empleados AS b ON a.id_empleado = b.id
    ORDER BY
        a.id ASC";
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from otros where  id='{$this->id}'";
        $res = parent::Query($sql);

        if (!empty($res) && !($res === NULL)) {
            foreach ($res[0] as $idx => $valor) {
                $this->{$idx} = $valor;
            }
        } else {
            $res = NULL;
        }

        return $res;
    }

    public function Liquidar()
    {

        $sql = "update
                    otros
                set
                    estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Existe()
    {
        $sql = "select id from otros where estatus='1' and id_empleado='{$this->id_empleado}'";
        //print_r($sql);
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar()
    {
        return true;
    }

    public function Agregar()
    {
        $interes = $this->numero_semanas * 1.5;
        $cantidad = ($this->monto * $interes) / 100;
        $monto_pagar = $this->monto + $cantidad;
        $interes_pagar = $monto_pagar - $this->monto;
        $monto_por_semana = $monto_pagar / $this->numero_semanas;

        $sql = "insert into otros
                (`id`,`id_empleado`,`monto`,`interes`,`monto_por_semana`,`numero_semanas`,`fecha_registro`,`monto_pagar`,`estatus`)
                values
                ('0','{$this->id_empleado}','{$this->monto}','$interes_pagar','$monto_por_semana','{$this->numero_semanas}',now(),'$monto_pagar','1')";
        $bResultado = $this->NonQuery($sql);

        $sql1 = "select id from otros order by id desc limit 1";
        $res = $this->Query($sql1);

        $this->id = $res[0]->id;

        return $bResultado;
    }

    public function Guardar()
    {
        $bRes = false;
        if ($this->Existe() === true) {
            $bRes = $this->Actualizar();
        } else {
            $bRes = $this->Agregar();
        }

        return $bRes;
    }
}
