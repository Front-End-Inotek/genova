<?php
include_once('clase_chat.php');
include_once('clase_usuario.php');
$ver_chats_globales = new Chat_Manager();
$id_propio = $_POST['id'];
$usuario =  NEW Usuario(0);


$bodyChat = '';

$datos = $ver_chats_globales->cargarMensajesGlobales();

while ($fila = mysqli_fetch_array($datos)){
    $mensaje = $fila['mensaje'];
    $id = $fila['usuario_id'];
    $nombre=$usuario->obtengo_nombre_completo($id);

    if( $id_propio == $id ){
        $bodyChat .='
        <div class="chat_message_other chat_message_own">
            <img src="./assets/user_own.svg"/>
            <div class="chat_message_content_own">
                <p class="chat_message_name">Tú</p>
                <p>'.$fila['mensaje'].'</p>
            </div>
        </div>
        ';
    } else {
        $bodyChat .= '
        <div class="chat_message_other">
            <img src="./assets/user.svg"/>
            <div class="chat_message_content">
                <p class="chat_message_name">'.$nombre.'</p>
                <p>'.$mensaje.'</p>
            </div>
        </div>
        ';
    }

}

echo $bodyChat;
?>