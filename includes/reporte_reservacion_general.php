<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_reservacion.php");
  include_once('clase_log.php');
  $reservacion= NEW Reservacion(0);
  $logs = NEW Log(0);

  require('../fpdf/fpdf.php');
  
  class PDF extends FPDF
  {
      // Cabecera de página
      function Header()
      {
          $conf = NEW Configuracion(0);
          $reservacion= NEW Reservacion(0);
          $logs = NEW Log(0);

          $this->SetFont('Arial','B',8);
          $this->SetTextColor(0,0,0);
          $fecha_actual = $_GET['inicial'];
        //   $fecha = date("d-m-Y",$fecha_actual);
        //   $fecha = $fecha_actual;
        //   $dia = substr($fecha, 0, 2);
        //   $mes = substr($fecha, 3, 2);
        //   $mes= $logs->formato_fecha($mes);
        //   $anio = substr($fecha, 6, 4);
          $nombre= $conf->obtener_nombre();
          $a_buscar= ' ';
        //   $porcentaje= $reservacion->porcentaje_ocupacion($_GET['inicial'],$a_buscar);

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
          // Datos y fecha
          $this->SetFont('Arial','',10);
          $this->SetTextColor(0,0,0);
        //   $this->Cell(172,9,iconv("UTF-8", "ISO-8859-1",'Día '.$dia.' de '.$mes.' de '.$anio.' - '.$porcentaje.'% de Ocupación'),0,1,'R');
          // Logo
          $this->Image("../images/simbolo.png",10,18,25,25);
          // Salto de línea
          $this->Ln(14);
          // Movernos a la derecha
          $this->Cell(80);
          // Título
          $this->SetFont('Arial','B',10);
          $this->SetTextColor(0, 102, 205);
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",$_GET['titulo']),0,0,'C');
          // Salto de línea
          $this->Ln(18);
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
  $fecha_actual = $_GET['inicial'];
//   $fecha = date("d-m-Y",$fecha_actual);
//   $dia = substr($fecha, 0, 2);
//   $mes = substr($fecha, 3, 2);
//   $mes= $logs->formato_fecha($mes);
//   $anio = substr($fecha, 6, 4);

  // Titulos tabla 
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
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
  $inicio_dia= date("Y-m-d");

  $inicio_dia= strtotime($inicio_dia);

  $consulta = $reservacion->seleccion_reporte($_GET['inicial'],$inicio_dia,$_GET['opcion'],$_GET['a_buscar']);
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
      if($fila['forzar_tarifa']>0){
        $total= $fila['forzar_tarifa'];
        $total_estancia= '$'.number_format($fila['forzar_tarifa'], 2); 
      }else{
        $total= $fila['total'];
        $total_estancia= '$'.number_format($fila['total'], 2);  
      }
      $total_pago='$'.number_format($fila['total_pago'], 2);
      $total_estancia_final= $total_estancia_final + $total;
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

      /*for($i = 1; $i <= 26; $i++){
        $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Iteracion '.$i),0,1,'R');
      }*/
    
      $x=$pdf->GetX();
      $y=$pdf->GetY();
      if($y >= 265){
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(255, 255, 255);
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
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(0,0,0);
      }
  }

  $total_diferencia= $total_estancia_final - $total_pago_final;
  $pdf->Cell(132,5,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'$ '.number_format($total_estancia_final, 2)),1,0,'C');
  $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'$ '.number_format($total_pago_final, 2)),1,0,'C');
  $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",'TOTAL SUMA'),1,1,'C');

//   $logs->guardar_log($_GET['usuario_id'],"Reporte reservaciones por dia: ".$dia.' de '.$mes.' de '.$anio);
  //$pdf->Output("reporte_reservacion_por_dia.pdf","I");
  $pdf->Output("reporte_reservacion_por_dia_.pdf","I");
  //$pdf->Output("../reportes/reservaciones/por_dia/reporte_reservacion_por_dia.pdf","F");
      //echo 'Reporte reservacion por dia';*/
?>

