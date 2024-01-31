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
  $nombre= $hab->nombre;
  $faltante= 0;//$_POST['faltante']
  if($_POST['forma_pago'] == 2){
    $factuar= 1;
  }else{
    $factuar= 0;
  }
  if($_POST['forma_pago'] == 1){
    $efectivo_pago= 1;
  }else{
    $efectivo_pago= 0;
  }
  // Guardamos el ticket del abono correspondiente y el log
  $tipo_cargo= 3; // Corresponde al cargo de hospedaje sin comida
  $resta= 0;
  $nombre_concepto= 'Abono de hospedaje';
  $cantidad= 1;
  $categoria= $hab->id;
  $nueva_etiqueta= $labels->obtener_etiqueta();
  $labels->actualizar_etiqueta();
  $comanda= $pedido_rest->saber_comanda($mov);
  $rest=0;
  if (urldecode($_POST['descripcion'])=="Abono restaurante"){
    $rest=1;
  }
  if($_POST['forma_pago'] == 1){
    $ticket_id= $ticket->guardar_ticket($mov,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['abono'],$_POST['abono'],0,0,0,0,$factuar,'','',$nueva_etiqueta,$resta,$comanda,0);
  }else{
    $ticket_id= $ticket->guardar_ticket($mov,$_POST['hab_id'],$_POST['usuario_id'],$_POST['forma_pago'],$_POST['abono'],0,0,$_POST['abono'],0,0,$factuar,'','',$nueva_etiqueta,$resta,$comanda,0,$rest);
  }
  $cuenta->guardar_cuenta($_POST['usuario_id'],$mov,urldecode($_POST['descripcion']),$_POST['forma_pago'],$faltante,$_POST['abono'],$ticket_id,$_POST['observaciones']);
  $concepto->guardar_concepto($ticket_id,$_POST['usuario_id'],$nombre_concepto,$cantidad,$_POST['abono'],($_POST['abono']*$cantidad),$efectivo_pago,$_POST['forma_pago'],$tipo_cargo,$categoria);
  // Imprimir ticket
  if($config->ticket_restaurante == 0){
    $ticket->cambiar_estado($ticket_id);
  }
  if($id_maestra==0){
    $logs->guardar_log($_POST['usuario_id'],"Agregar abono a la habitacion: ". $nombre);
  }else{
    require_once('clase_cuenta_maestra.php');
    $cm = new CuentaMaestra($id_maestra);
    $logs->guardar_log($_POST['usuario_id'],"Agregar abono a la cuenta maestra : ". $cm->nombre);
  }
  $logs->guardar_log($_POST['usuario_id'],"Agregar ticket con etiqueta: ". $nueva_etiqueta);
  echo $_POST['hab_id']."/".$_POST['estado']."/".$mov."/".$id_maestra;
?>
