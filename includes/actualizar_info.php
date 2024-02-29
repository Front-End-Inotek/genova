<?php
include_once("clase_configuracion.php");

$config = NEW Configuracion;

$nombre = $_POST["nombre"];
$direccion = $_POST["direccion"];
$pagina = $_POST["paginaWeb"];
$imagen = $_POST["imagen"];

$actualizar = $config->actualizar_info_basica($nombre, $direccion, $pagina, $imagen);

if($actualizar) {
    echo true;
} else {
    echo false;
}
?>