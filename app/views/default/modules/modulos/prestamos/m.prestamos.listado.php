<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/prestamos.class.php");

$oPrestamos = new prestamos(true, $_POST);
$lstprestamos = $oPrestamos->Listado();

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
        <h5 class="m-0 font-weight-bold text-danger">Prestamos</h5>
        <div class="form-group" style="text-align:right">
            <input type="button" id="btnAgregar" class="btn btn-danger" name="btnAgregar" value="Agregar Prestamo" />
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Fecha de registro</th>
                        <th>Monto Solicitado</th>
                        <th>Monto A Pagar</th>
                        <th>Cantidad A Pagar Por Semana</th>
                        <th>Semanas</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Empleado</th>
                    <th>Fecha de registro</th>
                    <th>Monto Solicitado</th>
                    <th>Monto A Pagar</th>
                    <th>Cantidad A Pagar Por Semana</th>
                    <th>Semanas</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstprestamos) > 0) {
                        foreach ($lstprestamos as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: ;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: ;"><?= $campo->fecha_registro ?></td>
                                <td style="text-align: ;">$<?= $campo->monto ?></td>
                                <td style="text-align: ;">$<?= $campo->monto_pagar ?></td>
                                <td style="text-align: ;">$<?= $campo->monto_por_semana ?></td>
                                <td style="text-align: ;"><?= $campo->numero_semanas ?></td>
                                <td style="text-align: ;"><?= $campo->est ?></td>
                                <td style="text-align: ;width: 20%;">
                                    <div class="row">
                                        <a class="btn btn-sm btn-danger" href="javascript:Editar('<?= $campo->id ?>','Detalles','<?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?>')">
                                            <span class="glyphicon glyphicon-ok">Ver Detalles</a><br>
                                    </div>
                                    <?php if (empty($campo->semana_actual) && $campo->estatus == "1") { ?>
                                        <div class="row" style="margin-top: 1%;">
                                            <a class="btn btn-sm btn-success" href="javascript:Editar('<?= $campo->id ?>','Editar')"><span class="glyphicon glyphicon-ok">Editar</a>
                                        </div>
                                    <?php } ?>
                                    <?php if ($campo->estatus == "1") { ?>
                                        <div class="row" style="margin-top: 1%;">
                                            <a class="btn btn-sm btn-warning" href="javascript:Editar('<?= $campo->id ?>','Liquidar')"><span class="glyphicon glyphicon-ok">Liquidar</a>
                                        </div>
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