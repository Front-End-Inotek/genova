<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_log.php");
  $huesped= NEW Huesped(0);
  $logs = NEW Log(0);
  $huesped->editar_huesped($_POST['id'],urldecode($_POST['nombre']),urldecode($_POST['apellido']),urldecode($_POST['direccion']),urldecode($_POST['ciudad']),urldecode($_POST['estado']),urldecode($_POST['codigo_postal']),urldecode($_POST['telefono']),urldecode($_POST['correo']),urldecode($_POST['contrato']),urldecode($_POST['cupon']),urldecode($_POST['preferencias']),urldecode($_POST['comentarios']),urldecode($_POST['titular_tarjeta']),urldecode($_POST['tipo_tarjeta']),urldecode($_POST['numero_tarjeta']),urldecode($_POST['vencimiento_mes']),urldecode($_POST['vencimiento_ano']),urldecode($_POST['cvv']));
  $logs->guardar_log($_POST['usuario_id'],"Editar huesped: ". $_POST['id']);
?>
