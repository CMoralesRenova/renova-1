<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/ahorros.class.php");
require_once($_SITE_PATH . "/app/model/empleados.class.php");

$oAhorros = new ahorros();
$oAhorros->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oAhorros->NombreSesion];
$oAhorros->Informacion();

$oEmpleados = new empleados();
$lstEmpleados = $oEmpleados->Listado();
?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Ahorro");
        /*$("#dataTable2").DataTable({
            //dom: 'Bfrtip',
            "paging": false,
            buttons: [
                 'pdf','print'
            ]
        });*/
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
        });
        $('#id_empleado').select2({ width: '100%' }); 
    });
</script>
<!-- DataTales Example -->
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/modulos/ahorros/m.ahorros.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">

    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Jefe Directo:</strong>
                    <div class="form-group">
                        <select id="id_empleado" class="form-control" name="id_empleado">
                            <?php
                            if (count($lstEmpleados) > 0) {
                                echo "<option value='0' >-- SELECCIONE --</option>\n";
                                foreach ($lstEmpleados as $idx => $campo) {
                                        echo "<option value='{$campo->id}' >".$campo->nombres." ".$campo->ape_paterno." ".$campo->ape_materno."</option>\n";
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Nombre:</strong>
                    <div class="form-group">
                        <input type="number" class="form-control form-control-user" aria-describedby="" id="monto" required name="monto" class="form-control" />
                    </div>
                </div>
            </div>

        </div>
        <input type="hidden" id="id" name="id" value="<?= $oAhorros->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>