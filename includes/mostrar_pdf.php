<?php
require('../fpdf/fpdf.php');
include("clase_factura.php");

include 'datos_servidor.php'; //conexion con la base de datos

$fact = NEW factura ();
$resultado2=$fact->folio();
$row2=mysqli_fetch_array($resultado2);

$folio = $row2[0];

$xml = simplexml_load_file('../facturas/'.$folio.'_cfdi_factura.xml');
$ns = $xml->getNamespaces(true);
$xml->registerXPathNamespace('cfdi', $ns['cfdi']);
$xml->registerXPathNamespace('t', $ns['tfd']);


class PDF extends FPDF
{
// Cabecera de página
function Header()
{
      include 'datos_servidor.php'; //conexion con la base de datos

      $fact = NEW factura ();
      $resultado2=$fact->folio();
      $row2=mysqli_fetch_array($resultado2);

      $folio = $row2[0];

      $xml = simplexml_load_file('../facturas/'.$folio.'_cfdi_factura.xml');
      $ns = $xml->getNamespaces(true);
      $xml->registerXPathNamespace('cfdi', $ns['cfdi']);
      $xml->registerXPathNamespace('t', $ns['tfd']);
    // Arial bold 15
      $this->SetFont('Arial','B',10);
    // Título
    foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
      $this->setDrawColor(176,173,172);
      $this->Cell(130,30,'','R');
      
      $this->setX(60);
      foreach ($xml->xpath('//cfdi:Emisor') as $Emisor){
/*DATOS DE LA HOJA*/  $this->Cell(60,5, utf8_decode($Emisor['Nombre']),0,0,'L',0);
      }
      $this->SetFont('Arial','B',10);
      $this->Cell(80,5, utf8_decode('FACTURA CFDI - VERSIÓN ').$cfdiComprobante['Version'],0,1,'R',0);
      $this->Ln(1);

      $this->setX(60);
      foreach ($xml->xpath('//cfdi:Emisor') as $Emisor){
      $this->Cell(60,5, utf8_decode($Emisor['Rfc']),0,0,'L',0);
      }

      $this->Ln(1);
      $this->SetFont('Arial','',8);
      $this->Cell(190,5, utf8_decode('Folio:'),0,1,'R',0);

      $this->setX(60);
      foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
      $this->SetFont('Arial','B',10);
      $this->Cell(60,5, 'C.P. '.$cfdiComprobante['LugarExpedicion'],0,0,'L',0);
      }

      $this->SetFont('Arial','B',10);
      $this->Cell(80,4, $cfdiComprobante['Folio'],0,1,'R',0);
      $this->Ln(1);

      $this->SetFont('Arial','',8);
      $this->Cell(190,5, utf8_decode('No. Certificado:'),0,1,'R',0);

      $this->SetFont('Arial','B',10);
      $this->Cell(190,4, $cfdiComprobante['NoCertificado'],0,1,'R',0);
      $this->Ln(1);

      
      $this->SetFont('Arial','',8);
      $this->Cell(190,5, utf8_decode('Fecha Certificación:'),0,1,'R',0);

      $this->SetFont('Arial','B',10);
      $this->Cell(190,4, $cfdiComprobante['Fecha'],0,1,'R',0);
      
      $this->setDrawColor(176,173,172);
      $this->Cell(190,3,'','B');
          // Salto de línea
      $this->Ln(3);
      }
   $this->Image('../images/hotelexpoabastos.png',10,1,40);
}

