<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_ticket.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_POST['hab_id']);
  $labels= NEW Labels(0);
  $ticket= NEW Ticket(0);
  $logs = NEW Log(0);
  $mov= $hab->mov;
  $nombre= $hab->nombre;
  $faltante= 0;//$_POST['faltante']
  if($_POST['forma_pago'] == 2){
    $factuar= 1;
  }else{
      $factuar= 0;
  }
  $cuenta->guardar_cuenta($_POST['usuario_id'],$mov,urldecode($_POST['descripcion']),$_POST['forma_pago'],$faltante,$_POST['abono']);
  
  // Guardamos el ticket del abono correspondiente y el log
  $nueva_etiqueta= $labels->obtener_etiqueta();
  $labels->actualizar_etiqueta();
  $ticket_id= $ticket->guardar_ticket($mov,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['abono'],$_POST['abono'],0,$_POST['abono'],0,0,$factuar,'','',$nueva_etiqueta);
  $logs->guardar_log($_POST['usuario_id'],"Agregar abono a la habitacion: ". $nombre);
  echo $_POST['hab_id']."/".$_POST['estado'];
?>
