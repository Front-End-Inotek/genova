<?php
  error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_forma_pago.php");
  include_once("clase_pago.php");
  include_once("clase_tarifa.php");
  $huesped= NEW Huesped(0);//
  $forma_pago= NEW Forma_pago(0);
  $pago= NEW Pago(0);
  $tarifa= NEW Tarifa($_GET['tarifa']);
  $adultos= $tarifa->mostrar_cantidad_hospedaje($_GET['tarifa']);
  $agregar= 1;
  $precio_hospedaje= 0;
  $precio_adulto= 0;
  $precio_junior= 0;
  $precio_infantil= 0;
  $precio_hospedaje= $tarifa->precio_hospedaje;
  $precio_adulto= $tarifa->precio_adulto;
  $precio_junior= $tarifa->precio_junior;
  $precio_infantil= $tarifa->precio_infantil;

  $cantidad_hospedaje = $tarifa->cantidad_hospedaje;

  // Checar si numero hab esta vacia o no
  if (empty($_GET['numero_hab'])){
    //echo 'La variable esta vacia';
    $numero_hab= 1;
  }else{
    $numero_hab= $_GET['numero_hab'];
  }
  // Checar si forzar tarifa esta vacia o no
  if (empty($_GET['forzar_tarifa'])){
    //echo 'La variable esta vacia';
    $forzar_tarifa= 0;
  }else{
    $forzar_tarifa= $_GET['forzar_tarifa'];
  }

  $precio_adulto= $precio_adulto /** $_GET['noches']*/;
  $precio_junior= $precio_junior * $_GET['noches'];
  $precio_infantil= $precio_infantil /* * $_GET['noches']*/;
  $precio_hab= $precio_hospedaje * $_GET['noches'] * $numero_hab;
  $cantidad_maxima= $tarifa->cantidad_maxima;
  $leyenda= $tarifa->leyenda;
  $tipo_hab= $_GET['tarifa'];
  

  $datos_interes = array(

    "precio_hab" => $precio_hab,
    "precio_adulto"=>$precio_adulto,
    "precio_infantil"=>$precio_infantil,
    "precio_hospedaje"=>$precio_hospedaje,
    "cantidad_hospedaje"=>$cantidad_hospedaje,
    "cantidad_maxima" => $cantidad_maxima,
  );

  echo json_encode($datos_interes);
?>
