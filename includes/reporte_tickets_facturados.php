<?php
include_once ('clase_ticket.php');
include_once ('clase_hab.php');
include_once ('clase_movimiento.php');
require('../fpdf/fpdf.php');

// variables obtenidas por GET
$opcion = $_GET["opcion"];
$inicial = $_GET["inicial"];
$final = $_GET["final"];


class PDF extends FPDF
{
    function Header()
    {
        $this->Image("../images/encabezado_pdf_2.jpg"  , 0   , -8  , 300 );
        $this->Image("../images/rectangulo_pdf.png"    , 260 , 2   , 20  , 20);
        $this->Image("../images/rectangulo_pdf_2.png"  , 10  , 10  , 85  , 12);
        $this->Image("../images/hotelexpoabastos.png"  , 260 , 1   , 20  , 20);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor( 255 , 255 , 255 );
        $this->Cell(85, 8, iconv("UTF-8", "ISO-8859-1" ,"REPORTE TICKETS"), 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 7);
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->SetFont('Arial', 'B', 7);
        $this->Ln(10);
        $this->SetTextColor(255, 255, 255);
    }

    
    function Footer()
    {
        date_default_timezone_set('America/Mexico_City');
        $fechaHoraActual = date('Y-m-d H:i:s');
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(30, 10, utf8_decode($fechaHoraActual) , 0, 0, 'C');
        $this->Cell(217, 10, utf8_decode('') , 0, 0, 'C');
        $this->Cell(30, 10, utf8_decode('Página ') . $this->PageNo(), 0, 0, 'C');
    }


    function CreateTable()
    {
        $ticket=NEW Ticket(0);
        $hab=NEW Hab(0);
        $mov= NEW Movimiento(0);
        $this->SetFillColor(64, 0, 61);
        $this->SetFont('Arial', 'B', 7);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(6, 6, '', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Inicio', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Fin', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Cuarto', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Fecha', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Factura', 1, 0, 'C', true);
        $this->Cell(80, 6, utf8_decode('Razón Social'), 1, 0, 'C', true);
        $this->Cell(20, 6, 'Importe', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Facturado', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Forma de Pago', 1, 0, 'C', true);
        $this->Cell(30, 6, 'UUID', 1, 0, 'C', true);
        $this->Ln(); // Salto de línea
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 7);

        $this->Cell(30, 6, 'NO FACTURADO', 0);
        $this->Ln();
        $inicio=1699029534;
        $fin=1699041428;
        $respuesta=$ticket->reporte_tickets_en_rango_fechas_sin_facturar($inicio,$fin);
        while ($fila = mysqli_fetch_array($respuesta)){
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', '', 7);
            $this->Cell(6, 6, utf8_decode($fila['id_ticket']), 1);
            $this->Cell(20, 6, utf8_decode(date("Y-m-d",$mov->saber_fecha_inicio($fila['mov']))), 1);
            $this->Cell(20, 6, utf8_decode(date("Y-m-d",$mov->saber_fecha_fin($fila['mov']))), 1);;
            $this->Cell(20, 6, utf8_decode($hab->mostrar_nombre_hab($fila['id_hab'])), 1);
            $this->Cell(20, 6, utf8_decode(date("Y-m-d", $fila['ticket_fecha'])), 1);
            $this->Cell(20, 6, utf8_decode(''), 1);
            $this->Cell(80, 6, utf8_decode(''), 1);
            $this->Cell(20, 6, utf8_decode('$'.number_format($fila['monto'],2)), 1);
            $this->Cell(20, 6, utf8_decode('$'.number_format(0,2)), 1);
            $this->Cell(20, 6, utf8_decode(''), 1);
            $this->Cell(30, 6, utf8_decode(''), 1);
            $this->Ln();
        }

        $this->Cell(30, 6, 'FACTURADO', 0);
        $this->Ln();
        $respuesta=$ticket->reporte_tickets_en_rango_fechas_facturado($inicio,$fin);
        while ($fila = mysqli_fetch_array($respuesta)){
            $this->SetTextColor(0, 0, 0);
            $this->SetFont('Arial', '', 7);
            $this->Cell(6, 6, utf8_decode($fila['id_ticket']), 1);
            $this->Cell(20, 6, utf8_decode(date("Y-m-d",$mov->saber_fecha_inicio($fila['mov']))), 1);
            $this->Cell(20, 6, utf8_decode(date("Y-m-d",$mov->saber_fecha_fin($fila['mov']))), 1);;
            $this->Cell(20, 6, utf8_decode($hab->mostrar_nombre_hab($fila['id_hab'])), 1);
            $this->Cell(20, 6, utf8_decode(date("Y-m-d", $fila['ticket_fecha'])), 1);
            $this->Cell(20, 6, utf8_decode($fila['folio']), 1);
            $this->Cell(80, 6, utf8_decode($fila['nombre']), 1);
            $this->Cell(20, 6, utf8_decode('$'.number_format(0,2)), 1);
            $this->Cell(20, 6, utf8_decode('$'.number_format($fila['monto'],2)), 1);
            $this->Cell(20, 6, utf8_decode(''), 1);
            $this->Cell(30, 6, utf8_decode($fila['uuid']), 1);
            $this->Ln();
        }
    }
}

// Crear instancia de PDF con orientación horizontal
$pdf = new PDF('L');
$pdf->AddPage();

// Definir una matriz de ejemplo


// Crear la tabla con la matriz
$pdf->CreateTable();

// Salida del PDF
$pdf->Output();
?>