// Pie de página
function Footer()
{
      include 'datos_servidor.php'; //conexion con la base de datos

      $fact = NEW factura ();
      $resultado2=$fact->folio();
      $row2=mysqli_fetch_array($resultado2);

      $folio = $row2[0];
      $xml = simplexml_load_file('../facturas/'.$folio.'_cfdi_factura.xml');
      $ns = $xml->getNamespaces(true);
      $xml->registerXPathNamespace('cfdi', $ns['cfdi']);
      $xml->registerXPathNamespace('t', $ns['tfd']);
    // Posición: a 1,5 cm del final
    $this->SetY(-82);
    $this->setDrawColor(176,173,172);
    $this->Cell(190,0,'','B');
    // Arial italic 8
    $this->SetFont('Arial','B',12);
    foreach ($xml->xpath('//t:TimbreFiscalDigital') as $tfd) {
      $this->setX(70);
      $this->Cell(50,8, utf8_decode('Sello Digital del CFDI'),0,1,'L',0);
      $this->SetFont('Arial','',6);
      $this->setX(70);
      $this->multicell(130,3, $tfd['SelloCFD'],0,'J',0);

      $this->setX(70);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,8, utf8_decode('Fecha Timbrado'),0,1,'L',0);
      $this->SetFont('Arial','',8);
      $this->Cell(89,5, $tfd['FechaTimbrado'],0,1,'R',0);

      $this->setX(70);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,8, utf8_decode('UUID'),0,1,'L',0);
      $this->SetFont('Arial','',8);
      $this->Cell(116,5, $tfd['UUID'],0,1,'R',0);

      $this->setX(70);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,8, utf8_decode('No. Certificado Sat'),0,1,'L',0);
      $this->SetFont('Arial','',8);
      $this->Cell(93,5, $tfd['NoCertificadoSAT'],0,1,'R',0);

      $this->setX(70);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,5, utf8_decode('Sello SAT'),0,1,'L',0);
      $this->SetFont('Arial','',6);
      $this->setX(70);
      $this->multicell(130,3, $tfd['SelloSAT'],0,'J',0);

      $this->setDrawColor(176,173,172);
      $this->Cell(190,0,'','B');
      $this->setX(100);
      $this->SetFont('Arial','B',10);
      $this->Cell(50,5, utf8_decode('Powered By inotek.mx'),0,1,'L',0);
      
      $this->Image('../facturas/'.$folio.'_cfdi_factura.png',5,223,60);
}
}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true, 70);
$pdf->SetFont('Arial','',10);


