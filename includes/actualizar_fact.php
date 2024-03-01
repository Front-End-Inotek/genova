<?php
include_once("clase_configuracion.php");

$config = new Configuracion;

$n_emisor = $_POST['n_emisor']; 
$e_emisor = $_POST['e_emisor']; 
$p_emisor = $_POST['p_emisor']; 
$e_receptor = $_POST['e_receptor']; 
$n_receptor = $_POST['n_receptor']; 

$actualzar = $config->actualizar_info_fac($n_emisor, $e_emisor, $p_emisor , $e_receptor , $e_emisor);

if($actualzar) { 
    echo true;
} else {
    echo false;
}
?>