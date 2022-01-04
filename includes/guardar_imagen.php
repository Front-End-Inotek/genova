<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_configuracion.php');
  include_once("clase_movimiento.php");
  include_once('clase_log.php');
  $config = NEW Configuracion();
  $logs = NEW Log(0);
  $movimiento= NEW Movimiento(0);
  
  $target_path = "../images/login/";
  $nombre_foto = $_FILES['uploadedfile']['name'];
  $tipo_foto = $_FILES['uploadedfile']['type'];
  $tamagno_foto = $_FILES['uploadedfile']['size'];
  
  $tipo = $tipo_foto;
  $tipo = substr($tipo, 6);
  $nombre="picturevisit".$movimiento->ultima_insercion().'.'.$tipo;
  $target_path = $target_path . $nombre; 

  if(((strpos($tipo_foto, "jpeg") || strpos($tipo_foto, "jpg")) || strpos($tipo_foto, "png")))
  {
    // Ruta de la carpeta destino en servidor
    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)){
      chmod($target_path, 0777);
      $logs->guardar_log($_GET['usuario_id'],"Cambiar foto de inicio");
      $config->guardar_foto($nombre);
      //header("location:../includes/cambiar_imagen.php"); 
      header("location:../inicio.php");
    }else{
      echo'<script type="text/javascript">
            //localStorage.setItem("error","Ha ocurrido un error, ¡trate de nuevo!");
            alert("Ha ocurrido un error, ¡trate de nuevo!");
            window.location.href="../inicio.php";
           </script>';
    }
  }else{
    //$("#area_trabajo_menu").load("includes/cambiar_imagen.php");
    echo'<script type="text/javascript">
          alert("Solo se pueden subir fotos jpeg/jpg/png");
          window.location.href="../inicio.php";
         </script>';
  }
?>

