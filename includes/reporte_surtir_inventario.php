<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_inventario.php");
  include_once("clase_surtir.php");
  
  $logs = NEW Log(0);
  $inventario = NEW Inventario(0);
  $surtir = NEW Surtir(0);

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
  $fecha_actual = time();
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
  //$logs->guardar_log($_GET['usuario_id'],"Reporte surtir inventario ".$dia.' de '.$mes.' de '.$anio);
  $pdf->Ln(4);

  // Titulos tabla -277
  $pdf->SetFont('Arial','B',10);
  $pdf->SetTextColor(0, 102, 205);
  $pdf->Cell(192,6.5,iconv("UTF-8", "ISO-8859-1",'REPORTE SURTIR INVENTARIO'),0,1,'C');
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Ln(4);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(45,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(80,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'CANTIDAD'),0,1,'C',True);

  // Datos dentro de la tabla surtir
  $pdf->SetTextColor(0,0,0);
  $id_reporte= $surtir->ultima_insercion_reporte();
  $id_reporte++;
  $consulta = $surtir->datos_surtir_inventario();
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_producto= $fila['id'];
      $surtir_id = $fila['ID'];
      $nombre = $fila['nombre'];  
      $cantidad = $fila['cantidad'];
      $pdf->Cell(45,5,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(80,5,iconv("UTF-8", "ISO-8859-1",$nombre),1,0,'C'); 
      $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$cantidad),1,1,'C');    
      $cantidad_inventario= $inventario->cantidad_inventario($id_producto);
      $cantidad_final= $cantidad_inventario + $cantidad;
      $nuevo_inventario= $inventario->editar_cantidad_inventario($id_producto,$cantidad_final);
      $ajustes= $surtir->ajustes_surtir($surtir_id,$id_reporte);
  }

  //$pdf->Output("reporte_cargo_noche.pdf","I");// I muestra y F descarga con directorio y D descarga en descargas
  $pdf->Output("../reportes/inventario/reporte_surtir_inventario".$id_reporte.".pdf","I");
  //$pdf->Output("../reportes/reservaciones/cargo_noche/reporte_cargo_noche.pdf","I");
      //echo 'Reporte cargo noche';*/
  // Luego de guardar el reporte se cambia el estado cargo noche de todas las habitaciones a 0
  /*$hab->estado_cargo_noche(0);
  $cargo_noche->guardar_cargo_noche($_GET['usuario_id'],$total_final,$cantidad_hab);*/

  //$logs->guardar_log($_POST['usuario_id'],"Aplicar surtir inventario");
?>

