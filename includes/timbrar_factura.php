<?php
include("clase_factura.php");
$fact = NEW factura ();

$consulta="SELECT * FROM rfc ";
$consulta.= "WHERE id = '1' ";
$resultado=mysqli_query($con,$consulta);
$row=mysqli_fetch_array($resultado);

$folio=1;
$consulta2="SELECT folio FROM facturas ORDER BY id DESC LIMIT 1";
$resultado2=mysqli_query($con,$consulta2);
$row2=mysqli_fetch_array($resultado2);

$numfolio =$row2[0]+1;

$rfc = $_POST['rfc'];

intval($cantidad = $_POST['cantidad']);
$unidad = $_POST['unidad'];
$claveunidad = $_POST['claveunidad'];
$clave = $_POST['clave'];
$id = $_POST['id'];
$producto = $_POST['producto'];
$importeuni = $_POST['importeuni'];
$importe = $_POST['importe'];
$iva = $_POST['iva'];
$ish = $_POST['ish'];

$rimporte = $_POST['rimporte'];
$riva = $_POST['riva'];
$rish = $_POST['rish'];
$rtotal = $_POST['rtotal'];

$contador = $_POST['filas'];

// Se desactivan los mensajes de debug
error_reporting(~(E_WARNING|E_NOTICE));

// Se especifica la zona horaria
date_default_timezone_set('America/Mexico_City');
// Se incluye el SDK
require_once '../../sdk2/sdk2.php';
// Se especifica la version de CFDi 4.0
if($rish > 0){
    $datos['complemento'] = 'implocal10';
}

$datos['version_cfdi'] = '4.0';

// Ruta del XML Timbrado
$datos['cfdi']='../facturas/'.$numfolio.'_cfdi_factura.xml';
// Ruta del XML de Debug
$datos['xml_debug']='../xml_debug/'.$numfolio.'_xml_debug_.xml';
$datos['validacion_local']= 'NO';


// Credenciales de Timbrado
$datos['PAC']['usuario'] = $row['usuariopac'];   //BASE DE DATOS
$datos['PAC']['pass'] = $row['passpac'];    //BASE DE DATOS
$datos['PAC']['produccion'] = 'SI';

// Rutas y clave de los CSD
$datos['conf']['cer'] = '../../sdk2/certificados/00001000000510019114.cer';
$datos['conf']['key'] = '../../sdk2/certificados/CSD_BELISARIO_GBE1803058Z3_20211123_105435.key';
$datos['conf']['pass'] = 'GBE180305';

// Datos de la Factura
$datos['factura']['condicionesDePago'] = 'CONDICIONES';
$datos['factura']['descuento'] = '0.00';
$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
$datos['factura']['folio'] = $row2[0]+1;    //BASE DE DATOS
$datos['factura']['forma_pago'] = $rfc['7'];    //RFC
$datos['factura']['LugarExpedicion'] = '44700';    //CODIGO POSTAL
$datos['factura']['metodo_pago'] = $rfc['6'];    //METODO DE PAGO
$datos['factura']['moneda'] = 'MXN';
$datos['factura']['serie'] = 'A';
$datos['factura']['subtotal'] = $rimporte;  //TOTAL DE IMPORTE
$datos['factura']['tipocambio'] = 1;
$datos['factura']['tipocomprobante'] = 'I';
$datos['factura']['total'] = $rtotal;   //TOTAL
$datos['factura']['Exportacion'] = '01';

// Datos del Emisor
$datos['emisor']['rfc'] = 'GBE1803058Z3'; //RFC DE PRUEBA
$datos['emisor']['nombre'] = 'GRUPO BELISARIO';  // EMPRESA DE PRUEBA
$datos['emisor']['RegimenFiscal'] = '601';

// Datos del Receptor
/*$datos['receptor']['rfc'] = $rfc['0'];
$datos['receptor']['nombre'] = $rfc['1'];
$datos['receptor']['UsoCFDI'] = $rfc['4'];
$datos['receptor']['DomicilioFiscalReceptor'] = $rfc['2'];
$datos['receptor']['RegimenFiscalReceptor'] = $rfc['3'];*/

$datos['receptor']['rfc'] = 'XAXX010101000';
$datos['receptor']['nombre'] = 'Publico en General';
$datos['receptor']['UsoCFDI'] = 'S01';
$datos['receptor']['DomicilioFiscalReceptor'] ='44700';
$datos['receptor']['RegimenFiscalReceptor'] = '616';

