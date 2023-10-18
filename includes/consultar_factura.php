<?php
error_reporting(E_ERROR);
include_once "../../../../sdk2/sdk2.php";

date_default_timezone_set('America/Mexico_City');
$datos['PAC']['usuario'] = 'DEMO700101XXX';
$datos['PAC']['pass'] = 'DEMO700101XXX';
$datos['PAC']['produccion'] = 'SI';
$datos['modulo'] = 'consultarestatuscfdi';
$datos['factura_xml'] = '../../timbrados/914_cfdi_factura.xml';
$res = mf_ejecuta_modulo($datos);
echo "<pre>";
print_r($res);
echo "</pre>";
