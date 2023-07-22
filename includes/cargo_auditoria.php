<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_huesped.php");
  include_once('clase_tarifa.php');
  include_once('clase_log.php');
  include_once("clase_configuracion.php");
  include_once('clase_cargo_noche.php');
  include_once("clase_usuario.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab(0);
  $huesped= NEW Huesped(0);
  $tarifa= NEW Tarifa(0);
  $logs = NEW Log(0);
  $cargo_noche = NEW Cargo_noche(0);
  
  $total_final= 0;
  $descripcion= "Cargo por noche";
  $consulta = $hab->datos_auditoria();

  // Revisamos el total de cargo por habitacion
  // while ($fila = mysqli_fetch_array($consulta))
  // {
  //   $hab_id = $fila['ID'];
  //   $extra_adulto = $fila['extra_adulto'];
  //   $extra_junior = $fila['extra_junior'];
  //   $extra_infantil = $fila['extra_infantil'];
  //   $id_tarifa = $fila['tarifa'];
  //   $descuento = $fila['descuento'];
  //   $mov = $fila['mov'];

  //   $total_aux = $fila['precio_hospedaje'];
  //   $nombre_tarifa= $tarifa->obtengo_nombre($id_tarifa);
  //   $total_tarifa= $tarifa->obtengo_tarifa_dia($id_tarifa,$extra_adulto,$extra_junior,$extra_infantil,$descuento);
  //   $total_final= $total_final + $total_tarifa;
  //   $cuenta->guardar_cuenta($_POST['usuario_id'],$mov,$descripcion,1,$total_aux,0);
  // }

  $logs->guardar_log($_POST['usuario_id'],"Aplicar cargo por noche en las habitaciones");

  // Comienza a realizarse el reporte //

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
          $nombre= $conf->obtener_nombre();
          // $realizo_usuario= $usuario->obtengo_nombre_completo($_POST['usuario_id']);
          $realizo_usuario="";

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
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'REPORTE CARGO POR NOCHE'),0,0,'C');
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
  $fecha_actual = time();
  $fecha = date("d-m-Y",$fecha_actual);
  $dia = substr($fecha, 0, 2);
  $mes = substr($fecha, 3, 2);
  $mes= $logs->formato_fecha($mes);
  $anio = substr($fecha, 6, 4);

  // Titulos tabla -277
  $pdf->SetFont('Arial','B',7);
  $pdf->SetTextColor(255, 255, 255);
  $pdf->SetFillColor(99, 155, 219);
  $pdf->Cell(25,4,iconv("UTF-8", "ISO-8859-1",'HAB'),0,0,'C',True);
  $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",'TARIFA'),0,0,'C',True);
  // $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'TARIFA $'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True); 
  // $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'NO.'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'NOCHES'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
  $pdf->Cell(40,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True); 
  $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",'QUIEN'),0,0,'C',True); 

  $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",'TOTAL'),0,1,'C',True);

  $pdf->Cell(25,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  // $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'ADULTO'),0,0,'C',True); 
  // $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'HAB'),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
  $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'MENOR'),0,0,'C',True); 
  $pdf->Cell(40,4,iconv("UTF-8", "ISO-8859-1",'HUESPED'),0,0,'C',True); 
  $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",'RESERVA'),0,0,'C',True);

  $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",''),0,1,'C',True);


  // Datos dentro de la tabla herramienta
  $total_final= 0;
  $cantidad_hab= 0;
  $pdf->SetFont('Arial','',7);
  $pdf->SetTextColor(0,0,0);
  $consulta = $hab->datos_auditoria();

  $NX =0;
  // Revisamos el total de cargo por habitacion
  while ($fila = mysqli_fetch_array($consulta))
  {
  
    $cantidad_hab++;
    $hab_id = $fila['ID'];
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
    $precio_tarifa = $fila['precio_hospedaje'];
    $noches = $fila['noches'];
    $nohabs = $fila['numero_hab'];
    $total = $fila['total'];

    $nombre_huesped= $huesped->obtengo_nombre_completo($id_huesped);
    $nombre_tarifa= $tarifa->obtengo_nombre($id_tarifa);
    $total_tarifa= $tarifa->obtengo_tarifa_dia($id_tarifa,$extra_adulto,$extra_junior,$extra_infantil,$descuento);
    $total_final= $total_final + $precio_tarifa;

    $nombre_tarifa = $id_tarifa != 0 ? $nombre_tarifa : "Forzar tarifa";


    $pdf->Cell(25,5,iconv("UTF-8", "ISO-8859-1",$hab_nombre),1,0,'C');
    $pdf->Cell(30,5,iconv("UTF-8", "ISO-8859-1",$precio_tarifa),1,0,'C');
    // $pdf->Cell(22,5,iconv("UTF-8", "ISO-8859-1",$precio_tarifa),1,0,'C'); 
    $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$extra_adulto),1,0,'C');
    // $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$nohabs),1,0,'C');
    $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$noches),1,0,'C');
    $pdf->Cell(12,5,iconv("UTF-8", "ISO-8859-1",$extra_menor),1,0,'C');
    $pdf->Cell(40,5,iconv("UTF-8", "ISO-8859-1",$nombre_huesped),1,0,'C'); 
    $pdf->Cell(30,5,iconv("UTF-8", "ISO-8859-1",$quien_reserva),1,0,'C'); 
    $pdf->Cell(28,5,iconv("UTF-8", "ISO-8859-1",'$'.number_format($precio_tarifa, 2)),1,1,'C');    

      /*for ($i = 1; $i <= 26; $i++) {
        $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Iteracion '.$i),0,1,'R');
      }*/
    
      $x=$pdf->GetX();
      $y=$pdf->GetY();
      if($y >= 265){
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',7);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetFillColor(99, 155, 219);
        $pdf->Cell(25,4,iconv("UTF-8", "ISO-8859-1",'HAB'),0,0,'C',True);
        $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",'TARIFA'),0,0,'C',True);
        // $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",'TARIFA $'),0,0,'C',True);
        $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True); 
        // $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'NO.'),0,0,'C',True);
        $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'NOCHES'),0,0,'C',True);
        $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'EXTRA'),0,0,'C',True);
        $pdf->Cell(40,4,iconv("UTF-8", "ISO-8859-1",'NOMBRE'),0,0,'C',True); 
        $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",'QUIEN'),0,0,'C',True); 

        $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",'TOTAL'),0,1,'C',True);

        $pdf->Cell(25,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
        $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
        // $pdf->Cell(22,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
        $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'ADULTO'),0,0,'C',True); 
        // $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'HAB'),0,0,'C',True);
        $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",''),0,0,'C',True);
        $pdf->Cell(12,4,iconv("UTF-8", "ISO-8859-1",'MENOR'),0,0,'C',True); 
        $pdf->Cell(40,4,iconv("UTF-8", "ISO-8859-1",'HUESPED'),0,0,'C',True); 
        $pdf->Cell(30,4,iconv("UTF-8", "ISO-8859-1",'RESERVA'),0,0,'C',True);
    
        $pdf->Cell(28,4,iconv("UTF-8", "ISO-8859-1",''),0,1,'C',True);
        $pdf->SetFont('Arial','',7);
        $pdf->SetTextColor(0,0,0);
      }
     
  }

  $pdf->SetFont('Arial','',10);
  $numero_actual= $cargo_noche->ultima_insercion();
  $numero_actual++;
  $pdf->Cell(192,8,iconv("UTF-8", "ISO-8859-1",'Total $ '.number_format($total_final, 2)),0,1,'R');

  // Luego de guardar el reporte se cambia el estado cargo noche de todas las habitaciones a 0
  $hab->estado_cargo_noche(0);
  $cargo_noche->guardar_cargo_noche($_POST['usuario_id'],$total_final,$cantidad_hab);
  $logs->guardar_log($_POST['usuario_id'],"Reporte cargo por noche: ".$numero_actual.' del '.$dia.' de '.$mes.' de '.$anio);
  
  //$pdf->Output("reporte_cargo_noche.pdf","I");// I muestra y F descarga con directorio y D descarga en descargas
  $pdf->Output("../reportes/reservaciones/cargo_noche/reporte_cargo_noche_".$numero_actual.".pdf","F");
  //$pdf->Output("../reportes/reservaciones/cargo_noche/reporte_cargo_noche_".$numero_actual.".pdf","I");
  //$pdf->Output("../reportes/reservaciones/cargo_noche/reporte_cargo_noche.pdf","I");//I
      //echo 'Reporte cargo noche';*/ I
?>
