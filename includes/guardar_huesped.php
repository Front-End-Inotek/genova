<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  $huesped->guardar_huesped(urldecode($_POST['nombre']),urldecode($_POST['apellido']),urldecode($_POST['direccion']),urldecode($_POST['ciudad']),urldecode($_POST['estado']),urldecode($_POST['codigo_postal']),urldecode($_POST['telefono']),urldecode($_POST['correo']),urldecode($_POST['preferencias']),urldecode($_POST['comentarios']));
?>

