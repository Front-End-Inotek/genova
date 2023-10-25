<?php

include 'datos_servidor.php'; //conexion con la base de datos
include("clase_factura.php");
$fact = NEW factura ();
$resultado2=$fact->folio();
$row2=mysqli_fetch_array($resultado2);

$numfolio =$row2[0];

header("Location: ../facturas/{$numfolio}_cfdi_factura.xml");



?>