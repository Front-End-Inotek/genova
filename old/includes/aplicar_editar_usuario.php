<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $usuario= NEW Usuario($_POST['id']);
  $logs = NEW Log(0);



  //$usuario->editar_usuario($_POST['id'],urldecode($_POST['usuario']),$_POST['nivel'],urldecode($_POST['nombre_completo']),urldecode($_POST['puesto']),urldecode($_POST['celular']),urldecode($_POST['correo']),urldecode($_POST['direccion']),$_POST['usuario_ver'],$_POST['usuario_agregar'],$_POST['usuario_editar'],$_POST['usuario_borrar'],$_POST['huesped_ver'],$_POST['huesped_agregar'],$_POST['huesped_editar'],$_POST['huesped_borrar'],$_POST['tipo_ver'],$_POST['tipo_agregar'],$_POST['tipo_editar'],$_POST['tipo_borrar'],$_POST['tarifa_ver'],$_POST['tarifa_agregar'],$_POST['tarifa_editar'],$_POST['tarifa_borrar'],$_POST['hab_ver'],$_POST['hab_agregar'],$_POST['hab_editar'],$_POST['hab_borrar'],$_POST['reservacion_ver'],$_POST['reservacion_agregar'],$_POST['reservacion_editar'],$_POST['reservacion_borrar'],$_POST['reporte_ver'],$_POST['reporte_agregar'],$_POST['forma_pago_ver'],$_POST['forma_pago_agregar'],$_POST['forma_pago_editar'],$_POST['forma_pago_borrar'],$_POST['inventario_ver'],$_POST['inventario_agregar'],$_POST['inventario_editar'],$_POST['inventario_borrar'],$_POST['inventario_surtir'],$_POST['categoria_ver'],$_POST['categoria_agregar'],$_POST['categoria_editar'],$_POST['categoria_borrar'],$_POST['restaurante_ver'],$_POST['restaurante_agregar'],$_POST['restaurante_editar'],$_POST['restaurante_borrar'],$_POST['cupon_ver'],$_POST['cupon_agregar'],$_POST['cupon_editar'],$_POST['cupon_borrar'],$_POST['logs_ver']);
  $usuario->editar_usuario($_POST['id'],urldecode($_POST['usuario']),$_POST['nivel'],urldecode($_POST['nombre_completo']),urldecode($_POST['puesto']),urldecode($_POST['celular']),urldecode($_POST['correo']),urldecode($_POST['direccion']),$_POST['usuario_ver'],$_POST['usuario_agregar'],$_POST['usuario_editar'],$_POST['usuario_borrar'],$_POST['huesped_ver'],$_POST['huesped_agregar'],$_POST['huesped_editar'],$_POST['huesped_borrar'],$_POST['tarifa_ver'],$_POST['tarifa_agregar'],$_POST['tarifa_editar'],$_POST['tarifa_borrar'],$_POST['reservacion_ver'],$_POST['reservacion_agregar'],$_POST['reservacion_editar'],$_POST['reservacion_borrar'],$_POST['reservacion_preasignar'],$_POST['reporte_ver'],$_POST['reporte_agregar'],$_POST['forma_pago_ver'],$_POST['forma_pago_agregar'],$_POST['forma_pago_editar'],$_POST['forma_pago_borrar'],$_POST['inventario_ver'],$_POST['inventario_agregar'],$_POST['inventario_editar'],$_POST['inventario_borrar'],$_POST['inventario_surtir'],$_POST['categoria_ver'],$_POST['categoria_agregar'],$_POST['categoria_editar'],$_POST['categoria_borrar'],$_POST['restaurante_ver'],$_POST['restaurante_agregar'],$_POST['restaurante_editar'],$_POST['restaurante_borrar'],$_POST['cupon_ver'],$_POST['cupon_agregar'],$_POST['cupon_editar'],$_POST['cupon_borrar'],$_POST['logs_ver'],$_POST['auditoria_ver'],$_POST['auditoria_editar'],$_POST['llegadas_salidas_ver']);
  $logs->guardar_log($_POST['usuario_id'],"Editar usuario: ". $_POST['id']);
?>