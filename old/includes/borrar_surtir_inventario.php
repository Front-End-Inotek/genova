<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_surtir.php");
  $surtir = NEW Surtir(0);
  $surtir->borrar_surtir($_POST['id']);
?>
