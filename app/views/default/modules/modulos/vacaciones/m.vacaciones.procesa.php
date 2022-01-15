<?php
/*
 * Copyright 2021 - Felipe angel cerda contreras 
 * felipeangelcerdacontreras@gmail.com
*/
session_start();

$_SITE_PATH = $_SERVER["DOCUMENT_ROOT"] . "/" . explode("/", $_SERVER["PHP_SELF"])[1] . "/";
require_once($_SITE_PATH . "/app/model/vacaciones.class.php");
require_once($_SITE_PATH . "/app/model/empleados.class.php");
require_once($_SITE_PATH . "vendor/autoload.php"); 

use Carbon\Carbon;


$accion = addslashes(filter_input(INPUT_POST, "accion"));

if ($accion == "GUARDAR") {
    $oVacaciones = new vacaciones(true, $_POST);
    if ($oVacaciones->Guardar() === true) {
        echo "Sistema@Se ha registrado exitosamente la información. @success";
    } else {
        echo "Sistema@Ha ocurrido un error al guardar la información , vuelva a intentarlo o consulte con el administrador del sistema.@warning";
    }
} else if ($accion == "Empleado") {
    $oEmpleados = new empleados();
    $oEmpleados->id = addslashes(filter_input(INPUT_POST, "id"));
    $resultado = $oEmpleados->Informacion();
    
    if (count($resultado) > 0){
        echo "{$resultado[0]->fecha_ingreso}"."@";
        echo "{$resultado[0]->salario_diario}";
    }

} else if ($accion == "ANOS") {
    $oVacaciones = new vacaciones(true, $_POST);
    $resultado = $oVacaciones->ObtenerAños(addslashes(filter_input(INPUT_POST, "fecha_ingreso"))); 
    echo $resultado[0]->años_transcurridos;
} else if ($accion == "DIAS") {
    $oVacaciones = new vacaciones(true, $_POST);
    $resultado = $oVacaciones->ObtenerDias(addslashes(filter_input(INPUT_POST, "anos")), addslashes(filter_input(INPUT_POST, "id_empleado"))); 
    
    echo $resultado[0]->dias."@";
    if (!empty($resultado[1]->dias)) {
        echo $resultado[1]->dias;
    } else {
        echo '0';
    }
} else if ($accion == "DiasTotales") {
    $oVacaciones = new vacaciones(true, $_POST);
    $dias = addslashes(filter_input(INPUT_POST, "dias"));
    $fecha_inicial = addslashes(filter_input(INPUT_POST, "fecha_inicial"));
    $fecha_final = addslashes(filter_input(INPUT_POST, "fecha_final"));

    $resultado = $oVacaciones->DiasVacacion($dias, $fecha_inicial, $fecha_final); 
    
    echo $resultado;
}
?>
