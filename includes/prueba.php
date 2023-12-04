<?php

$rfc = $_POST['rfc'];
$cantidad = $_POST['cantidad'];
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
var_dump($contador);

for ($i=1; $i <= $contador ; $i++) {
    if($cantidad[$i] > 0){
        var_dump($i.'.-cantidad '. $cantidad["$i"]);
        var_dump($i.'.-unidad '. $unidad["$i"]);
        var_dump($i.'.-claveunidad '. $claveunidad["$i"]);
        var_dump($i.'.-clave '. $clave["$i"]);
        var_dump($i.'.-id '. $id["$i"]);
        var_dump($i.'.-producto '. $producto["$i"]);
        var_dump($i.'.-importeuni '. $importeuni["$i"]);
        var_dump($i.'.-importe '. $importe["$i"]);
        var_dump($i.'.-iva '. $iva["$i"]);
        var_dump($i.'.-ish '. $ish["$i"]);
    }
}


var_dump($rfc['0']);//RFC
var_dump($rfc['1']);//NOMBRE
var_dump($rfc['2']);//CODIGO POSTAL
var_dump($rfc['3']);//REGIMEN FISCAL
var_dump($rfc['4']);//USO DE CFDI
var_dump($rfc['5']);//E-MAIL
var_dump($rfc['6']);//METODO DE PAGO
var_dump($rfc['7']);//FORMA DE PAGO
var_dump($rfc['8']);//NOTAS
//DATOS FACTURA GLOBAL
var_dump($rfc['9']);//PERIOCIDAD
var_dump($rfc['10']);//MES
var_dump($rfc['11']);//AÑO
//DATOS PARA FACTURAR

var_dump($rimporte);
var_dump($riva);
var_dump($rish);
var_dump($rtotal);
?>