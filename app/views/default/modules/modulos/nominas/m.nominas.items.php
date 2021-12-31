<?php
session_start();
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/nominas.class.php");
require_once($_SITE_PATH . "app/model/empleados.class.php");
require_once($_SITE_PATH . "app/model/puestos.class.php");
require_once($_SITE_PATH . "app/model/departamentos.class.php");
require_once($_SITE_PATH . "app/model/otros.class.php");
require_once($_SITE_PATH . "app/model/prestamos.class.php");


$oNominas = new nominas();
$oNominas->id = empty($_GET['id']) ? "" : $_GET['id'];
$oNominas->id_empleado = empty($_GET['id_empleado']) ? "" : $_GET['id_empleado'];
$lstnominas = $oNominas->Listado_prenomina();

$oEmpleados = new empleados();
$oEmpleados->id = $oNominas->id_empleado;
$oEmpleados->Informacion();

$oPuestos = new puestos();
$oPuestos->id = $oEmpleados->id_puesto;
$oPuestos->Informacion();

$oDepartamentos = new departamentos();
$oDepartamentos->id = $oPuestos->id_departamento;
$oDepartamentos->Informacion();

$oNominas_edit = new nominas();
$oNominas_edit->id_nomina = $oNominas->id_nomina;
$oNominas_edit->id_empleado = $oNominas->id_empleado;
$oNominas_edit->Nomina_edit();

$oPrestamos = new prestamos(true, $_POST);
$oPrestamos->id_empleado = empty($_GET['id_empleado']) ? "" : $_GET['id_empleado'];
$oPrestamos->fecha = $oNominas->fecha; 
$oPrestamos->PrestamoActivo();

$oOtros = new otros(true, $_POST);
$oOtros->id_empleado = empty($_GET['id_empleado']) ? "" : $_GET['id_empleado'];
$oOtros->fecha_pago = $oNominas->fecha;
$LstOtros = $oOtros->Listado();

    if ($oNominas_edit->nombre != '' && $oNominas_edit->estatus_final_edit == "2") {

        $id_nomina = $oNominas_edit->id_nomina;
        $id_empleado = $oNominas_edit->id_empleado;
        $nombre = $oNominas_edit->nombre;
        $asistencia = $oNominas_edit->asistencia;
        $puntualidad = $oNominas_edit->puntualidad;
        $productividad = $oNominas_edit->productividad;
        $doce = $oNominas_edit->doce;
        $complemento = $oNominas_edit->complemento;
        $diario = $oNominas_edit->diario;
        $faltas = $oNominas_edit->faltas;
        $asistencias = $oNominas_edit->asistencias;
        $extras = $oNominas_edit->extras;
        $vacaciones = $oNominas_edit->vacaciones;
        $total = $oNominas_edit->total;
        $comedor = $oNominas_edit->comedor;
        $ahorro = $oNominas_edit->ahorro;
        $prestamos = $oNominas_edit->prestamos;
        $fonacot = $oNominas_edit->fonacot;
        $infonavit = $oNominas_edit->infonavit;
        $otros = $oNominas_edit->otros;
        $total_r = $oNominas_edit->total_r;
        $total_p = $oNominas_edit->total_p;
        $fecha = $oNominas_edit->fecha;
    } else {
        $id_nomina = $oNominas->id_nomina;
        $id_empleado = $oNominas->id_empleado;
        $nombre = $oNominas->nombre;
        $asistencia = $oNominas->asistencia;
        $puntualidad = $oNominas->puntualidad;
        $productividad = $oNominas->productividad;
        $doce = $oNominas->doce;
        $complemento = $oNominas->complemento;
        $diario = $oNominas->diario;
        $faltas = $oNominas->faltas;
        $asistencias = $oNominas->asistencias;
        $extras = $oNominas->extras;
        $vacaciones = $oNominas->vacaciones;
        $total = $oNominas->total;
        $comedor = $oNominas->comedor;
        $ahorro = $oNominas->ahorro;
        $prestamos = $oNominas->prestamos;
        $fonacot = $oNominas->fonacot;
        $infonavit = $oNominas->infonavit;
        $otros = $oNominas->otros;
        $total_r = $oNominas->total_r;
        $total_p = $oNominas->total_p;
        $fecha = $oNominas->fecha;
    }

