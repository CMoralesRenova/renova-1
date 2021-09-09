<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");

class asistencia extends AW
{

    var $id;
    var $id_empleado;
    var $fecha;
    var $hora;
    var $estatus;
    var $dia;

    //busqueda 
    var $fecha_inicial;
    var $fecha_final;

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
        $sql = "SELECT a.nombres, a.ape_paterno, a.ape_materno, count(dia) as dia, id_empleado  FROM empleados as a 
        left join asistencia as b on a.id = b.id_empleado where 1=1 and fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' group by nombres";
        return $this->Query($sql);
    }

    public function Listado_asistencia(){
        $sql = "SELECT b.nombres, b.ape_paterno, b.ape_materno, a.fecha, a.hora, 
        if(a.dia = 0, 'Lunes', if(a.dia = 1, 'Martes',if(a.dia = 2, 'Miercoles',if(a.dia = 3, 'Jueves',if(a.dia = 4, 'Viernes',if(a.dia = 5, 'Sabado',if(a.dia = 6, 'Domingo',''))))))) as dia
        FROM renova.asistencia as a 
        left join empleados as b on b.id = a.id_empleado where 1=1 and fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' and id_empleado = '{$this->id_empleado}' order by a.dia asc";
        return $this->Query($sql);

    }

    public function Informacion()
    {

        $sql = "select * from asistencia where  id='{$this->id}'";
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
                    asistencia
                set
                    estatus = '{$this->estatus}'
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql);
    }

    public function Existe()
    {
        $sql = "select id from asistencia where estatus='1' and id_empleado='{$this->id_empleado}'";
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
        $dia = $this->fecha * 1.5;
        $cantidad = ($this->monto * $dia) / 100;
        $monto_pagar = $this->monto + $cantidad;
        $dia_pagar = $monto_pagar - $this->monto;
        $monto_por_semana = $monto_pagar / $this->fecha;

        $sql = "insert into asistencia
                (`id`,`id_empleado`,`monto`,`dia`,`monto_por_semana`,`fecha`,`hora`,`monto_pagar`,`estatus`)
                values
                ('0','{$this->id_empleado}','{$this->monto}','$dia_pagar','$monto_por_semana','{$this->fecha}',now(),'$monto_pagar','1')";
        $bResultado = $this->NonQuery($sql);

        $sql1 = "select id from asistencia order by id desc limit 1";
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
