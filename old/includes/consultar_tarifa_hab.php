<?php
include_once('clase_tarifa.php');
$tarifa = new Tarifa(0);
$tipo_hab = $_GET['tipo_hab'];
echo "<option value=''>Seleccionar una tarifa</option>";

$resultado = $tarifa->mostrar_tarifas($tipo_hab);


