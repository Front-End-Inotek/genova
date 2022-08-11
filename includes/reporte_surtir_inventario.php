<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_surtir.php");
  include_once("clase_surtir_inventario.php");
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $surtir = NEW Surtir(0);
  $surtir_inventario = NEW Surtir_inventario($_GET['id']);
  $logs = NEW Log(0);

  require('../fpdf/fpdf.php');
  
  class PDF extends FPDF
  {
      // Cabecera de página
      function Header()
      {
          $conf = NEW Configuracion(0);
          $usuario= NEW Usuario(0);
          $surtir_inventario = NEW Surtir_inventario($_GET['id']);
          $logs = NEW Log(0);

          $this->SetFont('Arial','B',8);
          $this->SetTextColor(0,0,0);
          if($_GET['id'] == 0){
              $fecha_actual = time();
          }else{
              $fecha_actual = $surtir_inventario->fecha;
          }
          $fecha = date("d-m-Y",$fecha_actual);
          $dia = substr($fecha, 0, 2);
          $mes = substr($fecha, 3, 2);
          $mes= $logs->formato_fecha($mes);
          $anio = substr($fecha, 6, 4);
          $nombre= $conf->obtener_nombre();
          $realizo_usuario= $usuario->obtengo_nombre_completo($_GET['usuario_id']);

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
          $this->Cell(172,9,iconv("UTF-8", "ISO-8859-1",'Realizó '.$realizo_usuario.' el '.$dia.' de '.$mes.' de '.$anio),0,1,'R');
          // Logo
          $this->Image("../images/simbolo.png",10,18,25,25);
          // Salto de línea
          $this->Ln(14);
          // Movernos a la derecha
          $this->Cell(80);
          // Título
          $this->SetFont('Arial','B',10);
          $this->SetTextColor(0, 102, 205);
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'REPORTE SURTIR INVENTARIO'),0,0,'C');
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
  if($_GET['id'] == 0){
    $fecha_actual = time();
  }else{
  $fecha_actual = $surtir_inventario->fecha;
  }
  $fecha = date("d-m-Y",$fecha_actual);
  $dia = substr($fecha, 0, 2);
  $mes = substr($fecha, 3, 2);
  $mes= $logs->formato_fecha($mes);
  $anio = substr($fecha, 6, 4);

  // Titulos tabla -277
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(45,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
  $pdf->Cell(80,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True);
  $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'CANTIDAD'),0,1,'C',True);

  // Datos dentro de la tabla surtir
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  if($_GET['id'] == 0){
      $id_reporte= $surtir->ultima_insercion_reporte();
  }else{
      $id_reporte= $_GET['id'];
  }
  $consulta = $surtir->datos_surtir_inventario_reporte($id_reporte);
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_producto= $fila['id'];
      $surtir_id = $fila['ID'];
      $nombre = $fila['nombre'];  
      $cantidad = $fila['cantidad'];
      $pdf->Cell(45,5,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
      $pdf->Cell(80,5,iconv("UTF-8", "ISO-8859-1",$nombre),1,0,'C'); 
      $pdf->Cell(20,5,iconv("UTF-8", "ISO-8859-1",$cantidad),1,1,'C'); 
      
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
        $pdf->Cell(45,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C');
        $pdf->Cell(80,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True);
        $pdf->Cell(20,4,iconv("UTF-8", "ISO-8859-1",'CANTIDAD'),0,1,'C',True);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(0,0,0);
      }
  }

  $logs->guardar_log($_GET['usuario_id'],"Reporte surtir inventario: ".$id_reporte.' del '.$dia.' de '.$mes.' de '.$anio);
  //$pdf->Output("reporte_surtir_inventario.pdf","I");// I muestra y F descarga con directorio y D descarga en descargas
  $pdf->Output("../reportes/inventario/reporte_surtir_inventario_".$id_reporte.".pdf","I");
  //$pdf->Output("../reportes/inventario/reporte_surtir_inventario.pdf","I");
      //echo 'Reporte surtir inventario';*/
?>

