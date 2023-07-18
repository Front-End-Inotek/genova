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
    case 0:// En habitacion disponible-edo.0 
        $id = $movimiento->guardar_limpieza($_POST['hab_id'],$_POST['usuario_id'],$_POST['usuario']);
        $hab->cambiohab($_POST['hab_id'],$id,3);
        $logs->guardar_log($_POST['usuario_id'],"Limpieza en habitacion: ". $hab->nombre);
        break;
    case 1:// En habitacion ocupada-edo.1 
        $motivo= 0;// No se cambia el motivo, manteniendo el motivo de reservar
        $movimiento->editar_estado_interno($hab->mov,1.2);
        $movimiento->editar_estado_limpieza($hab->mov,$_POST['usuario_id'],$_POST['usuario'],$motivo);
        $logs->guardar_log($_POST['usuario_id'],"Habitacion ocupada limpieza: ". $hab->nombre);
        break;
    case 2:// En habitacion sucia-edo.2 
        $motivo= 0;
        $movimiento->editar_estado_limpieza($hab->mov,$_POST['usuario_id'],$_POST['usuario'],$motivo);
        $hab->cambiohab($_POST['hab_id'],$hab->mov,3);
        $logs->guardar_log($_POST['usuario_id'],"Limpiar en habitacion: ". $hab->nombre);
        break;
    //uso casa
    case 8:
        $entrada = strtotime($_POST['fecha_entrada']);
        $salida = strtotime($_POST['fecha_salida']);
        $nombre_uso = $_POST['nombre'] . " " . $_POST['apellido'];
        $id = $movimiento->guardar_usocasa($_POST['hab_id'],$_POST['usuario_id'],$nombre_uso,$entrada,$salida);
        // $movimiento->editar_estado_usocasa($hab->mov,$_POST['usuario_id'],$nombre_uso,$_POST['fecha_entrada'],$_POST['fecha_salida']);
        $hab->cambiohab($_POST['hab_id'],$id,8);
        $logs->guardar_log($_POST['usuario_id'],"Uso casa  en habitacion: ". $hab->nombre);
        break;

    default:
        //echo "Estado indefinido";
  }
?>
