<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
 
  switch ($_POST['estado']) {
    case 2:// En habitacion sucia-edo.2 
        $movimiento->editar_detalle_fin($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado sucio de la habitacion: ". $hab->nombre);
        break;
    default:
        //echo "Estado indefinido";
  }
?>
