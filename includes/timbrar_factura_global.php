<?php
session_start();
include("clase_factura.php");


include_once('clase_ticket.php');
$ticket= NEW Ticket(0);
$fact = NEW factura ();
$LCantidad=explode(",", $_GET['LCantidad']);
$LDescipcion=explode(",", $_GET['LDescipcion']);
$LImporte=explode(",", $_GET['LImporte']);
$LPrecio=explode(",", $_SESSION['lista_totales']);
$Ltipo=explode(",", $_SESSION['lista_tipo']);
//var_dump($LPrecio);
//var_dump($Ltipo);
$resultado=$fact->rfc_propio();
//$resultado=mysqli_query($con,$consulta);
$row=mysqli_fetch_array($resultado);

//$folio=1;

$numfolio=$fact->obtener_folio_factura();


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
$ish = $_GET['rish'];
//echo "---------".$ish;
$forma_pago=$_GET['forma_pago'];
$metodopago=$_GET['metodopago'];



$rimporte = $_POST['rimporte'];
//echo $rimporte;
$riva = $_POST['riva'];
//echo $riva;
$rtotal = $_POST['rtotal'];
$contador = count($LPrecio);

// Se desactivan los mensajes de debug
error_reporting(~(E_WARNING|E_NOTICE));

// Se especifica la zona horaria
date_default_timezone_set('America/Mexico_City');
// Se incluye el SDK
require_once '../../sdk2/sdk2.php';
// Se especifica la version de CFDi 4.0
if($ish > 0){
    //echo "con ish";
    $datos['complemento'] = 'implocal10';
    $sumatotal=$rimporte+$riva+$ish;
}
else{
    $sumatotal=$rimporte+$riva;
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
$datos['PAC']['produccion'] = $row['produccion'];

// Rutas y clave de los CSD
/*$datos['conf']['cer'] = '../../sdk2/certificados/00001000000510019114.cer';
$datos['conf']['key'] = '../../sdk2/certificados/CSD_BELISARIO_GBE1803058Z3_20211123_105435.key';
$datos['conf']['pass'] = 'GBE180305';*/
$datos['conf']['cer'] = $row['cer'];
$datos['conf']['key'] = $row['key'];
$datos['conf']['pass'] = $row["passkey"];

// Datos de la Factura
$datos['factura']['condicionesDePago'] = 'CONDICIONES';
$datos['factura']['descuento'] = '0.00';
$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
$datos['factura']['folio'] = $numfolio;    //BASE DE DATOS
$datos['factura']['forma_pago'] = $forma_pago;    //RFC
$datos['factura']['LugarExpedicion'] = $row['codigo_postal'];    //CODIGO POSTAL
$datos['factura']['metodo_pago'] = $metodopago;    //METODO DE PAGO
$datos['factura']['moneda'] = 'MXN';
$datos['factura']['serie'] = 'A';
$datos['factura']['subtotal'] = $rimporte;  //TOTAL DE IMPORTE
$datos['factura']['tipocambio'] = 1;
$datos['factura']['tipocomprobante'] = 'I';
$datos['factura']['total'] =$sumatotal;   //TOTAL
$datos['factura']['Exportacion'] = '01';

// Datos del Emisor
$datos['emisor']['rfc'] = $row["rfc"]; //RFC DE PRUEBA
$datos['emisor']['nombre'] = $row["nombre"];  // EMPRESA DE PRUEBA
$datos['emisor']['RegimenFiscal'] = $row["regimen_fiscal"];

// Datos del Receptor
/*$datos['receptor']['rfc'] = $rfc['0'];
$datos['receptor']['nombre'] = $rfc['1'];
$datos['receptor']['UsoCFDI'] = $rfc['4'];
$datos['receptor']['DomicilioFiscalReceptor'] = $rfc['2'];
$datos['receptor']['RegimenFiscalReceptor'] = $rfc['3'];*/

$datos['receptor']['rfc'] = $rfc['0'];
$datos['receptor']['nombre'] = $rfc['1'];
$datos['receptor']['UsoCFDI'] = $rfc['4'];
$datos['receptor']['DomicilioFiscalReceptor'] = "".$rfc['2'];
$datos['receptor']['RegimenFiscalReceptor'] = $rfc['3'];
$total=0;
//$rish = 0;
for ($i=0; $i <= $contador ; $i++) {
    if($LPrecio[$i] > 0){
        if($Ltipo[$i]=="1"){
            //echo "------- ish";
            $precio=round(($LPrecio[$i]/1.19),2);
            //$rish=$rish+round(($precio*.03),2);
        }else{
           //echo "-------Sin ish";
            $precio=round(($LPrecio[$i]/1.16),2);
        }
        $iva=round(($precio*.16),2);
        
        $total=$total+$precio;

        $id_mov=$_GET['mov'];
        $datos['conceptos'][$i]['cantidad'] = 1;/// 0
        $datos['conceptos'][$i]['unidad'] = "SER";///1
        $datos['conceptos'][$i]['ID'] = $id["$i"];/////4
        $datos['conceptos'][$i]['descripcion'] = "HOSPEDAJE";////5
        $datos['conceptos'][$i]['valorunitario']=$precio;////6
        $datos['conceptos'][$i]['importe'] = $precio;
        $datos['conceptos'][$i]['ClaveProdServ'] = "90111500";/////3
        $datos['conceptos'][$i]['ClaveUnidad'] = "E48";/////2
        $datos['conceptos'][$i]['ObjetoImp'] = '02';

        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Base'] = $precio;
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
        $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Importe'] = $iva;//IMPUESTO
    }
}
//echo $total;


$datos['impuestos']['TotalImpuestosTrasladados'] = $riva; ////TOTAL DE IMPUESTOS

// Se agregan los Impuestos
$datos['impuestos']['translados'][0]['Base'] = $rimporte; //TOTAL DEL PRODUCTO SIN IMPUESTO
$datos['impuestos']['translados'][0]['impuesto'] = '002';
$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
$datos['impuestos']['translados'][0]['importe'] = $riva; //TOTAL DE IMPUESTOS
$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';

if($ish > 0){
$datos['implocal10']['TotaldeTraslados']= $ish;
$datos['implocal10']['TotaldeRetenciones']=0.00;
$datos['implocal10']['TrasladosLocales'][0]['Importe']= $ish;
$datos['implocal10']['TrasladosLocales'][0]['TasadeTraslado']=0.03;
$datos['implocal10']['TrasladosLocales'][0]['ImpLocTrasladado'] = 'ISH';
}

/*echo "<pre>";
print_r($datos);
echo "</pre>";*/
//var_dump($_GET);
//echo "<pre>"; echo arr2cs($datos); echo "</pre>".die();
// Se ejecuta el SDK
//$res = mf_genera_cfdi($datos);
$res = mf_genera_cfdi4($datos);
///////////    MOSTRAR RESULTADOS DEL ARRAY $res   ///////////
$rfcval = $rfc['0'];
$folios = $numfolio;

$regimenfiscal = $rfc['3'];

$codigopostal = $rfc['2'];
$email = $rfc['5'];
$notas = $rfc['8'];
$fecha = time();
$nombre_hab=0;
$pax=0;


//echo $formapago;

//$consulta3="SELECT * FROM rfc ";
//$consulta3.="WHERE rfc = '$rfc'";
//$resultado3=mysqli_query($con,$consulta3);
$resultado3=$fact->consultar_rfc($rfcval);
$row3=mysqli_fetch_array($resultado3);
//var_dump($_SESSION['lista_id_ticket']);

    if(mysqli_num_rows($resultado3) <= 0){
        //echo var_dump('El usuario ya existe');
        $consulta4=$fact->registrar_rfc($regimenfiscal,$rfc,$codigopostal,$email);
    }
    if($res['cancelada']=='NO'){

        $fact->guardar_factura($rfcval,$rimporte,$riva,$ish,$folios,$rfc[1],$fecha,$rfc[6],$id_mov,$nombre_hab,$pax,$notas);
        $facturas=$fact->ultima_factura();
        while ($fila = mysqli_fetch_array($facturas))
        {
            $id_factura=$fila['id'];
        }
        //echo count($listaid);
        echo $res['cancelada'];
        //var_dump($datos);
        $listaid=$_SESSION['lista_id_ticket'];
        //var_dump($listaid);
        if($listaid!=""){
            for($i=0; $i<count($listaid); $i++){
                $ticket->cambiar_estado_facturados($listaid[$i],$id_factura);
            };
        }
        $_SESSION['lista_id_ticket']="";
    }else{
        echo $res['mensaje_original_pac_json'];
        var_dump($datos);
    }
?>