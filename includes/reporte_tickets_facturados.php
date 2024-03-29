<?php
date_default_timezone_set('America/Mexico_City');
include_once ('clase_ticket.php');
include_once ('clase_hab.php');
include_once ('clase_movimiento.php');
include_once ('clase_factura.php');
require('../fpdf/fpdf.php');

// variables obtenidas por GET



class PDF extends FPDF
{
    function Header()
    {
        $inicial = $_GET["inicial"];
        $final = $_GET["final"];
        $this->Image("../images/encabezado_pdf_2.jpg"  , 0   , -8  , 300 );
        $this->Image("../images/rectangulo_pdf.png"    , 260 , 2   , 20  , 20);
        $this->Image("../images/rectangulo_pdf_2.png"  , 10  , 10  , 85  , 12);
        $this->Image("../images/hotelexpoabastos.png"  , 260 , 1   , 20  , 20);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor( 255 , 255 , 255 );
        $this->Cell(85, 8, iconv("UTF-8", "ISO-8859-1" ,"REPORTE FACTURADOS"), 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 10);
        $this->Cell(85, 5, iconv("UTF-8", "ISO-8859-1" , "Del ".$inicial." al ".$final), 0, 0, 'C');
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
        date_default_timezone_set('America/Mexico_City');
        $ticket=NEW Ticket(0);
        $hab=NEW Hab(0);
        $mov= NEW Movimiento(0);
        $fact=NEW factura(0);
        $this->SetFillColor(64, 0, 61);
        $this->SetFont('Arial', 'B', 7);
        $this->SetTextColor(255, 255, 255);
        $this->Cell(8, 6, '', 1, 0, 'C', true);
        $this->Cell(23, 6, 'Inicio', 1, 0, 'C', true);
        $this->Cell(23, 6, 'Fin', 1, 0, 'C', true);
        $this->Cell(12, 6, 'Cuarto', 1, 0, 'C', true);
        $this->Cell(23, 6, 'Fecha', 1, 0, 'C', true);
        $this->Cell(17, 6, 'Factura', 1, 0, 'C', true);
        $this->Cell(40, 6, utf8_decode('Razón Social'), 1, 0, 'C', true);
        $this->Cell(20, 6, 'Importe', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Facturado', 1, 0, 'C', true);
        $this->Cell(20, 6, 'Forma de Pago', 1, 0, 'C', true);
        $this->Cell(70, 6, 'UUID', 1, 0, 'C', true);
        $this->Ln(); // Salto de línea
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 7);

        $opcion = $_GET["opcion"];
        $inicial = $_GET["inicial"];
        $final = $_GET["final"];
        $inicio=strtotime($inicial);
        $fin=strtotime($final)+86400;
        $total_importe_nf=0;
        $total_facturado_f=0;
        if($opcion=="no-facturado"||$opcion=="ambos"){
            $this->Cell(30, 6, 'NO FACTURADO', 0);
            $this->Ln();
            $respuesta=$ticket->reporte_tickets_en_rango_fechas_sin_facturar($inicio,$fin);
            while ($fila = mysqli_fetch_array($respuesta)){
                if($fila['monto']>0){
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(8, 6, utf8_decode($fila['mov']), 1);
                    $this->Cell(23, 6, utf8_decode(date("Y-m-d H:i",$mov->saber_fecha_inicio($fila['mov']))), 1);
                    $this->Cell(23, 6, utf8_decode(date("Y-m-d H:i",$mov->saber_fecha_fin($fila['mov']))), 1);;
                    $this->Cell(12, 6, utf8_decode($hab->mostrar_nombre_hab($fila['id_hab'])), 1);
                    $this->Cell(23, 6, utf8_decode(date("Y-m-d H:i", $fila['ticket_fecha'])), 1);
                    $this->Cell(17, 6, utf8_decode(''), 1);
                    $this->Cell(40, 6, utf8_decode(''), 1);
                    $this->Cell(20, 6, utf8_decode('$'.number_format($fila['monto'],2)), 1);
                    $this->Cell(20, 6, utf8_decode('$'.number_format(0,2)), 1);
                    $this->Cell(20, 6, utf8_decode(''), 1);
                    $this->Cell(70, 6, utf8_decode(''), 1);
                    $this->Ln();
                    $total_importe_nf+=$fila['monto'];
                    }
            }
            if($total_importe_nf>0){
                $this->Cell(106, 6, utf8_decode(""), 0);
                $this->Cell(40, 6, utf8_decode("Total NO FACTURADO"), 0);
                $this->Cell(20, 6, utf8_decode('$'.number_format($total_importe_nf,2)), 0);
                $this->Cell(20, 6, utf8_decode('$'.number_format(0,2)), 0);
            }
            $this->Ln();
            $this->Line(10, $this->GetY(), 286, $this->GetY());
        }
        if($opcion=="facturado"||$opcion=="ambos"){
            $this->Cell(30, 6, 'FACTURADO', 0);
            $this->Ln();
            $respuesta=$ticket->reporte_tickets_en_rango_fechas_facturado($inicio,$fin);
            while ($fila = mysqli_fetch_array($respuesta)){
                if($fila){
                    $this->SetTextColor(0, 0, 0);
                    $this->SetFont('Arial', '', 7);
                    $this->Cell(8, 6, utf8_decode($fila['folio_casa']), 1);
                    $this->Cell(23, 6, utf8_decode(date("Y-m-d H:i",$mov->saber_fecha_inicio($fila['folio_casa']))), 1);
                    $this->Cell(23, 6, utf8_decode(date("Y-m-d H:i",$mov->saber_fecha_fin($fila['folio_casa']))), 1);;
                    $this->Cell(12, 6, utf8_decode('habitacion '.$fila['nombre_hab']), 1);
                    $this->Cell(23, 6, utf8_decode(date("Y-m-d H:i", $fila['fecha'])), 1);
                    $this->Cell(17, 6, utf8_decode($fila['folio']), 1);
                    $nombre = $fila['nombre'];
                    $nombre_truncado = (strlen($nombre) > 25 ) ? substr($nombre, 0 , 22 ) . '...' : $nombre;
                    $this->Cell(40, 6, utf8_decode($nombre_truncado), 1);
                    $this->Cell(20, 6, utf8_decode('$'.number_format(0,2)), 1);
                    $this->Cell(20, 6, utf8_decode('$'.number_format($fila['importe']+$fila['iva']+$fila['ish'],2)), 1);
                    if($fila['metodopago']){
                        $nombreMP = $fact->obtener_forma_pago($fila['metodopago']);
                        $nombre_truncadoMP = (strlen($nombreMP) > 18 ) ? substr($nombreMP, 0 , 16 ) . '...' : $nombreMP;
                        $this->Cell(20, 6, utf8_decode($nombre_truncadoMP), 1);
                    }else{
                        $this->Cell(20, 6, utf8_decode(''), 1);
                    }
                    
                    $this->Cell(70, 6, utf8_decode($fila['uuid']), 1);
                    $this->Ln();
                    $total_facturado_f+=($fila['importe']+$fila['iva']+$fila['ish']);
                }
            }
            if($total_facturado_f>0){
                $this->Cell(106, 6, utf8_decode(""), 0);
                $this->Cell(40, 6, utf8_decode("Total FACTURADO"), 0);
                $this->Cell(20, 6, utf8_decode('$'.number_format(0,2)), 0);
                $this->Cell(20, 6, utf8_decode('$'.number_format($total_facturado_f,2)), 0);
                $this->Ln();
            }
            
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

