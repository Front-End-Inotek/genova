<?php

include_once('clase_reservacion.php');
$reservacion = new Reservacion(0);
// $fechas_consulta =json_decode($_GET['fechas']);

$fecha_entrada = $_GET['fecha_entrada'];
$fecha_salida = $_GET['fecha_salida'];
// $ultima_fecha = $_GET['ultima_fecha'];

$hab_id = $_GET['hab_id'];

// $hab_id = $_GET['hab_id'];

$resultado = $reservacion->comprobarFechaReserva($fecha_entrada,$fecha_salida,$hab_id);


// echo $resultado;

if($hab_id!=0){
    if($resultado <1){
        echo "<script>alert('Fecha de asignación inválida'); manejarReservacion(0);</script>";
    }else{
        echo "<script>alert('Fecha de asignación válida'); manejarReservacion(1);</script>";
    }
    
    
}

