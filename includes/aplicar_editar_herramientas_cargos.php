<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_log.php");
  $cuenta= NEW Cuenta(0);
  $logs = NEW Log(0);
  $mensaje_log="Editar multiples cargos de habitacion:";
  $cuenta->editar_cargos($_POST['datos_cargos']);
  $logs->guardar_log($_POST['usuario_id'],$mensaje_log);
//   echo $_POST['hab_id']."/".$_POST['estado']."/".$_POST['mov']."/".$_POST['id_maestra'];
?>
