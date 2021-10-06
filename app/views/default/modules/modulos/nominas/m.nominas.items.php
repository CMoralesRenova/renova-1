<?php
session_start();
$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "app/model/nominas.class.php");
require_once($_SITE_PATH . "app/model/ezpdf/class.ezpdf.php");

$oNominas = new nominas();
$oNominas->id = addslashes(filter_input(INPUT_POST, "id"));
$oNominas->id_empleado = addslashes(filter_input(INPUT_POST, "id_empleado"));
$lstnominas = $oNominas->Listado_nomina();
?>
<style>
    #encabezado .fila #col_1 {
        width: 50.3%;

    }

    #encabezado .fila #col_2 {
        width: 50.3%;
    }

    #encabezado .fila #col_0 {
        width: 30%;
    }

    #encabezadosup {
        padding: 5px 0;
        margin-top: -30px;
        margin-left: -30px;
        border-top: 0px solid;
        border-bottom: 0px solid;
        border: 0px solid;
        width: 100%;
    }

    #encabezado {
        padding: 5px 0;
        margin-left: -30px;
        border-top: 0px solid;
        border-bottom: 0px solid;
        border: 0px solid;
        width: 100%;
    }

    #encabezado1 {
        padding: 5px 0;
        margin-left: -30px;
        border-top: 0px solid;
        border-bottom: 0px solid;
        border: 0px solid;
        width: 100%;
    }


    #encabezado .fila #ref1 {
        width: 52%;
    }

    #encabezado .fila #ref2 {
        width: 50%;
    }

    #encabezadosup .filasup #col_1 {
        width: 55%;
    }

    #encabezadosup .filasup #col_2 {
        width: 113%;
    }

    #encabezado .fila #col_2 {
        width: 113%;
        height: 10px;
    }

    #encabezadosup .filasup #col_3 {
        width: 10%;
        height: 6%
    }
</style>
<div class="table-responsive" style="border: solid 1px #000;">
    <table>
        <thead>
            <th>
                <tr>
                    <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                    <td>&nbsp;&nbsp;&nbsp;</td>-->
                    <td>
                        <h3 style="margin-left:240px;">RENOVA CHATARRAS INDUSTRIALES S.A DE C.V</h3>
                    </td>
                    </td>
                </tr>
            </th>
        </thead>
    </table>
    <table>
        <tbody>
            <tr>
                <td>
                    <h1>Recibo de nómina </h1>
                    <!--<td>&nbsp;&nbsp;&nbsp;&nbsp;<label style="font-size: 10px;"> RFC: RCI411223RA</label></td>
                    <td><label style="font-size: 10px;"> RFC: RCI411223RA</label></td>-->
                <td>
                <td>
                    <tabble>
                        <thead>
                            <tr>
                                <th>Frecuencia de pago</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                    </tabble>
                </td>
        <tbody>
            <tr>
                <td></td>
                <td>Fecha</td>
            </tr>
        </tbody>
        <td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>&nbsp;&nbsp;&nbsp;</td>
                <td><label> RFC: RCI411223RA</label></td>
            </tr>
            </tbody>
    </table>
</div>