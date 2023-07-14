<?php

include_once('clase_reservacion.php');

$reservacion = new Reservacion(0);

$info_ocupadas = $reservacion->consultar_ocupacion_mes();

while ($fila = mysqli_fetch_array($info_ocupadas)) {

    // $inicio = $fila['fecha_entrada']

}

$datos_ocupadas=[30, 150, 60, 80, 90, 89, 33,8,8,55,200];


$datos_visit = [
    "datos_ocupadas" => $datos_ocupadas
];

echo json_encode($datos_visit);