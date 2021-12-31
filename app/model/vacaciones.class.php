<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/principal.class.php");
require_once($_SITE_PATH . "vendor/autoload.php"); 

use Carbon\Carbon;

date_default_timezone_set('America/Mexico_City');

class vacaciones extends AW
{

    var $id;
    var $id_empleado;
    var $dias_correspondientes;
    var $dias_disfrutar;
    var $dias_restantes;
    var $periodo_inicio;
    var $periodo_fin;
    var $inicio_vacaci;
    var $fin_vacaci;
    var $pago_prima;
    var $dias_pagados;
    var $fecha_pago;
    var $observaciones;
    var $fecha;
    var $fecha_final;
    var $ano;

    var $pagar_dias;
    var $pagar_total;
    var $pagar_concepto;

    var $vacacionesInput;

    var $user_id;

    //busqueda 
    var $fecha1;
    var $pagar;


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
        $sqlfecha = "";
        if ($this->fecha1 != '') {
            $sqlfecha = "{$this->fecha1}";
        }

        $sql = "SELECT a.nombres, a.ape_paterno, a.ape_materno, b.* 
        from empleados as a inner join vacaciones as b on a.id = b.id_empleado WHERE
        fecha_final between '{$this->fecha_inicial}' and '{$this->fecha_final}' or
        fecha between '{$this->fecha_inicial}' and '{$this->fecha_final}' 
        ORDER BY
            b.fecha ASC";
        return $this->Query($sql);
    }

    public function Informacion()
    {

        $sql = "select * from vacaciones where  id='{$this->id}'";
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
    public function ObtenerAños($fecha_ingreso) {
        $sql = "SELECT TIMESTAMPDIFF(YEAR, '{$fecha_ingreso}', now()) AS años_transcurridos";
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

    public function ObtenerDias($anos, $id_empleado) {
        $sql = "(SELECT dias FROM anos_servicio
        where anos = '{$anos}')
        union all
        (select dias_restantes from  vacaciones
        where ano = '{$anos}' and id_empleado = '{$id_empleado}')";

        return $this->Query($sql);
    }

    public function Existe()
    {
        $sql = "select id from vacaciones where id = '{$this->id}'";
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
        $separateDate = explode(" ", $this->vacacionesInput);
        $day = $separateDate[1];
        $month = $separateDate[2];
        $year = $separateDate[3];

        $MESES = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");

        $clave = array_search($month, $MESES);
        if ($clave <= 9) {
            $clave = "0".$clave;
        }

        if ($day <= 9) {
            $day = "0".$day;
        }
        $fechaFinal = $year."-".$clave."-".$day;

        $sqlPagar = "";
        if (!empty($this->pagar)) {
            $sqlPagar = "
            pagar_dias='{$this->pagar_dias}',
            pagar_total = '{$this->pagar_total}',
            pagar_concepto = '{$this->pagar_concepto}',";
        }

        $sql = " UPDATE `vacaciones`
                 SET
                `dias_disfrutar` = '{$this->dias_disfrutar}',
                `dias_restantes` = '{$this->dias_restantes}',
                `inicio_vacaci` = '{$this->inicio_vacaci}',
                `fin_vacaci` = '{$this->fin_vacaci}',
                `reingreso` = '{$this->reingreso}',
                {$sqlPagar}
                `observaciones` = '{$this->observaciones}'
        WHERE `id` = '{$this->id}';";
        //print_r($sql);
        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            if ($this->dias_restantes) {
                $fechaActual = date('Y-m-d');
                if($fechaActual <= $fechaFinal) {
                    $sqlSiguiente = "INSERT INTO `renova`.`vacaciones`
                    (`id_empleado`, `dias_correspondientes`,`dias_restantes`,`periodo_inicio`,`periodo_fin`,
                    `pago_prima`,`dias_pagados`,`fecha_pago`,`fecha`,`fecha_final`,`ano`)
                    VALUES
                    ('{$this->id_empleado}','{$this->dias_correspondientes}','{$this->dias_restantes}','{$this->periodo_inicio}',
                    '{$this->periodo_fin}','{$this->pago_prima}','{$this->dias_pagados}','{$this->fecha_pago}',now(),'{$fechaFinal}','{$this->ano}')";

                    $bResultado = $this->NonQuery($sqlSiguiente);
                }
            }
        }
    }

    public function Agregar()
    {   
        $sqlPagar = "";
        $sqlPagarValues = "";
        if (!empty($this->pagar)) {
            $sqlPagar = ",pagar_dias, pagar_total, pagar_concepto";
            $sqlPagarValues = ",'{$this->pagar_dias}',
            '{$this->pagar_total}',
            '{$this->pagar_concepto}'";
        }
        
        $separateDate = explode(" ", $this->vacacionesInput);
        $day = $separateDate[1];
        $month = $separateDate[2];
        $year = $separateDate[3];

        $MESES = array(1 => "Enero", 2 => "Febrero", 3 => "Marzo", 4 => "Abril", 5 => "Mayo", 6 => "Junio", 7 => "Julio", 8 => "Agosto", 9 => "Septiembre", 10 => "Octubre", 11 => "Noviembre", 12 => "Diciembre");

        $clave = array_search($month, $MESES);
        if ($clave <= 9) {
            $clave = "0".$clave;
        }

        if ($day <= 9) {
            $day = "0".$day;
        }
        $fechaFinal = $year."-".$clave."-".$day;

        $sql = "INSERT INTO `renova`.`vacaciones`
        (`id_empleado`,
        `dias_correspondientes`,`dias_disfrutar`,`dias_restantes`,`periodo_inicio`,`periodo_fin`,`inicio_vacaci`,
        `fin_vacaci`,`reingreso`,`pago_prima`,`dias_pagados`,`fecha_pago`,`observaciones`,`fecha`,`fecha_final`,`ano`{$sqlPagar})
        VALUES
        ('{$this->id_empleado}','{$this->dias_correspondientes}','{$this->dias_disfrutar}','{$this->dias_restantes}','{$this->periodo_inicio}',
        '{$this->periodo_fin}','{$this->inicio_vacaci}','{$this->fin_vacaci}','{$this->reingreso}','{$this->pago_prima}','{$this->dias_pagados}','{$this->fecha_pago}',
        '{$this->observaciones}',now(),'{$fechaFinal}','{$this->ano}'{$sqlPagarValues})";

        $bResultado = $this->NonQuery($sql);

        if ($bResultado) {
            if ($this->dias_restantes) {
                $fechaActual = date('Y-m-d');
                if($fechaActual <= $fechaFinal) {
                    $sqlSiguiente = "INSERT INTO `renova`.`vacaciones`
                    (`id_empleado`, `dias_correspondientes`,`dias_restantes`,`periodo_inicio`,`periodo_fin`,
                    `pago_prima`,`dias_pagados`,`fecha_pago`,`fecha`,`fecha_final`,`ano`)
                    VALUES
                    ('{$this->id_empleado}','{$this->dias_correspondientes}','{$this->dias_restantes}','{$this->periodo_inicio}',
                    '{$this->periodo_fin}','{$this->pago_prima}','{$this->dias_pagados}','{$this->fecha_pago}',now(),'{$fechaFinal}','{$this->ano}')";

                    $bResultado = $this->NonQuery($sqlSiguiente);
                }
            }
        }
        $sql1 = "select id from vacaciones order by id desc limit 1";
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
