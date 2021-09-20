<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_usuario.php");
  include ("clase_log.php");
  $token=0;
  $usuario =$_POST["usuario"];
  $password =md5($_POST["password"]); 
  $users = NEW Usuario(0);
  $logs = NEW Log(0);
  $id=$users->evaluarEntrada($usuario ,$password);
  if($id>0){
	  $timepo = time();
	  $token = hash('sha256', $timepo.$usuario.$password);
	  $users->guardar_token($token,$id);
	  $logs->guardar_log($id , "Inicio de sesion" );
  }

  echo $id.'-'.$token;
?>
