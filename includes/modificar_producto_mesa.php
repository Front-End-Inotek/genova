<?php
  date_default_timezone_set('America/Mexico_City');
	include ("informacion.php");
  include_once("clase_mesa.php");
  include_once("clase_ticket.php");
  include_once("clase_inventario.php");
  //include_once('log.php');
  $saber = NEW Informacion();
  $mesa = NEW Mesa($_POST['mesa_id']);
  $ticket= NEW Ticket();
  $inv = NEW Inventario();
  //$logs = NEW Log(0);
	$usuario= urldecode($_POST["usuario"]);
	$password= md5($_POST["contrasena"]); 
	$id= $saber->evaluar_datos($usuario,$password);
  if($id >= 1){
    if($_POST['mesa_id'] != 0){
      $ticket->editar_concepto($_POST["producto"],$_POST["cantidad"],$_POST["precio"]);
      //$logs->guardar_log($_POST['id'],"Se edito el concepto de ticket: ".$_POST["producto"]);
    }else{
      $inv->editar_producto_apedido($_POST["cantidad"],$_POST["producto"]);
      //$logs->guardar_log($_POST['id'],"Se edito el concepto de comanda: ".$_POST["producto"]);
    }
	}
  echo $_POST['mesa_id']."/".$_POST['estado']."/".$id."/".$_POST['producto']."/".$_POST['cantidad']."/".$_POST['precio'];
?>
