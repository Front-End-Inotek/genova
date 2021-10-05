<?php
  date_default_timezone_set('America/Mexico_City');
  include ("informacion.php");
  $saber = NEW Informacion();
  $saber->mostrarhab($_GET['id'],$_GET['token']);//categoria
?>
