<?php
// Se desactivan los mensajes de debug
error_reporting(~(E_WARNING|E_NOTICE));

// Se especifica la zona horaria
date_default_timezone_set('America/Mexico_City');
// Se incluye el SDK
require_once '../../../../sdk2/sdk2.php';
// Se especifica la version de CFDi 4.0
$datos['version_cfdi'] = '4.0';
// Ruta del XML Timbrado
$datos['cfdi']='../../../../sdk2/timbrados/cfdi_ejemplo_factura4.xml';
// Ruta del XML de Debug
$datos['xml_debug']='../../../../sdk2/timbrados/sin_timbrar_ejemplo_factura4.xml';
$datos['validacion_local']= 'NO';
// Credenciales de Timbrado
$datos['PAC']['usuario'] = 'DEMO700101XXX';
$datos['PAC']['pass'] = 'DEMO700101XXX';
$datos['PAC']['produccion'] = 'NO';
// Rutas y clave de los CSD
$datos['conf']['cer'] = '../../../../sdk2/certificados/EKU9003173C9.cer.pem';
$datos['conf']['key'] = '../../../../sdk2/certificados/EKU9003173C9.key.pem';
$datos['conf']['pass'] = '12345678a';
// Datos de la Factura
$datos['factura']['condicionesDePago'] = 'CONDICIONEES';
//$datos['factura']['descuento'] = '0.00';
$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
$datos['factura']['folio'] = '100';
$datos['factura']['forma_pago'] = '01';
$datos['factura']['LugarExpedicion'] = '55700';
$datos['factura']['metodo_pago'] = 'PUE';
$datos['factura']['moneda'] = 'MXN';
$datos['factura']['serie'] = 'A';
$datos['factura']['subtotal'] = 298.00;
$datos['factura']['tipocambio'] = 1;
$datos['factura']['tipocomprobante'] = 'I';
$datos['factura']['total'] = 345.68;
$datos['factura']['Exportacion'] = '01';
// Datos del Emisor
$datos['emisor']['rfc'] = 'EKU9003173C9'; //RFC DE PRUEBA
$datos['emisor']['nombre'] = 'ESCUELA KEMPER URGATE';  // EMPRESA DE PRUEBA
$datos['emisor']['RegimenFiscal'] = '603';
// Datos del Receptor
$datos['receptor']['rfc'] = 'XAXX010101000';
$datos['receptor']['nombre'] = 'Publico En General';
$datos['receptor']['UsoCFDI'] = 'S01';
$datos['receptor']['DomicilioFiscalReceptor'] = '55700';
$datos['receptor']['RegimenFiscalReceptor'] = '616';
// Se agregan los conceptos
$datos['conceptos'][0]['cantidad'] = 1.00;
$datos['conceptos'][0]['unidad'] = 'Pieza';
$datos['conceptos'][0]['ID'] = "1726";
$datos['conceptos'][0]['descripcion'] = "Cigarros";
$datos['conceptos'][0]['valorunitario'] = 99.00;
$datos['conceptos'][0]['importe'] = 99.00;
$datos['conceptos'][0]['ClaveProdServ'] = '50211503';
$datos['conceptos'][0]['ClaveUnidad'] = 'H87';
$datos['conceptos'][0]['ObjetoImp'] = '02';

$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Base'] = 99.00;
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Importe'] = 15.84;


$datos['conceptos'][1]['cantidad'] = 1.00;
$datos['conceptos'][1]['unidad'] = 'NA';
$datos['conceptos'][1]['ID'] = "1586";
$datos['conceptos'][1]['descripcion'] = "PRODUCTO DE PRUEBA 2";
$datos['conceptos'][1]['valorunitario'] = 199.00;
$datos['conceptos'][1]['importe'] = 199.00;
$datos['conceptos'][1]['ClaveProdServ'] = '01010101';
$datos['conceptos'][1]['ClaveUnidad'] = 'ACT';
$datos['conceptos'][1]['ObjetoImp'] = '02';

$datos['conceptos'][1]['Impuestos']['Traslados'][0]['Base'] = 199.00;
$datos['conceptos'][1]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
$datos['conceptos'][1]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
$datos['conceptos'][1]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
$datos['conceptos'][1]['Impuestos']['Traslados'][0]['Importe'] = 31.84;

$datos['impuestos']['TotalImpuestosTrasladados'] = 47.68;

// Se agregan los Impuestos
$datos['impuestos']['translados'][0]['Base'] = 298.00;
$datos['impuestos']['translados'][0]['impuesto'] = '002';
$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
$datos['impuestos']['translados'][0]['importe'] = 47.68;
$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';

$res = mf_genera_cfdi4($datos);
///////////    MOSTRAR RESULTADOS DEL ARRAY $res   ///////////

echo "<h1>Respuesta Generar XML y Timbrado</h1>";
foreach ($res AS $variable => $valor) {
    $valor = htmlentities($valor);
    $valor = str_replace('<br/>', '<br/>', $valor);
    echo "<b>[$variable]=</b>$valor<hr>";
}

?>