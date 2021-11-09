<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_log.php');
  include_once("clase_huesped.php");
  include_once("clase_reservacion.php");

  $logs = NEW Log(0);
  //$logs->guardar_log($_GET['id'],"Reporte cargo por noche");
  $huesped= NEW Huesped(0);
  $reservacion= NEW Reservacion(0);
  //86400
  
  require('../fpdf/fpdf.php');
  //$pdf = new FPDF();
  $pdf = new FPDF('L','mm','A4');
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
  $pdf->Cell(277,5,iconv("UTF-8", "ISO-8859-1",$dia.' de '.$mes.' de '.$anio),0,1,'R');
  $pdf->Ln(4);

  // Titulos tabla -277
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(0, 102, 205);
  $pdf->Cell(277,6.5,iconv("UTF-8", "ISO-8859-1",'REPORTE POR NOCHE'),0,1,'C');
  $pdf->SetFont('Arial','B',9);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->Ln(4);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'HABITACION'),0,0,'C',True);
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",'TARIFA'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True); 
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(51,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True); 
  $pdf->Cell(51,4,iconv("UTF-8", "ISO-8859-1",'QUIEN'),0,0,'C',True); 
  $pdf->Cell(33,4,iconv("UTF-8", "ISO-8859-1",'TOTAL'),0,1,'C',True);

  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(32,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'ADULTO'),0,0,'C',True); 
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'JUNIOR'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'INFANTIL'),0,0,'C',True);
  $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'MENOR'),0,0,'C',True); 
  $pdf->Cell(51,4,iconv("UTF-8", "ISO-8859-1",'HUESPED'),0,0,'C',True); 
  $pdf->Cell(51,4,iconv("UTF-8", "ISO-8859-1",'RESERVA'),0,0,'C',True); 
  $pdf->Cell(33,4,iconv("UTF-8", "ISO-8859-1",''),0,1,'C',True);

  // Datos dentro de la tabla herramienta
 /*$y = 80.5;
  $x = 10;
  $pdf->SetXY($x,$y);
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $consulta = $herramienta->datos_herramienta();
  $part=0;
  $y_mayor = 0;
  // Revisamos si tiene registros la herramienta
  while ($fila = mysqli_fetch_array($consulta))
  {
      $nombre = $fila['nombre'];
      $marca = $fila['marca'];
      $modelo = $fila['modelo'];
      $descripcion = $fila['descripcion']; 
      $cantidad_almacen = $fila['cantidad_almacen']; 
      $cantidad_prestadas = $fila['cantidad_prestadas']; 
      $estado = $fila['estado'];
      
      $divisor=32;
      $divisor_nombre=32;
      $divisor_marca=18;
      $divisor_modelo=18;
      $longitud = strlen($descripcion);
      $longitud_nombre = strlen($nombre);
      $longitud_marca = strlen($marca); 
      $longitud_modelo = strlen($modelo); 

      $cantidad = intval($longitud /$divisor);
      if(($longitud%$divisor)>0){
          $cantidad++;
      }
      if($cantidad>=$y_mayor){
        $y_mayor = $cantidad;
      }
      $alto=$cantidad*6;

      $cantidad_nombre= intval($longitud_nombre /$divisor_nombre);
      if(($longitud_nombre%$divisor_nombre)>0){
          $cantidad_nombre++;
      }
      if($cantidad_nombre>=$y_mayor){
          $y_mayor = $cantidad_nombre;
      }
      $alto_nombre=$cantidad_nombre*6;
      if($alto_nombre>=$alto)
      {
          $alto=$alto_nombre;
      }

      $cantidad_marca= intval($longitud_marca /$divisor_marca);
      if(($longitud_marca%$divisor_marca)>0){
          $cantidad_marca++;
      }
      if($cantidad_marca>=$y_mayor){
        $y_mayor = $cantidad_marca;
      }
      $alto_marca=$cantidad_marca*6;
      if($alto_marca>=$alto)
      {
        $alto=$alto_marca;
      }

      $cantidad_modelo= intval($longitud_modelo /$divisor_modelo);
      if(($longitud_modelo%$divisor_modelo)>0){
          $cantidad_modelo++;
      }
      if($cantidad_modelo>=$y_mayor){
        $y_mayor = $cantidad_modelo;
      }
      $alto_modelo=$cantidad_modelo*6;
      if($alto_modelo>=$alto)
      {
        $alto=$alto_modelo;
      }
      $alto=$y_mayor*6 ;
      if($longitud<=32 && $longitud_nombre<32 && $longitud_marca<18 && $longitud_modelo<18){
        $alto=6;
        $y_mayor=1;
      }
      $lineas =$y+ ($y_mayor*6);
      $pdf->Line($x, $y, $x, $lineas); 
      $pdf->Line($x+59, $y, $x+59, $lineas); 
      $pdf->Line($x+87, $y, $x+87, $lineas); 
      $pdf->Line($x+115, $y, $x+115, $lineas); 
      $pdf->Line($x+192, $y, $x+192, $lineas); 
      $pdf->Line($x, $lineas, $x+192, $lineas);
      $pdf->SetXY($x,$y);
      $part++;
      $pdf->Cell(192,.1,"",1,1,"C",true);   

      $pdf->Cell(12,$alto,iconv("UTF-8", "ISO-8859-1",$part),1,0,'C');
      if($longitud_nombre<=$divisor_nombre){
        $pdf->Cell(47,$alto,iconv("UTF-8", "ISO-8859-1",$nombre),1,0,'C');
      }else{
        $x=$pdf->GetX();
        $y=$pdf->GetY();
        $y_old=$pdf->GetY();
        $inicio=0;
        for($i=1;$i<=$cantidad_nombre;$i++){
            $fin=$divisor_nombre;
            $pdf->SetXY($x,$y);
            if($i==1)
            {   
                $pdf->Cell(47,6,iconv("UTF-8", "ISO-8859-1",''.substr($nombre, $inicio, $fin)),0,0,'C');
            }else{
                $pdf->Cell(47,6,iconv("UTF-8", "ISO-8859-1",''.substr($nombre, $inicio, $fin)),0,0,'C');
            }
            $inicio = $inicio+$divisor_nombre;
            $y=$y+6;
        }
        $x=$x+47;
        $pdf->SetXY($x,$y_old);
      }

    if($longitud_marca<=$divisor_marca){
      $pdf->Cell(28,$alto,iconv("UTF-8", "ISO-8859-1",$marca),1,0,'C');
    }else{
      $x=$pdf->GetX();
      $y=$pdf->GetY();
      $y_old=$pdf->GetY();
      $inicio=0;
      for($i=1;$i<=$cantidad_marca;$i++){
          $fin=$divisor_marca;
          $pdf->SetXY($x,$y);
          if($i==1)
          {   
              $pdf->Cell(28,6,iconv("UTF-8", "ISO-8859-1",''.substr($marca, $inicio, $fin)),0,0,'C');
          }else{
              $pdf->Cell(28,6,iconv("UTF-8", "ISO-8859-1",''.substr($marca, $inicio, $fin)),0,0,'C');
          }
          $inicio = $inicio+$divisor_marca;
          $y=$y+6;
      }
      $x=$x+28;
      $pdf->SetXY($x,$y_old);
    }
    
    if($longitud_modelo<=$divisor_modelo){
      $pdf->Cell(28,$alto,iconv("UTF-8", "ISO-8859-1",$modelo),1,0,'C');
    }else{
      $x=$pdf->GetX();
      $y=$pdf->GetY();
      $y_old=$pdf->GetY();
      $inicio=0;
      for($i=1;$i<=$cantidad_modelo;$i++){
          $fin=$divisor_modelo;
          $pdf->SetXY($x,$y);
          if($i==1)
          {   
              $pdf->Cell(28,6,iconv("UTF-8", "ISO-8859-1",''.substr($modelo, $inicio, $fin)),0,0,'C');
          }else{
              $pdf->Cell(28,6,iconv("UTF-8", "ISO-8859-1",''.substr($modelo, $inicio, $fin)),0,0,'C');
          }
          $inicio = $inicio+$divisor_modelo;
          $y=$y+6;
      }
      $x=$x+28;
      $pdf->SetXY($x,$y_old);
    }

   
    if($longitud<=$divisor){
      $pdf->Cell(47,$alto,iconv("UTF-8", "ISO-8859-1",$descripcion),1,0,'C');
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
              $pdf->Cell(47,6,iconv("UTF-8", "ISO-8859-1",''.substr($descripcion, $inicio, $fin)),0,0,'C');
          }else{
              $pdf->Cell(47,6,iconv("UTF-8", "ISO-8859-1",''.substr($descripcion, $inicio, $fin)),0,0,'C');
          }
          $inicio = $inicio+$divisor;
          $y=$y+6;
      }
      $x=$x+47;
      $pdf->SetXY($x,$y_old);
    }
  
    $pdf->Cell(15,$alto,iconv("UTF-8", "ISO-8859-1",$cantidad_almacen),1,0,'C'); 
    $pdf->Cell(15,$alto,iconv("UTF-8", "ISO-8859-1",$cantidad_prestadas),1,1,'C');  
    $y =$lineas;
    $x =10;
    $pdf->SetXY($x,$y);
    
    if($y >= 265){
      $pdf->AddPage();
      $y =26;
      $x =10;
      $pdf->SetFont('Arial','B',9);
      $pdf->SetTextColor(255, 255, 255);
      $pdf->Ln(4);
      $pdf->SetFillColor(99, 155, 219);
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(47,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True); 
      $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(47,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'CANT.'),0,0,'C',True); 
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'CANT.'),0,1,'C',True);

      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'PART.'),0,0,'C',True);
      $pdf->Cell(47,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True);
      $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",'MARCA'),0,0,'C',True); 
      $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",'MODELO'),0,0,'C',True);
      $pdf->Cell(47,4,iconv("UTF-8", "ISO-8859-1",'DESCRIPCION'),0,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'ALMA-'),0,0,'C',True); 
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'PRES-'),0,1,'C',True);
      
      $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(47,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True); 
      $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(47,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'CEN'),0,0,'C',True); 
      $pdf->Cell(15,4,iconv("UTF-8", "ISO-8859-1",'TADAS'),0,1,'C',True);

      // Datos dentro de la tabla herramienta
      $pdf->SetFont('Arial','',7);
      $pdf->SetTextColor(0,0,0);
      $pdf->SetXY($x,$y);
    }          
  }
 */

  $_GET['id']=1;
  //$pdf->Output("reporte_herramienta.pdf","I");
  $pdf->Output("reporte_cargo_noche_".$_GET['id'].".pdf","I");
  //$pdf->Output("../reportes/herramienta/reporte_herramienta.pdf","F");
      //echo 'Reporte herramienta';*/
?>

