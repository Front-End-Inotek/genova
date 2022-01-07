<?php 
  include_once('clase_log.php');
  $logs = NEW Log(0);

  // Se cargan los datos necesarios
  $estado=$_REQUEST['estado'];
  $principal=$_REQUEST['principal'];
  $fondo=$_REQUEST['fondo'];
  $letra=$_REQUEST['letra'];

  // Se transforma el color hexadecimal a rgb en el estado 1 de ocupada
  if($estado == "estado1"){
    $t= 1;// Para que no tenga transparencia
    list($r, $g, $b) = sscanf($principal, "#%02x%02x%02x");
    $principal= "rgb(" . $r . ", " . $g . ", " . $b . ", " . $t . ")";

    list($r, $g, $b) = sscanf($fondo, "#%02x%02x%02x");
    $fondo= "rgb(" . $r . ", " . $g . ", " . $b . ", " . $t . ")";
  }

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
  fwrite($archivo,' padding: 0em 0px 0px 10px;');
  fwrite($archivo,"\n");
  if($estado != "estado1"){
    fwrite($archivo,' border-radius: 10px;');
  }else{
    fwrite($archivo,' border-radius: 10px 10px 100px 10px;');
  }
  fwrite($archivo,"\n");
  fwrite($archivo,'}');
  fwrite($archivo,"\n");

  fwrite($archivo,'.'.$estado.':hover{');
  fwrite($archivo,"\n");
  fwrite($archivo,' background-color:'.$fondo.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' color:'.$letra.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' padding: 0em 0px 0px 10px;');
  fwrite($archivo,"\n");
  if($estado != "estado1"){
    fwrite($archivo,' border-radius: 10px;');
  }else{
    fwrite($archivo,' border-radius: 10px 10px 100px 10px;');
  }
  fwrite($archivo,"\n");
  fwrite($archivo,'}');

  //echo "Se creo correctamente el archivo";
  $logs->guardar_log($_GET['usuario_id'],"Cambiar los colores del ". $estado);
  header("location:../inicio.php");
?>
