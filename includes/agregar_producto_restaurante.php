<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once('clase_log.php');
  $pedido_rest=NEW Pedido_rest(0);
  $logs = NEW Log(0);
  $categoria= 0;
  $pedido_rest->agregar_producto_apedido($_POST['hab_id'],$_POST['estado'],$_POST['producto'],$_POST['mov']);// mov 0 x ser sin hab
  //$pedido->mostar_pedido($_POST['hab_id'],$_POST['estado'],$_POST['mov']);// mov y hab son 0 al ser sin hab
  //$logs->guardar_log($_POST['usuario_id'],"Asignar el producto a restaurante: ". $_POST['producto']);
  if($_POST['mov'] == 0){
    if($_POST['producto'] != -1){
      echo $_POST['categoria']."/".$_POST['hab_id']."/".$_POST['estado']."/".$_POST['mesa'];
    }else{
      echo $categoria."/".$_POST['hab_id']."/".$_POST['estado']."/".$_POST['mesa'];
    }
  }else{
    echo $_POST['hab_id']."/".$_POST['estado'];
  }
?>

