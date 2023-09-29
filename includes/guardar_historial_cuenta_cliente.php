<?php
date_default_timezone_set('America/Mexico_City');
include_once("clase_configuracion.php");
include_once("clase_huesped.php");
include_once("clase_reservacion.php");
include_once('clase_log.php');
include_once("clase_hab.php");
include_once("clase_cuenta.php");
include_once("clase_forma_pago.php");


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
        //Encabezado 
        $this->Image("../images/encabezado_pdf.jpg", 0, 0, 211);
        $this->Image("../images/rectangulo_pdf.png", 160, 1, 27, 27);
        $this->Image("../images/rectangulo_pdf_2.png", 10, 20, 68, 12);

        // Arial bold 15
        $this->SetFont('Arial', '', 8);
        // Color de letra
        $this->SetTextColor(0, 0, 0);
        // Movernos a la derecha
        $this->Cell(2);
        // Nombre del Hotel
        //$this->Cell(20, 0, iconv("UTF-8", "ISO-8859-1", $nombre), 0, 0, 'C');
        // Logo
        $this->Image("../images/hotelexpoabastos.png", 160, 1, 27, 27);
        // Salto de línea
        $this->Ln(22);
        // Movernos a la derecha
        $this->Cell(21);
        // Título
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial', '', 16);
        $this->Cell(25, -11, iconv("UTF-8", "ISO-8859-1", 'HISTORIAL CUENTAS'), 0, 0, 'C');
        $this->SetTextColor(0, 0 , 0);
        $this->Ln(-6);
        $this->Cell(2);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 22, iconv("UTF-8", "ISO-8859-1", 'Fecha Inicio: ' .$_GET['inicial']), 0, 0, 'C');
        $this->Cell(60, 22, iconv("UTF-8", "ISO-8859-1", 'Fecha Fin: ' . $_GET['final']), 0, 0, 'C');
        $this->Ln(-2);
        $this->SetX(160);
        //$this->Line(10,10,200,10);
        // Salto de línea
        $this->Ln(8);
    }

    // Pie de página
    public function Footer()
    {
        $conf = new Configuracion(0);
        // Posición: a 1,5 cm del final
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial', '', 8);
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
$forma_pago= NEW Forma_pago(0);
$cuenta = new Cuenta(0);
$usuario_id=$_GET['usuario_id'];
$huesped = new Huesped($_GET['id']);
$inicial = $_GET['inicial'];
$final = $_GET['final'];
$a_buscar =$_GET['a_buscar'];
$historial = $huesped->mostrar_historial_cuenta($huesped->id,$inicial,$final,$a_buscar);
$nombre_huesped =$huesped->nombre . " ". $huesped->apellido;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$total_abonos=0;
$total_general=0;
$pdf->SetFont('Arial', '', 13);
$pdf->Cell(140);
// Título
$pdf->Cell(30, 10, iconv("UTF-8", "ISO-8859-1","". $nombre_huesped.""), 0, 1, 'C');

if(!empty($nombre_huesped)){
    $pdf->Ln(1);
}

$pdf->Cell(-9);
$pdf->SetFont('Arial', '', 8);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(45, 63, 83);
$pdf->SetLineWidth(0.1);
$pdf->SetDrawColor(45, 63 , 83);
$pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", 'Fecha'), 1, 0, 'C',1);
$pdf->Cell(30, 5, iconv("UTF-8", "ISO-8859-1", 'Tipo hab.'), 1, 0, 'C',1);
$pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", 'Cargo'), 1, 0, 'C',1);
$pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", 'Abono'), 1, 0, 'C',1);
$pdf->Cell(20, 5, iconv("UTF-8", "ISO-8859-1", 'Estado'), 1, 0, 'C',1);
$pdf->Cell(95, 5, iconv("UTF-8", "ISO-8859-1", 'Descripción'), 1, 0, 'C',1);
$pdf->Ln();
$pdf->SetTextColor(0, 0, 0);
$c=0;
while ($fila = mysqli_fetch_array($historial)) {
    $estado = $fila['estado_cuenta']== 1 ? "Activo" : "Cerrado";
    $pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", date('Y-m-d',$fila['fecha'])), 1, 0, 'C');
    $pdf->Cell(30, 5, iconv("UTF-8", "ISO-8859-1",$fila['hab_nombre']), 1, 0, 'C');
    $pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", number_format($fila['cargo'],2)), 1, 0, 'C');
    $pdf->Cell(21, 5, iconv("UTF-8", "ISO-8859-1", number_format($fila['abono'],2)), 1, 0, 'C');
    $pdf->Cell(20, 5, iconv("UTF-8", "ISO-8859-1",$estado), 1, 0, 'C');
    $pdf->Cell(86, 5, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), 1, 1, 'C');
}
$pdf->Output("reporte_historial_cuentas_.pdf", "I");
$logs->guardar_log($_GET['usuario_id'], "Reporte Historial Cuentas: ");

?>

