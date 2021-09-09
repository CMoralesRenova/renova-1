<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/asistencia.class.php");

$accion = addslashes(filter_input(INPUT_POST, "accion"));


if ($accion == "GUARDAR") {
    $oAsistencia = new asistencia(true, $_POST);

    $resultado = $oAsistencia->Existe();
    if ($resultado) {
        echo "Sistema@El empleado ya tiene un prestamo activo. @warning";
    } else {
        if ($oAsistencia->Guardar() === true) {
            echo "Sistema@Se ha registrado exitosamente la información. @success";
        } else {
            echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
        }
    }
} else if ($accion == "Liquidado") {
    $oAsistencia = new asistencia(true, $_POST);

    if ($oAsistencia->Liquidar() === true) {
        echo "Sistema@Prestamo liquidado exitosamente. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} 
