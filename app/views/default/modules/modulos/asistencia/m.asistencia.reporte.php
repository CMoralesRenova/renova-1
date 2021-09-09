<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/asistencia.class.php");

$oAsistencia = new asistencia(true, $_POST);
$oAsistencia->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$lstasistencia = $oAsistencia->Listado_asistencia();
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
                        columns: [0, 1, 2, 3]
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
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Dia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($lstasistencia) > 0) {
                        foreach ($lstasistencia as $idx => $campo) {
                    ?>
                            <tr>
                            <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?= $campo->fecha ?></td>
                                <td style="text-align: center;"><?= $campo->hora ?></td>
                                <td style="text-align: center;"><?= $campo->dia ?></td>
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