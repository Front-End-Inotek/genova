<?php
include_once('clase_chat.php');
$id_propio = $_POST['id'];

$ultimo_mensaje = new Chat_Manager();

$datos = $ultimo_mensaje->comprobarMensajeGlobal();
$datos = $ultimo_mensaje->comprobarMensajeGlobal('id');

if ($datos) {
    $json_datos = json_encode($datos);

    echo $json_datos;
} else {
    echo 'No hay resultados';
}
?>