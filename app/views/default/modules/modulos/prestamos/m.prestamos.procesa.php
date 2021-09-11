<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/prestamos.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oPrestamos = new prestamos(true, $_POST);

    $resultado = $oPrestamos->Existe();
    if ($resultado) {
        echo "Sistema@El empleado ya tiene un prestamo activo. @warning";
    } else {
        if ($oPrestamos->Guardar() === true) {
            echo "Sistema@Se ha registrado exitosamente la información. @success";
        } else {
            echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        }
    }
} else if ($accion == "Liquidado") {
    $oPrestamos = new prestamos(true, $_POST);

    if ($oPrestamos->Liquidar() === true) {
        echo "Sistema@Prestamo liquidado exitosamente. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "PrestamoActivo") {
    $oPrestamos = new prestamos(true, $_POST);
    
    $resultado = $oPrestamos->Existe();
    if ($resultado) {
        echo "El empleado ya tiene un prestamo activo";
    }
}
