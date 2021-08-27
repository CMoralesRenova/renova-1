<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/horarios.class.php");

$oHorarios = new horarios();
$oHorarios->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oHorarios->NombreSesion];
$oHorarios->Informacion();

?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Horario");
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
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/horarios/m.horarios.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="form-group">
            <strong class="">Nombre:</strong>
            <div class="form-group">
                <input type="text" class="form-control form-control-user" aria-describedby="" id="nombre" required name="nombre" value="<?= $oHorarios->nombre ?>" class="form-control" />
            </div>
        </div>
        <strong class="">Asignacion de horario: </strong>
        <div class="row" style="margin-left: 1%;">
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="A" <?php if ($oHorarios->A == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Lunes</label>
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="B" <?php if ($oHorarios->B == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Martes</label>
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="C" <?php if ($oHorarios->C == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Miercoles</label>
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="D" <?php if ($oHorarios->D == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Jueves</label>
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="E" <?php if ($oHorarios->E == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Viernes</label>
            </div>
        </div>
        <div class="row" style="margin-left: 1%;">
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="F" <?php if ($oHorarios->F == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Sabado</label>
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="G" <?php if ($oHorarios->G == 1) echo "checked" ?> value="1">
                <label class="form-check-label" for="inlineCheckbox1">Domingo</label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Lunes:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_1" required name="entrada_1" value="<?= $oHorarios->entrada_1 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Lunes:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_1" required name="salida_1" value="<?= $oHorarios->salida_1 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Martes:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_2" required name="entrada_2" value="<?= $oHorarios->entrada_2 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Martes:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_2" required name="salida_2" value="<?= $oHorarios->salida_2 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Miercoles:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_3" required name="entrada_3" value="<?= $oHorarios->entrada_3 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Miercoles:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_3" required name="salida_3" value="<?= $oHorarios->salida_3 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Jueves:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_4" required name="entrada_4" value="<?= $oHorarios->entrada_4 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Jueves:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_4" required name="salida_4" value="<?= $oHorarios->salida_4 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Viernes:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_5" required name="entrada_5" value="<?= $oHorarios->entrada_5 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Viernes:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_5" required name="salida_5" value="<?= $oHorarios->salida_5 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Sabado:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_6" required name="entrada_6" value="<?= $oHorarios->entrada_6 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Sabado:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_6" required name="salida_6" value="<?= $oHorarios->salida_6 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Entrada Domingo:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="entrada_7" required name="entrada_7" value="<?= $oHorarios->entrada_7 ?>" class="form-control" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Salida Domingo:</strong>
                    <div class="form-group">
                        <input type="time" class="form-control form-control-user" aria-describedby="" id="salida_7" required name="salida_7" value="<?= $oHorarios->salida_7 ?>" class="form-control" />
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oHorarios->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>