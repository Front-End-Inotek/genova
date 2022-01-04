<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_fotos_cotizacion.php");
  include_once('clase_log.php');
  $fotos_cotizacion= NEW Fotos_cotizacion(0);
  $logs = NEW Log(0);
  
  $target_path = "../images/imagenes_cotizacion/";
  $nombre_foto = $_FILES['uploadedfile']['name'];
  $tipo_foto = $_FILES['uploadedfile']['type'];
  $tamagno_foto = $_FILES['uploadedfile']['size'];
  
  $tipo = $tipo_foto;
  $tipo = substr($tipo, 6);
  $nombre="picturescrew".$fotos_cotizacion->saber_ultima().'.'.$tipo;
  $target_path = $target_path . $nombre; 

  if(((strpos($tipo_foto, "jpeg") || strpos($tipo_foto, "jpg")) || strpos($tipo_foto, "png")))
  {
    // Ruta de la carpeta destino en servidor
    if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
      chmod($target_path, 0777);
      $logs->guardar_log($_GET['foto_id'],"Agregar foto a cotizacion: ". $_GET['id']);
      $fotos_cotizacion->guardar_foto($nombre,urldecode($_POST['descripcion']),$_POST['orientacion'],$_GET['id']);
      //header("location:../includes/agregar_foto_cotizacion.php"); 
      header("location:../inicio.php?cotizacion=".$_GET['id']);
    }else{
      echo'<script type="text/javascript">
            //localStorage.setItem("error","Ha ocurrido un error, ¡trate de nuevo!");
            alert("Ha ocurrido un error, ¡trate de nuevo!");
            window.location.href="../inicio.php?cotizacion='.$_GET['id'].'";
           </script>';
    }
  }else{
    //$("#area_trabajo_menu").load("includes/agregar_foto_cotizacion.php?id="+id);
    echo'<script type="text/javascript">
          alert("Solo se pueden subir fotos jpeg/jpg/png");
          window.location.href="../inicio.php?cotizacion='.$_GET['id'].'";
         </script>';
  }
?>

