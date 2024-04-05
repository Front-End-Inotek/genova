<?php
    date_default_timezone_set("America/Mexico_City");
    include_once("clase_corte.php");
    $corte = NEW Corte(0);
    $posicon = $_GET["posicion"];

   echo $corte->mostrar_paginacion_corte($posicon);
?>