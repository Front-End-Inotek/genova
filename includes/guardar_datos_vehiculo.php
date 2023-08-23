<?php
//var_dump($_POST);
if(empty($_POST['usuario_id'] || empty($_POST['matricula'])) || empty($_POST['id_huesped'])){
    echo "NO";
    die();
}
include_once('clase_huesped.php');
include_once('clase_log.php');
$huesped = new Huesped(0);

if(sizeof($huesped->existe_vehiculo($_POST['id_huesped'],$_POST['id_reserva'])) <= 0){
    $huesped->guardar_datos_vehiculo($_POST);
}else{
    $huesped->actualizar_datos_vehiculo($_POST);
}

