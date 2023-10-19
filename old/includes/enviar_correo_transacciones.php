<?php
date_default_timezone_set('America/Mexico_City');
include_once("clase_configuracion.php");
include_once("clase_huesped.php");
include_once("clase_reservacion.php");
include_once('clase_log.php');
include_once("clase_hab.php");
include_once("clase_cuenta.php");

$logs = new Log(0);

// $hab= new Hab($_GET['id']);

// if($hab->estado == 0) {
//     die();
// }
require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    public function Header()
    {
        $cuenta= new Cuenta(0);
        $conf = new Configuracion(0);
        $nombre = $conf->nombre;


        // Marco primera pagina
        $this->Image("../images/hoja_margen.png", 1.5, -2, 211, 295);
        // Arial bold 15
        $this->SetFont('Arial', 'B', 10);
        // Color de letra
        $this->SetTextColor(0, 102, 205);
        // Movernos a la derecha
        $this->Cell(2);
        // Nombre del Hotel
        $this->Cell(20, 9, iconv("UTF-8", "ISO-8859-1", $nombre), 0, 0, 'C');
        // Logo
        $this->Image("../images/hotelexpoabastos.png", 10, 18, 25, 25);
        // Salto de línea
        $this->Ln(24);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->SetFont('Arial', '', 16);
        $this->Cell(30, 10, iconv("UTF-8", "ISO-8859-1", 'RESUMEN TRANSACCIONES'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(8);
        $this->SetX(160);
        // Salto de línea
        $this->Ln(18);
    }

    // Pie de página
    public function Footer()
    {
        $conf = new Configuracion(0);
        // Posición: a 1,5 cm del final
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial', '', 7);

        $this->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", 'Le invitamos a visitar nuestra página web: '.$conf->credencial_auto.' donde encontrará mayor información acerca de nuestras instalaciones y servicios.'), 0, 'C');


        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", $conf->domicilio), 0, 0, 'C');

        // Número de página
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, iconv("UTF-8", "ISO-8859-1", 'Página '.$this->PageNo().'/{nb}'), 0, 0, 'R');
    }
}

// Datos dentro de la reservacion
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

date_default_timezone_set('America/Mexico_City');
include_once("clase_cuenta.php");
include_once("clase_tarifa.php");
include_once("clase_movimiento.php");
$cuenta= new Cuenta(0);
$id_usuario=$_GET['id_usuario'];

$tarifa= new Tarifa(0);


$consulta_cargos = $cuenta->mostrarCargos($id_usuario);
$consulta_abonos = $cuenta->mostrarAbonos($id_usuario);

$pdf->SetFont('Arial', '', 15);






// Titulos tabla cargos
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Habitación/Folio Maestra'), 0, 0, 'C');
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Descripcion'), 0, 0, 'C');
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Fecha'), 0, 0, 'C');
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Cargo'), 0, 0, 'C');
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Abono'), 0, 0, 'C');
$pdf->Ln();

$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Ln(10);
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", '>> Cargos'), 0, 1, 'L');
$pdf->Ln();
$fila_atras="";
$total_cargos =0;
$total_maestra=0;
$total_=0;
$c=0;

while($fila=mysqli_fetch_array($consulta_cargos)) {
   
    if($fila_atras!= $fila['hab_nombre']){
        if($c!=0){
          $pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
          $pdf->Cell(40, 5,'',0, 0, 'C');
          $pdf->Cell(40, 5,'');
          $pdf->Cell(35, 5, '', 0, 0, 'C');
          $pdf->Cell(40, 5,'Total:', 0, 0, 'C');
          $pdf->Cell(40, 5, number_format($total_cargos, 2), 0, 1, 'C');
          $total_cargos=0;
        }
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1","Habitación ".  $fila['hab_nombre']), 0, 0, 'C');
    $pdf->Cell(40, 5,'');
    $pdf->Cell(35, 5, '', 0, 0, 'C');
    $pdf->Cell(40, 5,'', 0, 0, 'C');
    $pdf->Cell(40, 5, '', 0, 1, 'C');
    }
    $pdf->Cell(40, 5,'');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['descripcion']), 0, 0, 'C');
    $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['cargo']), 0, 0, 'C');
    $pdf->Cell(40, 5, '0', 0, 1, 'C');
    
    $fila_atras=$fila['hab_nombre'];
    $total_cargos+=$fila['cargo'];
    $total_+=$fila['cargo'];
    $c++;
}
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());


//cargos cuentas maestras.
$consulta= $cuenta->mostrarCargosMaestra($id_usuario);
while($fila=mysqli_fetch_array($consulta)) {
   
    if($fila_atras!= $fila['maestra_id']){
        if($c!=0){
         
          $pdf->Cell(40, 5,'',0, 0, 'C');
          $pdf->Cell(40, 5,'');
          $pdf->Cell(35, 5, '', 0, 0, 'C');
          $pdf->Cell(40, 5,'Total:', 0, 0, 'C');
          $pdf->Cell(40, 5, number_format($total_cargos, 2), 0, 1, 'C');
          $total_cargos=0;
        }
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1","Cuenta maestra: ".  $fila['maestra_nombre']), 0, 0, 'C');
    $pdf->Cell(40, 5,'');
    $pdf->Cell(35, 5, '', 0, 0, 'C');
    $pdf->Cell(40, 5,'', 0, 0, 'C');
    $pdf->Cell(40, 5, '', 0, 1, 'C');
    }
    $pdf->Cell(40, 5,'');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['descripcion']), 0, 0, 'C');
    $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['cargo']), 0, 0, 'C');
    $pdf->Cell(40, 5, '0', 0, 1, 'C');
    
    $fila_atras=$fila['maestra_id'];
    $total_cargos+=$fila['cargo'];
    $total_maestra+=$fila['cargo'];
    $c++;
}
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Cell(40, 5,'',0, 0, 'C');
$pdf->Cell(40, 5,'');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'Total:', 0, 0, 'C');
$pdf->Cell(40, 5, number_format($total_cargos, 2), 0, 1, 'C');
$total_cargos=0;


