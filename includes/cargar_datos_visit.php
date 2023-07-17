<?php

include_once('clase_reservacion.php');
include_once('clase_hab.php');
include_once('clase_forma_pago.php');

$reservacion = new Reservacion(0);
$forma_pago = new Forma_pago(0);
$hab = new Hab(0);
$year = "2023";

//Se consulta el rango de fechas del lunes pasado al domingo pasado.
$lunes_pasado =   date("Y-m-d", strtotime("last week monday"));
$lunes_pasado= strtotime($lunes_pasado);
$domingo_pasado =  date("Y-m-d", strtotime("last week sunday"));
$domingo_pasado=strtotime($domingo_pasado . "+1 day");

$dates = $reservacion->date_range($lunes_pasado,$domingo_pasado);

$datos_cargos=[];
$datos_abonos=[];

$datos_rest = $reservacion->consultar_restuarante_top4("");



foreach ($dates as $key => $fecha) {
    # code...
    $info = $reservacion->consultar_datos_abonos($fecha);
    array_push($datos_cargos,$info);

    $info_rest = $reservacion->consultar_datos_cargos($fecha);
    array_push($datos_abonos,$info_rest);
}

//Ventas restaurante.

$datos_ventas_rest=[];
//Ventas
$datos_ventas =[];

foreach ($dates as $key => $fecha) {
    # code...
    $info = $reservacion->consultar_datos_ventas($fecha);
    array_push($datos_ventas,$info);

    $info_rest = $reservacion->consultar_ventas_restaurante($fecha);
    array_push($datos_ventas_rest,$info_rest);
}

//Pagos
$etiquetas_forma_pago= $forma_pago->etiquetas_forma_pago();
$datos_pagos =[];
foreach ($etiquetas_forma_pago as $key => $pago) {
    $info = $reservacion->consultar_datos_pago($pago);
    array_push($datos_pagos,$info);

}
//Hospedaje
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
    "datos_pagos"=>$datos_pagos,
    "datos_ventas"=>$datos_ventas,
    "datos_ventas_rest"=>$datos_ventas_rest,
    "datos_rest"=>$datos_rest,

    "datos_abonos"=>$datos_abonos,
    "datos_cargos"=>$datos_cargos,

    //etiquetas
    "etiquetas_hospedaje"=>$etiquetas_hospedaje,
    "etiquetas_forma_pago" => $etiquetas_forma_pago,
];

echo json_encode($datos_visit);