$totalaPagar = $total_p;
$totalaRetencion = $total_r;
?>
<style>
    #encabezado .fila #col_1 {
        width: 50.3%;

    }

    #encabezado .fila #col_2 {
        width: 50.3%;
    }

    #encabezado .fila #col_0 {
        width: 30%;
    }

    #encabezadosup {
        padding: 5px 0;
        margin-top: -30px;
        margin-left: -30px;
        border-top: 0px solid;
        border-bottom: 0px solid;
        border: 0px solid;
        width: 100%;
    }

    #encabezado {
        padding: 5px 0;
        margin-left: -30px;
        border-top: 0px solid;
        border-bottom: 0px solid;
        border: 0px solid;
        width: 100%;
    }

    #encabezado1 {
        padding: 5px 0;
        margin-left: -30px;
        border-top: 0px solid;
        border-bottom: 0px solid;
        border: 0px solid;
        width: 100%;
    }


    #encabezado .fila #ref1 {
        width: 52%;
    }

    #encabezado .fila #ref2 {
        width: 50%;
    }

    #encabezadosup .filasup #col_1 {
        width: 55%;
    }

    #encabezadosup .filasup #col_2 {
        width: 113%;
    }

    #encabezado .fila #col_2 {
        width: 113%;
        height: 10px;
    }

    #encabezadosup .filasup #col_3 {
        width: 10%;
        height: 6%
    }
