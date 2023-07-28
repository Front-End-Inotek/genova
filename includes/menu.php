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
			<div class="side-navbar   flex-wrap flex-column" id="sidebar">
			<ul class="nav flex-column text-white w-100">
			<div class="informacion">
			<a href="inicio.php" class="nav-link text-white my-2">
				<img src="images/InotekLogotipoRec.png" alt="logo" width="215" height="50" style= "filter: invert(1); object-fit: contain;">
			</a>
			<div class="texto-check"><p></p></div>
			<div class="form-check2 form-switch ocultar">
			<input class="form-check-input2" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="cambiarVista(); switch_rack();">
			<label class="form-check-label2" for="flexSwitchCheckDefault" onclick="sub_menu(); boton_menu();">
			<span id="vista" class="toggle-text vista-habitacional">Rack Habitacional</span>
			</label>
			</div>
			</div>';
			if($usuario->nivel==0){
				echo '<li href="#" class="nav-link" onclick="sub_menu(); boton_menu();">
				<i class="bx bxs-chart text-secondary" ></i>
				<span class="mx-2" onclick="graficas()"> Estadística </span>
				</li>';
			}

			echo '
			<li href="#" onclick="showMenu(1)" class="nav-link">
			<i class="bx bx-desktop text-secondary"></i>
			<span class="mx-2">Recepcion</span>
			<ul id="1" class="submenu" name="1">
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="agregar_check()"> Check In </a></i></ul>
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cuenta_maestra()"> Cuenta Maestra </a></i></ul>';
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cargo_noche()">Reporte Diarios </a></i></ul>';
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reportes_llegadas()">Reporte de llegadas</a></i></ul>';
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reportes_salidas()">Reporte de salidas</a></i></ul>';
		echo'
			</ul>
			</li>';


		$permisos_reservaciones=$usuario->reservacion_ver+$usuario->reservacion_agregar+$usuario->huesped_ver+$usuario->huesped_agregar;
		if($permisos_reservaciones>0){
		echo '
		<li href="#" onclick="showMenu(2)" class="nav-link">
			<i class="bx bx-calendar text-secondary" ></i>
			<span class="mx-2 reservaciones">Reservaciones</span>
			<ul id="2" class="submenu">';

			$permisos_reservar=$usuario->reservacion_ver+$usuario->reservacion_agregar;
			if($permisos_reservar>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reservaciones()"> Ver reservaciones </a></i></ul>';
				echo '
					<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="agregar_reservaciones()"> Agregar reservaciones </a></i></ul>
				';

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

		if($usuario->llegadas_salidas_ver>0){
			echo '
			<li href="#" onclick="showMenu(3)" class="nav-link">
			<i class="bx bxs-arrow-to-right text-secondary"></i>
			<span class="mx-2">Llegadas y Salidas</span>
			<ul id="3" class="submenu">
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reportes_reservaciones(1)"> Llegadas probables </a></i></ul>
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reportes_reservaciones(2)"> Llegadas efectivas </a></i></ul>
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reportes_reservaciones(3)"> Salidas probables </a></i></ul>
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_reportes_reservaciones(4)"> Salidas efectivas </a></i></ul>
			';
		echo'
			</ul>
			</li>';
		}


		$permisos_reportes=$usuario->reporte_ver+$usuario->reservacion_agregar;
		if($permisos_reportes>0){
		echo '
		<li href="#" onclick="showMenu(4)" class="nav-link">
			<i class="bx bxs-report text-secondary"></i>
			<span class="mx-2 reportes">Reportes</span>
			<ul id="4" class="submenu">';

			$permisos_reportes_diarios=$usuario->reporte_ver+$usuario->reporte_agregar;
			if($permisos_reportes_diarios>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cargo_noche()"> Cargos por noche </a></i></ul>';
			}
			$permisos_surtir=$usuario->inventario_surtir;
			if($permisos_surtir>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_surtir()"> Surtir </a></i></ul>';
			}

			$permisos_reportes_diarios=$usuario->reporte_ver;//+$usuario->reporte_agregar;
			if($permisos_reportes_diarios>0 || $usuario->nivel==2){
			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_cortes()"> Ver cortes </a></i></ul>';

			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="hacer_cortes_dia()"> Corte Global Diario </a></i></ul>';

			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="hacer_cortes()"> Corte Global </a></i></ul>';

			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="hacer_corte(0)"> Resumen transacciones </a></i></ul>';

			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="saldo_huespedes()"> Saldo de huéspedes </a></i></ul>';

			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="corte_diario()"> Corte diario </a></i></ul>';

			echo'
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_historial_cuentas()"> Historial cuentas </a></i></ul>';

			}
		}
		echo'
			</ul>
		</li>';


		$permisos_restaurantes=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->restaurante_ver+$usuario->restaurante_agregar;
		if($permisos_restaurantes>0){
		echo '
		<li href="#" onclick="showMenu(5)" class="nav-link">
			<i class="bx bx-user-check text-secondary"></i>
			<span class="mx-2">Restaurante</span>
			<ul id="5" class="submenu">';

			$permisos_inventario=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->categoria_ver;
			if($permisos_inventario>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="agregar_inventario()"> Agregar </a></i></ul>';
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_categorias()"> Categorías </a></i></ul>';
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
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="mesas_restaurante()">Mesas</a></i></ul>';
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="agregar_mesa()"> Agregar mesa </a></i></ul>';
			}
		}
			echo '
			</ul>
		</li>';


		$permisos_habitaciones=$usuario->tipo_ver+$usuario->tipo_agregar+$usuario->tarifa_ver+$usuario->tarifa_agregar+$usuario->hab_ver+$usuario->hab_agregar;
		if($permisos_habitaciones>0){
				echo '
				<li id="#" onclick="showMenu(6);" class="nav-link">
				<i class="bx bx-bed text-secondary"></i>
				<span class="mx-2 habitaciones">Configuracion Hab.</span>
				<ul id="6" class="submenu ocultar">
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
				<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_hab()">Ver habitaciones</a></i></ul>';
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
		';
		if($usuario->auditoria_ver>0){
			echo '<li href="#"  class="nav-link" onclick="sub_menu(); boton_menu();">
					<i class="bx bx-file-find text-secondary"></i>
					<span class="mx-2"  onclick="ver_auditoria()">Auditoría</span>
				</li>';
		}

		$permisos_herramientas=$usuario->usuario_ver+$usuario->usuario_agregar+$usuario->logs_ver+$usuario->forma_pago_ver+$usuario->forma_pago_agregar+$usuario->cupon_ver+$usuario->cupon_agregar;
		if($permisos_herramientas>0){
		echo '
		<li href="#" onclick="showMenu(7)" class="nav-link">
			<i class="bx bxs-wrench text-secondary"></i>
			<span class="mx-2">Herramientas</span>
			<ul id="7" class="submenu">';

			$permisos_usuario=$usuario->usuario_ver;
			if($permisos_usuario>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_usuarios()">Ver Usuarios </a></i></ul>';
			}
			$permisos_usuario=$usuario->usuario_agregar;
			if($permisos_usuario>0){
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="agregar_usuarios('.$_GET['id'].')">Agregar Usuarios </a></i></ul>';
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
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_planes_alimentos()">Plan de alimentos</a></i></ul>';
			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_politicas_reservacion()">Políticas de reservación</a></i></ul>';

			echo '
			<ul class="contenedor-sub" onclick="sub_menu(); boton_menu();"><a class="subitem" onclick="ver_tipos_abonos()">Tipos de abonos</a></i></ul>';
			}
		}
			echo '
			</ul>
		</li>';

		$permisos_reportes=$usuario->reporte_ver+$usuario->reservacion_agregar;
		if($permisos_reportes>0) {
			echo '<li href="#" class="nav-link" onclick="sub_menu(); boton_menu();">
			<i class="bx bxs-user text-secondary" ></i>
			<span class="mx-2" onclick=""> Desarrollo </span>
			<!-- <span class="mx-2" onclick="mostrar_cargo_noche()"> Desarrollo </span> -->
			</li>';
		}

		echo '
		<li href="#" onclick="pregunta_salir()" class="nav-link">
			<i class="bx bx-exit text-secondary"></i>
			<span class="mx-2">Salir</span>
		</li>
		</ul>
			<!--ajustado con bootstrap---->
			<div class="informacion">
		<a href="#" class="btn btn-primary border-0 d-flex align-items-center justify-content-center icon-btn icon-btn--verde menu-btn" onclick="boton_menu()" id="menu-btn-desplegar">
			<!--icono extraido con la clase desde box icons---->
            <i class="bx bx-menu"></i>
            <span class="label color_black">Menu</span>
		</a>
		<!---
		<a href="#" class="btn btn-primary border-0 d-flex align-items-center justify-content-center icon-btn icon-btn--amarillo menu-btn" id="menu-btn-fecha">
			<i class="bx bx-calendar-star"></i>
            <span class="label">Fechas</span>
		</a>
		<a href="#" class="btn btn-primary border-0 d-flex align-items-center justify-content-center icon-btn icon-btn--rojo menu-btn" id="menu-btn-filtrar">
		<i class="bx bx-search-alt-2" ></i>
		<span class="label">Buscar</span>

		</a>
		<a class="btn btn-primary border-0 d-flex align-items-center justify-content-center menu-btn icon-btn icon-btn--morado" id="mostrar-botones" onclick="toggleBotones()">
            <i class="bx bxl-stack-overflow" ></i>
            <span class="label">Filtro</span>
        </a>-->
	</div>


	</div>';

		echo'
		<div class="modal fade" id="ventanasalir">
		<div class="modal-dialog>"
			<div class="modal-content">
			<div class"modal-header">
				<h3 class="modal-title"> <p> <a href="#" class="text-dark"> Reservaciones -> salir </a> </p> </h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
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