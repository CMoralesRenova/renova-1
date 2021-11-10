<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/nominas.class.php");

$oNominas = new nominas();
$oNominas->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$lstnominas = $oNominas->Listado_nomina();

?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $(document).ready(function() {
            $('#dataTable2').DataTable({
                "paging": false,
                dom: 'Bfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    title: 'Reporte Nomina Semana <?= $nombre ?>',
                    text: 'Exportar a pdf',
                    exportOptions: {
                        columns: [0, 5, 8, 9, 10, 11, 12, 13, 14]
                    }
                }]
            });
            $(".buttons-html5 ").addClass("btn btn-danger");
        });
    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable2" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nombre Empleado</th>
                        <th>Premio de asistencia</th>
                        <th>Premio de puntualidad</th>
                        <th>Bono de productividad</th>
                        <th>Sueldo Semanal</th>
                        <th>Faltas</th>
                        <th>Dias Laborados</th>
                        <th>Horas Extras</th>
                        <th>Total Percepciones</th>
                        <th>Comedor</th>
                        <th>Ahorro</th>
                        <th>Prestamos</th>
                        <th>Fonacot</th>
                        <th>Infonavit</th>
                        <th>Otros Cargos</th>
                        <th>Total Retenciones</th>
                        <th>Total A Pagar</th>
                        <th>Recibo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstnominas) > 0) {
                        foreach ($lstnominas as $idx => $campo) {
                            $totalEsperado = 0;
                            $totalRetenciones = 0;
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?= "$".bcdiv($campo->salario_asistencia, '1', 2) ?></td>
                                <td style="text-align: center;"><?= "$".bcdiv($campo->salario_puntualidad, '1', 2) ?></td>
                                <td style="text-align: center;"><?= "$".bcdiv($campo->salario_productividad, '1', 2) ?></td>
                                <td style="text-align: center;"><?= "$".bcdiv($campo->salario_semanal, '1', 2) ?></td>
                                <td style="text-align: center;"><?= (7 - $campo->dias_laborados) ?></td>
                                <td style="text-align: center;"><?= $campo->dias_laborados ?></td>
                                <td style="text-align: center;"><?= "$".bcdiv($campo->horas_extras, '1', 2) ?></td>
                                <td style="text-align: center;"><?php
                                                                if ($campo->dias_laborados < 7) {
                                                                    $totalEsperado = bcdiv($campo->esperado + $campo->bono_doce + $campo->complemento_sueldo + $campo->salario_productividad + $campo->horas_extras, '1', 2);
                                                                } else {
                                                                    $totalEsperado = bcdiv($campo->esperado + $campo->bono_doce + $campo->complemento_sueldo + $campo->salario_productividad + $campo->salario_puntualidad + $campo->salario_asistencia + $campo->horas_extras, '1', 2);
                                                                }
                                                                echo "$".$totalEsperado; ?></td>
                                <td style="text-align: center;"><?php if (!empty($campo->comedor)) {
                                                                    echo "-$" . $campo->comedor;
                                                                    $totalRetenciones = $totalRetenciones + $campo->comedor;
                                                                } else {
                                                                    echo "-0.00";
                                                                }?></td>
                                <td style="text-align: center;"><?php if ($campo->estatusAhorro == 1) {
                                                                    echo "-$" . $campo->monto;
                                                                    $totalRetenciones = $totalRetenciones + $campo->monto;
                                                                } else {
                                                                    echo "-0.00";
                                                                } ?></td>

                                <td style="text-align: center;"><?php echo "-$" . bcdiv($campo->prestamos, '1', 2);
                                                                $totalRetenciones = $totalRetenciones + $campo->prestamos; ?></td>
                                <td style="text-align: center;"><?php echo "-$" . bcdiv($campo->fonacot, '1', 2);
                                                                $totalRetenciones = $totalRetenciones + $campo->fonacot; ?></td>
                                <td style="text-align: center;"><?php echo "-$" . bcdiv($campo->infonavit, '1', 2);
                                                                $totalRetenciones = $totalRetenciones + $campo->infonavit; ?></td>
                                <td style="text-align: center;"><?php echo "-$" . bcdiv($campo->otros_descuentos, '1', 2);
                                                                $totalRetenciones = $totalRetenciones + $campo->otros_descuentos; ?></td>
                                <td style="text-align: center;"><?= "-$" . bcdiv($totalRetenciones, '1', 2); ?></td>
                                <td style="text-align: center;"><?php echo "$".($totalEsperado - $totalRetenciones); ?></td>
                                <td style="text-align: center;">
                                    <?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno . "<br>" ?>
                                    <?php if ($campo->estatus != 3) { ?>
                                        <a class="btn btn-sm btn-warning" href="javascript:Reporte('<?= $campo->id ?>','<?= $campo->id_empleado ?>')">Ver</a>
                                    <?php } ?>
                                </td>
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>