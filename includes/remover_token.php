<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_usuario.php");
  $usuario =$_POST["usuario"];
  $users = NEW Usuario(0);
  $users->remover_token($usuario);

?>
