<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_usuario.php");
  $token=0;
  $usuario_id =$_POST["usuario_id"];
  $password =md5($_POST["password"]); 
  $users = NEW Usuario(0);
  // se evalua si existe y son validas las credenciales
  $respuesta=0;
  $id=$users->evaluar_password($usuario_id,$password);
 
if($id != 0) {
    include_once("clase_huesped.php");
    $huesped_id = $_POST['huesped_id'];
    $huesped = new Huesped($huesped_id);

    $respuesta= $huesped->numero_tarjeta;


}
echo $respuesta;
?>
