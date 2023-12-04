<?php

//ejemplo factura cfdi 4.0
// Se desactivan los mensajes de debug
error_reporting(~(E_WARNING|E_NOTICE));
//error_reporting(E_ALL);

// Se especifica la zona horaria
date_default_timezone_set('America/Mexico_City');

// Se incluye el SDKSS
require_once '../../sdk2.php';

// Se especifica la version de CFDi 4.0
$datos['version_cfdi'] = '4.0';

// Ruta del XML Timbrado
$datos['cfdi']='../facturas/3034_cfdi_factura.xml';

// Ruta del XML de Debug
$datos['xml_debug']='../xml_debug/3034_xml_debug_.xml';

// Credenciales de Timbrado
$datos['PAC']['usuario'] = 'GBE1803058Z';
$datos['PAC']['pass'] = 'GBE1803058Z';
$datos['PAC']['produccion'] = 'NO';

// Rutas y clave de los CSD
/*
$datos['conf']['cer'] = '../../certificados/EKU9003173C9.cer.pem';
$datos['conf']['key'] = '../../certificados/EKU9003173C9.key.pem';
$datos['conf']['pass'] = '12345678a';
*/

$datos['conf']['cer'] = '../../sdk2/certificados/00001000000510019114.cer';
$datos['conf']['key'] = '../../sdk2/certificados/CSD_BELISARIO_GBE1803058Z3_20211123_105435.key';
$datos['conf']['pass'] = 'GBE180305';


// Datos de la Factura
$datos['factura']['condicionesDePago'] = 'CONDICIONEES';
$datos['factura']['descuento'] = '0.00';
//$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
$datos['factura']['fecha_expedicion'] = "2023-09-22T11:21:27";
$datos['factura']['folio'] = '3034';
$datos['factura']['forma_pago'] = '01';
$datos['factura']['LugarExpedicion'] = '44700';
$datos['factura']['metodo_pago'] = 'PUE';
$datos['factura']['moneda'] = 'MXN';
$datos['factura']['serie'] = 'A';
$datos['factura']['subtotal'] = 8.40;
$datos['factura']['tipocambio'] = 1;
$datos['factura']['tipocomprobante'] = 'I';
$datos['factura']['total'] = 9.99;
//$datos['factura']['RegimenFiscal'] = '601';
$datos['factura']['Exportacion'] = '01';


// Datos del Emisor
/*
$datos['emisor']['rfc'] = 'EKU9003173C9'; //RFC DE PRUEBA
$datos['emisor']['nombre'] = 'ESCUELA KEMPER URGATE';  // EMPRESA DE PRUEBA
$datos['emisor']['RegimenFiscal'] = '601';
//$datos['emisor']['FacAtrAdquirente'] = 'ACCEM SERVICIOS EMPRESARIALES SC';
*/
$datos['emisor']['rfc'] = 'GBE1803058Z3'; //RFC DE PRUEBA
$datos['emisor']['nombre'] = 'GRUPO BELISARIO';  // EMPRESA DE PRUEBA
$datos['emisor']['RegimenFiscal'] = '601';


$datos['receptor']['rfc'] = 'XAXX010101000';
$datos['receptor']['nombre'] = 'Publico en General';
$datos['receptor']['UsoCFDI'] = 'G01';
//opcional
$datos['receptor']['DomicilioFiscalReceptor'] = '44700';
//$datos['receptor']['ResidenciaFiscal']= 'MEX';
//$datos['receptor']['NumRegIdTrib'] = 'B';
$datos['receptor']['RegimenFiscalReceptor'] = '616';


// Datos del Receptor
/*
$datos['receptor']['rfc'] = 'IAÑL750210963';
$datos['receptor']['nombre'] = 'LUIS IAN ÑUZCO';
$datos['receptor']['UsoCFDI'] = 'D01';
//opcional
$datos['receptor']['DomicilioFiscalReceptor'] = '30230';
//$datos['receptor']['ResidenciaFiscal']= 'MEX';
//$datos['receptor']['NumRegIdTrib'] = 'B';
$datos['receptor']['RegimenFiscalReceptor'] = '605';
*/
/*
$datos['receptor']['rfc'] = 'GPS031229372';
$datos['receptor']['nombre'] = 'BIO PAPPEL SCRIBE';
$datos['receptor']['UsoCFDI'] = 'G01';
//opcional
$datos['receptor']['DomicilioFiscalReceptor'] = '11510';
//$datos['receptor']['ResidenciaFiscal']= 'MEX';
//$datos['receptor']['NumRegIdTrib'] = 'B';
$datos['receptor']['RegimenFiscalReceptor'] = '601';
*/
// Se agregan los conceptos

$datos['conceptos'][0]['cantidad'] = 1.00;
$datos['conceptos'][0]['unidad'] = 'SER';
$datos['conceptos'][0]['ID'] = "";
$datos['conceptos'][0]['descripcion'] = "HOSPEDAJE";
$datos['conceptos'][0]['valorunitario'] = 8.40;
$datos['conceptos'][0]['importe'] = 8.40;
$datos['conceptos'][0]['ClaveProdServ'] = '90111500';
$datos['conceptos'][0]['ClaveUnidad'] = 'E48';
$datos['conceptos'][0]['ObjetoImp'] = '02';

$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Base'] = 8.40;
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Importe'] = 1.34;



// Se agregan los Impuestos
$datos['impuestos']['translados'][0]['Base'] = 8.40;
$datos['impuestos']['translados'][0]['impuesto'] = '002';
$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
$datos['impuestos']['translados'][0]['importe'] = 1.34;
$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';


$datos['impuestos']['TotalImpuestosTrasladados'] = 0.25;


$datos['implocal10']['TotaldeTraslados']= 0.25;
$datos['implocal10']['TotaldeRetenciones']=0.00;
$datos['implocal10']['TrasladosLocales'][0]['Importe']= 0.25;
$datos['implocal10']['TrasladosLocales'][0]['TasadeTraslado']=0.03;
$datos['implocal10']['TrasladosLocales'][0]['ImpLocTrasladado'] = 'ISH';


echo "<pre>";
print_r($datos);
echo "</pre>";

//echo "<pre>"; echo arr2cs($datos); echo "</pre>".die();
// Se ejecuta el SDK
//$res = mf_genera_cfdi($datos);
$res = mf_genera_cfdi4($datos);
///////////    MOSTRAR RESULTADOS DEL ARRAY $res   ///////////

echo "<h1>Respuesta Generar XML y Timbrado</h1>";
foreach ($res AS $variable => $valor) {
    $valor = htmlentities($valor);
    $valor = str_replace('&lt;br/&gt;', '<br/>', $valor);
    echo "<b>[$variable]=</b>$valor<hr>";
}