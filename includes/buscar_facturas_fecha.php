<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_factura.php");
  $facturacion = NEW factura();
      $facturacion->busqueda(1,$_GET['inicial'],$_GET['final']);
  //echo "Folio ". $_GET['inicial']."</br>".$_GET['final'];
?>
