<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $usuario= NEW Usuario($_POST['id']);
  $logs = NEW Log(0);

  $usuario->editar_usuario($_POST['id'],urldecode($_POST['usuario']),$_POST['nivel'],urldecode($_POST['nombre_completo']),urldecode($_POST['puesto']),urldecode($_POST['celular']),urldecode($_POST['correo']),urldecode($_POST['direccion']),$_POST['usuario_editar'],$_POST['usuario_borrar'],$_POST['huesped_editar'],$_POST['huesped_borrar'],$_POST['tarifa_editar'],$_POST['tarifa_borrar'],$_POST['reservacion_agregar'],$_POST['reservacion_editar'],$_POST['reservacion_borrar'],$_POST['reservacion_preasignar'],$_POST['forma_pago_ver'],$_POST['forma_pago_agregar'],$_POST['forma_pago_editar'],$_POST['forma_pago_borrar'],$_POST['inventario_editar'],$_POST['inventario_borrar'],$_POST['categoria_editar'],$_POST['categoria_borrar'],$_POST['cupon_ver'],$_POST['cupon_agregar'],$_POST['cupon_editar'],$_POST['cupon_borrar'],$_POST['logs_ver'],$_POST['auditoria_ver'],$_POST['auditoria_editar'],$_POST["combinar_cuentas"],$_POST["ver_graficas"], $_POST['check_in'], $_POST['cuenta_maestra'], $_POST['reporte_diario'], $_POST['reporte_llegada'], $_POST['reporte_salidas'], $_POST['saldo_huspedes'], $_POST['edo_centa_fc'], $_POST['ver_reservaciones'], $_POST['agregar_reservaciones'], $_POST["info_huespedes"], $_POST["reporte_cancelaciones"], $_POST["reporte_cortes"], $_POST["cargos_noche"], $_POST["surtir"], $_POST["corte_diario"],$_POST["pronosticos"], $_POST["historial_cuentas"], $_POST["ama_de_llaves"], $_POST["historial_cortes_u"], $_POST["corte_diario_u"], $_POST["resumen_transacciones"], $_POST["factura_individual"], $_POST["factura_global"], $_POST["buscar_fc"], $_POST["cancelar_fac"] , $_POST["bus_fac_fecha"], $_POST["bus_fac_folio"], $_POST["bus_fac_folio_casa"], $_POST["resumen_fac"], $_POST["restaurante"], $_POST["agregar_res"], $_POST["cat_res"], $_POST["invet_res"], $_POST["surtir_res"], $_POST["mesas_res"], $_POST["agregar_mesas_res"], $_POST["tipo_hab"], $_POST["tarifas_hab"], $_POST["ver_hab"], $_POST["editar_abonos"] , $_POST["editar_cargos"]);
  $logs->guardar_log($_POST['usuario_id'],"Editar usuario: ". $_POST['id']);
?>
