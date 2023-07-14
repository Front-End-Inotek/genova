<?php

include_once('clase_reservacion.php');

$reservacion = new Reservacion(0);

$year = "2023";


// $info_ocupadas = $reservacion->consultar_ocupacion_mes();


// $datos_ocupadas[0] = $reservacion->consultar_ocupacion_mes($year,"01");
$datos_ocupadas=[];

$setencias = [];

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
    // "sentencias"=>$setencias,
  
];

echo json_encode($datos_visit);