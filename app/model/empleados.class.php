<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class empleados extends AW
{

    var $id;
    var $nombres;
    var $ape_paterno;
    var $ape_materno;
    var $fecha_nacimiento;
    var $estatus;
    var $fecha_ingreso;
    var $id_puesto;
    var $id_jefe;
    var $usuario_edicion;
    var $fecha_modificacion;
    var $usuario_creacion;
    var $salario_diario;
    var $salario_semanal;
    var $nivel_estudios;
    var $direccion;
    var $estado_civil;
    var $rfc;
    var $curp;
    var $nss;

    var $user_id;

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
        empleados.id,
        empleados.nombres,
        empleados.ape_paterno,
        empleados.ape_materno,
        empleados.fecha_ingreso,
        puestos.nombre as puesto,
        departamentos.nombre as departamento,
    CASE
            
            WHEN empleados.estatus = 1 THEN
            'ACTIVO' 
            WHEN empleados.estatus = 0 THEN
            'BAJA' ELSE 'OTRO' 
        END AS estatus 
    FROM
        empleados 
        join puestos on empleados.id_puesto=puestos.id
        join departamentos on puestos.id_departamento=departamentos.id
    ORDER BY
        empleados.nombres ASC";
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from empleados where  id='{$this->id}'";
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

    public function jefes()
    {
        $sql = "SELECT a.id, concat(ifnull( a.nombres, ''), ' ',ifnull(a.ape_paterno, ''), ' ', ifnull(ape_materno, '')) as empleado FROM renova.empleados as a 
        join puestos as b on b.id = id_puesto
        where b.nombre like '%JEFE%'";

        return $this->Query($sql);
    }

    public function Existe()
    {
        $sql = "select id from empleados where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar()
    {
        $sqlSalario = "";
        if (! empty($this->salario_diario)) {
            $sqlSalario = " salario_diario='{$this->salario_diario}',
            salario_semanal = '".$this->salario_diario * 7 ."',";
        }

        $sql = "update
                    empleados
                set
                nombres ='{$this->nombres}',
                ape_paterno = '{$this->ape_paterno}',
                ape_materno = '{$this->ape_materno}',
                fecha_nacimiento =  '{$this->fecha_nacimiento}',
                direccion   = '{$this->direccion}',
                estado_civil = '{$this->estado_civil}',
                rfc = '{$this->rfc}',
                curp = '{$this->curp}',
                nss = '{$this->nss}',
                nivel_estudios = '{$this->nivel_estudios}',
                id_puesto = '{$this->id_puesto}',
                id_jefe = '{$this->id_jefe}',
                {$sqlSalario}
                usuario_edicion = '{$this->user_id}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Agregar()
    {

        $sql = "insert into empleados
                (id,nombres, ape_paterno,ape_materno, fecha_nacimiento, direccion, estado_civil,
                 rfc, curp, nss, nivel_estudios, id_puesto, id_jefe, salario_diario, salario_semanal, fecha_ingreso, estatus, usuario_creacion)
                values
                ('0','{$this->nombres}', '{$this->ape_paterno}', '{$this->ape_materno}','".$this->fecha_nacimiento."', '{$this->direccion}', '{$this->estado_civil}',
                 '{$this->rfc}', '{$this->curp}', '{$this->nss}', '{$this->nivel_estudios}', '{$this->id_puesto}', '{$this->id_jefe}','{$this->salario_diario}','".$this->salario_diario * 7 ."', '".date('Y-m-d')."', '1', '{$this->user_id}')";

        $bResultado = $this->NonQuery($sql);

        $sql1 = "select id from empleados order by id desc limit 1";
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
