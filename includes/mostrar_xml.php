<?php

include 'datos_servidor.php'; //conexion con la base de datos

$consulta2="SELECT folio FROM facturas ORDER BY id DESC LIMIT 1 ";
$resultado2=mysqli_query($con,$consulta2);
$row2=mysqli_fetch_array($resultado2);

$numfolio =$row2[0];

header("Location: ../facturas/{$numfolio}_cfdi_factura.xml");



?>