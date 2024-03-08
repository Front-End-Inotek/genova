<?php

include_once("clase_movimiento.php");
include_once("clase_hab.php");
include_once('clase_log.php');

$hab_id = $_POST["hab_id"];
$usuario_id = $_POST["usuario"];

$logs = NEW Log(0);
$hab = NEW Hab($hab_id);
$movimiento = NEW Movimiento(0);


$hab->reactivarHab( $hab_id);

?>