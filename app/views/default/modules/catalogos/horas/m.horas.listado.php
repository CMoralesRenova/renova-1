<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/horas.class.php");

$oHoras = new horas();
$lsthoras = $oHoras->Listado();
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable();

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });

    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-danger">Horas Extras</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-success" name="btnAgregar" value="Agregar Horas Extra" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Empleado</th>
                        <th>Estatus</th>
                        <th>Fecha De Registro</th>
                        <th>Motivo</th>
                        <th>Horas Extras</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Folio</th>
                    <th>Empleado</th>
                    <th>Estatus</th>
                    <th>Fecha De Registro</th>
                    <th>Motivo</th>
                    <th>Horas Extras</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lsthoras) > 0) {
                        foreach ($lsthoras as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->id ?></td>
                                <td style="text-align: center;"><?= $campo->empleado ?></td>
                                <td style="text-align: center;"<?php if ($campo->est == "AUTORIZADA"){ echo "class='btn-success'";}else{echo "class='btn-warning'"; } ?>><?= $campo->est ?></td>
                                <td style="text-align: center;"><?= $campo->fecha_registro ?></td>
                                <td style="text-align: center;"><?= $campo->motivo ?></td>
                                <td style="text-align: center;"><?= $campo->horas_extras ?></td>
                                <td style="text-align: center;">
                                    <?php if ($campo->estatus == 1) { ?>
                                        <a class="btn btn-sm btn-success" href="javascript:Editar('<?= $campo->id ?>','Autorizar')">✓Autorizar</a>
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