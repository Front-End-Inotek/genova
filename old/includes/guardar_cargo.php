<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_configuracion.php');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $config = NEW Configuracion();
  $cuenta= NEW Cuenta(0);
  $concepto= NEW Concepto(0);
  $hab= NEW Hab($_POST['hab_id']);
  $pedido_rest= NEW Pedido_rest(0);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs = NEW Log(0);
  $mov= $hab->mov;
  $id_maestra=0;
  if(isset($_POST['mov'])){
    if($_POST['mov']!=0){
      $mov = $_POST['mov'];
    }
  }
  if(isset($_POST['id_maestra'])){
    if($_POST['id_maestra']!=0){
      $id_maestra = $_POST['id_maestra'];
    }
  }
  //Buscar en la BD el id correspondiente a efectivo.
  $forma_pago = $cuenta->obtener_id_pago();
  $nombre= $hab->nombre;
  $faltante= 0;//$_POST['faltante']
  $cuenta->guardar_cuenta($_POST['usuario_id'],$mov,urldecode($_POST['descripcion']),$forma_pago,$_POST['cargo'],$faltante);
  $logs->guardar_log($_POST['usuario_id'],"Agregar cargo hab: ". $_POST['hab_id']  ." usuario: " .$_POST['usuario_id']);
  echo $_POST['hab_id']."/".$_POST['estado']."/".$mov."/".$id_maestra;
?>
