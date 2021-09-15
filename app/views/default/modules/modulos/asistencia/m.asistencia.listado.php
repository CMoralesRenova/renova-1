<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/asistencia.class.php");

$oAsistencia = new asistencia(true, $_POST);
$lstasistencia = $oAsistencia->Listado();
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        //$('#dataTable').DataTable();
        $('#dataTable').DataTable({
            "paging": true,
        });

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });
        $(".buttons-html5 ").addClass("btn btn-danger");

    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-danger">Asistencia</h5>
        <div class="form-group" style="text-align:right">

        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Asistencias</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Empleado</th>
                    <th>Asistencias</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstasistencia) > 0) {
                        foreach ($lstasistencia as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?= $campo->dia ?></td>
                                <td style="text-align: center;">
                                    <a class="btn btn-sm btn-warning" href="javascript:Editar('<?= $campo->id_empleado ?>','Reporte')">Ver</a>
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