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
        $this->Image("../images/simbolo.png", 10, 18, 25, 25);
        // Salto de línea
        $this->Ln(24);
        // Movernos a la derecha
        $this->Cell(80);
        // Título
        $this->SetFont('Arial', '', 16);
        $this->Cell(30, 10, iconv("UTF-8", "ISO-8859-1", 'DIARIO/CORTE'), 0, 0, 'C');
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 22, iconv("UTF-8", "ISO-8859-1", 'Fecha Inicio: ' .date('d-m-Y')), 0, 0, 'C');
        $this->Cell(60, 22, iconv("UTF-8", "ISO-8859-1", 'Fecha Fin: ' . date('d-m-Y')), 0, 0, 'C');
        $this->Ln(8);
        $this->SetX(160);
        // Salto de línea
        $this->Ln(10);
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

$forma_pago= NEW Forma_pago(0);
$cuenta = new Cuenta(0);

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);

$total_abonos=0;
$total_general=0;

$id_usuario=$_GET['id_usuario'];

$pdf->SetFont('Arial', '', 15);
$pdf->Cell(80);
// Título
$pdf->Cell(30, 10, iconv("UTF-8", "ISO-8859-1", date('d-m-Y')), 0, 1, 'C');
$pdf->Ln();         

$pdf->SetFont('Arial', 'B', 10);
$pdf->SetTextColor(255, 255, 255);
$pdf->Cell(38, 4, iconv("UTF-8", "ISO-8859-1", 'Fecha'), 1, 0, 'C',1);
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1", 'FCasa'), 1, 0, 'C',1);
$pdf->Cell(25, 4, iconv("UTF-8", "ISO-8859-1", 'Hab.'), 1, 0, 'C',1);
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Descripción'), 1, 0, 'C',1);
$pdf->Cell(22, 4, iconv("UTF-8", "ISO-8859-1", 'Cargos'), 1, 0, 'C',1);
$pdf->Cell(22, 4, iconv("UTF-8", "ISO-8859-1", 'Abonos'), 1, 0, 'C',1);
$pdf->Cell(28, 4, iconv("UTF-8", "ISO-8859-1", 'Usuario'), 1, 0, 'C',1);
$pdf->Ln(10);
$pdf->SetTextColor(0, 0, 0);

$c=0;


foreach ($forma_pago->formas_pagos() as $key => $pago) {
    $consulta= $cuenta->mostrarCuentaUsuario($id_usuario,$pago['id']);

    $contador_row = mysqli_num_rows($consulta);

if($contador_row!=0) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", $pago['descripcion']), 0, 1);
    $pdf->Ln(2);

    $pdf->SetFont('Arial', '', 10);
    while ($fila = mysqli_fetch_array($consulta)) {
        $border_text="1";
        $hab_nombre = $fila['hab_nombre'];
        if($hab_nombre == null && $fila['fcasa'] == null){
          $hab_nombre="CM: ". $fila['cm_nombre'];
        }

        $pdf->Cell(38, 6, iconv("UTF-8", "ISO-8859-1", date('d-m-Y H:m:s', $fila['fecha'])), $border_text, 0, 'C');
        $pdf->Cell(25, 6, iconv("UTF-8", "ISO-8859-1", $fila['fcasa']), $border_text, 0, 'C');
        $pdf->Cell(25, 6, iconv("UTF-8", "ISO-8859-1", $hab_nombre), $border_text, 0, 'C');
        $pdf->Cell(35, 6, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), $border_text, 0, 'C');
        $pdf->Cell(22, 6, iconv("UTF-8", "ISO-8859-1", $fila['cargo']), $border_text, 0, 'C');
        $pdf->Cell(22, 6, iconv("UTF-8", "ISO-8859-1", $fila['abono']), $border_text, 0, 'C');
        $pdf->Cell(28, 6, iconv("UTF-8", "ISO-8859-1", $fila['usuario']), $border_text, 1, 'C');
        $total_abonos+=$fila['abono'];

        $c++;
    }
        $border_text="";
        $pdf->Cell(38, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(25, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 0, 'C');
        $pdf->Cell(25, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(35, 6, iconv("UTF-8", "ISO-8859-1", 'Total Posteo:'), $border_text, 0, 'C');
        $pdf->Cell(22, 6, iconv("UTF-8", "ISO-8859-1", '$0.00'), $border_text, 0, 'C');
        $pdf->Cell(22, 6, iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_abonos,2)), $border_text, 0, 'C');
        $pdf->Cell(28, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 1, 'C');

        $pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());

        $pdf->Ln(5);

        $total_general+=$total_abonos;
}
    }
        $noY = $pdf->GetY();

        $pdf->SetY($noY-3);
        $border_text="";    
        $pdf->Cell(38, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(25, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 0, 'C');
        $pdf->Cell(25, 6, iconv("UTF-8", "ISO-8859-1", ''), $border_text, 0, 'C');
        $pdf->Cell(35, 6, iconv("UTF-8", "ISO-8859-1", 'Total:'), $border_text, 0, 'C');
        $pdf->Cell(22, 6, iconv("UTF-8", "ISO-8859-1", '$0.00'), $border_text, 0, 'C');
        $pdf->Cell(22, 6, iconv("UTF-8", "ISO-8859-1",'$'.number_format($total_general,2)), $border_text, 0, 'C');
        $pdf->Cell(28, 6, iconv("UTF-8", "ISO-8859-1",''), $border_text, 1, 'C');

$pdf->Output("reporte_estado_cuenta_.pdf", "I");
$logs->guardar_log($_GET['id_usuario'], "Reporte reservacion diario: ");

?>

