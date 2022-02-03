<?php
	date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once('clase_tarifa.php');
  $logs = NEW Log(0);
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab(0);
  $huesped= NEW Huesped(0);
  $tarifa= NEW Tarifa(0);
  
  $total_final= 0;
  $descripcion= "Cargo por noche";
  $consulta = $hab->datos_cargo_noche();
  // Revisamos el total de cargo por habitacion
  while ($fila = mysqli_fetch_array($consulta))
  {
    $hab_id = $fila['ID'];
    $extra_adulto = $fila['extra_adulto'];
    $extra_junior = $fila['extra_junior'];
    $extra_infantil = $fila['extra_infantil'];
    $id_tarifa = $fila['tarifa'];
    $descuento = $fila['descuento'];
    $mov = $fila['mov'];

    $nombre_tarifa= $tarifa->obtengo_nombre($id_tarifa);
    $total_tarifa= $tarifa->obtengo_tarifa_dia($id_tarifa,$extra_adulto,$extra_junior,$extra_infantil,$descuento);
    $total_final= $total_final + $total_tarifa;
    $cuenta->guardar_cuenta($_POST['usuario_id'],$mov,$descripcion,0,$total_tarifa,0);
  }

  $logs->guardar_log($_POST['usuario_id'],"Aplicar cargo por noche en las habitaciones");
?>
