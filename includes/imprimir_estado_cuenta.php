<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_huesped.php");
  include_once("clase_reservacion.php");
  include_once('clase_log.php');
  include_once("clase_hab.php");

  $logs = NEW Log(0);

  $hab= NEW Hab($_GET['id']);


  require('../fpdf/fpdf.php');
  
  class PDF extends FPDF
  {
      // Cabecera de página
      function Header()
      {
          $conf = NEW Configuracion(0);
          $hab= NEW Hab($_GET['id']);
          $nombre= $conf->obtener_nombre();
          // Marco primera pagina
          $this->Image("../images/hoja_margen.png",1.5,-2,211,295);
          // Arial bold 15
          $this->SetFont('Arial','B',10);
          // Color de letra
          $this->SetTextColor(0, 102, 205);
          // Movernos a la derecha
          $this->Cell(2);
          // Nombre del Hotel
          $this->Cell(20,9,iconv("UTF-8", "ISO-8859-1",$nombre),0,0,'C');
          // Logo
          $this->Image("../images/simbolo.png",10,18,25,25);
          // Salto de línea
          $this->Ln(24);
          // Movernos a la derecha
          $this->Cell(80);
          // Título
          $this->SetFont('Arial','',20);
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'ESTADO DE CUENTA - Hab  '.$hab->nombre),0,0,'C');
          // Salto de línea
          $this->Ln(18);
      }
      
      // Pie de página
      function Footer()
      {
        $conf = NEW Configuracion(0);
          // Posición: a 1,5 cm del final
        $this->SetY(-20);
          // Arial italic 8
        $this->SetFont('Arial','',7);

        $this->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", 'Le invitamos a visitar nuestra página web: '.$conf->credencial_auto.' donde encontrará mayor información acerca de nuestras instalaciones y servicios.'), 0, 'C');


        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", $conf->domicilio), 0, 0, 'C');

          // Número de página
        $this->SetFont('Arial','',8);
        $this->Cell(0,4,iconv("UTF-8", "ISO-8859-1",'Página '.$this->PageNo().'/{nb}'),0,0,'R');
      }
  }
  
  // Datos dentro de la reservacion
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',9);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_tarifa.php");
  include_once("clase_movimiento.php");
  $cuenta= NEW Cuenta(0);

  $tarifa= NEW Tarifa(0);
  $movimiento= NEW Movimiento($hab->mov);
  $id_reservacion= $movimiento->saber_id_reservacion($hab->mov);
  $reservacion= NEW Reservacion($id_reservacion);
  $consulta = $reservacion->datos_reservacion($id_reservacion);
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_hab= $fila['ID'];
      $id_usuario= $fila['id_usuario'];
      $usuario_reservacion= $fila['usuario'];
      $fecha_entrada= date("d-m-Y",$fila['fecha_entrada']);
      $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
      $noches= $fila['noches'];
      $numero_hab= $fila['numero_hab'];
      $tarifa= $fila['habitacion'];
      $precio_hospedaje= $fila['precio_hospedaje'];
      $extra_adulto= $fila['extra_adulto'];
      $extra_junior= $fila['extra_junior'];
      $extra_infantil= $fila['extra_infantil'];
      $extra_menor= $fila['extra_menor'];
      $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
      $quien_reserva= $fila['nombre_reserva'];
      $acompanante= $fila['acompanante'];
      // Checar si suplementos esta vacio o no
      if (empty($fila['suplementos'])){
        //echo 'La variable esta vacia';
        $suplementos= 'Ninguno';
      }else{
        $suplementos= $fila['suplementos'];
      }
      $total_suplementos= $fila['total_suplementos'];
      $total_habitacion= $fila['total_hab'];
      if($fila['descuento']>0){
        $descuento= $fila['descuento'].'%'; 
      }else{
        $descuento= 'Ninguno'; 
      }
      // Total provisional
      $total_estancia= $fila['total']; 
      $total_pago= $fila['total_pago'];
      $forma_pago= $fila['descripcion'];
      $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
  }

  $saldo_faltante= 0;
  $total_faltante= 0;
  $mov= $hab->mov;
  $suma_abonos= $cuenta->obtner_abonos($mov);
  $saldo_pagado= $total_pago + $suma_abonos;
  $saldo_faltante= $total_estancia - $saldo_pagado;
  $total_cargos= 0;
  $total_abonos= 0;
  $faltante= 0;
  $faltante= $cuenta->mostrar_faltante($mov);
  if($faltante >= 0){
    $faltante_mostrar= '$'.number_format($faltante, 2);
  }else{
    $faltante_mostrar= substr($faltante, 1);
    $faltante_mostrar= '-$'.number_format($faltante_mostrar, 2);
  }



  $pdf->SetFont('Arial','B',10);
  $x= 20;
 
  $pdf->Cell(55,5,iconv("UTF-8", "ISO-8859-1",'Fecha Entrada: '.$fecha_entrada),0,0,'L');
  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Fecha Salida: '.$fecha_salida),0,0,'L');
  $pdf->Cell(30,5,iconv("UTF-8", "ISO-8859-1",'Noches: '.$noches),0,0,'L');
  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Tarifa: '.$tarifa),0,0,'L');
  $pdf->Ln(10);

  $pdf->MultiCell(80,5,iconv("UTF-8", "ISO-8859-1",'Nombre Huesped: '.$nombre_huesped),0,'J');
  $pdf->SetXY($pdf->GetX()+80,$pdf->GetY()-5);


  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Quién reserva: '.$quien_reserva),0,0,'L');


  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Forma Pago: '.$forma_pago),0,0,'L');
  $pdf->Ln(10);

  
  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Suplementos: '.$suplementos),0,0,'L');

  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Extra Adulto: '.$extra_adulto),0,0,'L');

  $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",'Extra Infantil: '.$extra_infantil),0,0,'L');
//   $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Fecha Entrada: '. $fecha_entrada),0,0,'L');
 
//   $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1",'Fecha Salida: '.$fecha_salida),0,0,'L');

//   $pdf->Cell(0,5,iconv("UTF-8", "ISO-8859-1",'Fecha Salida: '.$fecha_salida),0,0,'L');

 
  //$logs->guardar_log($_GET['usuario_id'],"Reporte reservacion: ". $_GET['id']);
  //$pdf->Output("reporte_reservacion.pdf","I");
  $pdf->Output("reporte_estado_cuenta_".$hab->nombre.".pdf","I");
  
  //$pdf->Output("../reportes/reservaciones/reporte_reservacion.pdf","F");
      //echo 'Reporte reservacion';*/
?>

