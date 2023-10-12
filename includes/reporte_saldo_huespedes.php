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
        //$this->Image("../images/hoja_margen.png", 1.5, -2, 211, 295);
        // Arial bold 15
        $this->Image("../images/encabezado_pdf.jpg", 0, 0, 211);
        $this->Image("../images/rectangulo_pdf.png", 160, 1, 27, 27);
        $this->Image("../images/rectangulo_pdf_2.png", 10, 20, 85, 12);
        $this->SetFont('Arial', '', 8);
        // Color de letra
        $this->SetTextColor(0, 0, 0);
        // Movernos a la derecha
        $this->Cell(2);
        // Nombre del Hotel
        //$this->Cell(20, 9, iconv("UTF-8", "ISO-8859-1", $nombre), 0, 0, 'C');
        // Logo
        $this->Image("../images/hotelexpoabastos.png", 160, 1, 27, 27);
        // Salto de línea
        $this->Ln(22);
        // Movernos a la derecha
        $this->Cell(30);
        // Título
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial', '', 13);
        $this->Cell(25, -11, iconv("UTF-8", "ISO-8859-1", 'SALDO DE HÚESPEDES - EN CASA'), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0 , 0);
        $this->Ln(-10);
        $this->SetX(160);
        // Salto de línea
        $this->Ln(15);
    }

    // Pie de página
    public function Footer()
    {
        $conf = new Configuracion(0);
        // Posición: a 1,5 cm del final
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(45, 63, 83);
        $this->MultiCell(0, 5, iconv("UTF-8", "ISO-8859-1", 'Le invitamos a visitar nuestra página web: '.$conf->credencial_auto.' donde encontrará mayor información acerca de nuestras instalaciones y servicios.'), 0, 'C');
        $this->Cell(0, 5, iconv("UTF-8", "ISO-8859-1", $conf->domicilio), 0, 0, 'C');
        // Número de página
        $this->SetFont('Arial', '', 8);
        $this->Cell(0, 4, iconv("UTF-8", "ISO-8859-1", 'Página '.$this->PageNo().'/{nb}'), 0, 0, 'R');
    }
}
//Formato de hoja (Orientacion, tamaño , tipo)
$pdf = new FPDF('P', 'mm', 'Letter');

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
// $id_usuario=$_GET['id_usuario'];

$tarifa= new Tarifa(0);


$consulta= $cuenta->hab_ocupadas();

$pdf->SetFont('Arial', '', 15);

// Titulos tabla cargos
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(-9);
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1", 'Número de hab.'), 0, 0, 'C');
$pdf->Cell(43, 4, iconv("UTF-8", "ISO-8859-1", 'Nombre del húesped'), 0, 0, 'C');
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Abonos'), 0, 0, 'C');
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Cargos'), 0, 0, 'C');
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Saldo'), 0, 0, 'C');
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Tarifa xnx'), 0, 0, 'C');
$pdf->Ln();
$pdf->Cell(-9);
$pdf->Line($pdf->GetX(), $pdf->GetY(), 209,$pdf->GetY());
$pdf->Ln(2);
$fila_atras="";
$total_cargos =0;
$total_maestra=0;
$total_=0;
$c=0;
while($fila=mysqli_fetch_array($consulta)) {
    $abonos = $cuenta->obtner_abonos($fila['mov']);
    $cargos = $cuenta->mostrar_total_cargos($fila['mov']);
    $saldo = $cuenta->mostrar_faltante($fila['mov']);
    //$nombre_huesped = $fila['nombre'] . ' ' . $fila['apellido'];
    $estado_credito = $fila['estado_credito'];
    $limite_credito = $fila['limite_credito'];

    $nombre_huesped = $fila['nombre'];
    $apellido_huesped = $fila['apellido'];

    if ( strlen($nombre_huesped) > 9 ){
        $nombre_huesped = substr($nombre_huesped, 0 , 9 ) . '...';
    }
    if ( strlen($apellido_huesped) > 9 ){
        $apellido_huesped = substr($apellido_huesped, 0 , 9 ) . '...';
    }
    $nombre_completo = $nombre_huesped . " " . $apellido_huesped;

    if($fila_atras!= $fila['hab_nombre']){
        $pdf->Cell(-9);
        $pdf->Cell(25, 5, iconv("UTF-8", "ISO-8859-1","Hab. ".  $fila['hab_nombre']), 0, 0, 'C');
        $pdf->Cell(43, 5, iconv("UTF-8", "ISO-8859-1", $nombre_completo), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", $abonos), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1",$cargos), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1",$saldo), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1",number_format($fila['tarifa'],2)), 0, 0, 'C');
    }else{
        $pdf->Cell(-9);
        $pdf->Cell(25, 5, '', 0, 0, 'C');
        $pdf->Cell(43, 5, iconv("UTF-8", "ISO-8859-1", $nombre_completo), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1",$abonos), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1",$cargos), 0, 0, 'C');
        $pdf->Cell(35, 5, '', 0, 0, 'C');
        $pdf->Cell(35, 5,'', 0, 0, 'C');
    }
    $pdf->Ln(5);
    $pdf->Cell(25, 5, '', 0, 0, 'C');
    $pdf->Cell(20, 5, '', 0, 0, 'C');
    $pdf->Cell(20, 5, '', 0, 0, 'C');
    $pdf->Cell(20, 5, '', 0, 0, 'C');
    $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1","Estado credito: ".  $estado_credito), 0, 0, 'C');
    $pdf->Cell(50, 5, iconv("UTF-8", "ISO-8859-1","Limite de credito: ".number_format($limite_credito,2)), 0, 0, 'C');
    $pdf->Ln(5);
    $pdf->Cell(-9);
    $pdf->Line($pdf->GetX(), $pdf->GetY(), 209,$pdf->GetY());
    $fila_atras = $fila['hab_nombre'];
    $c++;
    $pdf->Ln(5);
}


$pdf->Output("reporte_estado_cuenta_.pdf", "I");
//$logs->guardar_log($_GET['usuario_id'], "Reporte reservacion: ". $_GET['id']);

?>

