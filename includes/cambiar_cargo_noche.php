<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $hab= NEW Hab(0);
  $logs = NEW Log(0);
  $hab->cambiar_cargo_noche($_POST['id'],$_POST['cargo_noche']);
  //$logs->guardar_log($_GET['usuario_id'],"Cambio habitacion: ". $_POST['id'].' - '.$_POST['cargo_noche']);
?>