//Informacion Global
if($rfc['11'] > 0){
    $datos['InformacionGlobal']['Periodicidad'] = $rfc['9'];
    $datos['InformacionGlobal']['Meses'] = $rfc['10'];
    $datos['InformacionGlobal']['Año'] = $rfc['11'];
}

for ($i=1; $i <= $contador ; $i++) {
    if($cantidad[$i] > 0 && $importeuni[$i] > 0){
        $datos['conceptos'][$i]['cantidad'] = $cantidad["$i"];/// 0
        $datos['conceptos'][$i]['unidad'] = $unidad["$i"];///1
        $datos['conceptos'][$i]['ID'] = $id["$i"];/////4
        $datos['conceptos'][$i]['descripcion'] = $producto["$i"];////5
        $datos['conceptos'][$i]['valorunitario']=round(($importeuni["$i"]/1.19),2);////6
        $datos['conceptos'][$i]['importe'] = $importe["$i"];
        $datos['conceptos'][$i]['ClaveProdServ'] = $clave["$i"];/////3
        $datos['conceptos'][$i]['ClaveUnidad'] = $claveunidad["$i"];/////2
        $datos['conceptos'][$i]['ObjetoImp'] = '02';

        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Base'] = $importe["$i"];
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Importe'] = $iva["$i"];//IMPUESTO
    }
}

$datos['impuestos']['TotalImpuestosTrasladados'] = $riva; ////TOTAL DE IMPUESTOS

// Se agregan los Impuestos
$datos['impuestos']['translados'][0]['Base'] = $rimporte; //TOTAL DEL PRODUCTO SIN IMPUESTO
$datos['impuestos']['translados'][0]['impuesto'] = '002';
$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
$datos['impuestos']['translados'][0]['importe'] = $riva; //TOTAL DE IMPUESTOS
$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';

if($rish > 0){
$datos['implocal10']['TotaldeTraslados']= $rish;
$datos['implocal10']['TotaldeRetenciones']=0.00;
$datos['implocal10']['TrasladosLocales'][0]['Importe']= $rish;
$datos['implocal10']['TrasladosLocales'][0]['TasadeTraslado']=0.03;
$datos['implocal10']['TrasladosLocales'][0]['ImpLocTrasladado'] = 'ISH';
}

/*echo "<pre>";
print_r($datos);
echo "</pre>";*/

//echo "<pre>"; echo arr2cs($datos); echo "</pre>".die();
// Se ejecuta el SDK
//$res = mf_genera_cfdi($datos);
$res = mf_genera_cfdi4($datos);
///////////    MOSTRAR RESULTADOS DEL ARRAY $res   ///////////
$rfc = $rfc['0'];
$folios = $row2[0]+1;

$regimenfiscal = $rfc['3'];

$codigopostal = $rfc['2'];
$email = $rfc['5'];
$notas = $rfc['8'];

$fecha = time();

//echo $formapago;

$consulta3="SELECT * FROM rfc ";
$consulta3.="WHERE rfc = '$rfc'";
$resultado3=mysqli_query($con,$consulta3);
$row3=mysqli_fetch_array($resultado3);

    if(mysqli_num_rows($resultado3) < 0){
        //echo var_dump('El usuario ya existe');
        $consulta4="INSERT INTO rfc (`regimen_fiscal`,`rfc`,`nombre`,`produccion`,`codigo_postal`,`email`,`cer`,`key`,`passkey`,`usuariopac`,`passpac`,`impresora`,`telefono`)
        VALUES ('$regimenfiscal','$rfc','$nombre','','$codigopostal','$email','','','','','','','')";
        $resultado4=mysqli_query($con,$consulta4);
    }


    if($res['cancelada']=='NO'){
        $consulta4="INSERT INTO facturas (`rfc`,`importe`,`iva`,`ish`,`folio`,`estado`,`nombre`,`fecha`,`forma_pago`)
        VALUES ('$rfc','$rimporte','$riva','$rish','$folios','0','$nombre','$fecha','$formapago')";
        $resultado4=mysqli_query($con,$consulta4);

        echo $res['cancelada'];
        
    }else{
        echo $res['mensaje_original_pac_json'];
        var_dump($datos);
    }
?>