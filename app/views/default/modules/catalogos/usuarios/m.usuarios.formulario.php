<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oUsuarios = new Usuarios ();
$oUsuarios->usr_id = addslashes(filter_input(INPUT_POST, "usr_id"));
$sesion = $_SESSION[$oUsuarios->NombreSesion];
$oUsuarios->Informacion();

?>
<script type="text/javascript">
$(document).ready(function(e) {
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
                <input type="text" class="form-control form-control-user" aria-describedby="" id="usr_nombre"
                    required name="usr_nombre" value="<?= $oUsuarios->usr_nombre ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <strong class="">Contraseña:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="emailHelp" id="usr_pass"
                    required name="usr_pass" value=""  maxlength="15" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="usr_id" name="usr_id" value="<?= $oUsuarios->usr_id ?>" />
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>