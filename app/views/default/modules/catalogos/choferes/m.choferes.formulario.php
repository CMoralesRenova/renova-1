<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oChoferes = new Usuarios ();
$oChoferes->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oChoferes->NombreSesion];
$oChoferes->Informacion();

?>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#nameModal").text("<?php  echo $nombre?> Chofer");
    $("#frmFormulario").ajaxForm({
        beforeSubmit: function(formData, jqForm, options) {},
        success: function(data) {
            var str = data;
            var datos0 = str.split("@")[0];
            var datos1 = str.split("@")[1];
            var datos2 = str.split("@")[2];
            if ((datos3 = str.split("@")[3]) === undefined) {
                datos3 = "";
            } else {
                datos3 = str.split("@")[3];
            }
            Alert(datos0, datos1 + "" + datos3, datos2);
            Listado();
            $("#myModal_1").modal("hide");
        }
    });
});
</script>
<form id="frmFormulario" name="frmFormulario"
    action="app/views/default/modules/catalogos/usuarios/m.usuarios.procesa.php" enctype="multipart/form-data"
    method="post" target="_self" class="form-horizontal">
    <div>
        <div class="form-group">
            <strong class="">Nombre:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="" id="nombre_usuario"
                    required name="nombre_usuario" value="<?= $oChoferes->nombre_usuario ?>" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oChoferes->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>