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
$fecha = date('d-m-Y');
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
        $this->SetTextColor(255, 255, 255);
        // Movernos a la derecha
        //$this->Cell(10);
        // Nombre del Hotel
        //$this->Cell(20, 9, iconv("UTF-8", "ISO-8859-1", $nombre), 0, 0, 'C');
        // Logo
        $imagenHotel = '../images/'.$conf->imagen.'';
        $this->Image( $imagenHotel , 160, 1, 27, 27);
        // Salto de línea
        $this->Ln(22);
        // Movernos a la derecha
        $this->Cell(22);
        // Título
        $this->SetFont('Arial', '', 15);
        $this->Cell(40, -11, iconv("UTF-8", "ISO-8859-1", 'CORTE/DIARIO'), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Ln(-10);
        $this->Cell(110);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 22, iconv("UTF-8", "ISO-8859-1", 'Fecha Inicio: ' .date('d-m-Y')), 0, 0, 'C');
        $this->Cell(60, 22, iconv("UTF-8", "ISO-8859-1", 'Fecha Fin: ' . date('d-m-Y')), 0, 0, 'C');
        $this->Ln(5);
        $this->SetX(160);
        // Salto de línea
        $this->Ln(15);
    }
    // Pie de página
    public function Footer()
    {
        $texto = "Corte realizado el: ";
        $fecha = date("d-m-Y");
        $textoCompleto = $texto . $fecha;
        $conf = new Configuracion(0);
        // Posición: a 1,5 cm del final
        $this->SetY(-20);
        // Arial italic 8
        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(45, 63, 83);
        $this->Cell(0, 10, iconv("UTF-8", "ISO-8859-1", $textoCompleto), 0, 1, 'C');
        $this->MultiCell(0, 2, iconv("UTF-8", "ISO-8859-1", 'Le invitamos a visitar nuestra página web: '.$conf->credencial_auto.' donde encontrará mayor información acerca de nuestras instalaciones y servicios.'), 0, 'C');
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
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$total_abonos=0;
$total_cargos=0;
$total_general_cargos=0;
$total_general=0;
$id_usuario=$_GET['id_usuario'];
$pdf->SetFont('Arial', '', 13);
$pdf->Cell(140);
// Título
$pdf->Ln();
$pdf->SetFont('Arial', '', 9);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetFillColor(45, 63, 83);
$pdf->SetLineWidth(0.1);
$pdf->Cell(-9);
$pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", 'Fecha'), 0, 0, 'C',1);
$pdf->Cell(15, 5, iconv("UTF-8", "ISO-8859-1", 'FCasa'), 0, 0, 'C',1);
$pdf->Cell(15, 5, iconv("UTF-8", "ISO-8859-1", 'Hab.'), 0, 0, 'C',1);
$pdf->Cell(38, 5, iconv("UTF-8", "ISO-8859-1", 'Descripción'), 0, 0, 'C',1);
$pdf->Cell(45, 5, iconv("UTF-8", "ISO-8859-1", 'Observación'), 0, 0, 'C',1);
$pdf->Cell(20, 5, iconv("UTF-8", "ISO-8859-1", 'Cargos'), 0, 0, 'C',1);
$pdf->Cell(20, 5, iconv("UTF-8", "ISO-8859-1", 'Abonos'), 0, 0, 'C',1);
$pdf->Cell(20, 5, iconv("UTF-8", "ISO-8859-1", 'Usuario'), 0, 0, 'C',1);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);
$c=0;

foreach ($forma_pago->formas_pagos() as $key => $pago) {
    $consulta= $cuenta->mostrarCuentaUsuario($id_usuario,$pago['id']);
    $contador_row = mysqli_num_rows($consulta);
    if($contador_row!=0) {
    $pdf->SetFont('Arial', '', 11);
    $pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", $pago['descripcion']), 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('Arial', '', 10);
    while ($fila = mysqli_fetch_array($consulta)) {
        $border_text="1";
        $hab_nombre = $fila['hab_nombre'];
        if($hab_nombre == null && $fila['fcasa'] == null){
            $hab_nombre="CM: ". $fila['cm_nombre'];
        }
        $pdf->Cell(-9);
        $pdf->Cell(35, 6, iconv("UTF-8", "ISO-8859-1", date('d-m-Y H:m:s', $fila['fecha'])), $border_text, 0, 'C');
        $pdf->Cell(15, 6, iconv("UTF-8", "ISO-8859-1", $fila['fcasa']), $border_text, 0, 'C');
        $pdf->Cell(15, 6, iconv("UTF-8", "ISO-8859-1", $hab_nombre), $border_text, 0, 'C');
        $pdf->Cell(38, 6, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), $border_text, 0, 'C');
        $pdf->Cell(45, 6, iconv("UTF-8", "ISO-8859-1", $fila['observacion']), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1", '$'.number_format($fila['cargo'],2)), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1", '$'.number_format($fila['abono'],2)), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1", $fila['usuario']), $border_text, 1, 'C');
        $total_cargos+=$fila['cargo'];
        $total_abonos+=$fila['abono'];
        $c++;
    }
        $pdf->Cell(-9);
        $border_text="";
        $pdf->Cell(35, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(15, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 0, 'C');
        $pdf->Cell(15, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(38, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(45, 6, iconv("UTF-8", "ISO-8859-1", 'Total Posteo:'), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1", '$'.number_format($total_cargos,2)), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_abonos,2)), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 1, 'C');
        $pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
        $pdf->Ln(5);
        $total_general_cargos+=$total_cargos;
        $total_general+=$total_abonos;
}
    }
        $noY = $pdf->GetY();
        $pdf->Cell(-9);
        $pdf->SetY($noY-3);
        $border_text="";
        $pdf->Cell(34, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(15, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 0, 'C');
        $pdf->Cell(15, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(30, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(45, 6, iconv("UTF-8", "ISO-8859-1", 'Total:'), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1", '$'.number_format($total_general_cargos,2)), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_general,2)), $border_text, 0, 'C');
        $pdf->Cell(20, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 1, 'C');
$pdf->Output("reporte_estado_cuenta_.pdf", "I");
$logs->guardar_log($_GET['id_usuario'], "Reporte reservacion diario: ");
?>