</style>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="10mm" style="border: #00 1px solid;">
    <table style="margin-top: -10px;">
        <tr>
            <td>
                <label style="margin-left:150px; font-size:18px;">RENOVA CHATARRAS INDUSTRIALES S.A. DE C.V</label>
            </td>
        </tr>
        <br />
    </table>
    <table border="1" style="margin-left:10px; position:relative;">
        <thead>
            <tr>
                <h1>Recibo de nómina</h1>
            </tr>
        </thead>
    </table>
    <table style="margin-left:270px; position:relative; margin-top: -4px;">
        <thead>
            <tr>
                <td>RFC: RC112222255522</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>IMSS: A407855596</td>
            </tr>
        </tbody>
    </table>
    <table border="1" style="margin-left:460px; position:relative; margin-top: -30px; border-collapse: collapse; width: 310px;">
        <thead>
            <tr>
                <th style="color: #f3eded; background-color: #000;width:135px;">Frecuancia de pago</th>
                <th style="color: #f3eded; background-color: #000;width:135px;">Fecha</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>SEMANAL</td>
                <td><?= $fecha ?></td>
            </tr>
        </tbody>
    </table>
    <table style="margin-left:0px; position:relative; margin-top: 10px; border: #00 1px solid;">
        <tr>
            <th style="color: #f3eded; background-color: #000;width:450px;  text-align:center;" COLSPAN=2>Empleado</th>
        </tr>
        <tr>
            <td><Label>Nombre:</Label></td>
            <td><?= $nombre ?></td>
        </tr>
        <tr>
            <td><Label>Puesto:</Label></td>
            <td><?= $oPuestos->nombre ?></td>
        </tr>
        <tr>
            <td><Label>Departamento:</Label></td>
            <td><?= $oDepartamentos->nombre ?></td>
        </tr>
        <tr>
            <td><Label>RFC:</Label></td>
            <td><?= $oEmpleados->rfc ?></td>
        </tr>
        <tr>
            <td><Label>CURP:</Label></td>
            <td><?= $oEmpleados->curp ?></td>
        </tr>
    </table>
    <table style="margin-left:458px; position:relative; margin-top: -112px; border: #00 1px solid;">
        <tr>
            <th style="color: #f3eded; background-color: #000;width:275px; text-align:center;" COLSPAN=2>Seguridad Social</th>
        </tr>
        <tr>
            <td><Label>Registro:</Label></td>
            <td></td>
        </tr>
        <tr>
            <td><Label>Tipo de salario:</Label></td>
            <td>Fijo</td>
        </tr>
        <tr>
            <td><Label>Salario integrado:</Label></td>
            <td ><?= $oEmpleados->salario_diario ?> diario</td>
        </tr>
        <tr>
            <td><Label>Jornada:</Label></td>
            <td>8:00 horas</td>
        </tr>
        <tr>
            <td><Label>Fecha de ingreso:</Label></td>
            <td><?= $oNominas->fecha_ingreso ?></td>
        </tr>
    </table>
    <table style="margin-left:0px; position:relative; margin-top: 5px; border: #00 1px solid;">
        <tr>
            <th style="color: #f3eded; background-color: #000;width:175px; text-align:center;">Percepción</th>
            <th style="color: #f3eded; background-color: #000;width:85px; text-align:center;">Monto</th>
            <th style="color: #f3eded; background-color: #000;width:60px; height:14px; text-align:center;">Unidades</th>
            <th></th>
            <th style="margin-left:10px;color: #f3eded; background-color: #000;width:134px; text-align:center;">Concepto</th>
            <th style="color: #f3eded; background-color: #000;width:80px;  text-align:center;">Monto</th>
            <th style="color: #f3eded; background-color: #000;width:80px;  text-align:center;">Retención</th>
            <th style="color: #f3eded; background-color: #000;width:100px; text-align:center;">Saldo</th>
        </tr>
        <?php
            
        ?>
        <tr>
            <td><Label>Sueldo normal</Label></td>
            <td style="text-align:right"><?= $asistencias * $diario ?></td>
            <td style="text-align:right"><?= $asistencias ?> dias</td>
            <td>&nbsp;</td>
            <?php if ($prestamos != "0.00") { ?>
                <td>Prestamo</td>
                <td style="text-align:right"><?= $oPrestamos->monto_pagar ?> </td>
                <td style="text-align:right"><?= $oPrestamos->monto_por_semana ?></td>
                <td style="text-align:right"><?= $oPrestamos->restante ?></td>
            <?php } else { ?>
                <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
            <?php if ($asistencias == 7) {  ?>
                <td><Label>Premio de Asistencia</Label></td>
                <td style="text-align:right"><?= $asistencia ?></td>
            <?php } else { ?>
                <td><Label>&nbsp;</Label></td>
                <td>&nbsp;</td>
            <?php } ?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php if ($comedor > 0) { ?>
                <td>Servicio de comedor</td>
                <td>&nbsp;</td>
                <td style="text-align:right"><?php echo $comedor; ?></td>
            <?php } else { ?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
            <?php if ($puntualidad > 0) {?>
                <td><Label>Premio de Puntualidad </Label></td>
                <td style="text-align:right"><?= $puntualidad ?> </td>
            <?php } else { ?>
                <td><Label>&nbsp;</Label></td>
                <td>&nbsp;</td>
            <?php } ?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php if ($otros > 0) { ?>
                <?php
                $totalDescuentos = 0;
                $totalSemana = 0;
                $totalRestante = 0;
                if (count($LstOtros) > 0) {

                    foreach ($LstOtros as $idx => $campo) {
                        $totalDescuentos = $totalDescuentos + $campo->monto_pagar;
                        $totalSemana = $totalSemana + $campo->monto_por_semana;
                        $totalRestante = $totalRestante + $campo->restante;
                    }
                    $totalaRetencion = $totalaRetencion + $totalSemana;
                    echo "<td>Otros Cargos</td>";
                    echo "<td style='text-align:right'>$totalDescuentos</td>";
                    echo "<td style='text-align:right'>$totalSemana</td>";
                    echo "<td style='text-align:right'>$totalRestante</td>";
                } ?>
            <?php } ?>
        </tr>
        <tr>
            <?php if ($productividad > 0) { ?>
                <td><Label>Bono de productividad</Label></td>
                <td style="text-align:right"><?= bcdiv($productividad, '1', 2); ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
                <?php if ($ahorro > 0) { ?>
                    <td><Label>Caja de ahorro</Label></td>
                    <td></td>
                    <?php  echo "<td style='text-align:right'>$oNominas->monto</td>"; ?>
                    <td style="text-align:right"></td>
                <?php } else { ?>
                    <td><Label>&nbsp;</Label></td>
                    <td>&nbsp;</td>
                <?php } ?>
        </tr>
        <tr>
        <?php if ($extras > 0) { ?>
                <td><Label>Horas extras</Label></td>
                <td style="text-align:right"><?=  bcdiv($extras, '1', 2); ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
        <?php if ($fonacot > 0) { ?>
            <td><Label>Fonacot</Label></td>
            <td style="text-align:right"></td>
            <td style="text-align:right"><?= $fonacot ?></td>
            <td style="text-align:right"></td>
        <?php } else { ?>
            <td></td>
            <td style="text-align:right"> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
        <?php if ($doce > 0) {
                 ?>
                <td><Label>Bono turno 12Hrs</Label></td>
                <td style="text-align:right"><?= bcdiv($doce, '1', 2) ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
        <?php if ($infonavit > 0) { ?>
            <td><Label>Infonavit</Label></td>
            <td style="text-align:right"> </td>
            <td style="text-align:right"><?= $infonavit ?></td>
            <td style="text-align:right"></td>
        <?php } else { ?>
            <td></td>
            <td style="text-align:right"> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
        <?php if ($complemento > 0) { ?>
                <td><Label>Complemento de sueldo</Label></td>
                <td style="text-align:right"><?= bcdiv($complemento, '1', 2) ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
            <td>&nbsp;</td>
            <td style="text-align:right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
        <?php if ($vacaciones > 0) { ?>
                <td><Label>Vacaciones</Label></td>
                <td style="text-align:right"><?= bcdiv($vacaciones, '1', 2) ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
            <td>&nbsp;</td>
            <td style="text-align:right">&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <table style="margin-left:0px; position:relative; margin-top: 0px; border: #00 1px solid;">
        <tr>
            <td style="width:529px;"><Label style=" font-size:12px;">Recibí de esta empresa la cantidad que señala este recibo de pago, estando conforme con las<br>
                    percepciones y las retenciones descritas, por lo que certifico que no se me adeuda cantidad alguna<br>
                    por ningún concepto.</Label></td>
        </tr>
        <tr>
            <td style=" height: 40px;width:190px; text-align:center;"><Label>______________________________________<br>Firma del empleado</Label></td>
        </tr>
    </table>
    <table style="margin-left:538px; position:relative; margin-top: -93px; border: #00 1px solid; heig">
        <tr>
            <td style="font-size:14px;">Total de<br> percepciones: </td>
            <td style="width=101px; text-align:right;"><?= bcdiv($totalaPagar + $totalaRetencion , '1', 2) ?></td>
        </tr>
        <tr>
            <td style="font-size:15px;">Total de <br>retenciones: </td>
            <td style="text-align:right"><u>-<?= bcdiv($totalaRetencion, '1', 2)  ?>&nbsp;</u></td>
        </tr>
        <tr>
            <td >Pago: </td>
            <td style="text-align: right;"><?= bcdiv($totalaPagar, '1', 2) ?></td>
        </tr>

    </table>
    <table style="margin-left:0px; position:relative; margin-top: -1px; border: #00 1px solid;">
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
        </tr>
        <tr>
            <td style="width:730px; text-align:center; " colspan="3"><Label>Este pago de nómina no cuenta con un CFDI generado y certificado.</Label></td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
        </tr>
        <tr>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
            <td><Label>&nbsp;</Label></td>
        </tr>
    </table>
</page>