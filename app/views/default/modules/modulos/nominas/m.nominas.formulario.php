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
                        columns: [0, 1, 2, 3, 4, 5, 6, 7]
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
                        <th>Sueldo Diario</th>
                        <th>Sueldo Semanal</th>
                        <th>Faltas</th>
                        <th>Dias Laborados</th>
                        <th>Horas Extras</th>
                        <th>Total Percepciones</th>
                        <th>Total Retenciones</th>
                        <th>Total A Pagar</th>
                        <th>Recibo</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstnominas) > 0) {
                        foreach ($lstnominas as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?= $campo->salario_diario ?></td>
                                <td style="text-align: center;"><?= $campo->salario_semanal ?></td>
                                <td style="text-align: center;"><?= $campo->estatus ?></td>
                                <td style="text-align: center;"><?= $campo->estatus ?></td>
                                <td style="text-align: center;"><?= $campo->horas ?></td>
                                <td style="text-align: center;"><?= $campo->percepciones ?></td>
                                <td style="text-align: center;"><?= $campo->retenciones ?></td>
                                <td style="text-align: center;"><?= $campo->total ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-sm btn-warning" href="javascript:Editar('<?= $campo->id ?>','Editar')">Ver</a>
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