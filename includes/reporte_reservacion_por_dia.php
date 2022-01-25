<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once("clase_movimiento.php");
  include_once("clase_reservacion.php");
  include_once('clase_tarifa.php');

  $logs = NEW Log(0);
  //$logs->guardar_log($_GET['usuario_id'],"Reporte reservaciones por dia");//CAMBIAR
  $hab= NEW Hab(0);
  $huesped= NEW Huesped(0);
  $reservacion= NEW Reservacion(0);
  $movimiento = NEW Movimiento(0);
  $tarifa= NEW Tarifa(0);
  //86400

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
  $pdf->Cell(192,5,iconv("UTF-8", "ISO-8859-1",$dia.' de '.$mes.' de '.$anio),0,1,'R');
  $pdf->Ln(4);

  // Titulos tabla 
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 102, 205);
  $pdf->Cell(192,6.5,iconv("UTF-8", "ISO-8859-1",'RESERVACIONES POR DIA'),0,1,'C');
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Ln(4);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(8,4,iconv("UTF-8", "ISO-8859-1",'HAB'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'TARIFA'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True); 
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(50,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True); 
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",'QUIEN'),0,0,'C',True); 
  $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",'%'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'TOTAL'),0,1,'C',True);

  $pdf->Cell(8,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'ADULTO'),0,0,'C',True); 
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'JUNIOR'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'INFANTIL'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'MENOR'),0,0,'C',True); 
  $pdf->Cell(50,4,iconv("UTF-8", "ISO-8859-1",'HUESPED'),0,0,'C',True); 
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",'RESERVA'),0,0,'C',True);
  $pdf->Cell(10,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True); 
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",''),0,1,'C',True);

  // Datos dentro de la tabla reservaciones por dia
  $total_final= 0;
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $a_buscar= ' ';
  $porcentaje= $reservacion->porcentaje_ocupacion($_GET['dia'],$a_buscar);
  /*$consulta = $reservacion->datos_reservacion_por_dia($_GET['dia']);
  // Revisamos las reservaciones por dia
  while ($fila = mysqli_fetch_array($consulta))
  {
      $hab_id = $fila['id'];
      $hab_nombre = $fila['nombre'];  
      $habitacion = $fila['id_hab'];
      $fecha_entrada = $fila['inicio_hospedaje'];
      $fecha_salida = $fila['fin_hospedaje'];
      $extra_adulto = $fila['extra_adulto'];
      $extra_junior = $fila['extra_junior'];
      $extra_infantil = $fila['extra_infantil'];
      $extra_menor = $fila['extra_menor'];
      $id_tarifa = $fila['tarifa'];
      $id_huesped = $fila['id_huesped'];
      $quien_reserva	= $fila['nombre_reserva'];
      $descuento = $fila['descuento'];
      //$total = $fila['total'];
      if (empty($descuento)){// Checar si existe descuento en la reservacion
        //echo 'La variable esta vacia';
        $descuento= 0; 
      }

      $nombre_huesped= $huesped->obtengo_nombre_completo($id_huesped);
      $nombre_tarifa= $tarifa->obtengo_nombre($id_tarifa);
      $total_tarifa= $tarifa->obtengo_tarifa_dia($id_tarifa,$extra_adulto,$extra_junior,$extra_junior,$descuento);
      $total_final= $total_final + $total_tarifa;

      $pdf->Cell(8,5,iconv("UTF-8", "ISO-8859-1",$hab_nombre),1,0,'C');
      $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1",$nombre_tarifa),1,0,'C');
      $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$extra_adulto),1,0,'C'); 
      $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$extra_junior),1,0,'C');
      $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$extra_infantil),1,0,'C');
      $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$extra_menor),1,0,'C');
      $pdf->Cell(50,5,iconv("UTF-8", "ISO-8859-1",$nombre_huesped),1,0,'C'); 
      $pdf->Cell(32,5,iconv("UTF-8", "ISO-8859-1",$quien_reserva),1,0,'C'); 
      $pdf->Cell(10,5,iconv("UTF-8", "ISO-8859-1",$descuento),1,0,'C'); 
      $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_tarifa, 2)),1,1,'C');    
  }*/

  $pdf->SetFont('Arial','',10);
  $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Total $ '.number_format($total_final, 2)),0,1,'R');
  $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Ocupacion '.$porcentaje.'%'),0,1,'R');

  $_GET['id']=1;
  //$pdf->Output("reporte_reservacion_por_dia.pdf","I");
  $pdf->Output("reporte_reservacion_por_dia".$_GET['id'].".pdf","I");
  //$pdf->Output("../reportes/reservaciones/reporte_reservacion_por_dia.pdf","F");
      //echo 'Reporte reservacion por dia';*/
?>

