<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte.php");
  include_once("clase_corte_info.php");
  include_once("clase_log.php");
  $labels= NEW Labels(0);
  $forma_pago= NEW Forma_pago(0);
  $corte= NEW Corte(0);
  $inf= NEW Corte_info($_POST['usuario_id']);
  $logs = NEW Log(0);

  // Guardar corte
  $cantidad_habitaciones= $inf->total_hab;
  $total_habitaciones= $inf->total_hab;
  $restaurante= $inf->total_restaurante;
  $total= $inf->total_global;
  $cantidad= $forma_pago->total_elementos();
  $pago= array();
  $cantidad= $cantidad + 1;
  for($z=1 ; $z<$cantidad; $z++)
  {
    $pago[$z-1]= $inf->total_pago[$z-1];
  }
  $nueva_etiqueta= $labels->obtener_corte();
  $labels->actualizar_etiqueta_corte();
  $corte_id= 2;//$corte->guardar_corte($_POST['usuario_id'],$nueva_etiqueta,$total,$pago[0],$pago[1],$pago[2],$pago[3],$pago[4],$pago[5],$pago[6],$pago[7],$pago[8],$pago[9],$cantidad_habitaciones,$total_habitaciones,$restaurante);

  // Guardar log
  $logs->guardar_log($_POST['usuario_id'],"Hacer corte con etiqueta: ". $nueva_etiqueta);
?>
