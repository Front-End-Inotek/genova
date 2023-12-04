<?php
  date_default_timezone_set('America/Mexico_City');
  include ("clase_factura.php");
  $facturacion = NEW factura();
    echo ' <div class="container-fluid">
            <br>
            <h2>Busqueda de factura por fecha</h2>';
              $facturacion->busqueda(1,$_GET['inicial'],$_GET['final']);
    echo  '</div>';
  //echo "Folio ". $_GET['inicial']."</br>".$_GET['final'];
?>
