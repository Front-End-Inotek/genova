<?php
date_default_timezone_set('America/Mexico_City');
include("clase_factura.php");
$facturacion = NEW factura();
$folio_casa = $_POST['folio'];

echo '
    <div>
    <h1>'.$folio_casa.'</h1>
    ';
    $facturacion->busqueda_folio_casa($folio_casa);

echo '
    </div>
    
';
?>