$pdf->Ln();
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$total_cargo_general = $total_+ $total_maestra;
$pdf->Ln();
$pdf->Cell(40, 5, 'Total Cargos:', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($total_cargo_general, 2)), 0, 1, 'C');


//Abonos
$pdf->Ln(10);
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", '>> Abonos'), 0, 1, 'L');
$pdf->Ln();
$fila_atras="";
$total_abonos =0;
$total_maestra=0;
$total_=0;
$c=0;

while($fila=mysqli_fetch_array($consulta_abonos)) {
   
    if($fila_atras!= $fila['hab_nombre']){
        if($c!=0){
          $pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
          $pdf->Cell(40, 5,'',0, 0, 'C');
          $pdf->Cell(40, 5,'');
          $pdf->Cell(35, 5, '', 0, 0, 'C');
          $pdf->Cell(40, 5,'Total:', 0, 0, 'C');
          $pdf->Cell(40, 5, number_format($total_abonos, 2), 0, 1, 'C');
          $total_abonos=0;
        }
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1","Habitación ".  $fila['hab_nombre']), 0, 0, 'C');
    $pdf->Cell(40, 5,'');
    $pdf->Cell(35, 5, '', 0, 0, 'C');
    $pdf->Cell(40, 5,'', 0, 0, 'C');
    $pdf->Cell(40, 5, '', 0, 1, 'C');
    }
    $pdf->Cell(40, 5,'');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['descripcion']), 0, 0, 'C');
    $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');

    $pdf->Cell(40, 5, '0', 0, 0, 'C');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['abono']), 0, 1, 'C');
    
    $fila_atras=$fila['hab_nombre'];
    $total_abonos+=$fila['abono'];
    $total_+=$fila['abono'];
    $c++;
}
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());


//cargos cuentas maestras.
$consulta= $cuenta->mostrarAbonosMaestra($id_usuario);
while($fila=mysqli_fetch_array($consulta)) {
   
    if($fila_atras!= $fila['maestra_id']){
        if($c!=0){
         
          $pdf->Cell(40, 5,'',0, 0, 'C');
          $pdf->Cell(40, 5,'');
          $pdf->Cell(35, 5, '', 0, 0, 'C');
          $pdf->Cell(40, 5,'Total:', 0, 0, 'C');
          $pdf->Cell(40, 5, number_format($total_abonos, 2), 0, 1, 'C');
          $total_abonos=0;
        }
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1","Cuenta maestra: ".  $fila['maestra_nombre']), 0, 0, 'C');
    $pdf->Cell(40, 5,'');
    $pdf->Cell(35, 5, '', 0, 0, 'C');
    $pdf->Cell(40, 5,'', 0, 0, 'C');
    $pdf->Cell(40, 5, '', 0, 1, 'C');
    }
    $pdf->Cell(40, 5,'');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['descripcion']), 0, 0, 'C');
    $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
    $pdf->Cell(40, 5, '0', 0, 0, 'C');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$fila['abono']), 0, 1, 'C');
    $fila_atras=$fila['maestra_id'];
    $total_abonos+=$fila['abono'];
    $total_maestra+=$fila['abono'];
    $c++;
}
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Cell(40, 5,'',0, 0, 'C');
$pdf->Cell(40, 5,'');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'Total:', 0, 0, 'C');
$pdf->Cell(40, 5, number_format($total_abonos, 2), 0, 1, 'C');
$total_abonos=0;


$pdf->Ln();
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$total_abono_general = $total_+ $total_maestra;
$pdf->Ln();
$pdf->Cell(40, 5, 'Total Abonos:', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($total_abono_general, 2)), 0, 1, 'C');




$file = $pdf->Output("reporte_estado_cuenta_.pdf", "S");


require_once('../PHPMailer/class.phpmailer.php');

$mail = new PHPMailer(true);
$mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP
try {
    //Server settings
    //$mail->SMTPDebug = 2;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'orware.factura@gmail.com';                   //SMTP username
    $mail->Password   = 'wmtitpzizsqnnwcr';                               //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit TLS encryption
    $mail->Port       = 465;

    $mail->setFrom('orware.factura@gmail.com', utf8_decode('Carlos Garcia'));
    $mail->addAddress('gderiangarcia@gmail.com', utf8_decode('Carlos Garcia'));  


    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->addStringAttachment($file, 'reporte_transacciones.pdf');

    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = utf8_decode('Resumen de transacciones');

    $mail->msgHTML('Se adjunta archivo con las transacciones realizadas en Visit');


    $mail->send();
    $pdf->Output("reporte_transacciones.pdf", "I");

} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


//$logs->guardar_log($_GET['usuario_id'], "Reporte reservacion: ". $_GET['id']);

?>

