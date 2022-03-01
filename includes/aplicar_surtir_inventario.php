<?php
	date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_inventario.php");
  include_once("clase_surtir.php");
  $logs = NEW Log(0);
  $inventario = NEW Inventario(0);
  $surtir = NEW Surtir(0);
  
  $id_reporte= $surtir->ultima_insercion();
  $id_reporte++;
  $consulta = $surtir->datos_surtir_inventario();
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_producto= $fila['id'];
      $surtir_id = $fila['ID'];
      $nombre = $fila['nombre'];  
      $cantidad = $fila['cantidad'];  
      $cantidad_inventario= $inventario->cantidad_inventario($id_producto);
      $cantidad_final= $cantidad_inventario + $cantidad;
      $nuevo_inventario= $inventario->editar_cantidad_inventario($id_producto,$cantidad_final);
      $ajustes= $surtir->ajustes_surtir($surtir_id,$id_reporte);
  }
  $logs->guardar_log($_GET['usuario_id'],"Aplicar surtir inventario");
?>
