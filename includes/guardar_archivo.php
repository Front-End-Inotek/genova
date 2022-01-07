<?php 
  include_once('clase_log.php');
  $logs = NEW Log(0);

  // Se cargan los datos necesarios
  $estado=$_REQUEST['estado'];
  $rack=$_REQUEST['rack'];
  $hover=$_REQUEST['hover'];
  $letra=$_REQUEST['letra'];
  $subestado=$_REQUEST['subestado'];
  $subcolor=$_REQUEST['subcolor'];

  // Se transforma el color hexadecimal a rgb en el estado 1 de ocupada
  if($estado == "estado1"){
    $t= 1;// Para que no tenga transparencia
    list($r, $g, $b) = sscanf($rack, "#%02x%02x%02x");
    $rack= "rgb(" . $r . ", " . $g . ", " . $b . ", " . $t . ")";

    list($r, $g, $b) = sscanf($hover, "#%02x%02x%02x");
    $hover= "rgb(" . $r . ", " . $g . ", " . $b . ", " . $t . ")";
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
  fwrite($archivo,' background-color:'.$rack.';');
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
  fwrite($archivo,' background-color:'.$hover.';');
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