//EMPIEZO A LEER LA INFORMACION DEL CFDI E IMPRIMIRLA
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){

      $pdf->Cell(100,10, 'Expedido en: '.$cfdiComprobante['LugarExpedicion'],0,1,'R',0);
      $pdf->setDrawColor(176,173,172);
      $pdf->Cell(190,0,'','B');
      $pdf->Ln(3);

      $pdf->setX(10);
/*DATOS DE LA HOJA*/  $pdf->Cell(30,5, utf8_decode('Método de Pago: '),0,0,'L',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(60,5, $cfdiComprobante['MetodoPago'],0,0,'L',0);
      $pdf->SetFont('Arial','',10);
/*DATOS DE LA HOJA*/  $pdf->Cell(80,5, utf8_decode('Tipo de comprobante: '),0,0,'R',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(10,5, $cfdiComprobante['TipoDeComprobante'],0,1,'L',0);

      $pdf->setX(10);
      $pdf->SetFont('Arial','',10);
/*DATOS DE LA HOJA*/  $pdf->Cell(30,5, utf8_decode('Forma de Pago: '),0,0,'L',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(60,5, $cfdiComprobante['FormaPago'],0,0,'L',0);
      $pdf->SetFont('Arial','',10);
/*DATOS DE LA HOJA*/  $pdf->Cell(80,5, utf8_decode('Moneda : '),0,0,'R',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(90,5, $cfdiComprobante['Moneda'],0,1,'L',0);

      $pdf->setX(10);
      $pdf->SetFont('Arial','',10);
/*DATOS DE LA HOJA*/  $pdf->Cell(170,5, utf8_decode('Tipo de cambio: '),0,0,'R',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(90,5, $cfdiComprobante['TipoCambio'],0,1,'L',0);

      $pdf->Ln(3);
      $pdf->setDrawColor(176,173,172);
      $pdf->Cell(190,0,'','B');
      $pdf->Ln(3);

}


foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor){

      $pdf->setX(30);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(20,5, utf8_decode('Nombre: '),0,0,'L',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(10,5, utf8_decode($Receptor['Nombre']) ,0,1,'L',0);
      $pdf->Ln(3);

      $pdf->setX(30);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(20,5, utf8_decode('Rfc: '),0,0,'L',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(90,5, $Receptor['Rfc'],0,1,'L',0);
      $pdf->Ln(3);

      $pdf->setX(30);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(20,5, utf8_decode('Domicilio: '),0,0,'L',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(90,5, $Receptor['DomicilioFiscalReceptor'],0,1,'L',0);
      $pdf->Ln(3);

      $pdf->setX(30);
      $pdf->SetFont('Arial','',10);
      $pdf->Cell(20,5, utf8_decode('Uso Cfdi: '),0,0,'L',0);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(90,5, $Receptor['UsoCFDI'],0,1,'L',0);
      
      $pdf->Ln(3);
      $pdf->SetFillColor(176,173,172);
      $pdf->setDrawColor(176,173,172);

}
      $pdf->Cell(20,10, utf8_decode('Clave'),1,0,'J',1);
      $pdf->Cell(20,10, utf8_decode('Cantidad'),1,0,'L',1);
      $pdf->Cell(30,10, utf8_decode('Clave unidad'),1,0,'L',1);
      $pdf->Cell(65,10, utf8_decode('Descripción'),1,0,'L',1);
      $pdf->Cell(30,10, utf8_decode('Precio unitario'),1,0,'L',1);
      $pdf->Cell(25,10, utf8_decode('Importe'),1,1,'L',1);

      foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Conceptos//cfdi:Concepto') as $Concepto){
      
      $pdf->SetFont('Arial','',9);

      $pdf->Cell(20,10, $Concepto['ClaveProdServ'],0,0,'L',0);
      $pdf->Cell(20,10, $Concepto['Cantidad'],0,0,'C',0);
      $pdf->Cell(30,10, $Concepto['ClaveUnidad'],0,0,'C',0);
      $pdf->setX(150);
      $pdf->Cell(30,10, $Concepto['ValorUnitario'],0,0,'L',0);
      $pdf->Cell(25,10, $Concepto['Importe'],0,0,'L',0);
      $pdf->setX(80);
      $pdf->multicell(65,10, $Concepto['Descripcion'],0,'J',0);

      $pdf->Ln(3);

      

}

      $pdf->Ln(4);
      foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante){
      $pdf->SetFillColor(176,173,172);
      $pdf->setDrawColor(176,173,172);
      $pdf->Cell(190,0,'','B');
      $pdf->Ln(3);

      $pdf->setX(150);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(20,5, utf8_decode('SubTotal'),1,0,'L',1);
      $pdf->SetFont('Arial','',11);
      $pdf->Cell(10,5, utf8_decode(' $ '). $cfdiComprobante['SubTotal'],0,1,'L',0);
      /*$pdf->Cell(10,5, utf8_decode(' $ '). $cfdiComprobante['SubTotal'],0,1,'L',0,);*/
      $pdf->setX(150);
      $pdf->SetFont('Arial','B',11);

      $pdf->Cell(20,5, utf8_decode('I.V.A.'),1,0,'L',1);
      $pdf->SetFont('Arial','',11);
      foreach ($xml->xpath('cfdi:Impuestos') as $Impuestos){
            $pdf->Cell(10,5,utf8_decode(' $ '). $Impuestos['TotalImpuestosTrasladados'],0,1,'L',0);
      } 
      foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Complemento//implocal:ImpuestosLocales ') as $impuestosLocales){
            $pdf->setX(150);
            $pdf->SetFont('Arial','B',11);
            $pdf->Cell(20,5, utf8_decode('I.S.H.'),1,0,'L',1);
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(10,5, utf8_decode(' $ '). $impuestosLocales['TotaldeTraslados'],0,1,'L',0);
      }

      $pdf->setX(150);
      $pdf->SetFont('Arial','B',11);
      $pdf->Cell(20,5, utf8_decode('Total'),1,0,'L',1);
      $pdf->SetFont('Arial','',11);
      $pdf->Cell(10,5, utf8_decode(' $ '). $cfdiComprobante['Total'],0,1,'L',0);
}

$pdf->Output();
$pdf->Output('F', '../facturas/'. $folio .'_Factura.pdf');
//echo 'Gpfd';
?>