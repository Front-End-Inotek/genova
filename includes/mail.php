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
        $conf = NEW Configuracion(0);
          // Posición: a 1,5 cm del final
        $this->SetY(-20);
          // Arial italic 8
        $this->SetFont('Arial','',7);

        $this->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", 'Le invitamos a visitar nuestra página web: http://www. donde encontrará mayor información acerca de nuestras instalaciones y servicios.'), 0, 'C');


        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", $conf->domicilio), 0, 0, 'C');

          // Número de página
        $this->SetFont('Arial','',8);
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
      $tarifa_noche = $fila['precio_hospedaje'];

      $habitaciones=$fila['numero_hab'];

      $tipohab=$fila['tipohab'];
      $nombre_alimentos=$fila['nombre_alimentos'];
      if($tarifa_noche>0){
        $tarifa_noche= '$'.number_format($tarifa_noche, 2);
      }
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
  $vencimiento_tarjeta = $huesped->vencimiento_mes . "/" . $huesped->vencimiento_ano;

  $x= 20;
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Confirmación de reservación'),0,0,'L');
  $pdf->SetFont('Arial','',9);
  $pdf->Ln(10);
  $pdf->Cell(35,5,iconv("UTF-8", "ISO-8859-1",'Estimado(A) Sr (Srita)'),0,0,'L');
  $pdf->SetFont('Arial','U',9);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1","             ".$nombre_huesped ."                "),0,1,'L');
  $pdf->SetFont('Arial','',9);
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Su reservación ha sido procesada con éxito el (día) de (mes) del (año), de acuerdo con los siguientes datos:'),0,0,'L');
  $pdf->Ln(10);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Nombre: '.$nombre_huesped),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Empresa/agencia: ' . $huesped->empresa),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Fecha de llegada: '.$fecha_entrada),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Fecha de salida: '.$fecha_salida),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Número de noches: ' .$noches),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Número de habitaciones: ' .$habitaciones),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Adultos: '.$extra_adulto),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Niños: '.$extra_infantil),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Tipo de habitación: '.$tipohab),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Plan de alimentos: '.$nombre_alimentos),0,0,'L');
  $pdf->Ln();
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Clave de confirmación: '),0,0,'L');
  $pdf->Ln(10);
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Tarifa por noche: ' .$tarifa_noche),0,0,'L');
  $pdf->Ln();
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Total estancia: ' .$total_estancia),0,0,'L');
  $pdf->Ln(10);
  
  $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Precio en Pesos Mexicanos por habitación, por noche 19% impuestos incluidos. Todas nuestras habitaciones son de NO FUMAR'),0,0,'L');
  //$pdf->MultiCell(80,5,iconv("UTF-8", "ISO-8859-1",'Su reservación ha sido procesada con éxito el (día) de (mes) del (año), de acuerdo con los siguientes datos:'.$huesped->comentarios),0,'J');
  $pdf->Ln(10);
  //Esto es solo si la tarjeta está garantizada.
  if($huesped->estado_tarjeta==2){
    if($huesped->voucher!=""){
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Garantía:'),0,0,'L');
      $pdf->Ln(8);
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Voucher '),0,0,'L');
      $pdf->Ln();
      $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Esta reserva está confirmada y garantizada con un voucher con el  código: '$huesped->voucher'. Dependiendo de los términos y condiciones aplicables a las tarifas de las habitaciones reservadas, el cliente acepta que el hotel cobre cualquier pago necesario bajo estos mismos términos."),0,'J');
    }else{
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Garantía:'),0,0,'L');
      $pdf->Ln(8);
      $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",$huesped->nombre_tarjeta),0,0,'L');
      $pdf->Ln();
      $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Esta reserva está confirmada y garantizada por la tarjeta con el número '$huesped->numero_tarjeta', que caduca el '$vencimiento_tarjeta'. Dependiendo de los términos y condiciones aplicables a las tarifas de las habitaciones reservadas, el cliente acepta que el hotel cobre cualquier pago necesario bajo estos mismos términos."),0,'J');
    }
   
  }
  if($huesped->tipo_tarjeta==1 || $huesped->tipo_tarjeta=="Efectivo"){
    $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",'Garantía:'),0,0,'L');
    $pdf->Ln();
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1","Esta reserva está confirmada y garantizada por un pago en efectivo. Dependiendo de los términos y condiciones aplicables a las tarifas de las habitaciones reservadas, el cliente acepta que el hotel cobre cualquier pago necesario bajo estos mismos términos."),0,'J');
  }
  $pdf->Ln(8);
  //Políticas de reservación
  require_once('clase_politicas_reservacion.php');
  $pr = new PoliticasReservacion(0);

  $consulta= $pr->datos_politicas();
  while ($politica = mysqli_fetch_array($consulta)) {
    $pdf->Cell(92,5,iconv("UTF-8", "ISO-8859-1",$politica['nombre'].":"),0,0,'L');
    $pdf->Ln(8);
    $pdf->MultiCell(0,5,iconv("UTF-8", "ISO-8859-1",$politica['descripcion']),0,'J');
    $pdf->Ln(8);
  }



 
  //$logs->guardar_log($_GET['usuario_id'],"Reporte reservacion: ". $_GET['id']);
  //$pdf->Output("reporte_reservacion.pdf","I");
  $pdf->Output("reporte_reservacion_".$_GET['id'].".pdf","I");
  
  //$pdf->Output("../reportes/reservaciones/reporte_reservacion.pdf","F");
      //echo 'Reporte reservacion';*/
?>

