<?php
date_default_timezone_set('America/Mexico_City');
include("clase_factura.php");
$facturacion = NEW factura();
$folio_casa = $_POST['folio'];

echo '
    <div>
    ';
    $facturacion->busqueda_folio_casa($folio_casa);

echo '
    </div>
    
';
?>