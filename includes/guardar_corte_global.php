<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte.php");
  include_once("clase_corte_info_dia.php");
  include_once("clase_log.php");
  include_once("clase_configuracion.php");
  include_once("clase_cuenta.php");
  include_once("clase_tipo.php");
  include_once("clase_usuario.php");
  $labels= NEW Labels(0);
  $forma_pago= NEW Forma_pago(0);
  $corte= NEW Corte(0);
  $inf= NEW Corte_info($_POST['usuario_id']);
  $logs = NEW Log(0);
  $cuenta= NEW Cuenta(0);
  $ticket= NEW Ticket(0);
  $concepto= NEW Concepto(0);
  $tipo= NEW Tipo(0);
  // Guardar corte
  $cantidad_habitaciones= $inf->total_hab;
  $total_habitaciones= $inf->total_hab;
  $restaurante= $inf->total_restaurante_entrada;
  $total= $inf->total_global;
  $cantidad= $forma_pago->total_elementos();
  $pago= array();
  //$cantidad= $cantidad + 1;
  $ids= $forma_pago->total_elementos();
  $cantidad= count($ids);
  for($z=1 ; $z<$cantidad; $z++)
  {
    $pago[$z-1]= $inf->total_pago[$ids[$z]];
  }
  $nueva_etiqueta= $labels->obtener_corte();
  //$nueva_etiqueta++;
  $corte->guardar_corte($_POST['usuario_id'],$nueva_etiqueta,$total,$pago[0],$pago[1],$pago[2],$pago[3],$pago[4],$pago[5],$pago[6],$pago[7],$pago[8],0,$cantidad_habitaciones,$total_habitaciones,$restaurante);

  // Guardar log
  $logs->guardar_log($_POST['usuario_id'],"Hacer corte con etiqueta: ". $nueva_etiqueta);

  // Comienza a realizarse el reporte //

  $total_cuartos_hospedaje= 0;
  $suma_cuartos_hospedaje= 0;
  $total_cuartos= 0;
  $total_productos= 0;//$inf->total_productos;
  $total_restaurante= 0;//$inf->total_restaurante;
  $total_productos_hab= 0;//$inf->total_productos_hab;
  $total_productos_rest= 0;//$inf->total_productos_rest;
  $total_restaurante_verificacion= $inf->total_restaurante;

  require('../fpdf/fpdf.php');

  class PDF extends FPDF
  {
      // Cabecera de página
      function Header()
      {
          $conf = NEW Configuracion(0);
          $ticket= NEW Ticket(0);
          $labels= NEW Labels(0);
          $usuario= NEW Usuario(0);
          $logs = NEW Log(0);

          $this->SetFont('Arial','',8);
          $this->SetTextColor(0,0,0);
          $fecha_actual = time();
          $fecha = date("d-m-Y h:i A",$fecha_actual);
          $dia = substr($fecha, 0, 2);
          $mes = substr($fecha, 3, 2);
          $mes= $logs->formato_fecha($mes);
          $anio = substr($fecha, 6, 4);
          $anio_hora = substr($fecha, 6, 13);
          $nombre= $conf->obtener_nombre();
          $nueva_etiqueta= $labels->obtener_corte();
          //$nueva_etiqueta= $nueva_etiqueta - 1;
          $realizo_usuario= $usuario->obtengo_nombre_completo($_POST['usuario_id']);

          // Marco primera pagina
          //$this->Image("../images/hoja_margen.png",1.5,-2,211,295);
          // Arial bold 15
          $this->Image("../images/encabezado_pdf.jpg", 0, 0, 211);
          $this->Image("../images/rectangulo_pdf.png", 160, 1, 27, 27);
          $this->Image("../images/rectangulo_pdf_2.png", 10, 20, 68, 12);
          $this->SetFont('Arial','',8);
          // Color de letra
          $this->SetTextColor(0, 102, 205);
          // Movernos a la derecha
          $this->Cell(2);
          // Nombre del Hotel
          //$this->Cell(20,9,iconv("UTF-8", "ISO-8859-1",$nombre),0,0,'C');
          // Datos y fecha
          $this->SetFont('Arial','',16);
          $this->SetTextColor(255,255,255);
          $this->Ln(22);
          $this->Cell(21);
          $this->Cell(25,-11,iconv("UTF-8", "ISO-8859-1",'REPORTE CORTE: '.$nueva_etiqueta),0,0,'C');
          $this->SetTextColor( 0 , 0 ,0 );
          // Logo
          $this->Image("../images/hotelexpoabastos.png",160,1,27,27);
          // Salto de línea
          $this->Ln(10);
          // Movernos a la derecha
          $this->Cell(21);
          // Título
          $this->SetFont('Arial','',10);
          $this->Cell(170,-20,iconv("UTF-8", "ISO-8859-1",'Realizó '.$realizo_usuario.' el '.$dia.' de '.$mes.' de '.$anio_hora),0,1,'R');
          // Salto de línea
          $this->Ln(8);
      }
      
      // Pie de página
      function Footer()
      {
          // Posición: a 1,5 cm del final
          $this->SetY(-20);
          // Arial italic 8
          $this->SetFont('Arial','',8);
          // Número de página
          $this->Cell(0,4,iconv("UTF-8", "ISO-8859-1",'Página '.$this->PageNo().'/{nb}'),0,0,'R');
      }
  }

