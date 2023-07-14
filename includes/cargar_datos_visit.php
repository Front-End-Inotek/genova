<?php

include_once('clase_reservacion.php');
include_once('clase_hab.php');
include_once('clase_forma_pago.php');

$forma_pago = new Forma_pago(0);
$etiquetas_forma_pago= $forma_pago->etiquetas_forma_pago();

$reservacion = new Reservacion(0);
$hab = new Hab(0);
$year = "2023";

$etiquetas_hospedaje = $hab->mostrar_tipoHab();

$datos_hospedaje = [];
foreach ($etiquetas_hospedaje as $key => $hospedaje) {
    $info = $reservacion->consultar_datos_hospedaje($hospedaje);
    array_push($datos_hospedaje,$info);

}

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
    //datos
    "datos_ocupadas" => $datos_ocupadas,
    "datos_hospedaje"=>$datos_hospedaje,


    //etiquetas
    "etiquetas_hospedaje"=>$etiquetas_hospedaje,
    "etiquetas_forma_pago" => $etiquetas_forma_pago,
];

echo json_encode($datos_visit);