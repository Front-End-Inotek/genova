<?php

include_once('clase_reservacion.php');
include_once('clase_hab.php');

$reservacion = new Reservacion(0);
$hab = new Hab(0);
$year = "2023";


//Para consultar todas las habitaciones que se ocuparon por año.
$datos_ocupadas=[];
for ($i=1; $i <=12 ; $i++) {
    if($i<10){
        $mes = "0".$i;
    }else{
        $mes = $i;
    }
    $rango_fecha =$year."-".$mes;
    $info = $reservacion->consultar_ocupacion_mes($rango_fecha);
    array_push($datos_ocupadas,$info);
}
// $datos_ocupadas=[30, 150, 60, 80, 90, 89, 33,8,8,55,300];
$datos_visit = [
    "datos_ocupadas" => $datos_ocupadas,
    "datos_habs"=>[],
  
];

echo json_encode($datos_visit);