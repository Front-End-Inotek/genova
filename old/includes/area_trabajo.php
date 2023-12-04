<?php
  date_default_timezone_set('America/Mexico_City');
  include ("informacion.php");
  $saber = NEW Informacion();//
  $estatus_hab="";
  //si hay un filtro
  if(isset($_GET['estatus_hab'])){
    if($_GET['estatus_hab']!="")
    $estatus_hab=$_GET['estatus_hab'];
  }

  $saber->mostrarhab($_GET['id'],$_GET['token'],$estatus_hab);//categoria
?>
