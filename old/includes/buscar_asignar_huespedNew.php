<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  $a_buscar =urldecode($_GET['a_buscar']);
  $id_maestra=0;
  if(isset($_GET['id_maestra'])){
    $id_maestra=$_GET['id_maestra'];
  }
  $huesped->buscar_asignar_huespedNew($_GET['funcion'],$_GET['precio_hospedaje'],$_GET['total_adulto'],$_GET['total_junior'],$_GET['total_infantil'],$a_buscar,$id_maestra,$_GET['mov']);
?>