//Formato de hoja (Orientacion, tamaño , tipo)
$pdf = new FPDF('P', 'mm', 'Letter');

  // Fecha y datos generales
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $fecha_actual = time();
  $fecha = date("d-m-Y h:i A",$fecha_actual);
  $dia = substr($fecha, 0, 2);
  $mes = substr($fecha, 3, 2);
  $mes= $logs->formato_fecha($mes);
  $anio = substr($fecha, 6, 4);
  $anio_hora = substr($fecha, 6, 13);
  // Datos dentro de la tabla hospedaje
  $x_inicial=$pdf->GetX();
  $y_inicial=$pdf->GetY();
  $pdf->SetFillColor(45, 63, 83);
  $pdf->SetFont('Arial','',8);
  $pdf->SetTextColor(45, 63, 83);
  $pdf->SetLineWidth(0.1);
  $pdf->SetDrawColor(45, 63 , 83);
  $pdf->Cell(72,8,iconv("UTF-8", "ISO-8859-1",'Hospedaje'),0,1,'C');
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",'Tipo'),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'Cant.'),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,1,'C',True);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $cantidad= $tipo->total_elementos();
  $c = sizeof($inf->hab_tipo_hospedaje);
  $c = $c;
  for($z=0 ; $z<$c; $z++)
  {
      $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",$inf->hab_tipo_hospedaje[$z]),1,0,'C');
      $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",$inf->hab_cantidad_hospedaje[$z]),1,0,'C');
      $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->hab_total_hospedaje[$z], 2)),1,1,'C');
      $total_cuartos_hospedaje= $total_cuartos_hospedaje + $inf->hab_total_hospedaje[$z];
      $suma_cuartos_hospedaje= $suma_cuartos_hospedaje + $inf->hab_cantidad_hospedaje[$z];
  }
  $pdf->SetFillColor(45, 63, 83);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",''),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",$suma_cuartos_hospedaje),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_cuartos_hospedaje, 2)),1,1,'C',True);
  $pdf->SetFillColor(45, 63, 83);
  $pdf->Ln(6);
 
  // Datos dentro de la tabla totales
  $pdf->SetFont('Arial','',8);
  $pdf->SetTextColor(45, 63, 83);
  $pdf->Cell(72,8,iconv("UTF-8", "ISO-8859-1",'Totales'),0,1,'C');
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",'Concepto'),1,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,1,'C',True);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  //$cantidad= $tipo->total_elementos();
  $conceptos= array();
  $conceptos[0]= 'Habitaciones';
  $conceptos[1]= 'Restaurante';
  $conceptos[2]= 'Total';
  $total= array(); 
  $total[0]= $inf->total_hab;
  $total[1]= $inf->total_restaurante_entrada;
  $total[2]= $inf->total_global;
  $cantidad= 2;
  for($z=0 ; $z<$cantidad; $z++)
  {
      $pdf->SetTextColor(0, 0, 0);
      $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",$conceptos[$z]),1,0,'C');
      $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total[$z], 2)),1,1,'C');
      $pdf->SetTextColor(225, 225, 255);
  }
  $pdf->SetFillColor(45, 63, 83);
  $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",$conceptos[2]),1,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->total_global, 2)),1,1,'C',True);
  $pdf->SetFillColor(45, 63, 83);
  $pdf->Ln(6);
 
  // Datos dentro de la tabla desgloce en sistema
  $pdf->SetFont('Arial','',8);
  $pdf->SetTextColor(45, 63, 83);
  $pdf->Cell(72,8,iconv("UTF-8", "ISO-8859-1",'Desglose en Sistema'),0,1,'C');
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",'Concepto'),1,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,1,'C',True);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $ids= $forma_pago->total_elementos();
  $cantidad= count($ids);
  for($z=0; $z<$cantidad; $z++)
  {
      $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",$forma_pago->obtener_descripcion($ids[$z])),1,0,'C');
      $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->total_pago[$ids[$z]], 2)),1,1,'C');
  }

  // Datos dentro de la tabla ventas restaurante
  if($total_restaurante_verificacion > 0){
      $x_final=$pdf->GetX();
      $y_final=$pdf->GetY();
      $pdf->SetXY($x_inicial,$y_inicial);
      $pdf->SetFont('Arial','',8);
      $pdf->SetTextColor(20, 31, 102);
      $pdf->Cell(86,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(106,8,iconv("UTF-8", "ISO-8859-1",'Ventas Restaurante'),0,1,'C');
      $pdf->SetFont('Arial','',7);
      $pdf->SetTextColor(255, 255, 255);
      $pdf->Cell(86,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(42,4,iconv("UTF-8", "ISO-8859-1",'Producto'),1,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'Precio'),1,0,'C',True);
      $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",'Venta'),1,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,0,'C',True);
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'En Hab.'),1,0,'C',True);
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'En Rest.'),1,1,'C',True);
      $pdf->SetFont('Arial','',7);
      $pdf->SetTextColor(0,0,0);
      $cantidad= count($inf->producto_nombre);
      for($z=0 ; $z<$cantidad; $z++)
      {
          $pdf->Cell(86,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
          $pdf->Cell(42,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_nombre[$z]),1,0,'C');
          $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->producto_precio[$z], 2)),1,0,'C');
          $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_venta[$z]),1,0,'C');
          $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format(($inf->producto_venta[$z] * $inf->producto_precio[$z]), 2)),1,0,'C');
          $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_tipo_hab[$z]),1,0,'C');
          $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_tipo_rest[$z]),1,1,'C');
          $total_restaurante= $total_restaurante + ($inf->producto_venta[$z] * $inf->producto_precio[$z]);
          $total_productos= $total_productos + $inf->producto_venta[$z];
          $total_productos_hab= $total_productos_hab + $inf->producto_tipo_hab[$z];
          $total_productos_rest= $total_productos_rest + $inf->producto_tipo_rest[$z];
          
          /*if($z == 4){
            for ($i = 1; $i <= 24; $i++) {
                $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Iteracion '.$i),0,1,'R');
            }
          }*/
          $x=$pdf->GetX();
          $y=$pdf->GetY();
          if($y >= 265){
            $pdf->AddPage();
            $pdf->SetFont('Arial','',7);
            $pdf->SetFillColor(45, 63, 83);
            $pdf->SetTextColor(255, 255, 255);
            $pdf->Cell(86,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
            $pdf->Cell(42,4,iconv("UTF-8", "ISO-8859-1",'Producto'),1,0,'C',True);
            $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'Precio'),1,0,'C',True);
            $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",'Venta'),1,0,'C',True);
            $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,0,'C',True);
            $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'En Hab.'),1,0,'C',True);
            $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'En Rest.'),1,1,'C',True);
            $pdf->SetFont('Arial','',7);
            $pdf->SetTextColor(0,0,0);
          }
      }
      $pdf->Cell(86,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->SetFillColor(45, 63, 83);
      $pdf->SetTextColor(255, 255, 255);
      $pdf->Cell(42,4,iconv("UTF-8", "ISO-8859-1",''),1,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",''),1,0,'C',True);
      $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$total_productos),1,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_restaurante, 2)),1,0,'C',True);
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$total_productos_hab),1,0,'C',True);
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$total_productos_rest),1,1,'C',True);
      $pdf->SetTextColor(255, 255, 255);
      $pdf->SetFillColor(45, 63, 83);
  }
  
  $nueva_etiqueta= $labels->obtener_corte();
  //$nueva_etiqueta= $nueva_etiqueta - 1;
  $corte_id= $corte->ultima_insercion();



  $hoy = date('Y-m-d');
  // Cambiar concepto a inactivo
  $concepto->cambiar_activoGlobal($_POST['usuario_id']);

  // Cambiar ticket a estado 1 (en corte) y poner el corte que le corresponde
  $ticket->editar_estado_corteGlobal($_POST['usuario_id'],$corte_id,2);

  $ticket->editar_estadoGlobal($_POST['usuario_id'],$corte_id,2);
  $labels->actualizar_etiqueta_corte();
  $cuenta->editar_estadoGlobal($_POST['usuario_id']);
  $logs->guardar_log($_POST['usuario_id'],"Reporte corte con etiqueta: ".$nueva_etiqueta.' del '.$dia.' de '.$mes.' de '.$anio); 
  
  //$pdf->Output("reporte_corte.pdf","I");// I muestra y F descarga con directorio y D descarga en descargas
  $pdf->Output("../reportes/corte/reporte_corte_".$nueva_etiqueta.".pdf","F");
?>
