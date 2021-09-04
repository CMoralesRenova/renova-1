<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
 */
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/empleados.class.php");

$oEmpleados = new empleados();
$sesion = $_SESSION[$oEmpleados->NombreSesion];
$oEmpleados->ValidaNivelUsuario("empleados");

?>
<?php require_once('app/views/default/script_h.html'); ?>
<script type="text/javascript">
    $(document).ready(function(e) {
        Listado();
        $("#btnGuardar").button().click(function(e) {
            $(".form-control").css('border', '1px solid #d1d3e2');
            var frmTrue = true;
            $("#frmFormulario").find('select, input').each(function() {
                var elemento = this;
                if ($(elemento).hasClass("obligado")) {
                    if (elemento.value == "" || elemento.value == 0) {
                        Alert("", $(elemento).attr("description"), "warning",900,false);
                        Empty(elemento.id);
                        frmTrue = false;
                    }
                }
            });
            if(frmTrue == true) {
                $("#frmFormulario").submit();
            }

            /* if ($("#nombres").val() === "") {
                 Empty("nombre");
                 Alert("", "Ingrese el nombre", "warning",900,false);
             } else if ($("#ape_paterno").val() === "") {
                 Empty("ape_paterno");
                 Alert("", "Ingrese el apellido paterno", "warning",900,false);
             } else if ($("#ape_materno").val() === "") {
                 Empty("ape_materno");
                 Alert("", "Ingrese el apellido materno", "warning",900,false);
             } else if ($("#fecha_nacimiento").val() === "") {
                Empty("fecha_nacimiento");
                 Alert("", "Seleccione la fecha de nacimiento", "warning",900,false);
             } else if ($("#direccion").val() == "" ) {
                 Empty("direccion");
                 Alert("", "Ecribir la direccion completa", "warning",900,false);
             } else if ($("#estado_civil").val() == 0 ) {
                 Empty("estado_civil");
                 Alert("", "Seleccione el estado civil", "warning",900,false);
             } else if ($("#rfc").val() == "") {
                 Empty("rfc");
                 Alert("", "Ingrese el RFC", "warning",900,false);
             } else if ($("#curp").val() == "") {
                 Empty("curp");
                 Alert("", "Ingrese la CURP", "warning",900,false);
             } else if ($("#nss").val() == "") {
                 Empty("nss");
                 Alert("", "Ingrese el NSS", "warning",900,false);
             } else if ($("#nivel_estudios").val() == 0) {
                 Empty("nivel_estudios");
                 Alert("", "Seleccione el nivel estudios", "warning",900,false);
             } else if ($("#id_puesto").val() == 0) {
                 Empty("id_puesto");
                 Alert("", "Seleccione el puesto", "warning",900,false);
             } else if ($("#id_jefe").val() == 0) {
                 Empty("id_jefe");
                 Alert("", "Seleccione el jefe", "warning",900,false);
             } else if ($("#salario_diario").val() == "") {
                 Empty("salario_diario");
                 Alert("", "Ingrese el salario diario", "warning",900,false);
             } else {
                 $("#frmFormulario").submit();
             }*/
        });
        $("#btnBuscar").button().click(function(e) {
            Listado();
        });

    });

    function Listado() {
        var jsonDatos = {
            "accion": "BUSCAR"
        };
        $.ajax({
            data: jsonDatos,
            type: "POST",
            url: "app/views/default/modules/catalogos/empleados/m.empleados.listado.php",
            beforeSend: function() {
                $("#divListado").html(
                    '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Leyendo información de la Base de Datos, espere un momento por favor...</center></div>'
                );
            },
            success: function(datos) {
                $("#divListado").html(datos);
            }
        });
    }

    function Editar(id, nombre) {
        if (nombre == "Desactivar") {
            $.ajax({
                data: "accion=Desactivar&id=" + id + "&estatus= 0",
                type: "POST",
                url: "app/views/default/modules/catalogos/empleados/m.empleados.procesa.php",
                beforeSend: function() {

                },
                success: function(datos) {
                    console.log(datos);
                    Listado();
                }
            });
        } else if (nombre == "Activar") {
            $.ajax({
                data: "accion=Desactivar&id=" + id + "&estatus= 1",
                type: "POST",
                url: "app/views/default/modules/catalogos/empleados/m.empleados.procesa.php",
                beforeSend: function() {

                },
                success: function(datos) {
                    console.log(datos);
                    Listado();
                }
            });
        } else {
            $.ajax({
                data: "id=" + id + "&nombre=" + nombre,
                type: "POST",
                url: "app/views/default/modules/catalogos/empleados/m.empleados.formulario.php",
                beforeSend: function() {
                    $("#divFormulario").html(
                        '<div class="container"><center><img src="app/views/default/img/loading.gif" border="0"/><br />Cargando formulario, espere un momento por favor...</center></div>'
                    );
                },
                success: function(datos) {
                    $("#divFormulario").html(datos);
                }
            });
            $("#myModal_1").modal({
                backdrop: "true"
            });
        }
    }
</script>

<?php require_once('app/views/default/link.html'); ?>

<head>
    <?php require_once('app/views/default/head.html'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <title>Empleados</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- archivo menu-->
        <?php require_once('app/views/default/menu.php'); ?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">
                <!--archivo header-->
                <?php require_once('app/views/default/header.php'); ?>
                <div class="container-fluid">
                    <!-- contenido de la pagina -->

                    <!-- cerrar contenido pagina-->
                    <div id="divListado"></div>
                </div>
            </div>
            <!-- Logout Modal-->
            <div class="modal fade bd-example-modal-lg" id="myModal_1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel"><strong id="nameModal"></strong>
                            </h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- contenido del modal-->
                            <div style="width:100%;" class="modal-body" id="divFormulario">
                            </div>
                        </div>
                        <div class="modal-footer">

                            <input type="submit" class="btn btn-danger" id="btnGuardar" value="Guardar">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal -->

            <!-- archivo Footer -->
            <?php require_once('app/views/default/footer.php'); ?>
            <!-- End of Footer -->
        </div>
    </div>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php require_once('app/views/default/script_f.html'); ?>
</body>

</html>