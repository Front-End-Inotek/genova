<?php
date_default_timezone_set('America/Mexico_City');
include_once("clase_info.php");
include_once("clase_hab.php");
include_once("clase_configuracion.php");
include_once("clase_movimiento.php");
$conf = NEW Configuracion();
function mostar_info($hab_id,$estado,$mov,$id,$entrada="",$salida=""){

	$info = NEW Informacion($hab_id,$estado,$mov,$id,$entrada,$salida);
}
function show_info($hab_id,$estado,$estado_interno){
	$hab = NEW Hab($hab_id);

	echo '<div class="row">'; 
	echo '<div class="col-xs-12 col-sm-12 col-md-12">';
		echo '<div>';
		echo '<h3>';
			switch ($estado) {
			case 0:
				echo 'Disponible limpia';
			break;

			case 1:
				if($estado_interno=="sin estado"){
					echo 'Ocupado';
				}else{
					if($estado_interno=="limpieza"){
						echo "Ocupada limpieza";
					}
					if($estado_interno=="sucia"){
						echo "Sucia ocupada";
					}
				}

			break;

			case 2:
				echo 'Vacia sucia';
			break;

			case 3:
				echo 'Vacia limpieza';
			break;

			case 4:
				echo 'Mantenimiento';
			break;

			case 5:
				echo 'Bloqueo';
			break;

			case 6:
				echo 'Reserva pagada';
			break;

			case 7:
				echo 'Reserva pendiente';
			break;

			case 8:
				echo 'Uso casa';
			break;

			case 9:
				echo 'Mantenimiento';
			break;

			case 10:
				echo 'Bloqueo';
			break;

			default:
				//echo "Estado indefinido";
			break; 
			}
		echo '</h3>';
		echo '</div>';
		echo '<div>';
		echo '<h4>Información:</h4>';
		echo '</div>';

		echo '</div>';
	echo '</div>';
	//echo '</br>'; 

}

include_once("clase_usuario.php");
//include_once("clase_cliente.php");
$hab = NEW Hab($_GET['hab_id']);
$nombre_habitacion = $hab->nombre;
$movimiento = NEW Movimiento(0);
//$cliente = NEW Cliente($_GET['hab_id']);
$user = NEW Usuario($_GET['id']);
if($hab->mov >= 0){
	$estado_interno= $movimiento->mostrar_estado_interno($hab->mov);
	$id_reserva = $movimiento->saber_id_reservacion($hab->mov); ///----------------------*/
}


$entrada="";
$salida="";
if(isset($_GET['entrada'])){
	$entrada = $_GET['entrada'];
}
if(isset($_GET['salida'])){
	$salida = $_GET['salida'];
}


echo '<div class="modal-header" >
		<h3 class="modal-title">Habitación '.$nombre_habitacion.' </h3>
		<button type="button" class="btn btn-light" data-dismiss="modal">
			<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
				<path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
			</svg>
		</button>
	</div>';
echo '<div class="container-fluid">';
//echo $estado_interno;
show_info($_GET['hab_id'],$_GET['estado'],$estado_interno);
echo '<div class="contenedor_botones">';


