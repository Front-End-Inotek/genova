<?php
include_once("clase_chat.php");

try {
    $guardarMensaje = new Chat_Manager();

    $message = isset($_POST['mensaje']) ? $_POST['mensaje'] : '';
    $id_usuario = isset($_POST['id_usuario']) ? $_POST['id_usuario'] : 0; // Asegúrate de asignar un valor predeterminado adecuado
    $message_type = isset($_POST['message_type']) ? $_POST['message_type'] : 0 ;

    // Validar y escapar datos según sea necesario
    $id_usuario = intval($id_usuario); // Asegúrate de que $id_usuario sea un entero

    $guardarMensaje->guardarMensaje($id_usuario, $message_type, $message);
} catch (Exception $e) {
    // Manejar la excepción según tus necesidades (puede ser loguearla, mostrar un mensaje al usuario, etc.)
    echo "Error: " . $e->getMessage();
}
?>