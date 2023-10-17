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


echo '<div class="modal-header" style="background-color: #97b2f9ee; color: #000;">
		<h3 class="modal-title">Habitacion '.$nombre_habitacion.' </h3>
		<button type="button" class="close" data-dismiss="modal">&times;</button>
	</div>';
echo '<div class="container-fluid">';
echo $estado_interno;
show_info($_GET['hab_id'],$_GET['estado'],$estado_interno);
echo '</br>';
echo '<div class="row flex-wrap">';


switch ($_GET['estado']) {
	case 0:
	if($user->nivel<=2 && $conf->hospedaje ==1){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="supervision ocupadoH  btn-square-lg" onclick="disponible_asignar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cama.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Asignar / ocupar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	//boton para agregar reservas
	if(true){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="supervision AsignarReserva  btn-square-lg" onclick="asignarHabitacion('.$id_reserva.','.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cama.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Asignar reserva';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		$nuevo_estado= 2;
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="limpieza ocupada-limpieza btn-square-lg" onclick="hab_estado_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$nuevo_estado.')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Limpieza';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="sucia btn-square-lg" onclick="hab_sucia_vacia('.$_GET['hab_id'].',2)">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Sucia';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="ocupada usoCasa uso btn-square-lg" onclick="uso_casa_asignar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cama.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Uso casa';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		// echo $nuevo_estado;
		$nuevo_estado=9;
		$nuevo_estado= 4;
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="ocupada mantenimiento btn-square-lg" onclick="hab_estado_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$nuevo_estado.')">';
			echo '</br>';
			echo '<div>';
			echo '</div>';
			echo '<div>';
			echo 'Mantenimiento';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2 && $conf->hospedaje ==1){
		$nuevo_estado= 10;
		$nuevo_estado=5;
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="ocupada bloqueo btn-square-lg" onclick="hab_estado_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$nuevo_estado.')">';
			echo '</br>';
			echo '<div>';
			echo '</div>';
			echo '<div>';
			echo 'Bloqueo';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	break;


	case 1 :
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="desocupar btn-square-lg" onclick="hab_desocupar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Desocupar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas" >';
		echo '<div class="edo_cuenta btn-square-lg" onclick="estado_cuenta('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Edo. Cuenta';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas" >';
		echo '<div class="restaurante btn-square-lg" onclick="agregar_restaurante('.$_GET['hab_id'].','.$_GET['estado'].')">';
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
	}
	if($user->nivel<=2 && $estado_interno != 'sucia'){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="sucia btn-square-lg" onclick="hab_sucia_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Sucia';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	if($user->nivel<=2 && $estado_interno != 'limpieza'){
		echo '<div class="col-md-3 btn-herramientas" >';
		echo '<div class="limpieza btn-square-lg" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Limpieza';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	/* boton para editar */
	if($user->nivel<=2){
		$ruta="recargar_pagina()";
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="editarHab btn-square-lg" onclick="editar_checkin('.$id_reserva.','.$_GET['hab_id'].',\''.$ruta.'\')">';
			echo '</br>';
			echo '<div>';
			echo '</div>';
			echo '<div>';
			echo 'Editar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	/* boton para editar */
	if($user->nivel<=2){
		$ruta="recargar_pagina()";
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="btnCambiarHab btn-square-lg" onclick="hab_estado_cambiar_hab('.$id_reserva.','.$_GET['hab_id'].','.$_GET['estado'].',\''.$ruta.'\')">';
			echo '</br>';
			echo '<div>';
			echo '</div>';
			echo '<div>';
			echo 'Cambiar hab.';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2 && $estado_interno != 'sin estado'){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="terminar btn-square-lg" onclick="hab_ocupada_terminar_interno('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Terminar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
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
		echo '<div class="col-md-3 btn-herramientas" >';
		echo '<div class="limpieza btn-square-lg" onclick="hab_estado_limpiar('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/cobrando.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Limpieza';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="terminar btn-square-lg" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Terminar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	break;


	case 3 :
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="terminar btn-square-lg" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Terminar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="cambiar_usuario btn-square-lg" onclick="hab_cambiar_persona_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Cambio Rec.';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	break;


	case 4 :
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="terminar btn-square-lg" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Terminar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}

	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="cambiar_usuario btn-square-lg" onclick="hab_cambiar_persona_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Cambio Mant.';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	break;


	case 5 :
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="terminar btn-square-lg" onclick="hab_terminar_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Terminar';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	if($user->nivel<=2){
		echo '<div class="col-md-3 btn-herramientas">';
		echo '<div class="cambiar_usuario btn-square-lg" onclick="hab_cambiar_persona_estado('.$_GET['hab_id'].','.$_GET['estado'].')">';
			echo '</br>';
			echo '<div>';
				//echo '<img src="images/home.png"  class="center-block img-responsive">';
			echo '</div>';
			echo '<div>';
			echo 'Cambio Sup.';
			echo '</div>';
			echo '</br>';
		echo '</div>';
		echo '</div>';
	}
	break;
	//reserva pagada
	case 6 :
	if($user->nivel<=2){
		$hoy = date('Y-m-d');
		$entrada_fecha = date('Y-m-d',$entrada);
		if($hoy == $entrada_fecha){
			echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
			echo '<div class="ocupadoH btn-square-lg" onclick="select_asignar_checkin('.$_GET['reserva_id'].',1,'.$_GET['hab_id'].','.$_GET['mov'].')">';
				echo '</br>';
				echo '<div>';
					//echo '<img src="images/home.png"  class="center-block img-responsive">';
				echo '</div>';
				echo '<div>';
				echo 'Asignar';
				echo '</div>';
				echo '</br>';
			echo '</div>';
			echo '</div>';
		}
		
	}
	break;
	case 8:
		if($user->nivel<=2){
			echo '<div class="col-md-3 btn-herramientas">';
			echo '<div class="desocupar btn-square-lg" onclick="hab_desocupar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].',1)">';
				echo '</br>';
				echo '<div>';
					//echo '<img src="images/home.png"  class="center-block img-responsive">';
				echo '</div>';
				echo '<div>';
				echo 'Desocupar';
				echo '</div>';
				echo '</br>';
			echo '</div>';
			echo '</div>';
		}
		break;

}



echo '</div>';
echo '<div class="row flex-wrap justify-content-around">';
	mostar_info($_GET['hab_id'],$_GET['estado'],$hab->mov,$_GET['id'],$entrada,$salida);
echo '</div>';
echo '</div>';
echo '<div class="modal-footer" style="background-color: #97b2f9ee; color: #000;">
		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
		</div>';
?>
