<?php
	include_once("clase_movimiento.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $hab = NEW Hab($_POST['hab_id']);
  $hab->cambiohabUltimo($hab->id);
  $logs = NEW Log(0);
  $movimiento->editar_detalle_inicio($hab->mov);
  $movimiento->editar_estado_interno($hab->mov,1.1);
  $estado == 'estado1';
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

  if($estado == "estado1"){
    // Se comprueba si existe el archivo previamente antes de generarlo
    if(!file_exists('../styles/'.$subestados.'.css')){
      //echo "Existio un problema borrando el archivo";
    }else{
      //echo "Archivo borrado con exito";
      unlink('../styles/'.$subestados.'.css');
    }
    // Se genera el archivo de css
    $archivo=fopen('../styles/'.$subestados.'.css','a') or die ('Error al crear');

    fwrite($archivo,'.'.$sin.'{');
    fwrite($archivo,"\n");
    fwrite($archivo,' background-color:'.$rack.';');
    fwrite($archivo,"\n");
    fwrite($archivo,' padding: 0em 0px 0px 0px;');
    fwrite($archivo,"\n");
    fwrite($archivo,' border-radius: 10px;');
    fwrite($archivo,"\n");
    fwrite($archivo,'}');
    fwrite($archivo,"\n");

    fwrite($archivo,'.'.$sucia.'{');
    fwrite($archivo,"\n");
    fwrite($archivo,' background-color:'.$sub_sucia.';');
    fwrite($archivo,"\n");
    fwrite($archivo,' padding: 0em 0px 0px 0px;');
    fwrite($archivo,"\n");
    fwrite($archivo,' border-radius: 10px;');
    fwrite($archivo,"\n");
    fwrite($archivo,'}');
    fwrite($archivo,"\n");

    fwrite($archivo,'.'.$limpieza.'{');
    fwrite($archivo,"\n");
    fwrite($archivo,' background-color:'.$sub_limpieza.';');
    fwrite($archivo,"\n");
    fwrite($archivo,' padding: 0em 0px 0px 0px;');
    fwrite($archivo,"\n");
    fwrite($archivo,' border-radius: 10px;');
    fwrite($archivo,"\n");
    fwrite($archivo,'}');
    fwrite($archivo,"\n");
  }

  //echo "Se creo correctamente el archivo";
  $logs->guardar_log($_GET['usuario_id'],"Cambiar los colores del ". $estado);
  header("location:../inicio.php");
  $logs->guardar_log($_POST['usuario_id'],"Habitacion ocupada sucia: ". $hab->nombre);
?>
