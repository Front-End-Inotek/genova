<?php
			date_default_timezone_set('America/Mexico_City');
			include_once('clase_configuracion.php');
			include_once('clase_usuario.php');
			$config = NEW Configuracion(0);
			$usuario =  NEW Usuario($_GET['id']);
			$usuario->datos($_GET['id']);
			$tiempo=time();
			$nombreUsuario = $usuario->nombre_completo;

			if($_GET['token']== $usuario->token & $usuario->fecha_vencimiento>=$tiempo & $usuario->activo=1 ){
			echo '
			<aside class="aside_nav_container" id="asidenav">
				<div class="aside_nav_logo">
					<a class="aside_nav_logos" href="inicio.php">
						<img class="aside_nav_logo_img" src="./images/nuve.png"/>
						<p class="aside_nav_logo_link">VISIT</p>
					</a>
				</div>
				<div class="aside_nav_username d-none" id="nombreNav">
					<p>Bienvenido <span class="text-secondary" >'.$nombreUsuario.'.</span></p>
				</div>
				<div class="aside_nav_menu_hamburger" >
					<img class="aside_menu_hamburger" src="./assets/icons-nav/burger.svg" onclick="handleSiceTable()"/>
					<div class="aside_nav_menu_switch_container" id="switch_container_menu">
						<input class="switch_input_rack" type="checkbox" role="switch" id="flexSwitchCheckDefault" onclick="switch_rack(); handleSiceTable();" />
						<label class="aside_nav_menu_switch" for="flexSwitchCheckDefault"> Cambiar vista </label>
					</div>
				</div>
				<div class="aside_nav_divider"></div>

				<section class="aside_nav_links">';

				if($usuario->nivel == 0 || $usuario->nivel == 1){
					echo '
					<div class="aside_nav_link_container" onclick="graficas(); handleSiceTable();">
						<img class="aside_nav_link" src="./assets/icons-nav/estadistica.svg" />
						<p class="aside_nav_link_text">Estadísticas</p>
						<img class="aside_nav_link aside_nav_link_text arrow-link hide_arow" src="./assets/icons-nav/arrow-next.svg" />
					</div>
					';
				}
				echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/recepcion.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(1)">Recepción </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(1)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links " id="1">
							<ul class="aside_nav_links_list">
								<li class="aside_ruta" onclick="agregar_check(); handleSiceTable();">Check In</li>
								<li class="aside_ruta" onclick="ver_cuenta_maestra(); handleSiceTable();">Cuenta Maestra</li>
								<li class="aside_ruta" onclick="ver_cargo_noche(); handleSiceTable();">Reporte Diarios</li>
								<li class="aside_ruta" onclick="ver_reportes_llegadas(); handleSiceTable();">Reporte de llegadas</li>
								<li class="aside_ruta" onclick="ver_reportes_salidas(0); handleSiceTable();">Reporte de salidas</li>
								<li class="aside_ruta" onclick="saldo_huespedes(); handleSiceTable();">Saldo de huéspedes</li>
								<li class="aside_ruta" onclick="edo_cuenta_folio_casa(); handleSiceTable();">Edo. cuenta folio casa</li>
								<li class="aside_ruta" onclick="mostrar_herramientas(1,3,101,0,0); handleSiceTable();">edo cuenta</li>
							</ul>
						</div>
					</div>';
				//Opciones para las reservaciones
				$permisos_reservaciones=$usuario->reservacion_ver+$usuario->reservacion_agregar+$usuario->huesped_ver+$usuario->huesped_agregar;
				if($permisos_reservaciones > 0 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/reservaciones.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(2)">Reservaciones </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(2)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="2">
							<ul class="aside_nav_links_list">';
						$permisos_reservar = $usuario->reservacion_ver + $usuario->reservacion_agregar;
						if($permisos_reservar > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_reservaciones(); handleSiceTable();">Ver reservaciones</li>
							<li class="aside_ruta" onclick="agregar_reservaciones(); handleSiceTable();">Agregar reservaciones</li>
							';
						}
						$permisos_huesped = $usuario->huesped_ver+$usuario->huesped_agregar;
						if($permisos_huesped > 0){
							echo '
							<li class="aside_ruta" onclick="ver_huespedes(); handleSiceTable();">Info huéspedes</li>
							<li class="aside_ruta" onclick="ver_reportes_canceladas(); handleSiceTable();">Reporte de cancelaciones</li>
							';
						}
						echo '
							</ul>
						</div>
					</div>';
				}
				// Opciones para los reportes
				$permisos_reportes=$usuario->reporte_ver+$usuario->reservacion_agregar;
				if($permisos_reportes > 0 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/reportes.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(3)">Reportes </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(3)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="3">
							<ul class="aside_nav_links_list">
							<li class="aside_ruta" onclick="ver_reporte_corte(); handleSiceTable();">Reporte cortes</li>
							';
						$permisos_reportes_diarios=$usuario->reporte_ver+$usuario->reporte_agregar;
						if($permisos_reportes_diarios > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_cargo_noche(); handleSiceTable();">Cargos por noche</li>
							';
						}
						$permisos_surtir=$usuario->inventario_surtir;
						if($permisos_surtir > 0){
							echo '
							<li class="aside_ruta" onclick="ver_surtir(); handleSiceTable();">Surtir</li>
							';
						}
						echo '
							<li class="aside_ruta" onclick="corte_diario(); handleSiceTable();">Corte diario</li>
							<li class="aside_ruta" onclick="pronosticos(); handleSiceTable();">Pronosticos de ocupación</li>
						';
						$permisos_reportes_diarios=$usuario->reporte_ver;
						if($permisos_reportes_diarios > 0 || $usuario->nivel == 2){
							echo '
							<li class="aside_ruta" onclick="ver_historial_cuentas(); handleSiceTable();">Historial de cuentas</li>
							';
						}
						if(true){
							echo '
							<li class="aside_ruta" onclick="ver_reporte_ama_de_llaves(); handleSiceTable();">Reporte ama de llaves</li>
							';
						}
						echo '
							</ul>
						</div>
					</div>';
				}
				//Menu Cortes y transacciones
				if($permisos_reportes > 0 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/cortesytransacciones.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(4)">Cortes y transacciones </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(4)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="4">
							<ul class="aside_nav_links_list">';
						$permisos_reportes_diarios=$usuario->reporte_ver+$usuario->reporte_agregar;
						$permisos_surtir=$usuario->inventario_surtir;
						$permisos_reportes_diarios=$usuario->reporte_ver;
						if($permisos_reportes_diarios > 0 || $usuario->nivel == 2){
							echo '
							<li class="aside_ruta" onclick="ver_cortes(); handleSiceTable();">Historial cortes usuario</li>
							<li class="aside_ruta" onclick="hacer_cortes_dia(); handleSiceTable();">Corte diario usuario</li>
							<li class="aside_ruta" onclick="hacer_cortes(0); handleSiceTable();">Resumen transacciones</li>
							';
						};
						echo '
							</ul>
						</div>
					</div>';
				}
				//Menu Facturacion
				$permiso_ver_facturacion = $usuario->facturas_ver;
				if($permiso_ver_facturacion  > 0 || $usuario->nivel == 2 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/factura.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(5)">Facturacion </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(5)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="5">
							<ul class="aside_nav_links_list">';
							if($usuario->nivel <=1){
								echo '
									<li class="aside_ruta" onclick="factura_individual(); handleSiceTable();">Factura individual</li>';
								};
							echo'
								<!-- <li class="aside_ruta" onclick="factura_individual(); handleSiceTable();">Factura individual</li> -->
								<li class="aside_ruta" onclick="factura_global_form(); handleSiceTable();">Factura global</li>
								<li class="aside_ruta" onclick="folio_casa_form(); handleSiceTable();">Buscar conceptos por folio casa</li>';
						$permisos_cancelar_factura=$usuario->facturas_cancelar;
						if($permisos_cancelar_factura > 0 || $usuario->nivel == 2){
							echo '
								<li class="aside_ruta" onclick="factura_cancelar(); handleSiceTable();">Cancelar factura</li>
							';
						};
						echo '
								<li class="aside_ruta" onclick="factura_buscar_fecha(); handleSiceTable();">Buscar factura por fecha</li>
								<li class="aside_ruta" onclick="factura_buscar_folio(); handleSiceTable();">Buscar factura por folio</li>
								<li class="aside_ruta" onclick="factura_buscar_folio_casa(); handleSiceTable();">Buscar factura folio casa</li>
								<li class="aside_ruta" onclick="factura_resumen(); handleSiceTable();">Resumen Facturas</li>
							</ul>
						</div>
					</div>';
				}
				$permisos_restaurantes=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->restaurante_ver+$usuario->restaurante_agregar;
				if($permisos_restaurantes > 0 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/restaurante.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(6)">Restaurante </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(6)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="6">
							<ul class="aside_nav_links_list">';
							$permisos_restaurante=$usuario->restaurante_ver+$usuario->restaurante_agregar;
						if($permisos_restaurante > 0){
							echo '
							<li class="aside_ruta" onclick="agregar_restaurante(0,0); handleSiceTable();">Restaurante</li>
							';
						}
						$permisos_inventario=$usuario->inventario_ver+$usuario->inventario_agregar+$usuario->categoria_ver;
						if($permisos_inventario > 0 ){
							echo '
							<li class="aside_ruta" onclick="agregar_inventario(); handleSiceTable();">Agregar</li>
							<li class="aside_ruta" onclick="ver_categorias(); handleSiceTable();">Categorías</li>
							<li class="aside_ruta" onclick="ver_inventario(); handleSiceTable();">Inventario</li>
							';
						};
						$permisos_surtir=$usuario->inventario_surtir;
						if($permisos_surtir > 0 ){
							echo '
							<li class="aside_ruta" onclick="surtir_inventario(); handleSiceTable();">Surtir</li>
							';
						}
						$permisos_restaurante=$usuario->restaurante_ver+$usuario->restaurante_agregar;
						if($permisos_restaurante > 0){
							echo '
							<li class="aside_ruta" onclick="mesas_restaurante(); handleSiceTable();">Mesas</li>
							<li class="aside_ruta" onclick="agregar_mesa(); handleSiceTable();">Agregar mesa</li>
							';
						}
						echo '
							</ul>
						</div>
					</div>';
				}
				// configuracion habitacion
				$permisos_habitaciones=$usuario->tipo_ver+$usuario->tipo_agregar+$usuario->tarifa_ver+$usuario->tarifa_agregar+$usuario->hab_ver+$usuario->hab_agregar;
				if($permisos_habitaciones > 0 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/configuracionhab.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(7)">Configuración Hab. </p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(7)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="7">
							<ul class="aside_nav_links_list">';
						$permisos_tipo=$usuario->tipo_ver+$usuario->tipo_agregar;
						if($permisos_tipo > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_tipos(); handleSiceTable();">Ver tipo de habitación</li>
							';
						};
						$permisos_tarifa=$usuario->tarifa_ver+$usuario->tarifa_agregar;
						if($permisos_tarifa > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_tarifas(); handleSiceTable();">Ver tipos de tarifa</li>
							';
						}
						$permisos_hab=$usuario->hab_ver+$usuario->hab_agregar;
						if($permisos_hab > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_hab(); handleSiceTable();">Ver habitaciones</li>
							';
						}
						echo '
							</ul>
						</div>
					</div>';
				}

				//Opciones Herramientas
				$permisos_herramientas=$usuario->usuario_ver+$usuario->usuario_agregar+$usuario->logs_ver+$usuario->forma_pago_ver+$usuario->forma_pago_agregar+$usuario->cupon_ver+$usuario->cupon_agregar;
				if($permisos_herramientas > 0 ){
					echo '
					<div class="aside_nav_link_containerMore" >
						<div class="aside_nav_link_containerInfo">
							<img class="aside_nav_link" src="./assets/icons-nav/herramientas.svg" onclick="handleSiceTable()"/>
							<p class="aside_nav_link_text flex-grow-1" onclick="showMenu(8)">Herramientas</p>
							<img class="aside_nav_link aside_nav_link_text arrow-link" src="./assets/icons-nav/arrow.svg" onclick="showMenu(8)"/>
						</div>
						<div class="aside_nav_link_containerInfo_links" id="8">
							<ul class="aside_nav_links_list">
							<li class="aside_ruta" onclick="ver_reactivar_tickets(); handleSiceTable();">Reactivar tickets</li>
							';
						$permisos_usuario=$usuario->usuario_ver;
						if($permisos_usuario > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_usuarios(); handleSiceTable();">Ver usuario</li>
							';
						};
						$permisos_usuario=$usuario->usuario_agregar;
						if($permisos_usuario > 0 ){
							echo '
							<li class="aside_ruta" onclick="agregar_usuarios('.$_GET['id'].'); handleSiceTable();">Agregar Usuario</li>
							';
						};
						$permisos_logs=$usuario->logs_ver;
						if($permisos_logs > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_logs(); handleSiceTable();">Logs</li>
							';
						};
						$permisos_forma_pago=$usuario->forma_pago_ver;
						if($permisos_forma_pago > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_formas_pago(); handleSiceTable();">Forma de pago</li>
							';
						};
						$permisos_cupon=$usuario->cupon_ver+$usuario->cupon_agregar;
						if($permisos_cupon > 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_cupones(); handleSiceTable();">Cupones</li>
							';
						};
						$permisos_configuracion= $usuario->nivel;
						if($permisos_configuracion == 0 ){
							echo '
							<li class="aside_ruta" onclick="ver_tipos(); handleSiceTable();">Configuración</li>
							<li class="aside_ruta" onclick="config_colores_hab(); handleSiceTable();">Configuración colores hab.</li>
							<li class="aside_ruta" onclick="ver_planes_alimentos(); handleSiceTable();">Plan de alimentos</li>
							<li class="aside_ruta" onclick="ver_politicas_reservacion(); handleSiceTable();">Políticas de reservación</li>
							';
						};
						echo '
							</ul>
						</div>
					</div>';
				}
				// opciones de auditoria
				if($usuario->auditoria_editar > 0 ){
					echo '
					<div class="aside_nav_link_container" onclick="ver_auditoria();  handleSiceTable();">
						<img class="aside_nav_link" src="./assets/icons-nav/auditoria.svg" />
						<p class="aside_nav_link_text">Auditoría</p>
						<img class="aside_nav_link aside_nav_link_text arrow-link hide_arow" src="./assets/icons-nav/arrow-next.svg" />
					</div>
					';
				}
				if($usuario->nivel == 0 ){
					echo '
					<div class="aside_nav_link_container" onclick="ver_nuevo_rack(); handleSiceTable();">
						<img class="aside_nav_link" src="./assets/icons-nav/desarrollo.svg" />
						<p class="aside_nav_link_text">Desarrollo</p>
						<img class="aside_nav_link aside_nav_link_text arrow-link hide_arow" src="./assets/icons-nav/arrow-next.svg" />
					</div>
					';
				};
				//Herramientas de super usuario !SOLO PARA DESARROLLADORES
				if($usuario->nivel == 0 ){
					echo '
					<div class="aside_nav_link_container" onclick="herramientas_admin(); handleSiceTable();">
						<img class="aside_nav_link" src="./assets/icons-nav/admin.svg" />
						<p class="aside_nav_link_text">Herramientas Admin</p>
						<img class="aside_nav_link aside_nav_link_text arrow-link hide_arow" src="./assets/icons-nav/arrow-next.svg" />
					</div>
					';
				}
				echo '
					<div class="aside_nav_divider"></div>
					<div class="aside_nav_link_container aside_btn_salir" onclick="pregunta_salir()">
						<img class="aside_nav_link" src="./assets/icons-nav/salir.svg" />
						<p class="aside_nav_link_text">Salir</p>
					</div>
				</section>
			</aside>
			';
		}else {
			echo "
			<div class='expire_message'>
				<img class='expire_message_img' src='./images/nuve.png'/>
				<h1 class='expire_message_text'>Su sesión ha expirado o su cuenta ha sido abierta desde otro dispositivo. Es necesario iniciar sesión nuevamente.</h1>
			</div>
			";
			echo '
			<script>
				salida_automatica();
			</script>
			';
		}
?>