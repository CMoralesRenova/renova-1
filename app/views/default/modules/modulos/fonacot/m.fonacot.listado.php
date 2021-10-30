<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/fonacot.class.php");

$oFonacot = new fonacot(true, $_POST);
$lstfonacot = $oFonacot->Listado();
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
        <h5 class="m-0 font-weight-bold text-danger">Fonacot</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-danger" name="btnAgregar" value="Agregar Fonacot" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Fecha de registro</th>
                        <th>Fecha pago</th>
                        <th>Monto A Pagar</th>
                        <th>Cantidad A Pagar Por Semana</th>
                        <th>Semanas</th>
                        <th>Semana actual</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Empleado</th>
                    <th>Fecha de registro</th>
                    <th>Fecha pago</th>
                    <th>Monto A Pagar</th>
                    <th>Cantidad A Pagar Por Semana</th>
                    <th>Semanas</th>
                    <th>Semana actual</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstfonacot) > 0) {
                        foreach ($lstfonacot as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?= $campo->fecha_registro ?></td>
                                <td style="text-align: center;"><?= $campo->fecha_pago ?></td>
                                <td style="text-align: center;">$<?= $campo->monto_pagar ?></td>
                                <td style="text-align: center;">$<?= $campo->monto_por_semana ?></td>
                                <td style="text-align: center;"><?= $campo->numero_semanas ?></td>
                                <td style="text-align: center;"><?= $campo->semana_actual ?></td>
                                <td style="text-align: center;"><?= $campo->est ?></td>
                                <td style="text-align: center;">
                                    <?php if ($campo->estatus == "1") { ?>
                                        <a class="btn btn-sm btn-warning" href="javascript:Editar('<?= $campo->id ?>','Liquidar')"><span class="glyphicon glyphicon-ok">Liquidar</a>
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