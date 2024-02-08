<?php
include_once("clase_chat.php");

try {
    $guardarMensaje = new Chat_Manager();

    $message = isset($_POST["mensaje"]) ? $_POST["mensaje"] : '';
    $id_usuario = isset($_POST["id_usuario"]) ? $_POST["id_usuario"] : 0;
    $message_type = isset($_POST["message_type"]) ? $_POST["message_type"] : 0;

    $id_usuario = intval($id_usuario);

    $guardarMensaje->guardarMensajeHabitacion($id_usuario, $message_type , $message);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>