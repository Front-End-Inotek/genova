<?php 


require('../fpdf/fpdf.php');
require_once('../fpdi2/src/autoload.php');



class PDF extends \setasign\Fpdi\Fpdi {

 // Pie de página
 function Footer()
 {
     $this->Ln(50);
     $this->SetX($this->GetPageWidth() / 4);
     $this->SetY(-15);
     // Arial italic 8
     $this->SetFont('Arial','',8);

     // Número de página
     $this->Cell(0,4,iconv("UTF-8", "ISO-8859-1",'Página '.$this->PageNo().'/{nb}'),0,0,'R');
 }
}
//Formato de hoja (Orientacion, tamaño , tipo)
$pdf = new FPDF('P', 'mm', 'Letter');

$pdf = new PDF();
$pdf->AliasNbPages();
$pageCount = $pdf->setSourceFile('Tarjeta de registro.pdf');
$pageId = $pdf->importPage(1, \setasign\Fpdi\PdfReader\PageBoundaries::MEDIA_BOX);


$pdf->addPage();
$pdf->useTemplate($pageId);
$pdf->SetFont('Arial','',8);

if(true) {
    $pdf->setXY(60, 40);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", '203'), 0, 0, 'C');

    $pdf->setXY(160, 40);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", '203'), 0, 0, 'C');

    $pdf->setXY(90, 65);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", '2023-08-09'), 0, 0, 'C');

    $pdf->setXY(160, 65);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", '2023-08-09'), 0, 0, 'C');


    $pdf->setXY(60, 80);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", 'David Vázquez'), 0, 0, 'C');


    $pdf->setXY(65, 100);
    $pdf->Cell(60, 4, iconv("UTF-8", "ISO-8859-1", 'Inoteck'), 0, 0, 'C');

    $pdf->setXY(160, 100);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", 'México'), 0, 0, 'C');


    $pdf->setXY(65, 122);
    $pdf->Cell(60, 4, iconv("UTF-8", "ISO-8859-1", 'dev@inotek.com'), 0, 0, 'C');


    $pdf->setXY(160, 122);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", '3320889960'), 0, 0, 'C');

    $pdf->setXY(100, 132);
    $pdf->MultiCell(110, 4, iconv("UTF-8", "ISO-8859-1", 'Julian Martínez, Lidia López, Omar Valenzuela, Roberto Carlos, Roberto Carlos, Roberto Carlos, Roberto Carlos, Roberto Carlos'), 0, 'C');


    $pdf->setXY(65, 144);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", 'Suite'), 0, 0, 'C');


    $pdf->setXY(100, 154);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", '10'), 0, 0, 'C');

    $pdf->setXY(170, 154);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", '10'), 0, 0, 'C');


    $pdf->setXY(65, 171);
    $pdf->MultiCell(50, 4, iconv("UTF-8", "ISO-8859-1", 'Comida y desayuno todo incluido'), 0, 'C');

    $pdf->setXY(170, 171);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", '1'), 0, 0, 'C');


    $pdf->setXY(65, 188);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", 'Tarjeta de débito'), 0, 0, 'C');

    $pdf->setXY(171, 188);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", '$850.00'), 0, 0, 'C');

    $pdf->setXY(171, 194);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", '$2500.00'), 0, 0, 'C');


    $pdf->setXY(171, 205);
    $pdf->MultiCell(35, 4, iconv("UTF-8", "ISO-8859-1", 'María Sandoval'), 0, 'C');



    $pdf->setXY(65, 226);
    $pdf->Cell(60, 4, iconv("UTF-8", "ISO-8859-1", 'Tecnologías Gumont'), 0, 0, 'C');

    $pdf->setXY(173, 226);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", 'ABCDEFGHIJKL1'), 0, 0, 'C');


    $pdf->setXY(65, 236);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", 'Cassiopea 4989 Av. de la calma'), 0, 0, 'C');


    $pdf->setXY(173, 236);
    $pdf->Cell(30, 4, iconv("UTF-8", "ISO-8859-1", '45130'), 0, 0, 'C');


    $pdf->setXY(65, 254);
    $pdf->Cell(50, 4, iconv("UTF-8", "ISO-8859-1", 'Personas físicas y morales'), 0, 0, 'C');

    $pdf->setXY(170, 254);
    $pdf->MultiCell(35, 5, iconv("UTF-8", "ISO-8859-1", 'F01- Tecnología y servicios'), 0, 'C');
}


$pdf->Output('I', 'generated.pdf');