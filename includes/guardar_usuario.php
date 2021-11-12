<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $usuario= NEW Usuario(0);
  $logs = NEW Log(0);
  $usuario->guardar_usuario(urldecode($_POST['usuario']),$_POST['contrasena'],$_POST['nivel'],urldecode($_POST['nombre_completo']),urldecode($_POST['puesto']),urldecode($_POST['celular']),urldecode($_POST['correo']),urldecode($_POST['direccion']));
  $logs->guardar_log($_POST['id'],"Agregar usuario: ". urldecode($_POST['usuario']));
?>

