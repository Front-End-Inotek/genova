<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_reservacion.php");
  $logs = NEW Log(0);
  $reservacion= NEW Reservacion(0);

  require('../fpdf/fpdf.php');
  $pdf = new FPDF();
  // Primera pagina
  $pdf->AddPage();
  // Marco primera pagina
  //$pdf->Image($fondo_uno,4.8,9,205);
  // Logo
  //$pdf->Image($imagen,10,8,45);
  // Salto de línea
  //$pdf->Ln(1);

  // Fecha y datos generales 
  $pdf->SetFont('Arial','B',8);
  $pdf->SetTextColor(0,0,0);
  $fecha_actual = $_GET['dia'];
  $fecha = date("d-m-Y",$fecha_actual);
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
  
  // Datos y fecha
  $pdf->SetFont('Arial','',10);
  $pdf->SetTextColor(0,0,0);
  $a_buscar= ' ';
  $porcentaje= $reservacion->porcentaje_ocupacion($_GET['dia'],$a_buscar);
  $pdf->Cell(60,8,iconv("UTF-8", "ISO-8859-1",$porcentaje.'% de Ocupación'),0,0,'L');
  $pdf->Cell(132,5,iconv("UTF-8", "ISO-8859-1",$dia.' de '.$mes.' de '.$anio),0,1,'R');
  $logs->guardar_log($_GET['usuario_id'],"Reporte reservaciones por dia ".$dia.' de '.$mes.' de '.$anio);
  $pdf->Ln(4);

  // Titulos tabla 
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 102, 205);
  $pdf->Cell(192,6.5,iconv("UTF-8", "ISO-8859-1",'RESERVACIONES POR DIA'),0,1,'C');
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Ln(4);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'NÚMERO'),0,0,'C',True);
  $pdf->Cell(16,4,iconv("UTF-8", "ISO-8859-1",'FECHA'),0,0,'C',True);
  $pdf->Cell(16,4,iconv("UTF-8", "ISO-8859-1",'FECHA'),0,0,'C',True); 
  $pdf->Cell(14,4,iconv("UTF-8", "ISO-8859-1",'NOCHES'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'NO.'),0,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'TIPO'),0,0,'C',True);
  $pdf->Cell(36,4,iconv("UTF-8", "ISO-8859-1",'HUÉSPED'),0,0,'C',True); 
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'TOTAL'),0,0,'C',True); 
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'TOTAL'),0,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'STATUS'),0,1,'C',True);

  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(16,4,iconv("UTF-8", "ISO-8859-1",'ENTRADA'),0,0,'C',True);
  $pdf->Cell(16,4,iconv("UTF-8", "ISO-8859-1",'SALIDA'),0,0,'C',True); 
  $pdf->Cell(14,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'HAB.'),0,0,'C',True);
  $pdf->Cell(26,4,iconv("UTF-8", "ISO-8859-1",'HABITACIÓN'),0,0,'C',True); 
  $pdf->Cell(36,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True); 
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'ESTANCIA'),0,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'PAGO'),0,0,'C',True); 
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",''),0,1,'C',True);

  // Datos dentro de la tabla reservaciones por dia
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $total_estancia_final= 0;
  $total_pago_final= 0;
  $consulta = $reservacion->datos_reservacion_por_dia($_GET['dia']);
  // Revisamos las reservaciones por dia
  while ($fila = mysqli_fetch_array($consulta))
  {
      $numero= $fila['ID'];
      $fecha_entrada= date("d-m-Y",$fila['fecha_entrada']);
      $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
      $noches= $fila['noches']; 
      $numero_habitaciones= $fila['numero_hab']; 
      $tipo_habitacion= $fila['habitacion'];    
      $huesped= $fila['persona'].' '.$fila['apellido'];
      $total_estancia= '$'.number_format($fila['total'], 2);
      $total_pago='$'.number_format($fila['total_pago'], 2);
      $total_estancia_final= $total_estancia_final + $fila['total'];
      $total_pago_final= $total_pago_final + $fila['total_pago'];
    
      if($fila['edo'] == 1){
        if($fila['total_pago'] <= 0){
          $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$numero),1,0,'C');
          $pdf->Cell(16,5,iconv("UTF-8", "ISO-8859-1",$fecha_entrada),1,0,'C');
          $pdf->Cell(16,5,iconv("UTF-8", "ISO-8859-1",$fecha_salida),1,0,'C'); 
          $pdf->Cell(14,5,iconv("UTF-8", "ISO-8859-1",$noches),1,0,'C');
          $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$numero_habitaciones),1,0,'C');
          $pdf->Cell(26,5,iconv("UTF-8", "ISO-8859-1",$tipo_habitacion),1,0,'C');
          $pdf->Cell(36,5,iconv("UTF-8", "ISO-8859-1",$huesped),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$total_estancia),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$total_pago),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'Abierta'),1,1,'C'); 
        }else{
          $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$numero),1,0,'C');
          $pdf->Cell(16,5,iconv("UTF-8", "ISO-8859-1",$fecha_entrada),1,0,'C');
          $pdf->Cell(16,5,iconv("UTF-8", "ISO-8859-1",$fecha_salida),1,0,'C'); 
          $pdf->Cell(14,5,iconv("UTF-8", "ISO-8859-1",$noches),1,0,'C');
          $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$numero_habitaciones),1,0,'C');
          $pdf->Cell(26,5,iconv("UTF-8", "ISO-8859-1",$tipo_habitacion),1,0,'C');
          $pdf->Cell(36,5,iconv("UTF-8", "ISO-8859-1",$huesped),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$total_estancia),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$total_pago),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'Garantizada'),1,1,'C');
        }
      }else{
          $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$numero),1,0,'C');
          $pdf->Cell(16,5,iconv("UTF-8", "ISO-8859-1",$fecha_entrada),1,0,'C');
          $pdf->Cell(16,5,iconv("UTF-8", "ISO-8859-1",$fecha_salida),1,0,'C'); 
          $pdf->Cell(14,5,iconv("UTF-8", "ISO-8859-1",$noches),1,0,'C');
          $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$numero_habitaciones),1,0,'C');
          $pdf->Cell(26,5,iconv("UTF-8", "ISO-8859-1",$tipo_habitacion),1,0,'C');
          $pdf->Cell(36,5,iconv("UTF-8", "ISO-8859-1",$huesped),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$total_estancia),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$total_pago),1,0,'C'); 
          $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'Activa'),1,1,'C');
      } 
  }

  $total_diferencia= $total_estancia_final - $total_pago_final;
  $pdf->Cell(132,5,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'$ '.number_format($total_estancia_final, 2)),1,0,'C');
  $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'$ '.number_format($total_pago_final, 2)),1,0,'C');
  $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'TOTAL SUMA'),1,1,'C');

  //$pdf->Output("reporte_reservacion_por_dia.pdf","I");
  $pdf->Output("reporte_reservacion_por_dia_".$dia.' de '.$mes.' de '.$anio.".pdf","I");
  //$pdf->Output("../reportes/reservaciones/por_dia/reporte_reservacion_por_dia.pdf","F");
      //echo 'Reporte reservacion por dia';*/
?>

