<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/comedor.nomina.class.php");

$oComedor = new comedor_nominas(true, $_POST);
$lstcomedor = $oComedor->Listado();
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#dataTable").DataTable({
            "ordering": false
        });

        $("#btnAgregar").button().click(function(e) {
            Editar("", "Agregar");
        });

    });
</script>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3" style="text-align:left">
        <h5 class="m-0 font-weight-bold text-danger">Comedor</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Empleado</th>
                        <th>Fecha de registro</th>
                        <th>Cantidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <th>Empleado</th>
                    <th>Fecha de registro</th>
                    <th>Cantidad</th>
                    <th>Acciones</th>
                </tfoot>
                <tbody>
                    <?php
                    if (count($lstcomedor) > 0) {
                        foreach ($lstcomedor as $idx => $campo) {
                    ?>
                            <tr>
                                <td style="text-align: center;"><?= $campo->nombres . " " . $campo->ape_paterno . " " . $campo->ape_materno ?></td>
                                <td style="text-align: center;"><?= $campo->fecha ?></td>
                                <td style="text-align: center;"><?= $campo->precio_platillo ?></td>
                                <td style="text-align: center;">
                                        <a class="btn btn-sm btn-danger" href="javascript:Editar('<?= $campo->id ?>','Editar')"><span class="glyphicon glyphicon-ok">Editar</a>
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