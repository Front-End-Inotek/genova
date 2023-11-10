<?php

include 'datos_servidor.php'; //conexion con la base de datos
include("clase_factura.php");
$fact = NEW factura ();

$resultado=$fact->obtener_primer_rfc();
$row=mysqli_fetch_array($resultado);

$motivo = $_POST["motivo"];
$uuid=$_GET["uuid"];
$folio=$_GET["folio"];
//$file = $_FILES['file']['tmp_name'];

error_reporting(E_ERROR);                        
require_once '../../sdk2/sdk2.php';
$datos['PAC']['usuario'] = $row['usuariopac'];
$datos['PAC']['pass'] = $row['passpac'];
$datos['modulo']="cancelacion2022"; 
$datos['accion']="cancelar";                                                  
$datos["produccion"]=$row['produccion'];
//$datos["xml"]= $file;
$datos["uuid"]=$uuid;
$datos["rfc"] =$row['rfc'];
$datos["password"]=$row['passkey'];
$datos["motivo"]=$motivo;
//$datos["folioSustitucion"]="";
$datos["b64Cer"]=$row["cer"]; //RFC DE PRUEBA
$datos["b64Key"]=$row["key"];

$res = mf_ejecuta_modulo($datos);

$respuesta = $res['codigo_mf_texto'];
echo $respuesta;


if($respuesta == 'OK'){
        $fact->estado_cancelar_factura($folio);
}

/*NOTA: PARA REALIZAR LA CANCELACION SE REQUIERE EL UUID DE LA FACTURA A CANCELAR. 
OPCIONALMENTE PODRA ENVIAR EL XML Y DE AHI SE ESTRAERÁ EL UUID, POR LO CUAL DEBE DE ELGIR UNA DE LAS 2 OPCIONES. ($datos["uuid"] O $datos["xml"])
EN CASO DE QUE POR ERROR SE ENVIEN AMBOS PARAMETROS EL VALOR QUE SERA TOMADO EN CUENTA SERA EL QUE ESTÉ EN EL CAMPO UUID
Y SE IGNORARA LA FACTURA QUE SE ESPECIFIQUE EN EL CAMPO "$datos["xml"]"*/                                                   

?>