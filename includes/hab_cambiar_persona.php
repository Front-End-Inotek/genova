<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $logs = NEW Log(0);

  switch($_POST['estado']){
    case 3:// En habitacion limpieza-edo.3
        $movimiento->editar_persona_limpio($hab->mov,$_POST['usuario']);
        $logs->guardar_log($_POST['usuario_id'],"Cambiar persona que realiza la limpieza por usuario: ". $hab->nombre);
        break;
    case 4:// En habitacion mantenimiento-edo.4 
        $movimiento->editar_detalle_realiza($hab->mov,$_POST['usuario']);
        $logs->guardar_log($_POST['usuario_id'],"Cambiar persona que realiza el mantenimiento por usuario: ". $hab->nombre);
        break;
    case 5:// En habitacion supervision-edo.5 
        $movimiento->editar_detalle_realiza($hab->mov,$_POST['usuario']);
        $logs->guardar_log($_POST['usuario_id'],"Cambiar persona que realiza la supervision por usuario: ". $hab->nombre);
        break;
    default:
        //echo "Estado indefinido";
  }
?>
