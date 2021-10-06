<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class nominas extends AW
{

    var $id;
    var $fecha;
    var $estatus;
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
        $sql = "SELECT nominas.fecha, nominas.id,CONCAT('$',sum( nomina_detalle.total )) AS total_nomina,CASE WHEN nominas.estatus = 0 THEN 'NO PAGADA' WHEN nominas.estatus = 1 THEN
        'PAGADA' ELSE 'OTRO'END AS estatus, WEEK ( nominas.fecha ) AS semana FROM nominas LEFT JOIN nomina_detalle ON nominas.id = nomina_detalle.id_nomina 
        where fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' GROUP BY nominas.fecha, nominas.id 
        ORDER BY fecha ASC  ";
        //echo nl2br($sql);
        return $this->Query($sql);
    }
    public function Listado_nomina()
    {
        $sql = "SELECT a.*, c.id as id_empleado,nombres, c.ape_paterno, c.ape_materno, WEEK ( a.fecha ) AS semana,
        c.salario_semanal,
        c.salario_diario,
        c.salario_asistencia,
        c.salario_puntualidad,
        c.salario_productividad,
        c.complemento_sueldo,
        c.bono_doce,
        (select count(dia) + 1 from asistencia where id_empleado = c.id and estatus_entrada = 1 and fecha between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) as dias_laborados,
        ((select sum(horas_extras) from horas_extras where id_empleado = c.id and estatus = 2 and fecha_registro between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) * (c.salario_diario / 8)) as horas_extras,
        ((select count(dia) + 1 from asistencia where id_empleado = c.id and estatus_entrada = 1 and fecha between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) * c.salario_diario) as esperado,
        (select sum(monto_por_semana) from otros where id_empleado = c.id and estatus = 1 and fecha_pago between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) as otros_descuentos,
        (select sum(monto_por_semana) from prestamos where id_empleado = c.id and estatus = 1 and fecha_pago between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) as prestamos,
        ((select sum(monto_por_semana) from otros where id_empleado = c.id and estatus = 1 and fecha_pago between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) +
        (select sum(monto_por_semana) from prestamos where id_empleado = c.id and estatus = 1 and fecha_pago between date_add(a.fecha, INTERVAL -7 DAY) and a.fecha)) as retenciones
        FROM nominas a
        LEFT JOIN empleados c ON  c.id 
        LEFT JOIN horas_extras as d on c.id = d.id_empleado 
        inner JOIN ( SELECT dia, id_empleado, fecha FROM asistencia) e ON c.id = e.id_empleado
        left JOIN ( SELECT * FROM otros) f ON c.id = f.id_empleado
        left JOIN ( SELECT * FROM prestamos) g ON c.id = g.id_empleado
        WHERE a.id ='{$this->id}' group by c.nombres";
        //echo nl2br($sql);
        return $this->Query($sql);
    }
    public function Pagar()
    {
        $sql = "update
                    nominas
                set
                estatus = '1',
                fecha_pago = " . date("Y-m-d") . "
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Informacion()
    {

        $sql = "select * from nominas where  id='{$this->id}'";
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

    public function Existe()
    {
        $sql = "select id from nominas where id='{$this->id}'";
        $res = $this->Query($sql);

        $bExiste = false;

        if (count($res) > 0) {
            $bExiste = true;
        }
        return $bExiste;
    }

    public function Actualizar()
    {

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

    public function Desactivar()
    {

        $sql = "update
                    nominas
                set
                estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        // echo nl2br($sql);
        return $this->NonQuery($sql);
    }

    public function Agregar()
    {


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
