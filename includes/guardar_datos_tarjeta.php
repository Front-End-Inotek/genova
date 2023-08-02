<?php
date_default_timezone_set('America/Mexico_City');

include_once("clase_huesped.php");
$huesped= NEW Huesped(0);

if(empty($_POST['huesped_id'])){
    echo "NO_valido";
    die();
}

$huesped->guardar_tarjeta($_POST['huesped_id'],$_POST);