<?php
include_once('clase_chat.php');

$ultimo_mensaje = new Chat_Manager();

$ver_ultimo_mensaje = $ultimo_mensaje->comprobarMensajeGlobal();

echo $ver_ultimo_mensaje;

?>