<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab(0);
  $hab->cambiar_cargo_noche($_POST['id'],$_POST['cargo_noche']);
?>
