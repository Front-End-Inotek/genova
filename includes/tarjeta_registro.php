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

$pdf = new PDF();
$pdf->AliasNbPages();
$pageCount = $pdf->setSourceFile('Tarjeta de registro.pdf');
$pageId = $pdf->importPage(1, \setasign\Fpdi\PdfReader\PageBoundaries::MEDIA_BOX);

$pdf->addPage();
$pdf->useTemplate($pageId);
$pdf->SetFont('Arial','',8);
$pdf->Output('I', 'generated.pdf');