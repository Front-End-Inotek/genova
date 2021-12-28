<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);
  /*if($_POST['estado']>0){
    $movimiento->editar_detalle_fin($hab->mov);
    $movimiento->editar_persona_limpio($hab->mov,$_POST['usuario']);
  }*/

  switch($_POST['estado']){
    case 4:// Enviar a mantenimiento 
        $id = $movimiento->guardar_comentario($_POST['hab_id'],$_POST['usuario_id'],$_POST['usuario'],$_POST['estado'],urldecode($_POST['motivo']));
        $hab->cambiohab($_POST['hab_id'],$id,4);
        $logs->guardar_log($_POST['usuario_id'],"Mantenimiento en habitacion: ". $hab->nombre);
        break;
    case 5:// Enviar a supervision
        $motivo= '';
        $id = $movimiento->guardar_comentario($_POST['hab_id'],$_POST['usuario_id'],$_POST['usuario'],$_POST['estado'],$motivo);
        $hab->cambiohab($_POST['hab_id'],$id,5);
        $logs->guardar_log($_POST['usuario_id'],"Supervision en habitacion: ". $hab->nombre);
        break;
    case 6:// Enviar a
        $id = $movimiento->guardar_comentario($_POST['hab_id'],$_POST['usuario_id'],$_POST['usuario_id'],$_POST['estado'],urldecode($_POST['motivo']));
        $hab->cambiohab($_POST['hab_id'],$id,6);
        $logs->guardar_log($_POST['usuario_id'],"Cancelar la habitacion: ". $hab->nombre);
        break;
    default:
        //echo "Estado indefinido";
        break;
  }
?>
