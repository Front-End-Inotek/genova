<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_usuario.php");
  $token=0;
  $usuario =$_POST["usuario"];
  $password =md5($_POST["password"]); 
  $users = NEW Usuario(0);
  // se evalua si existe y son validas las credenciales
  $id=$users->evaluarEntrada($usuario,$password);
  

  if($id>0){
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

  echo $id.'-'.$token;
?>
