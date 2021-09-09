<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/empleados.class.php");
require_once($_SITE_PATH . "/app/model/puestos.class.php");

$oEmpleados = new empleados();
$oEmpleados->id = addslashes(filter_input(INPUT_POST, "id"));
$nombre = addslashes(filter_input(INPUT_POST, "nombre"));
$sesion = $_SESSION[$oEmpleados->NombreSesion];
$oEmpleados->Informacion();
$lstJefes = $oEmpleados->jefes();

$oPuestos = new puestos();
$lstpuestos = $oPuestos->Listado();

?>
<script type="text/javascript">
    $(document).ready(function(e) {
        $("#nameModal").text("<?php echo $nombre ?> Empleado");
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
        $('#estado_civil').select2({
            width: '100%'
        });
        $('#nivel_estudios').select2({
            width: '100%'
        });
        $('#id_puesto').select2({
            width: '100%'
        });
        $('#id_jefe').select2({
            width: '100%'
        });
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<form id="frmFormulario" name="frmFormulario" action="app/views/default/modules/catalogos/empleados/m.empleados.procesa.php" enctype="multipart/form-data" method="post" target="_self" class="form-horizontal">
    <div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Nombres:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el nombre" class="form-control obligado" aria-describedby="" id="nombres" required name="nombres" value="<?= $oEmpleados->nombres ?>" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Apellido Paterno:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el apellido paterno " aria-describedby="" id="ape_paterno" required name="ape_paterno" value="<?= $oEmpleados->ape_paterno ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Apellido Materno:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el apellido materno" aria-describedby="" id="ape_materno" required name="ape_materno" value="<?= $oEmpleados->ape_materno ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Fecha Nacimiento:</strong>
                    <div class="form-group">
                        <input type="date" description="Seleccione la fecha de nacimiento" aria-describedby="" id="fecha_nacimiento" required name="fecha_nacimiento" value="<?= $oEmpleados->fecha_nacimiento ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <strong class="">Dirección:</strong>
            <div class="form-group">
                <input type="text" description="Ingrese la dirección" aria-describedby="" id="direccion" name="direccion" value="<?= $oEmpleados->direccion ?>" class="form-control obligado" data-toggle="tooltip" title="" data-original-title="Escribir la direccion completa" />
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Estado Civil:</strong>
                    <div class="form-group">
                        <select id="estado_civil" description="Seleccione el estado civil" class="form-control obligado" name="estado_civil">
                            <option value='0'>--SELECCIONE--</option>
                            <option value='1' <?php if ($oEmpleados->estado_civil == 1) echo "selected" ?>>Soltero/a</option>
                            <option value='2' <?php if ($oEmpleados->estado_civil == 2) echo 'Selected'; ?>>Casado/a</option>
                            <option value='3' <?php if ($oEmpleados->estado_civil == 3) echo 'Selected'; ?>>Unión libre</option>
                            <option value='4' <?php if ($oEmpleados->estado_civil == 4) echo 'Selected'; ?>>Separado/a</option>
                            <option value='5' <?php if ($oEmpleados->estado_civil == 5) echo 'Selected'; ?>>Divorciado/a</option>
                            <option value='6' <?php if ($oEmpleados->estado_civil == 6) echo 'Selected'; ?>>Viudo/a.</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">RFC:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el RFC" aria-describedby="" id="rfc" required name="rfc" value="<?= $oEmpleados->rfc ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">CURP:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese la CURP" aria-describedby="" id="curp" required name="curp" value="<?= $oEmpleados->curp ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">NSS:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese el NSS" aria-describedby="" id="nss" required name="nss" value="<?= $oEmpleados->nss ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Nivel de Estudios:</strong>
                    <div class="form-group">
                        <select id="nivel_estudios" description="Seleccione el nivel de estudios" class="form-control obligado" name="nivel_estudios">
                            <option value='0'>--SELECCIONE--</option>
                            <option value='1' <?php if ($oEmpleados->nivel_estudios == 1) echo "selected" ?>>Primaria</option>
                            <option value='2' <?php if ($oEmpleados->nivel_estudios == 2) echo "selected" ?>>Secundaria</option>
                            <option value='3' <?php if ($oEmpleados->nivel_estudios == 3) echo "selected" ?>>Preparatoria</option>
                            <option value='4' <?php if ($oEmpleados->nivel_estudios == 4) echo "selected" ?>>Ingenieria</option>
                            <option value='5' <?php if ($oEmpleados->nivel_estudios == 5) echo "selected" ?>>Licenciatura/a</option>
                            <option value='6' <?php if ($oEmpleados->nivel_estudios == 6) echo "selected" ?>>Maestria</option>
                            <option value='7' <?php if ($oEmpleados->nivel_estudios == 7) echo "selected" ?>>Doctorado</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Puestos:</strong>
                    <div class="form-group">
                        <select id="id_puesto" description="Seleccione el puesto" class="form-control obligado" name="id_puesto">
                            <?php
                            if (count($lstpuestos) > 0) {
                                echo "<option value='0' >-- SELECCIONE --</option>\n";
                                foreach ($lstpuestos as $idx => $campo) {
                                    if ($campo->id == $oEmpleados->id_puesto) {
                                        echo "<option value='{$campo->id}' selected>{$campo->nombre}</option>\n";
                                    } else {
                                        echo "<option value='{$campo->id}' >{$campo->nombre}</option>\n";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <strong class="">Jefe Directo:</strong>
                    <div class="form-group">
                        <select id="id_jefe" description="Seleccione el jefe directo" class="form-control obligado" name="id_jefe">
                            <?php
                            if (count($lstJefes) > 0) {
                                echo "<option value='0' >-- SELECCIONE --</option>\n";
                                foreach ($lstJefes as $idx => $campo) {
                                    if ($campo->id == $oEmpleados->id_jefe) {
                                        echo "<option value='{$campo->id}' selected>{$campo->empleado}</option>\n";
                                    } else {
                                        echo "<option value='{$campo->id}' >{$campo->empleado}</option>\n";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <strong class="">Sueldo Base Diario:</strong>
                    <div class="form-group">
                        <input type="text" description="Ingrese sueldo base" aria-describedby="" id="salario_diario" required name="salario_diario" value="<?= $oEmpleados->salario_diario ?>" class="form-control obligado" />
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <strong class="">Reloj checador:</strong>
            <div class="form-group">
                <input type="text" description="Conecte el lector para leer el numero" aria-describedby="" id="checador" required name="checador" value="<?= $oEmpleados->checador ?>" class="form-control obligado" />
            </div>
        </div>
        <input type="hidden" id="id" name="id" value="<?= $oEmpleados->id ?>" />
        <input type="hidden" id="user_id" name="user_id" value="<?= $sesion->id ?>">
        <input type="hidden" id="accion" name="accion" value="GUARDAR" />
    </div>
</form>