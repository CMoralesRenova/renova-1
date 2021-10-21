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
    var $id_empleado;


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

        return $this->Query($sql);
    }
    public function Listado_nomina()
    {
        $sqlEmpleado = "";
        if (!empty($this->id_empleado)) {
            $sqlEmpleado = " and c.id='{$this->id_empleado}'";
        }

        $sql = "SELECT a.*, c.id as id_empleado,nombres, c.ape_paterno, c.ape_materno,h.nombre as puesto,
        i.nombre as departamento,
        c.rfc,c.curp,c.fecha_ingreso,
        WEEK ( a.fecha ) AS semana,
        c.salario_semanal,c.salario_diario,c.salario_asistencia,
        c.salario_puntualidad,c.salario_productividad,c.complemento_sueldo,c.bono_doce,
        (select count(dia) + 1 from asistencia where id_empleado = c.id and estatus_entrada = 1 and fecha between date_add(a.fecha,
        INTERVAL -7 DAY) and a.fecha) as dias_laborados,
        ((select sum(horas_extras) from horas_extras where id_empleado = c.id and estatus = 2 and fecha_registro between
        date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) * (c.salario_diario / 8)) as horas_extras,
        ((select count(dia) + 1 from asistencia where id_empleado = c.id and estatus_entrada = 1 and fecha between date_add(a.fecha,
        INTERVAL -7 DAY) and a.fecha) * c.salario_diario) as esperado,
        (select sum(monto_por_semana) from otros where id_empleado = c.id and fecha_pago between date_add(a.fecha,
        INTERVAL -7 DAY) and a.fecha) as otros_descuentos,
        (select monto_por_semana from prestamos where id_empleado = c.id and fecha_pago between
        date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) as prestamos,
        j.monto, j.frecuencia, j.estatus as estatusAhorro,
        f.id as id_otros, g.id as id_prestamo, j.id as id_ahorros,
        ((SELECT 
            SUM(precio_platillo)
        FROM
            comedor
        WHERE
            id_empleado = c.id AND fecha BETWEEN DATE_ADD(a.fecha, INTERVAL - 7 DAY) AND a.fecha) ) AS comedor
        FROM nominas a
        LEFT JOIN empleados c ON c.id
        LEFT JOIN horas_extras as d on c.id = d.id_empleado
        inner JOIN ( SELECT dia, id_empleado, fecha FROM asistencia) e ON c.id = e.id_empleado
        left JOIN ( SELECT * FROM otros) f ON c.id = f.id_empleado
        left JOIN ( SELECT * FROM prestamos) g ON c.id = g.id_empleado
        left join (select * from puestos) h ON c.id_puesto = h.id
        left join (select * from departamentos) i on h.id_departamento = i.id
        left join (select * from ahorros) j on c.id = j.id_empleado 
        WHERE a.id ='{$this->id}' {$sqlEmpleado} group by c.nombres";

        if (!empty($this->id_empleado)) {
            $res = parent::Query($sql);
            if (!empty($res) && !($res === NULL)) {
                foreach ($res[0] as $idx => $valor) {
                    $this->{$idx} = $valor;
                }
            } else {
                $res = NULL;
            }

            return $res;
        } else {
            return $this->Query($sql);
        }
    }
    public function Pagar()
    {
        $sql = "SELECT a.*, c.id as id_empleado,nombres, c.ape_paterno, c.ape_materno,h.nombre as puesto,
        i.nombre as departamento,
        c.rfc,c.curp,c.fecha_ingreso,
        WEEK ( a.fecha ) AS semana,
        c.salario_semanal,c.salario_diario,c.salario_asistencia,
        c.salario_puntualidad,c.salario_productividad,c.complemento_sueldo,c.bono_doce,
        (select count(dia) + 1 from asistencia where id_empleado = c.id and estatus_entrada = 1 and fecha between date_add(a.fecha,
        INTERVAL -7 DAY) and a.fecha) as dias_laborados,
        ((select sum(horas_extras) from horas_extras where id_empleado = c.id and estatus = 2 and fecha_registro between
        date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) * (c.salario_diario / 8)) as horas_extras,
        ((select count(dia) + 1 from asistencia where id_empleado = c.id and estatus_entrada = 1 and fecha between date_add(a.fecha,
        INTERVAL -7 DAY) and a.fecha) * c.salario_diario) as esperado,
        (select sum(monto_por_semana) from otros where id_empleado = c.id and fecha_pago between date_add(a.fecha,
        INTERVAL -7 DAY) and a.fecha) as otros_descuentos,
        (select monto_por_semana from prestamos where id_empleado = c.id and fecha_pago between
        date_add(a.fecha, INTERVAL -7 DAY) and a.fecha) as prestamos,
        j.monto, j.frecuencia, j.estatus as estatusAhorro,
        f.id as id_otros, g.id as id_prestamo, j.id as id_ahorros,
        ((SELECT 
            SUM(precio_platillo)
        FROM
            comedor
        WHERE
            id_empleado = c.id AND fecha BETWEEN DATE_ADD(a.fecha, INTERVAL - 7 DAY) AND a.fecha) ) AS comedor
        FROM nominas a
        LEFT JOIN empleados c ON c.id
        LEFT JOIN horas_extras as d on c.id = d.id_empleado
        inner JOIN ( SELECT dia, id_empleado, fecha FROM asistencia) e ON c.id = e.id_empleado
        left JOIN ( SELECT * FROM otros) f ON c.id = f.id_empleado
        left JOIN ( SELECT * FROM prestamos) g ON c.id = g.id_empleado
        left join (select * from puestos) h ON c.id_puesto = h.id
        left join (select * from departamentos) i on h.id_departamento = i.id
        left join (select * from ahorros) j on c.id = j.id_empleado 
        WHERE a.id ='{$this->id}' group by c.nombres";

        $res = parent::Query($sql);
        if (!empty($res) && !($res === NULL)) {
            foreach ($res as $idx => $valor) {
                $percepciones = 0;
                $retenciones = 0;
                if ($valor->dias_laborados <= 6) {
                    $percepciones = $percepciones + $valor->salario_diario * $valor->dias_laborados;
                    $percepciones = $percepciones + $valor->salario_productividad;
                    $percepciones = $percepciones + $valor->complemento_sueldo;
                    $percepciones = $percepciones + $valor->bono_doce;
                    $percepciones = $percepciones + $valor->horas_extras;
                } else {
                    $percepciones = $percepciones + $valor->salario_diario * $valor->dias_laborados;
                    $percepciones = $percepciones + $valor->salario_productividad;
                    $percepciones = $percepciones + $valor->complemento_sueldo;
                    $percepciones = $percepciones + $valor->bono_doce;
                    $percepciones = $percepciones + $valor->horas_extras;
                    $percepciones = $percepciones + $valor->salario_asistencia;
                    $percepciones = $percepciones + $valor->salario_puntualidad;
                }
                $retenciones = $retenciones + $valor->otros_descuentos;
                $retenciones = $retenciones + $valor->prestamos;
                $retenciones = $retenciones + $valor->comedor;
                if ($valor->estatusAhorro == 1){
                    $retenciones = $retenciones + $valor->monto;
                }

                $sqlOtros = "select * from otros where id_empleado='{$valor->id_empleado}' and fecha_pago between date_add('{$valor->fecha}', INTERVAL -7 DAY) and '{$valor->fecha}'";
                $resOtros = $this->Query($sqlOtros);

                if (!empty($resOtros) && !($resOtros === NULL)) {
                    foreach ($resOtros as $idx => $otros) {
                        if ($otros->numero_semanas == ($otros->semana_actual + 1) && $otros->estatus == 1) {
                            $sqlUpdateOtros1 = "UPDATE `otros`
                                        SET
                                        `estatus` = 0,
                                        `semana_actual` = ($otros->semana_actual + 1),
                                        `restante` = '" . ($otros->restante - $otros->monto_por_semana) . "' 
                                        WHERE `id` = '{$otros->id}'";
                            $this->NonQuery($sqlUpdateOtros1);
                        } else {
                            $sqlUpdateOtros = "UPDATE `otros`
                            SET
                            `estatus` = '0',
                            `restante` = '" . ($otros->restante - $otros->monto_por_semana) . "' 
                            WHERE `id` = '{$otros->id}'";

                            if ($this->NonQuery($sqlUpdateOtros)) {
                                $sqlInsertOtros = "INSERT INTO `otros`
                                (`id_empleado`,`numero_semanas`,`semana_actual`,`estatus`,`fecha_registro`,`fecha_pago`,
                                `monto`,`monto_por_semana`,`monto_pagar`,`motivo`,`detalles`,`restante`)
                                VALUES
                                ('{$otros->id_empleado}','{$otros->numero_semanas}',
                                '" . ($otros->semana_actual + 1). "',
                                '1','{$otros->fecha_registro}',
                                date_add('{$otros->fecha_pago}', INTERVAL +7 DAY),
                                '{$otros->monto}','{$otros->monto_por_semana}','{$otros->monto_pagar}','{$otros->motivo}','{$otros->detalles}'
                                ,'" . ($otros->restante - $otros->monto_por_semana) . "')";
                                $this->NonQuery($sqlInsertOtros);
                            }
                        }
                    }
                }

                $sqlPrestamos = "select * from prestamos where id_empleado='{$valor->id_empleado}' and fecha_pago between date_add('{$valor->fecha}', INTERVAL -7 DAY) and '{$valor->fecha}'";
                $resPrestamos = $this->Query($sqlPrestamos);

                if (!empty($resPrestamos) && !($resPrestamos === NULL)) {
                    foreach ($resPrestamos as $idx => $prestamos) {
                        if ($prestamos->numero_semanas == ($prestamos->semana_actual + 1) && $prestamos->estatus == 1) {
                            $sqlUpdatePrestamos1 = "UPDATE `prestamos`
                                SET
                                `estatus` = 0,
                                `semana_actual` = ($prestamos->semana_actual + 1),
                                `restante` = '" . ($prestamos->restante - $prestamos->monto_por_semana) . "' 
                                WHERE `id` = '{$prestamos->id}'";
                                $this->NonQuery($sqlUpdatePrestamos1);
                        } else {
                            $sqlUpdatePrestamos = "UPDATE `prestamos`
                            SET 
                            `estatus` = 0,
                            `restante` = '".($prestamos->restante - $prestamos->monto_por_semana)."'
                            WHERE `id` = '{$prestamos->id}'";

                            if ($this->NonQuery($sqlUpdatePrestamos)) {
                                $sqlInsertOtros = "INSERT INTO `prestamos`
                                (`id_empleado`,`numero_semanas`, `estatus`,`fecha_registro`, `fecha_pago`, `monto`,`interes`, `monto_por_semana`,
                                `monto_pagar`, `restante`, `semana_actual`)
                                VALUES
                                ('{$prestamos->id_empleado}','{$prestamos->numero_semanas}','1','{$prestamos->fecha_registro}',
                                date_add('{$prestamos->fecha_pago}', INTERVAL +7 DAY),
                                 '{$prestamos->monto}','{$prestamos->interes}',
                                '{$prestamos->monto_por_semana}','{$prestamos->monto_pagar}',
                                '".($prestamos->restante - $prestamos->monto_por_semana)."', 
                                '". ($prestamos->semana_actual + 1) ."')";
                                $this->NonQuery($sqlInsertOtros);
                            }
                        }
                    }
                } 

                $sqlAhorros = "select * from ahorros where id_empleado='{$valor->id_empleado}' and estatus = '1'";
                $resAhorros = $this->Query($sqlAhorros);

                if (!empty($resAhorros) && !($resAhorros === NULL)) {
                    foreach ($resAhorros as $idx => $ahorros) {
                        if ($ahorros->estatus == 1) {
                            $sqlUpdateahorros = "UPDATE `ahorros`
                            SET
                            `frecuencia` = frecuencia + 1,
                            `acumulado` = `acumulado` + `monto` 
                            WHERE `id` = '{$ahorros->id}'";
                            $this->NonQuery($sqlUpdateahorros);
                        }
                    }
                }

                $sql1 = "INSERT INTO `nomina_detalle`
                (`id_nomina`,`id_empleado`,`percepciones`,`retenciones`, `total`)
                VALUES
                ('{$valor->id}','{$valor->id_empleado}','" . ($percepciones - $retenciones) . "','{$retenciones}','{$percepciones}')";
                $this->NonQuery($sql1);
            }
        } else {
            $res = NULL;
        }

        $sql2 = "update
                    nominas
                set
                estatus = '1',
                fecha_pago = now()
                where
                  id='{$this->id}'";
        return $this->NonQuery($sql2);
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