switch ($_GET['estado']) {
	case 0:
	if($user->nivel<=2 && $conf->hospedaje ==1){
		echo '<div class="btn_modal_herramientas btn_ocupado " onclick="disponible_asignar('.$_GET['hab_id'].','.$_GET['estado'].')" >';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/bnt_ocupado.svg" />';
			echo '<p>Asignar / ocupar</p>';
		echo '</div>';
	}
	//boton para agregar reservas
	if(true){
		echo '<div class="btn_modal_herramientas btn_reservar" onclick="asignarHabitacion('.$id_reserva.','.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/btn_reservar.svg" />';
			echo '<p>Asignar reserva</p>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		$nuevo_estado= 2;
		echo '<div class="btn_modal_herramientas btn_limpieza" onclick="hab_estado_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$nuevo_estado.')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/limpieza.svg" />';
			echo '<p>Limpieza</p>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		echo '<div class="btn_modal_herramientas btn_sucia" onclick="hab_sucia_vacia('.$_GET['hab_id'].',2)">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/sucia.svg" />';
			echo '<p>Sucia</p>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		echo '<div class="btn_modal_herramientas btn_uso_casa" onclick="uso_casa_asignar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/uso_casa.svg" />';
			echo '<p>Uso casa</p>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		// echo $nuevo_estado;
		$nuevo_estado=9;
		$nuevo_estado= 4;
		echo '<div class="btn_modal_herramientas btn_mantenimiento" onclick="hab_estado_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$nuevo_estado.')" >';
		echo '<img  class="btn_modal_img" src="./assets/iconos_btn/mantenimiento.svg" />';
			echo '<p>Mantenimiento</p>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		$nuevo_estado= 10;
		$nuevo_estado=5;
		echo '<div class="btn_modal_herramientas btn_bloqueado" onclick="hab_estado_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$nuevo_estado.')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/btn_bloqueado.svg" />';
			echo '<p>Bloqueo</p>';
		echo '</div>';
	}

	break;


	case 1 :
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_desocupar" onclick="hab_desocupar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
		echo '<img  class="btn_modal_img" src="./assets/iconos_btn/desocupar.svg" />';
			echo '<p>Desocupar</p>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_edo_cuenta" onclick="estado_cuenta('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/edo_cuenta.svg" />';
			echo '<p>Edo. Cuenta</p>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_restaurante" onclick="agregar_restaurante('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/restaurante.svg" />';
			echo '<p>Restaurante</p>';
		echo '</div>';
	}
	if($user->nivel<=2 && $estado_interno != 'sucia'){
		echo '<div class="btn_modal_herramientas btn_sucia" onclick="hab_sucia_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/sucia.svg" />';
			echo '<p>Sucia</p>';
		echo '</div>';
	}
	if($user->nivel<=2 && $estado_interno != 'limpieza'){
		echo '<div class="btn_modal_herramientas btn_limpieza" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/limpieza.svg" />';
			echo '<p>Limpieza</p>';
		echo '</div>';
	}

	/* boton para editar */
	if($user->nivel<=2){
		$ruta="recargar_pagina()";
		echo '<div class="btn_modal_herramientas btn_editar" onclick="editar_checkin('.$id_reserva.','.$_GET['hab_id'].',\''.$ruta.'\')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/editar.svg" />';
			echo '<p>Editar</p>';
		echo '</div>';
	}

	/* boton para editar */
	if($user->nivel<=2){
		$ruta="recargar_pagina()";
		echo '<div class="btn_modal_herramientas btn_cambiar" onclick="hab_estado_cambiar_hab('.$id_reserva.','.$_GET['hab_id'].','.$_GET['estado'].',\''.$ruta.'\')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/cambiar.svg" />';
			echo '<p>Cambiar hab.</p>';
		echo '</div>';
	}

	if($user->nivel<=2 && $estado_interno != 'sin estado'){
		echo '<div class="btn_modal_herramientas btn_terminar " onclick="hab_ocupada_terminar_interno('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/terminar.svg" />';
			echo '<p>Terminar</p>';
		echo '</div>';
	}
	
	/*if($user->nivel<=2){
		echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas" >';
				echo '<div class="restaurante btn-square-lg" onclick="agregar_abono('.$_GET['hab_id'].','.$_GET['estado'].')">';
				//echo '<div class="ocupada" onclick="hab_checkin('.$_GET['hab_id'].','.$_GET['estado'].')">';
				echo '</br>';
				echo '<div>';
					//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
				echo '</div>';
				echo '<div>';
					echo 'Restaurante';
				echo '</div>';
				echo '</br>';
				echo '</div>';
			echo '</div>';
	}*/
	break;


	case 2 :
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_limpieza" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/limpieza.svg" />';
			echo '<p>Limpieza</p>';
	echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_terminar" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/terminar.svg" />';
			echo '<p>Terminar</p>';
		echo '</div>';
	}
	break;


	case 3 :
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_terminar" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/terminar.svg" />';
			echo '<p>Terminar</p>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_cambiar" onclick="hab_cambiar_persona_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
		echo '<img  class="btn_modal_img" src="./assets/iconos_btn/cambiar.svg" />';
			echo '<p>Cambio Rec.</p>';
		echo '</div>';
	}
	break;


	case 4 :
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_terminar" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/terminar.svg" />';
			echo '<p>Terminar</p>';
		echo '</div>';
	}

	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_cambiar" onclick="hab_cambiar_persona_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/cambiar.svg" />';
			echo '<p>Cambio Mant.</p>';
		echo '</div>';
	}
	break;


	case 5 :
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_terminar" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/terminar.svg" />';
			echo '<p>Terminar</p>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="btn_modal_herramientas btn_cambiar" onclick="hab_cambiar_persona_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '<img  class="btn_modal_img" src="./assets/iconos_btn/cambiar.svg" />';
			echo '<p>Cambio Sup.</p>';
		echo '</div>';
	}
	break;
	//reserva pagada
	case 6 :
	if($user->nivel<=2){
		$hoy = date('Y-m-d');
		$entrada_fecha = date('Y-m-d',$entrada);
		if($hoy == $entrada_fecha){
			echo '<div class="btn_modal_herramientas btn_ocupado" onclick="select_asignar_checkin('.$_GET['reserva_id'].',1,'.$_GET['hab_id'].','.$_GET['mov'].')">';
				echo '<img  class="btn_modal_img" src="./assets/iconos_btn/bnt_ocupado.svg" />';
				echo '<p>Asignar</p>';
			echo '</div>';
		}
		
	}
	break;
	case 8:
		if($user->nivel<=2){
			echo '<div class="btn_modal_herramientas btn_desocupar"  onclick="hab_desocupar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].',1)">';
				echo '<img  class="btn_modal_img" src="./assets/iconos_btn/desocupar.svg" />';
				echo '<p>Desocupar</p>';
			echo '</div>';
		}
		break;

}

echo '</div>';
echo '<div class="row flex-wrap justify-content-around">';
	mostar_info($_GET['hab_id'],$_GET['estado'],$hab->mov,$_GET['id'],$entrada,$salida);
echo '</div>';
echo '</div>';
echo '<div class="modal-footer" >
		<button type="button" class="btn btn-danger btn-default" data-dismiss="modal">
			Cancelar
		</button>
		</div>';
?>
