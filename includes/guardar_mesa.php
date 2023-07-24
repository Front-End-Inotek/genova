<?php

include_once('informacion_mesas.php');
include_once('clase_movimiento.php');

$info_mesa = new Informacion_mesas();

$nombre = $_POST['nombre'];
$comentario=$_POST['comentario'];
$capacidad=$_POST['capacidad'];
$mov=0;
// $mov= new Movimiento();

// $mov->disponible_asignar();

$info_mesa->guardar_mesa($nombre,$comentario,$capacidad,$mov);

