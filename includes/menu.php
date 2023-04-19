			<?php
			date_default_timezone_set('America/Mexico_City');
			include_once('clase_configuracion.php');
			include_once('clase_usuario.php');
			$config = NEW Configuracion(0);
			$usuario =  NEW Usuario($_GET['id']);
			$usuario->datos($_GET['id']);
			$tiempo=time();
			if($_GET['token']== $usuario->token & $usuario->fecha_vencimiento>=$tiempo & $usuario->activo=1 ){

			echo '
			<!----------------------->
			<!-- Side-Nav -->
			<!----------------------->
		<div class="side-navbar d-flex justify-content-between flex-wrap flex-column" id="sidebar">
		<ul class="nav flex-column text-white w-100">
		<div class="informacion">
		<a href="inicio.php" class="nav-link text-white my-2">
			<img src="images/InotekLogotipoRec.png" alt="logo" width="215" height="50" style= "margin-top: 25px; margin-bottom:10px;">
		</a>
		<div class="texto-check"><p>Cambiar a vista Habitacional</p></div>
        <div class="form-check2 form-switch ocultar">
        <input class="form-check-input2" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="switch_rack();">
        <label class="form-check-label2" for="flexSwitchCheckDefault" onclick="sub_menu(); boton_menu();"></label>
        </div>
		</div>';

		$permisos_habitaciones=$usuario->tipo_ver+$usuario->tipo_agregar+$usuario->tarifa_ver+$usuario->tarifa_agregar+$usuario->hab_ver+$usuario->hab_agregar;
		if($permisos_habitaciones>0){
				echo '
				<li id="#" onclick="sub_menu();" class="nav-link">
				<i class="bx bx-bed"></i>
				<span class="mx-2 habitaciones">Habitaciones</span>
				<ul id="habitaciones_submenu" class="submenu ocultar">
				';

			$permisos_tipo=$usuario->tipo_ver+$usuario->tipo_agregar;
			if($permisos_tipo>0){
				echo '
				<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_tipos();">Ver tipos de habitación</a></i></ul>';
			}

			$permisos_tarifa=$usuario->tarifa_ver+$usuario->tarifa_agregar;
			if($permisos_tarifa>0){
				echo '
				<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_tarifas()"> Ver tipos de tarifa</a></i></ul>';
			}

			$permisos_hab=$usuario->hab_ver+$usuario->hab_agregar;
			if($permisos_hab>0){
				echo '
				<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_hab()">Ver tipos de habitaciones</a></i></ul>';
			}
		}
			echo '
			</ul>
		</li>';


		$permisos_reservaciones=$usuario->reservacion_ver+$usuario->reservacion_agregar+$usuario->huesped_ver+$usuario->huesped_agregar;
		if($permisos_reservaciones>0){
		echo '
		<li href="#" onclick="sub_menu()" class="nav-link">
			<i class="bx bx-calendar" ></i>
			<span class="mx-2 reservaciones">Reservaciones</span>
			<ul id="reservaciones_submenu" class="submenu">';

			$permisos_reservar=$usuario->reservacion_ver+$usuario->reservacion_agregar;
			if($permisos_reservar>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reservaciones()"> Ver reservaciones </a></i></ul>';
			}

			$permisos_huesped=$usuario->huesped_ver+$usuario->huesped_agregar;
			if($permisos_huesped>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_huespedes()">Ver huéspedes</a></i></ul>';
			}
		}
			echo'
			</ul>
		</li>';


		$permisos_reportes=$usuario->reporte_ver+$usuario->reservacion_agregar;
		if($permisos_reportes>0){
		echo '
		<li href="#" onclick="sub_menu()" class="nav-link">
			<i class="bx bxs-report" ></i>
			<span class="mx-2 reportes">Reportes</span>
			<ul id="reportes_submenu" class="submenu">';

			$permisos_reportes_diarios=$usuario->reporte_ver+$usuario->reporte_agregar;
			if($permisos_reportes_diarios>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cargo_noche()"> Diarios </a></i></ul>';
			}
			$permisos_surtir=$usuario->inventario_surtir;
			if($permisos_surtir>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_surtir()"> Surtir </a></i></ul>';
			}

			$permisos_reportes_diarios=$usuario->reporte_ver;//+$usuario->reporte_agregar;
			if($permisos_reportes_diarios>0 || $usuario->nivel==2){
			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cortes()"> Corte </a></i></ul>';
			}
		}
		echo'
			</ul>
		</li>';


		$permisos_herramientas=$usuario->usuario_ver+$usuario->usuario_agregar+$usuario->logs_ver+$usuario->forma_pago_ver+$usuario->forma_pago_agregar+$usuario->cupon_ver+$usuario->cupon_agregar;
		if($permisos_herramientas>0){
		  echo '
		<li href="#" onclick="sub_menu()" class="nav-link">
			<i class="bx bxs-wrench"></i>
			<span class="mx-2">Herramientas</span>
			<ul id="herramientas_submenu" class="submenu">';

			$permisos_usuario=$usuario->usuario_ver+$usuario->usuario_agregar;
			if($permisos_usuario>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_usuarios()"> Usuarios </a></i></ul>';
			}

			$permisos_logs=$usuario->logs_ver;
			if($permisos_logs>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_logs()"> Logs </a></i></ul>';
			}

			$permisos_forma_pago=$usuario->forma_pago_ver;
			if($permisos_forma_pago>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_formas_pago()"> Formas de pago </a></i></ul>';
			}

			$permisos_cupon=$usuario->cupon_ver+$usuario->cupon_agregar;
			if($permisos_cupon>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cupones()"> Cupones </a></i></ul>';
			}

			$permisos_configuracion= $usuario->nivel;
			if($permisos_configuracion==0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_tipos()"> Configuracion </a></i></ul>';
			}
		}
			echo '
			</ul>
		</li>';



		$permisos_restaurantes=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->restaurante_ver+$usuario->restaurante_agregar;
		if($permisos_restaurantes>0){
		echo '
		<li href="#" onclick="sub_menu()" class="nav-link">
			<i class="bx bx-user-check"></i>
			<span class="mx-2">Restaurante</span>
			<ul id="restaurante_submenu" class="submenu">';

			$permisos_inventario=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->categoria_ver;
			if($permisos_inventario>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_inventario()"> Inventario </a></i></ul>';
			}

			$permisos_surtir=$usuario->inventario_surtir;
			if($permisos_surtir>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="surtir_inventario()"> Surtir </a></i></ul>';
			}
			$permisos_restaurante=$usuario->restaurante_ver+$usuario->restaurante_agregar;
			if($permisos_restaurante>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="agregar_restaurante(0,0)"> Restaurante </a></i></ul>';
			}
		}
			echo '
			</ul>
		</li>';

		/*<li href="" onclick="ver_rack_habitacional()" class="nav-link">
			<i class="bx bxs-user" ></i>
			<span class="mx-2">Rack Habitacional</span>
		</li>*/

		echo '
		<li href="#" class="nav-link">
			<i class="bx bxs-user" ></i>
			<span class="mx-2">Desarrollo</span>
		</li>



		<li href="#" onclick="pregunta_salir()" class="nav-link">
			<i class="bx bx-exit"></i>
			<span class="mx-2">Salir</span>
		</li>



		</ul>
			<!--ajustado con bootstrap---->
		<a href="#" class="btn btn-primary border-0 d-flex align-items-center justify-content-center menu-btn" onclick="boton_menu()" id="menu-btn-desplegar">
			<!--icono extraido con la clase desde box icons---->
		<i class="bx bx-menu"></i>
		</a>
		<a href="#" class="btn btn-primary border-0 d-flex align-items-center justify-content-center menu-btn" id="menu-btn-fecha">
			<i class="bx bx-calendar-star"></i>
		</a>
		<a href="#" class="btn btn-primary border-0 d-flex align-items-center justify-content-center menu-btn" id="menu-btn-filtrar">
			<!--bx-tada da el efecto de movimiento---->
			<i class="bx bx-search-alt-2" ></i>
		</a>
		<button class="btn btn-primary border-0 d-flex align-items-center justify-content-center menu-btn" id="mostrar-botones" onclick="toggleBotones()">
			<i class="bx bxl-stack-overflow" ></i>
		</button>

	</div>';

		echo'
		<div class="modal fade" id="ventanasalir">
		<div class="modal-dialog>"
			<div class="modal-content">
			<div class"modal-header">
				<h3 class="modal-title"> <p> <a href="#" class="text-dark"> Reservaciones -> salir </a> </p> </h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span arial-hidden="true">&times;</span></button>
				</div><br>

				<div class="modal-body">
					<p><a href="#" class="text-dark"> ¿ '. $usuario->usuario .' estas seguro de salir de la aplicación? </a></p>
				</div><br>

				<div class="modal-body">
					<button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar </button>
					<button type="button" class="btn btn-success" onclick="pregunta_salir()"> salir </button>
				</div>
				</div>
			</div>
			</div>
		';

			}else{
			echo 'Su sesion a espirado o su cuenta ha sido abierta desde otro dispositivo , es necesario iniciar sesion nuevamente ';
			echo "<script>";
			echo "salida_automatica();";
			echo "</script>";
			}
			?>
			