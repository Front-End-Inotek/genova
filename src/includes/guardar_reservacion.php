<?php
$datosJSON = file_get_contents('php://input');

// Decodificar los datos JSON en un array PHP
$datos = json_decode($datosJSON, true);

$id = $datos['id'];
$nombre = $datos['nombre'];
$apellido = $datos['apellido'];
$correo = $datos['correo'];
$llegada = strtotime($datos['llegada']);
$salida = strtotime($datos['salida']);
$telefono = $datos['telefono'];
$huespedes = $datos['huespedes'];
$tarifa = $datos['tarifa'];




echo $nombre . ", " . $apellido . $correo . $llegada . $salida . $telefono. $huespedes . $tarifa . $id ;