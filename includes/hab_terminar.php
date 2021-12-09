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
        $movimiento->editar_fin_limpieza($hab->mov);
        $movimiento->editar_liberacion($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado limpieza de la habitacion: ". $hab->nombre);
        break;
    case 4:// En habitacion mantenimiento-edo.4 
        $movimiento->editar_detalle_fin($hab->mov);
        $movimiento->editar_liberacion($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado mantenimiento de la habitacion: ". $hab->nombre);
        break;     
    case 5:// En habitacion supervision-edo.5 
        $movimiento->editar_detalle_fin($hab->mov);
        $movimiento->editar_liberacion($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado supervision de la habitacion: ". $hab->nombre);
        break;
    case 6:// En habitacion cancelada-edo.6 
        $movimiento->editar_detalle_fin($hab->mov);
        $movimiento->editar_liberacion($hab->mov);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,0);
        $logs->guardar_log($_POST['usuario_id'],"Terminar estado cancelada de la habitacion: ". $hab->nombre);
        break;  
    default:
        //echo "Estado indefinido";
        break; 
  }
?>
