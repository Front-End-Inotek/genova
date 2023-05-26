<?php
require('fpdf/fpdf.php');

// Crear una clase extendida de FPDF para personalizar el PDF
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        // Logo
        $this->Image('logo.png', 10, 10, 30);
        
        // Título
        $this->SetFont('Arial', 'B', 15);
        $this->Cell(0, 15, 'Confirmación de Reservación de Hotel', 0, 1, 'C');
        
        // Salto de línea
        $this->Ln(10);
    }
    
   
    function Footer()
    {
        // Número de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}


$pdf = new PDF();
$pdf->AliasNbPages(); //numeración de páginas


$pdf->AddPage();

//PDF
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Estimado/a [Nombre del Cliente],', 0, 1);
$pdf->Ln(5);
$pdf->MultiCell(0, 10, 'Nos complace confirmar su reservación en nuestro hotel. A continuación, encontrará los detalles de su reserva:', 0, 1);
$pdf->Ln(5);
$pdf->Cell(0, 10, 'Fecha de entrada: [Fecha de entrada]', 0, 1);
$pdf->Cell(0, 10, 'Fecha de salida: [Fecha de salida]', 0, 1);
$pdf->Cell(0, 10, 'Número de habitaciones: [Número de habitaciones]', 0, 1);
$pdf->Cell(0, 10, 'Tipo de habitación: [Tipo de habitación]', 0, 1);
$pdf->Ln(10);
$pdf->Cell(0, 10, 'Si tiene alguna pregunta o necesita realizar cambios en su reserva, no dude en ponerse en contacto con nosotros.', 0, 1);
$pdf->Ln(5);
$pdf->Cell(0, 10, '¡Esperamos darle la bienvenida a nuestro hotel!', 0, 1);


// Salida del PDF
$pdf->Output();
?>