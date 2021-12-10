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
        $logs->guardar_log($_POST['usuario_id'],"Cambiar persona que realiza la limpieza por: ". $hab->nombre);
        break;
    case 4:// En habitacion limpieza-edo.3 ////--
        $movimiento->editar_persona_limpio($hab->mov,$_POST['usuario']);
        $logs->guardar_log($_POST['usuario_id'],"Cambiar persona que realiza la limpieza por: ". $hab->nombre);
        break;
    default:
        //echo "Estado indefinido";
  }
?>
