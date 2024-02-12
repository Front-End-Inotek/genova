<?php
include_once("clase_chat.php");
include_once('clase_usuario.php');

date_default_timezone_set("America/Mexico_city");
$usuario =  NEW Usuario(0);

$id_hab = $_POST["id_hab"];
$ver_chats_hab = new Chat_Manager();

//echo $id_hab;

$datos = $ver_chats_hab->cargarMensajesHabitacion($id_hab);

//var_dump($datos);

if(mysqli_num_rows($datos) > 0) {


	while ($fila = mysqli_fetch_array($datos)){
		$tiempo_unix = $fila["hora_envio"];
		$fecha = date("d/m/Y - H:i", $tiempo_unix);
		$id = $fila['usuario_id'];
		$nombre=$usuario->obtengo_nombre_completo($id);
		echo '
				<div class="chat_habitacion_body_message">
					<div class="chat_habitacion_body_message_icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
							<path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
							<path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
						</svg>
					</div>
					<div class="chat_habitacion_body_message_text">
						<div class="chat_habitacion_body_message_text_header">
							<p>'.$nombre.'</p>
							<p>'.$fecha.'</p>
						</div>
						<p>'.$fila ["mensaje"].'</p>
					</div>
				</div>
		';
	}

} else {
	echo '<div class="chat_habitacion_body_message">No hay mensajes disponibles en esta habitación.</div>'; 
}

?>