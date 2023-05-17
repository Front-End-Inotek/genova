<?php

include_once('clase_reservacion.php');
$reservacion = new Reservacion(0);
// $fechas_consulta =json_decode($_GET['fechas']);

$fecha_entrada = $_GET['fecha_entrada'];
$fecha_salida = $_GET['fecha_salida'];
// $ultima_fecha = $_GET['ultima_fecha'];
$hab_id = $_GET['hab_id'];

$resultado = $reservacion->comprobarFechaReserva($fecha_entrada,$fecha_salida,$hab_id);

//Lógica para reservaciones
if(is_array($resultado)){
    if($resultado[0]==1){
        //Habilitar checkbox de sobrevender.
        echo "<script>document.getElementById('sobrevender').disabled= false; </script>";
        
    }
    echo $resultado[1];
}

//Lógica para checkin
// echo $resultado;
if($hab_id!=0){
    if($resultado <1){
        echo "<script>alert('Fecha de asignación inválida'); manejarReservacion(0);</script>";
    }else{
        echo "<script>alert('Fecha de asignación válida'); manejarReservacion(1);</script>";
    }
    
    
}

