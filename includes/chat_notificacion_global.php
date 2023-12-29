<?php
include_once('clase_chat.php');
include_once('clase_usuario.php');

$id_propio = $_POST['id'];

$ultimo_mensaje = new Chat_Manager();
$conocer_nombre = new Usuario(0);


$datos = $ultimo_mensaje->comprobarMensajeGlobal('id');

if ($datos) {

    $id_usuario = $datos['usuario_id'];

    $nombre_usuario = $conocer_nombre->obtengo_nombre_completo($id_usuario);

    $datos["nombre"] = $nombre_usuario;

    echo json_encode(($datos));
} else {
    echo 'No hay resultados';
}
?>