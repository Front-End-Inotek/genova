<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_usuario.php");
  $token=0;
  $usuario =$_POST["usuario"];
  $password =md5($_POST["password"]); 
  $users = NEW Usuario(0);
  // se evalua si existe y son validas las credenciales

  $entrada = $users->evaluarEntrada($usuario,$password);
  $id=$entrada[0];
  $nivel=$entrada[1];
  if($id>0){
    session_start();
    $_SESSION['auth']=true;
    //se evalua si ya existe un token.
    /*
    $existe_token = $users->evaluarToken($id);
    if($existe_token>0){
    }else{*/
      $timepo = time();
      $token = hash('sha256', $timepo.$usuario.$password);
      $users->guardar_token($token,$id);
    /*}*/
  }

  echo $id.'-'.$token."-".$nivel;
?>
