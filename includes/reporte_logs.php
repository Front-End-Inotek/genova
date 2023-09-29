<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $logs = NEW Log(0);
  require('../fpdf/fpdf.php');
  class PDF extends FPDF
  {
      // Cabecera de página
      function Header()
      {
          $conf = NEW Configuracion(0);
          $usuario= NEW Usuario(0);
          $logs = NEW Log(0);
          $this->SetFont('Arial','B',8);
          $this->SetTextColor(0,0,0);
          $fecha_actual = time();
          $fecha = date("d-m-Y",$fecha_actual);
          $dia = substr($fecha, 0, 2);
          $mes = substr($fecha, 3, 2);
          $mes= $logs->formato_fecha($mes);
          $anio = substr($fecha, 6, 4);
          $usuario_nombre= $usuario->obtengo_usuario($_GET['usuario']);
          $actividad= urldecode($_GET['buscar']);
          $nombre= $conf->obtener_nombre();
          $realizo_usuario= $usuario->obtengo_nombre_completo($_GET['usuario_id']);
          // Reporte de que fecha a que fecha
          $fecha_ini = date("Y-m-d",$_GET['fecha_ini']);
          $fecha_fin = date("Y-m-d",$_GET['fecha_fin']);
          $fecha_inicial_dia = substr($fecha_ini, 8, 2);
          $fecha_inicial_mes = substr($fecha_ini, 5, 2);
          $fecha_inicial_anio = substr($fecha_ini, 0, 4);
          $fecha_final_dia = substr($fecha_fin, 8, 2);
          $fecha_final_mes = substr($fecha_fin, 5, 2);
          $fecha_final_anio = substr($fecha_fin, 0, 4);
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
          $this->Cell(172,5,iconv("UTF-8", "ISO-8859-1",'Realizó '.$realizo_usuario.' el '.$dia.' de '.$mes.' de '.$anio),0,1,'R');
          if($_GET['usuario'] == 0){
            $this->Cell(194,5,iconv("UTF-8", "ISO-8859-1",''),0,1,'R');
          }else{
            $this->Cell(194,5,iconv("UTF-8", "ISO-8859-1",'Usuario buscado: '.$usuario_nombre),0,1,'R');
          }
          if(strlen($actividad) == 0){
            $this->Cell(194,5,iconv("UTF-8", "ISO-8859-1",''),0,1,'R');
          }else{
            $this->Cell(194,5,iconv("UTF-8", "ISO-8859-1",'Actividad buscada: '.$actividad),0,1,'R');
          }
          // Logo
          $this->Image("../images/hotelexpoabastos.png",10,18,25,25);
          // Salto de línea
          $this->Ln(8);
          // Movernos a la derecha
          $this->Cell(80);
          // Título
          $this->SetFont('Arial','',10);
          $this->SetTextColor(0, 102, 205);
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'Reporte Logs del '.$fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio),0,0,'C');
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
//Formato de hoja (Orientacion, tamaño , tipo)
$pdf = new FPDF('P', 'mm', 'Letter');
  // Fecha y datos generales
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $usuario= $_GET['usuario'];
  $actividad= urldecode($_GET['buscar']);

  // Reporte de que fecha a que fecha
  $fecha_ini = date("Y-m-d",$_GET['fecha_ini']);
  $fecha_fin = date("Y-m-d",$_GET['fecha_fin']);
  $fecha_inicial_dia = substr($fecha_ini, 8, 2);
  $fecha_inicial_mes = substr($fecha_ini, 5, 2);
  $fecha_inicial_anio = substr($fecha_ini, 0, 4);
  $fecha_final_dia = substr($fecha_fin, 8, 2);
  $fecha_final_mes = substr($fecha_fin, 5, 2);
  $fecha_final_anio = substr($fecha_fin, 0, 4);

  // Titulos de tabla
  $pdf->SetFont('Arial','U',9);
  $pdf->SetTextColor(20, 31, 102);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",'USUARIO'),1,0,'C',True); 
  $pdf->Cell(26,6,iconv("UTF-8", "ISO-8859-1",'FECHA'),1,0,'C',True); 
  $pdf->Cell(26,6,iconv("UTF-8", "ISO-8859-1",'IP'),1,0,'C',True); 
  $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",'ACTIVIDAD REALIZADA'),1,1,'C',True);
  $pdf->SetFont('Arial','',8);
  $pdf->SetTextColor(0,0,0);

  // Datos dentro de la tabla logs
  $x=$pdf->GetX();
  $y=$pdf->GetY();
  $consulta=$logs->obtener_usuario();
  $part=0;
  $y_mayor = 0;
  $consulta=$logs->obtener_logs($usuario,$_GET['fecha_ini'],$_GET['fecha_fin'],$actividad);
  while ($fila = mysqli_fetch_array($consulta))
  {
     $divisor=44;
     $longitud = strlen($fila['actividad']);
     
     $cantidad = intval($longitud /$divisor);
     if(($longitud%$divisor)>0){
         $cantidad++;
     }
     if($cantidad>=$y_mayor){
         $y_mayor = $cantidad;
     }
     $alto=$cantidad*6;
     $alto=$y_mayor*6;
     if($longitud<=44){
        $alto=6;
        $y_mayor=1;
     }
     $linea =$y+ ($y_mayor*6);
     $pdf->Line($x+192, $y, $x+192, $linea); 
     $pdf->Line($x, $linea, $x+192, $linea); 
     $pdf->SetXY($x,$y);
     $part++;
     
     $pdf->Cell(70,$alto,iconv("UTF-8", "ISO-8859-1",$logs->saber_nombre($fila['usuario'])),1,0,'C');
     $pdf->Cell(26,$alto,iconv("UTF-8", "ISO-8859-1",date("d-m-Y",$fila['hora'])),1,0,'C'); 
     $pdf->Cell(26,$alto,iconv("UTF-8", "ISO-8859-1",$fila['ip']),1,0,'C'); 
     if($longitud<=$divisor){
         $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",$fila['actividad']),0,0,'C');   
     }else{
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $y_old=$pdf->GetY();
        $inicio=0;
        for($i=1;$i<=$cantidad;$i++){
            $fin=$divisor;
            $pdf->SetXY($x,$y);
            if($i==1)
            {   
                $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",''.substr($fila['actividad'], $inicio, $fin)),0,0,'C'); 
            }else{
                $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",''.substr($fila['actividad'], $inicio, $fin)),0,0,'C'); 
            }
            $inicio = $inicio+$divisor;
            $y=$y+6;
        }
        $x=$x+70;
        $pdf->SetXY($x,$y_old);
      }
      $y =$linea;
      $x =10;
      $pdf->SetXY($x,$y);

      /*for($i = 1; $i <= 26; $i++){
        $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Iteracion '.$i),0,1,'R');
      }*/

      if($y >= 265){
        $pdf->AddPage();
        $y =57;
        $x =10;
        $pdf->SetFont('Arial','U',9);
        $pdf->SetTextColor(20, 31, 102);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(99, 155, 219);
        $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",'USUARIO'),1,0,'C',True); 
        $pdf->Cell(26,6,iconv("UTF-8", "ISO-8859-1",'FECHA'),1,0,'C',True); 
        $pdf->Cell(26,6,iconv("UTF-8", "ISO-8859-1",'IP'),1,0,'C',True); 
        $pdf->Cell(70,6,iconv("UTF-8", "ISO-8859-1",'ACTIVIDAD REALIZADA'),1,1,'C',True);
        
        // Datos dentro de la tabla logs
        $pdf->SetFont('Arial','',8);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetXY($x,$y);
      }
  }

  $logs->guardar_log($_GET['usuario_id'],"Reporte logs del: ". $fecha_inicial_dia.'-'.$fecha_inicial_mes.'-'.$fecha_inicial_anio.' al '.$fecha_final_dia.'-'.$fecha_final_mes.'-'.$fecha_final_anio);
  
  $pdf->Output("reporte_logs.pdf","I");
  //$pdf->Output("reporte_logs_".$_GET['usuario_id'].".pdf","I");
  //$pdf->Output("../reportes/logs/reporte_logs_".$_GET['usuario_id'].".pdf","F");
  //echo 'Reporte logs';
?>