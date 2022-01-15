<?php

//Api Rest
header("Acces-Control-Allow-Origin: *");
header("Content-Type: application/json");

include_once './bd.php';
$con = new bd();

$method = $_SERVER['REQUEST_METHOD'];

$KEY = 'AIzaSyDNuQjcMaL880tNTT_rY6X3G6DhiMqSDFw';
$API = filter_input(INPUT_POST, "API_KEY");

// Metodo para peticiones tipo GET
if ($method == "POST" && $KEY == $API) {

    $sql = 'SELECT id, concat(nombres," ",ape_paterno," ",ape_materno) as nombre  FROM empleados where estatus = "1"';
    $rs = $con->findAll($sql);     

    $sql_ = "SELECT count(id) total from empleados where estatus = '1'";
    $rs_c = $con->findAll($sql_);

    $arrayResponse = array();
    for ($index = 0; $index < count($rs); $index++) {
        $arrayObject = array();
        $arrayObject["total"] = $rs_c[0]['total'];
        $arrayObject["id"] = $rs[$index]['id'];
        $arrayObject["nombre"] = $rs[$index]["nombre"];
        $arrayResponse[] = $arrayObject;
    }
    echo json_encode($arrayResponse);
}