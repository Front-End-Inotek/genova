<?php
  date_default_timezone_set('America/Mexico_City');
/*
  $nombre = $_POST['nombre'];
  $apellido = $_POST['apellido'];
  $direccion = $_POST['direccion'];
  $ciudad = $_POST['ciudad'];
  $estado = $_POST['estado'];
  $codigo_postal = $_POST['codigo_postal'];
  $telefono = $_POST['telefono'];
  $correo = $_POST['correo'];
  $contrato = $_POST['contrato'];
  $cupon = $_POST['cupon'];
  $preferencias = $_POST['preferencias'];
  $comentarios = $_POST['comentarios'];
  $titular_tarjeta = $_POST['titular_tarjeta'];
  $numero_tarjeta = $_POST['numero_tarjeta'];
  $vencimiento_mes = $_POST['vencimiento_mes'];
  $vencimiento_ano = $_POST['vencimiento_ano'];
  $cvv = $_POST['cvv'];
  $usuario_id = $_POST['usuario_id'];
  echo $nombre;
  echo $apellido;
  echo $direccion;
  echo $ciudad;
  echo $estado;
  echo $codigo_postal;
  echo $telefono;
  echo $correo;
  echo $contrato;
  echo $cupon;
  echo $preferencias;
  echo $comentarios;
  echo $titular_tarjeta;
  echo $numero_tarjeta;
  echo $vencimiento_mes;
  echo $vencimiento_ano;
  echo $cvv;
  echo $usuario_id;
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  $huesped->guardar_huesped(urldecode($_POST['nombre']),urldecode($_POST['apellido']),urldecode($_POST['direccion']),urldecode($_POST['ciudad']),urldecode($_POST['estado']),urldecode($_POST['codigo_postal']),urldecode($_POST['telefono']),urldecode($_POST['correo']),urldecode($_POST['contrato']),urldecode($_POST['cupon']),urldecode($_POST['preferencias']),urldecode($_POST['comentarios']),urldecode($_POST['titular_tarjeta']),urldecode($_POST['tipo_tarjeta']),urldecode($_POST['numero_tarjeta']),urldecode($_POST['vencimiento_mes']),urldecode($_POST['vencimiento_ano']),urldecode($_POST['cvv']),$_POST['usuario_id']);
*/
  session_start();
  //echo $_SESSION['nombre_huesped_sin_editar'];
  $tipo_tarjeta="";
  $indole_tarjeta="";
  $numero_tarjeta = $_GET['numero_tarjeta']  !="null" ? $_GET['numero_tarjeta'] : NULL;
  if($_GET['tipo_tarjeta'] == "Debito"  || $_GET['tipo_tarjeta'] == "Credito"){
    $indole_tarjeta=$_GET['tipo_tarjeta'];
  }else{
    $tipo_tarjeta=$_GET['tipo_tarjeta'];
  }
  include_once("clase_huesped.php");
  $huesped= NEW Huesped(0);
  @$huesped->guardar_huesped(urldecode($_GET['nombre']),urldecode($_GET['apellido']),urldecode($_GET['direccion']),urldecode($_GET['ciudad']),urldecode($_GET['estado']),urldecode($_GET['codigo_postal']),urldecode($_GET['telefono']),urldecode($_GET['correo']),urldecode($_GET['contrato']),urldecode($_GET['cupon']),urldecode($_GET['preferencias']),urldecode($_GET['comentarios']),urldecode($_GET['titular_tarjeta']),urldecode($tipo_tarjeta),urldecode($numero_tarjeta),urldecode($_GET['vencimiento_mes']),urldecode($_GET['vencimiento_ano']),urldecode($_GET['cvv']),
  $_GET['usuario_id'],$_GET['pais'],$_GET['empresa'],$_GET['nombre_tarjeta'],$_GET['estado_tarjeta'],$_GET['voucher'],$_GET['estado_credito'],$_GET['limite_credito'],$indole_tarjeta,$_GET['nombre_huesped_sin_editar'],$_GET['apellido_huesped_sin_editar']);
  ?>

