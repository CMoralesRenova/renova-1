<?php
session_start();
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/nominas.class.php");
require_once($_SITE_PATH . "app/model/prestamos.class.php");
require_once($_SITE_PATH . "app/model/otros.class.php");
require_once($_SITE_PATH . "app/model/fonacot.class.php");
require_once($_SITE_PATH . "app/model/infonavit.class.php");

$oNominas = new nominas(true, $_POST);
$oNominas->id = empty($_GET['id']) ? "" : $_GET['id'];
$oNominas->id_empleado = empty($_GET['id_empleado']) ? "" : $_GET['id_empleado'];
$oNominas->Listado_nomina();

$oPrestamos = new prestamos(true, $_POST);
$oPrestamos->id = $oNominas->id_prestamo;
$oPrestamos->Informacion();

$oFonacot = new fonacot(true, $_POST);
$oFonacot->id = $oNominas->id_fonacot;
$oFonacot->Informacion();

$oInfonavit = new infonavit(true, $_POST);
$oInfonavit->id = $oNominas->id_infonavit;
$oInfonavit->Informacion();

$oOtros = new otros(true, $_POST);
$oOtros->id_empleado = empty($_GET['id_empleado']) ? "" : $_GET['id_empleado'];
$oOtros->fecha_pago = $oNominas->fecha;
$LstOtros = $oOtros->Listado();

$totalaPagar = 0;
$totalaRetencion = 0;
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
                <td><?= $oNominas->fecha ?></td>
            </tr>
        </tbody>
    </table>
    <table style="margin-left:0px; position:relative; margin-top: 10px; border: #00 1px solid;">
        <tr>
            <th style="color: #f3eded; background-color: #000;width:450px;  text-align:center;" COLSPAN=2>Empleado</th>
        </tr>
        <tr>
            <td><Label>Nombre:</Label></td>
            <td><?= $oNominas->nombres . " " . $oNominas->ape_paterno . " " . $oNominas->ape_materno  ?></td>
        </tr>
        <tr>
            <td><Label>Puesto:</Label></td>
            <td><?= $oNominas->puesto ?></td>
        </tr>
        <tr>
            <td><Label>Departamento:</Label></td>
            <td><?= $oNominas->departamento ?></td>
        </tr>
        <tr>
            <td><Label>RFC:</Label></td>
            <td><?= $oNominas->rfc ?></td>
        </tr>
        <tr>
            <td><Label>CURP:</Label></td>
            <td><?= $oNominas->curp ?></td>
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
            <td ><?= $oNominas->salario_diario ?> diario</td>
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
        <tr>
            <td><Label>Sueldo normal</Label></td>
            <?php $totalaPagar = $totalaPagar + $oNominas->dias_laborados * $oNominas->salario_diario; ?>
            <td style="text-align:right"><?= $oNominas->dias_laborados * $oNominas->salario_diario ?></td>
            <td style="text-align:right"><?= $oNominas->dias_laborados ?> dias</td>
            <td>&nbsp;</td>
            <?php if ($oNominas->prestamos > 0) {
                $totalaRetencion = $totalaRetencion + $oPrestamos->monto_por_semana ?>
                <td>Prestamo</td>
                <td style="text-align:right"><?= $oPrestamos->monto_pagar ?> </td>
                <td style="text-align:right"><?= $oPrestamos->monto_por_semana ?></td>
                <td style="text-align:right"><?= $oPrestamos->restante ?></td>
            <?php } else { ?>
                <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
            <?php if ($oNominas->dias_laborados == 7) {
                $totalaPagar = $totalaPagar + $oNominas->salario_asistencia;  ?>
                <td><Label>Premio de Asistencia</Label></td>
                <td style="text-align:right"><?= $oNominas->salario_asistencia ?></td>
            <?php } else { ?>
                <td><Label>&nbsp;</Label></td>
                <td>&nbsp;</td>
            <?php } ?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php if (!empty($oNominas->comedor)) { ?>
                <td>Servicio de comedor</td>
                <td>&nbsp;</td>
                <td style="text-align:right"><?php echo $oNominas->comedor;
                    $totalaRetencion = $totalaRetencion + $oNominas->comedor; ?></td>
            <?php } else { ?>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
            <?php if ($oNominas->dias_laborados == 7) {
                $totalaPagar = $totalaPagar + $oNominas->salario_puntualidad; ?>
                <td><Label>Premio de Puntualidad</Label></td>
                <td style="text-align:right"><?= $oNominas->salario_puntualidad ?> </td>
            <?php } else { ?>
                <td><Label>&nbsp;</Label></td>
                <td>&nbsp;</td>
            <?php } ?>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php if ($oNominas->otros_descuentos > 0) { ?>
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
            <?php if ($oNominas->salario_productividad > 0) {
                $totalaPagar = $totalaPagar +  $oNominas->salario_productividad; ?>
                <td><Label>Bono de productividad</Label></td>
                <td style="text-align:right"><?= $oNominas->salario_productividad ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
                <?php if ($oNominas->monto > 0) { ?>
                    <td><Label>Caja de ahorro</Label></td>
                    <td></td>
                    <?php if ($oNominas->estatusAhorro == 1) {
                        $totalaRetencion = $totalaRetencion + $oNominas->monto;
                        echo "<td style='text-align:right'>$oNominas->monto</td>";
                    } else {
                        echo "<td>A/D</td>";
                    } ?>
                    <td style="text-align:right"><?= $oNominas->monto * $oNominas->frecuencia ?></td>
                <?php } else { ?>
                    <td><Label>&nbsp;</Label></td>
                    <td>&nbsp;</td>
                <?php } ?>
        </tr>
        <tr>
        <?php if ($oNominas->horas_extras > 0) {
                $totalaPagar = $totalaPagar +  $oNominas->horas_extras; ?>
                <td><Label>Horas extras</Label></td>
                <td style="text-align:right"><?=  bcdiv($oNominas->horas_extras, '1', 2); ?> </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } else {?>
                    <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <?php } ?>
        <?php if ($oNominas->fonacot > 0) {
            $totalaRetencion = $totalaRetencion + $oFonacot->monto_por_semana; ?>
            <td><Label>Fonacot</Label></td>
            <td style="text-align:right"></td>
            <td style="text-align:right"><?= $oFonacot->monto_por_semana ?></td>
            <td style="text-align:right"></td>
        <?php } else { ?>
            <td></td>
            <td style="text-align:right"> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        <?php if ($oNominas->infonavit > 0) {
            $totalaRetencion = $totalaRetencion + $oInfonavit->monto_por_semana; ?>
            <td><Label>Infonavit</Label></td>
            <td style="text-align:right"> </td>
            <td style="text-align:right"><?= $oInfonavit->monto_por_semana ?></td>
            <td style="text-align:right"></td>
        <?php } else { ?>
            <td></td>
            <td style="text-align:right"> </td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <?php } ?>
        </tr>
        <tr>
            <td><Label></Label></td>
            <td> </td>
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
            <td style="width=101px; text-align:right;"><?= bcdiv($totalaPagar, '1', 2) ?></td>
        </tr>
        <tr>
            <td style="font-size:15px;">Total de <br>retenciones: </td>
            <td style="text-align:right"><u>-<?= bcdiv($totalaRetencion, '1', 2)  ?>&nbsp;</u></td>
        </tr>
        <tr>
            <td >Pago: </td>
            <td style="text-align: right;"><?= bcdiv($totalaPagar - $totalaRetencion, '1', 2) ?></td>
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