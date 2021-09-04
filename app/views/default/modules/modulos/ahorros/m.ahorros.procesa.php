<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/ahorros.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oAhorros = new ahorros(true, $_POST);
    $resultado = $oAhorros->Existe();
    if ($resultado) {
        echo "Sistema@El empleado ya tiene un ahorrro. @warning";
    } else {
        if ($oAhorros->Guardar() === true) {
            echo "Sistema@Se ha registrado exitosamente la información. @success";
        } else {
            echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        }
    }
} else if ($accion == "Detener") {
    $oAhorros = new ahorros(true, $_POST);

    if ($oAhorros->Detener() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
}
