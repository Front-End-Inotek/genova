<?php 
  include_once('clase_configuracion.php');
  include_once('clase_log.php');
  $config = NEW Configuracion();
  $logs = NEW Log(0);

  // Se cargan los datos necesarios
  $nombre= $_REQUEST['nombre'];
  $color_fondo= $_REQUEST['fondo'];
  $encabezado= $_REQUEST['encabezado'];
  $fondo= 'fondo';
  $body= 'body';
  $topnav= 'topnav';

  // Checar si el nombre esta vacio o no
  /*if (empty($nombre) || $nombre == ''){
      //echo 'La variable esta vacia';
      $nombre=  'Sin nombre';
  }else{
      // Se conserva el nombre que se paso
  }*/

  // Se comprueba si existe el archivo previamente antes de generarlo
  if(!file_exists('../styles/'.$fondo.'.css')){
    //echo "Existio un problema borrando el archivo";
  }else{
    //echo "Archivo borrado con exito";
    unlink('../styles/'.$fondo.'.css');
  }
  // Se genera el archivo de css
  $archivo=fopen('../styles/'.$fondo.'.css','a') or die ('Error al crear');

  fwrite($archivo,$body.'{');
  fwrite($archivo,"\n");
  fwrite($archivo,' overflow-x: hidden;');
  fwrite($archivo,"\n");
  fwrite($archivo,' background-color:'.$color_fondo.';');
  fwrite($archivo,"\n");
  fwrite($archivo,'}');
  fwrite($archivo,"\n");

  fwrite($archivo,'.'.$topnav.'{');
  fwrite($archivo,"\n");
  fwrite($archivo,' background-color:'.$encabezado.';');
  fwrite($archivo,"\n");
  fwrite($archivo,' overflow: hidden;');
  fwrite($archivo,"\n");
  fwrite($archivo,'}');

  //echo "Se creo correctamente el archivo";
  $config->guardar_nombre($nombre);
  $logs->guardar_log($_GET['usuario_id'],"Cambiar los colores del ". $fondo);
  header("location:../inicio.php");
?>

