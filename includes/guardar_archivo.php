<?php 
  include_once('clase_log.php');
  $logs = NEW Log(0);

  // Se cargan los datos necesarios
  $estado=$_REQUEST['estado'];
  $principal=$_REQUEST['principal'];
  $fondo=$_REQUEST['fondo'];
  $letra=$_REQUEST['letra'];

  // Se comprueba si existe el archivo previamente antes de generarlo
  if(!file_exists('../styles/'.$estado.'.css')){
    //echo "Existio un problema borrando el archivo";
  }else{
    //echo "Archivo borrado con exito";
    unlink('../styles/'.$estado.'.css');
  }
  // Se genera el archivo de css
  $archivo=fopen('../styles/'.$estado.'.css','a') or die ('Error al crear');

  fwrite($archivo,'.'.$estado.'{');
  fwrite($archivo,"\n");
  fwrite($archivo,' background-color:'.$principal.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' color:'.$letra.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' padding: 0em 10px 0px 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,' border-radius: 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,'}');
  fwrite($archivo,"\n");

  fwrite($archivo,'.'.$estado.':hover{');
  fwrite($archivo,"\n");
  fwrite($archivo,' background-color:'.$fondo.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' color:'.$letra.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' padding: 0em 10px 0px 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,' border-radius: 10px;');
  fwrite($archivo,"\n");
  fwrite($archivo,'}');

  //echo "Se creo correctamente el archivo";
  $logs->guardar_log($_GET['usuario_id'],"Cambiar los colores del ". $estado);
  header("location:../inicio.php");
?>
