<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  include_once('clase_planes_alimentos.php');
  $cuenta= NEW Cuenta(0);
  // $reservacion = new Reservacion(0);

  $logs = NEW Log(0);
  $mensaje_log="Editar multiples cargos de habitacion:";
  // $reservacion->editar_cargos($_POST['datos_cargos']);

  $cargos = json_decode($_POST['datos_cargos']);
  // print_r($cargos);
  // die();
  $forzar_tarifa=0;
  $total=0;
  $costo_plan = 0;
  $usuario_id =$_POST['usuario_id'];
  $descripcion="Cargo por noche";
 
  //Se necesita recalcular el total de pago de esa reservación con la 'nueva tarifa', seria como forzar la tarifa.
  //Para ello se necesita obtener la info de dicha reservación para volver a calcular precios, etc.
  //Buscar en la BD el id correspondiente a efectivo.
  $forma_pago = $cuenta->obtener_id_pago();

  foreach ($cargos as $key => $cargo) {
      $reservacion = new Reservacion($cargo->reservaid);
      // print_r($reservacion);
      $forzar_tarifa = $cargo->valor;
      $mov = $reservacion->saber_id_movimiento_($reservacion->id);

      if($forzar_tarifa==0){
        $total_aux =$reservacion->precio_hospedaje;
        $reservacion->editar_tarifa_hab_aud($reservacion->id);
        $cuenta->guardar_cuenta($usuario_id,$mov,$descripcion,$forma_pago,$total_aux,0);
      }else{
        $reservacion->editar_tarifa_hab($forzar_tarifa,$reservacion->id);
      }


  //   $sentencia = "UPDATE `reservacion` SET
  //   `total` = '$cargo->valor'
  //   WHERE `id` = '$cargo->reservaid';";
  //   // echo $sentencia ;
  //   $comentario="Editar el cargo de una cuenta dentro de la base de datos";
  //   $consulta= $this->realizaConsulta($sentencia,$comentario);
  }

  $logs->guardar_log($_POST['usuario_id'],$mensaje_log);
//   echo $_POST['hab_id']."/".$_POST['estado']."/".$_POST['mov']."/".$_POST['id_maestra'];
?>
