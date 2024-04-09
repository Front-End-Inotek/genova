<?php
date_default_timezone_set('America/Mexico_City');
include("clase_factura.php");
$facturacion = NEW factura();
$folio_casa = $_POST['folio'];
$estado_facura=$_POST['estado_factura'];
echo '
    <div>
    <h1>'.$folio_casa.'</h1>
    ';
    $facturacion->busqueda_folio_casa($folio_casa,$estado_facura);

echo '
    </div>
    
';
?>