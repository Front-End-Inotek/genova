<?php

if(!isset($_POST['usuario_id']) && empty($_POST['usuario'])){
    return "NO";
}
include_once("clase_movimiento.php");
include_once("clase_reservacion.php");

$movimiento = new Movimiento(0);
$id_mov = $_POST['id_mov'];

$hecho = $movimiento->cancelar_preasignada($id_mov);

if($hecho){
    echo "OK";
}else{
    echo "No";
}