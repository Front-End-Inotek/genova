<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento= NEW Movimiento(0);
  $hab= NEW Hab($_POST['hab_id']);
  $logs= NEW Log(0);
 
  switch($_POST['estado']){
    case 2:// En habitacion sucia-edo.2 
        $movimiento->editar_detalle_fin($hab->mov);
        $movimiento->editar_liberacion($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado sucio de la habitacion: ". $hab->nombre);
        break;
    case 3:// En habitacion limpieza-edo.3 
        $movimiento->ditar_fin_limpieza($hab->mov);
        $movimiento->editar_liberacion($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado limpieza de la habitacion: ". $hab->nombre);
        break;
    default:
        //echo "Estado indefinido";
  }
?>
