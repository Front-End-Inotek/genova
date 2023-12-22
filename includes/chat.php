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
    $fecha = date('H:i', strtotime($fila['hora_envio']));
    $color_margen = "Administrador";
    $nivel=$usuario->obtener_nivel($id);
    switch ($nombre) {
        case "Administrador" :
            $color_margen = "#3498db";
            break;
        case "Cajera" :
            $color_margen = "#27ae60";
            break;
        case "Recamarera" :
            $color_margen = "#f39c12";
            break;
        case "Mantenimiento" :
            $color_margen = "#e74c3c";
            break;
        case "Supervision" :
            $color_margen = "#8e44ad";
            break;
        case "Restaurante" :
            $color_margen = "#e67e22";
            break;
        case "Reservaciones" :
            $color_margen = "#2ecc71";
            break;
        case "Ama Llaves" :
            $color_margen = "#9b59b6";
            break;
        case "Indefinido" :
            $color_margen = "#95a5a6";
            break;
        case "Indeterminado" :
            $color_margen = "#0D6EFD";
            break;
        default :
            $color_margen = "#0D6EFD";
            break;
    }

    if( $id_propio == $id ){
        $bodyChat .='
        <div class="chat_message_other chat_message_own chat_message_own_triangle">
            <img src="./assets/user_own.svg" style="border: 2px solid white" />
            <div class="chat_message_content_own">
                <div class="chat_message_info chat_message_info_own">
                    <p class="chat_message_name">Tú</p>
                    <p class="chat_message_name">'.$fecha.'</p>
                </div>
                <p>'.$fila['mensaje'].'</p>
            </div>
        </div>
        ';
    } else {
        $bodyChat .= '
        <div class="chat_message_other chat_message_other_triangle">
            <img src="./assets/user.svg" style="border: 2px solid '.$color_margen.';"/>
            <div class="chat_message_content">
                <div class="chat_message_info ">
                    <p class="chat_message_name">'.$nombre.'</p>
                    <p class="chat_message_name">'.$fecha.'</p>
                </div>
                <p style="width: 100%;">'.$mensaje.'</p>
            </div>
        </div>
        ';
    }

}

echo $bodyChat;
?>