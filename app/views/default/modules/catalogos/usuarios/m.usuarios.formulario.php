<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/usuarios.class.php");

$oUsuarios = new Usuarios ();
$oUsuarios->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oUsuarios->NombreSesion];
$oUsuarios->Informacion();

$aPermisos = empty($oUsuarios->perfiles_id) ? array() : explode("@", $oUsuarios->perfiles_id);
?>
<script type="text/javascript">
$(document).ready(function(e) {
    $("#nameModal").text("<?php  echo $nombre?> Usuario");
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
                    required name="nombre_usuario" value="<?= $oUsuarios->nombre_usuario ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <strong class="">Usuario:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="" id="usuario"
                    required name="usuario" value="<?= $oUsuarios->usuario ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <strong class="">Correo:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="" id="correo"
                    required name="correo" value="<?= $oUsuarios->correo ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <strong class="">N° Económico:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="" id="numero_economico"
                    required name="numero_economico" value="<?= $oUsuarios->numero_economico ?>" class="form-control" />
            </div>
        </div>
        <div class="form-group">
            <strong class="">Permisos: </strong>
            <div class="col-sm-10">
                <table id="dtBasicExample" class="table table-bordered-curved table-hover" cellspacing="0" width="100%">
                    <tr>
                        <td style="vertical-align: top;">
                            <strong>Usuarios</strong><br />
                            <input type="checkbox" name="perfiles_id[]" value="usuarios"
                                <?php if ($oUsuarios->ExistePermiso("usuarios", $aPermisos) === true) echo "checked" ?>><br>
                            <strong>Choferes</strong><br />
                            <input type="checkbox" name="perfiles_id[]" value="choferes"
                                <?php if ($oUsuarios->ExistePermiso("choferes", $aPermisos) === true) echo "checked" ?>><br>
                        </td>
                        <td style="vertical-align: top;">
                            <strong>Cabecera</strong><br />
                            <input type="checkbox" name="perfiles_id[]" value="cabecera"
                                <?php if ($oUsuarios->ExistePermiso("cabecera", $aPermisos) === true) echo "checked" ?>><br>
                            <strong>Servicios</strong><br />
                            <input type="checkbox" name="perfiles_id[]" value="servicios"
                                <?php if ($oUsuarios->ExistePermiso("servicios", $aPermisos) === true) echo "checked" ?>><br>
                            <strong>Multimedia</strong><br />
                            <input type="checkbox" name="perfiles_id[]" value="tecnologia"
                                <?php if ($oUsuarios->ExistePermiso("tecnologia", $aPermisos) === true) echo "checked" ?>><br>
                        </td>

                    </tr>
                </table>
            </div>
        <div class="form-group">
            <strong class="">Contraseña:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="" id="clave_usuario"
                    required name="clave_usuario" value="" class="form-control" />
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oUsuarios->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>