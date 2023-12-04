<?php

if(!isset($_POST['usuario_id']) && empty($_POST['usuario'])){
    return "NO";
}
include_once("clase_movimiento.php");
include_once("clase_reservacion.php");


$reservacion = new Reservacion(0);
$movimiento = new Movimiento(0);
$id_mov = $_POST['id_mov'];

$id_reserva= $reservacion->duplicar($_POST['id_reserva']);
$movimiento->duplicar($id_mov,$id_reserva);

echo "OK";