<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_usuario.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte.php");
  include_once("clase_corte_info.php");
  include_once('clase_log.php');
  $ticket= NEW Ticket(0);
  $concepto= NEW Concepto(0);
  $labels= NEW Labels(0);
  $tipo= NEW Tipo(0);
  $usuario= NEW Usuario(0);
  $forma_pago= NEW Forma_pago(0);
  $corte= NEW Corte(0);
  $inf= NEW Corte_info($_GET['usuario_id']);
  $logs = NEW Log(0);
  $total_cuartos_hospedaje= 0;
  $suma_cuartos_hospedaje= 0; 
  $total_cuartos= 0;
  $total_productos= 0;//$inf->total_productos;
  $total_restaurante= 0;//$inf->total_restaurante;
  $total_productos_hab= 0;//$inf->total_productos_hab;
  $total_productos_rest= 0;//$inf->total_productos_rest;

  require('../fpdf/fpdf.php');

  class PDF extends FPDF
  {
      // Cabecera de página
      function Header()
      {
          $ticket= NEW Ticket(0);
          $labels= NEW Labels(0);
          $nueva_etiqueta= $labels->obtener_corte();
          $nueva_etiqueta= $nueva_etiqueta - 1;
          // Marco primera pagina
          $this->Image("../images/hoja_margen.png",1.5,-2,211,295);
          // Logo
          $this->Image("../images/simbolo.png",10,10,25,25);
          // Arial bold 15
          $this->SetFont('Arial','B',10);
          // Salto de línea
          $this->Ln(16);
          // Movernos a la derecha
          $this->Cell(80);
          // Color de letra
          $this->SetTextColor(0, 102, 205);
          // Título
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'REPORTE CORTE: '.$nueva_etiqueta),0,0,'C');
          // Salto de línea
          $this->Ln(14);
      }
      
      // Pie de página
      function Footer()
      {
          // Posición: a 1,5 cm del final
          $this->SetY(-15);
          // Arial italic 8
          $this->SetFont('Arial','',8);
          // Número de página
          $this->Cell(0,4,iconv("UTF-8", "ISO-8859-1",'Página '.$this->PageNo().'/{nb}'),0,0,'R');
      }
  }

  // Fecha y datos generales 
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','B',8);
  $pdf->SetTextColor(0,0,0);
  $fecha_actual = time();
  $fecha = date("d-m-Y h:i A",$fecha_actual);
  $dia = substr($fecha, 0, 2);
  $mes = substr($fecha, 3, 2);
  switch ($mes) {
      case "01":
          $mes = "enero";
          break;
      case "02":
          $mes = "febrero";
          break;
      case "03":
          $mes = "marzo";
          break;
      case "04":
          $mes = "abril";
          break;
      case "05":
          $mes = "mayo";
          break;
      case "06":
          $mes = "junio";
          break;
      case "07":
          $mes = "julio";
          break;
      case "08":
          $mes = "agosto";
          break;
      case "09":
          $mes = "septiembre";
          break;
      case "10":
          $mes = "octubre";
          break;
      case "11":
          $mes = "noviembre";
          break;
      case "12":
          $mes = "diciembre";
          break;            
      default:
          echo "No existe este mes";
  }
  $anio = substr($fecha, 6, 4);
  $anio_hora = substr($fecha, 6, 13);
  
  // Datos y fecha
  $pdf->SetFont('Arial','',10);
  $pdf->SetTextColor(0,0,0);
  $pdf->Ln(-28);
  //$realizo_usuario= $usuario->obtengo_usuario($_GET['usuario_id']);
  $realizo_usuario= $usuario->obtengo_nombre_completo($_GET['usuario_id']);
  $pdf->Cell(192,5,iconv("UTF-8", "ISO-8859-1",'Realizo '.$realizo_usuario.' el '.$dia.' de '.$mes.' de '.$anio_hora),0,1,'R');
  //$pdf->Cell(60,5,iconv("UTF-8", "ISO-8859-1",'Tickets '.$ticket->obtener_etiqueta($_GET['ticket_ini']).' - '.$ticket->obtener_etiqueta($_GET['ticket_fin'])),0,1,'R');  
  $pdf->Ln(18);

  // Titulo
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 102, 205);
  $nueva_etiqueta= $labels->obtener_corte();
  $nueva_etiqueta= $nueva_etiqueta - 1;
  //$pdf->Cell(192,6.5,iconv("UTF-8", "ISO-8859-1",'REPORTE CORTE: '.$nueva_etiqueta),0,1,'C');
  $pdf->Ln(6);
  $pdf->SetFillColor(99, 155, 219);

  // Datos dentro de la tabla ventas restaurante
  $x_final=$pdf->GetX();
  $y_final=$pdf->GetY();
  $pdf->SetFont('Arial','B',8);
  $pdf->SetTextColor(20, 31, 102);
  $pdf->Cell(100,8,iconv("UTF-8", "ISO-8859-1",'Ventas Restaurante'),0,1,'C');// NO OLVIDAR SI ESTA EN 0 NO PONER TITULOS
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
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
      $pdf->Cell(42,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_nombre[$z]),1,0,'C');
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->producto_precio[$z], 2)),1,0,'C');
      $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_venta[$z]),1,0,'C');
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format(($inf->producto_venta[$z] * $inf->producto_precio[$z]), 2)),1,0,'C');
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$inf->producto_tipo_venta[$z]),1,0,'C');
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",($inf->producto_venta[$z] - $inf->producto_tipo_venta[$z])),1,1,'C');
      $total_restaurante= $total_restaurante + ($inf->producto_venta[$z] * $inf->producto_precio[$z]);
      $total_productos= $total_productos + $inf->producto_venta[$z];
      $total_productos_hab= $total_productos_hab + $inf->producto_tipo_venta[$z];
      $total_productos_rest= $total_productos_rest + ($inf->producto_venta[$z] - $inf->producto_tipo_venta[$z]);
  }
  $pdf->SetFillColor(193, 229, 255);
  $pdf->Cell(42,4,iconv("UTF-8", "ISO-8859-1",''),1,0,'C',True);
  $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",''),1,0,'C',True);
  $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",$total_productos),1,0,'C',True);
  $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_restaurante, 2)),1,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$total_productos_hab),1,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",$total_productos_rest),1,1,'C',True);
  $pdf->SetFillColor(99, 155, 219);

  // Datos dentro de la tabla hospedaje
  $x_inicial=$pdf->GetX();
  $y_inicial=$pdf->GetY();
  $pdf->SetXY($x_final,$y_final);
  $pdf->SetFont('Arial','B',8);
  $pdf->SetTextColor(24, 31, 102);
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(72,8,iconv("UTF-8", "ISO-8859-1",'Hospedaje'),0,1,'C');
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",'Tipo'),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'Cant.'),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,1,'C',True);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $cantidad= $tipo->total_elementos();
  for($z=0 ; $z<$cantidad; $z++)
  {
      $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",$inf->hab_tipo_hospedaje[$z]),1,0,'C');
      $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",$inf->hab_cantidad_hospedaje[$z]),1,0,'C');
      $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->hab_total_hospedaje[$z], 2)),1,1,'C');
      $total_cuartos_hospedaje= $total_cuartos_hospedaje + $inf->hab_total_hospedaje[$z];
      $suma_cuartos_hospedaje= $suma_cuartos_hospedaje + $inf->hab_cantidad_hospedaje[$z];
  }
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->SetFillColor(193, 229, 255);
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",''),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",$suma_cuartos_hospedaje),1,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_cuartos_hospedaje, 2)),1,1,'C',True);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Ln(6);
 
  // Datos dentro de la tabla totales
  //$pdf->SetXY($x_final,$y_final);
  $pdf->SetFont('Arial','B',8);
  $pdf->SetTextColor(20, 31, 102);
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(72,8,iconv("UTF-8", "ISO-8859-1",'Totales'),0,1,'C');
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
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
  $total[1]= $inf->total_restaurante;
  $total[2]= $inf->total_global;
  $cantidad= 2;
  for($z=0 ; $z<$cantidad; $z++)
  {
      $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",$conceptos[$z]),1,0,'C');
      $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total[$z], 2)),1,1,'C');
  }
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->SetFillColor(193, 229, 255);
  $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",$conceptos[2]),1,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->total_global, 2)),1,1,'C',True);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Ln(6);
 
  // Datos dentro de la tabla desgloce en sistema
  $pdf->SetFont('Arial','B',8);
  $pdf->SetTextColor(20, 31, 102);
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(72,8,iconv("UTF-8", "ISO-8859-1",'Desgloce en Sistema'),0,1,'C');
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",'Concepto'),1,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'Total'),1,1,'C',True);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $cantidad= $forma_pago->total_elementos();
  $cantidad= $cantidad + 1;
  for($z=1; $z<$cantidad; $z++)
  {
      $pdf->Cell(120,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(46,4,iconv("UTF-8", "ISO-8859-1",$forma_pago->obtener_descripcion($z)),1,0,'C');
      $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'$'.number_format($inf->total_pago[$z-1], 2)),1,1,'C');
  }

  $corte_id= $corte->ultima_insercion();
  // Cambiar concepto a inactivo
  //$concepto->cambiar_activo($_GET['usuario_id']);
  // Cambiar ticket a estado 1 (en corte) y poner el corte que le corresponde
  //$ticket->editar_estado($_GET['usuario_id'],$corte_id,1);
  for($i=1;$i<=37;$i++)
    $pdf->Cell(0,10,'Imprimiendo linea numero '.$i,0,1);
  
  $logs->guardar_log($_GET['usuario_id'],"Reporte corte con etiqueta: ".$nueva_etiqueta.' del '.$dia.' de '.$mes.' de '.$anio); 
  //$pdf->Output("reporte_corte.pdf","I");// I muestra y F descarga con directorio y D descarga en descargas
  $pdf->Output("../reportes/corte/reporte_corte_".$nueva_etiqueta.".pdf","I");
  //$pdf->Output("../reportes/reservaciones/cargo_noche/reporte_corte.pdf","I");
      //echo 'Reporte corte';*/
       /*
  agua
  vitamina c
  algo con urea o vitamina e
  arnica
  compresivo*/
?>

