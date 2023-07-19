<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_configuracion.php");
  include_once("clase_huesped.php");
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
          $nombre= $conf->obtener_nombre();
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
          // Logo
          $this->Image("../images/simbolo.png",10,18,25,25);
          // Salto de línea
          $this->Ln(24);
          // Movernos a la derecha
          $this->Cell(80);
          // Título
          $this->Cell(30,10,iconv("UTF-8", "ISO-8859-1",'RESERVACIÓN '.$_GET['id']),0,0,'C');
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
  
  // Datos dentro de la reservacion
  $pdf = new PDF();
  $pdf->AliasNbPages();
  $pdf->AddPage();
  $pdf->SetFont('Arial','',9);
  $consulta= $reservacion->datos_reservacion($_GET['id']);
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_hab= $fila['ID'];
      $id_usuario= $fila['id_usuario'];
      $usuario_reservacion= $fila['usuario'];
      $id_huesped= $fila['id_huesped'];
      $id_cuenta= $fila['id_cuenta'];
      $fecha_entrada= date("d-m-Y",$fila['fecha_entrada']);
      $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
      $noches= $fila['noches'];
      $numero_hab= $fila['numero_hab'];
      $tarifa= $fila['habitacion'];
      $precio_hospedaje= '$'.number_format($fila['precio_hospedaje'], 2);
      $cantidad_hospedaje= $fila['cantidad_hospedaje'];
      $extra_adulto= $fila['extra_adulto'];
      $extra_junior= $fila['extra_junior'];
      $extra_infantil= $fila['extra_infantil'];
      $extra_menor= $fila['extra_menor'];
      $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
      $quien_reserva= $fila['nombre_reserva'];
      $acompanante= $fila['acompanante'];
      // Checar si suplementos esta vacio o no
      if (empty($fila['suplementos'])){
          //echo 'La variable esta vacia';
          $suplementos= 'Ninguno';
      }else{
          $suplementos= $fila['suplementos'];
      }
      $total_suplementos= '$'.number_format($fila['total_suplementos'], 2);
      $total_habitacion= '$'.number_format($fila['total_hab'], 2);
      if($fila['descuento']>0){
          $descuento= $fila['descuento'].'%'; 
      }else{
          $descuento= 'Ninguno'; 
      }
      if($fila['forzar_tarifa']>0){
          $total_estancia= '$'.number_format($fila['forzar_tarifa'], 2);
      }else{
          $total_estancia= '$'.number_format($fila['total'], 2);
      }
      if($fila['total_pago']>0){
          $total_pago= '$'.number_format($fila['total_pago'], 2);
      }else{
          $total_pago= 'Ninguno';
      }
      $forma_pago= $fila['descripcion'];
      $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
  }

  // Datos de reservacion
  $huesped= NEW Huesped($id_huesped);  
  $x= 20;
  $y=$pdf->GetY() + 0;
  $pdf->SetXY($x,$y);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Fecha Entrada: '.$fecha_entrada),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Fecha Salida: '.$fecha_salida),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Usuario que la hizo: '.$usuario_reservacion),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Cantidad habitaciones: '.$numero_hab),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Noches: '.$noches),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Tarifa: '.$tarifa),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Nombre Huesped: '.$nombre_huesped),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Quién Reserva: '.$quien_reserva),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Acompañante: '.$acompanante),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Cantidad Hospedaje: '.$cantidad_hospedaje),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  if($extra_adulto>0){
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Adulto: '.$extra_adulto),0,0,'L');
  }else{
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Adulto: 0'),0,0,'L');
  }
  if($extra_junior>0){
    $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Junior: '.$extra_junior),0,1,'L');
  }else{
    $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Junior: 0'),0,1,'L'); 
  }

  $x= 20;
  $pdf->SetX($x);
  if($extra_infantil>0){
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Infantil: '.$extra_infantil),0,0,'L');
  }else{
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Infantil: 0'),0,0,'L');
  }
  if($extra_menor>0){
    $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Menor: '.$extra_menor),0,1,'L');
  }else{
    $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Extra Menor: 0'),0,1,'L'); 
  }

  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Número Cuenta: '.$id_cuenta),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Precio Hospedaje: '.number_format($precio_hospedaje,2)),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Suplementos: '.$suplementos),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Total suplementos: '.$total_suplementos),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Forma Pago: '.$forma_pago),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Limite Pago: '.$limite_pago),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Total Habitacion: '.$total_habitacion),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Descuento: '.$descuento),0,1,'L');

  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Total Estancia: '.$total_estancia),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Total Pago: '.$total_pago),0,1,'L');

  // Datos de huesped de la reservacion
  $y=$pdf->GetY() + 10;
  $x = 20;
  $pdf->SetXY($x,$y);
  $pdf->SetFont('Arial','B',13);
  $pdf->SetTextColor(0, 102, 205);
  $pdf->Cell(192,7,iconv("UTF-8", "ISO-8859-1",'DATOS HUÉSPED'),0,1,'L');
  $pdf->SetTextColor(0,0,0);
  $pdf->SetFont('Arial','',9);
  $pdf->Ln(2);
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Nombre: '.$huesped->nombre),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Apellido: '.$huesped->apellido),0,1,'L');

  $x= 20;
  $pdf->SetX($x);
  $y_final=$pdf->GetY();
  $pdf->MultiCell(80,5,iconv("UTF-8", "ISO-8859-1",'Direccion: '.$huesped->direccion),0,'J');
  $y_direccion=$pdf->GetY();
  $x= 112;
  $pdf->SetX($x);
  $pdf->SetXY($x,$y_final);
  $pdf->MultiCell(80,5,iconv("UTF-8", "ISO-8859-1",'Ciudad: '.$huesped->ciudad),0,'J');

  $x= 20;
  $pdf->SetXY($x,$y_direccion);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Estado: '.$huesped->estado),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Codigo postal: '.$huesped->codigo_postal),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Telefono: '.$huesped->telefono),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Correo: '.$huesped->correo),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Contrato Socio: '.$huesped->contrato),0,0,'L');
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Cupón: '.$huesped->cupon),0,1,'L');
  
  $x= 20;
  $pdf->SetX($x);
  $y_final=$pdf->GetY();
  $pdf->MultiCell(80,5,iconv("UTF-8", "ISO-8859-1",'Preferencias del huésped: '.$huesped->preferencias),0,'J');
  $x= 112;
  $pdf->SetX($x);
  $pdf->SetXY($x,$y_final);
  $pdf->MultiCell(80,5,iconv("UTF-8", "ISO-8859-1",'Comentarios adicionales: '.$huesped->comentarios),0,'J');

  $logs->guardar_log($_GET['usuario_id'],"Reporte reservacion: ". $_GET['id']);
  //$pdf->Output("reporte_reservacion.pdf","I");
  $pdf->Output("reporte_reservacion_".$_GET['id'].".pdf","I");
  
  //$pdf->Output("../reportes/reservaciones/reporte_reservacion.pdf","F");
      //echo 'Reporte reservacion';*/
?>

