<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once ("clase_usuario.php");
  include_once("clase_log.php");
  $concepto = NEW Concepto(0);
  $usuario = NEW Usuario(0);
  $logs = NEW Log(0);

	$usuario_entrada= urldecode($_POST["usuario"]);
	$contrasena= md5($_POST["contrasena"]); 
	$id= $usuario->evaluar_datos($usuario_entrada,$contrasena);
  if($id >= 1){
    $concepto->editar_concepto($_POST["producto"],$_POST["cantidad"],$_POST["precio"]);
    $logs->guardar_log($_POST['id'],"Se edito el concepto de ticket: ".$_POST["producto"]);
	}
  echo $_POST['mesa_id']."/".$_POST['estado']."/".$id."/".$_POST['producto']."/".$_POST['cantidad']."/".$_POST['precio'];
?>
