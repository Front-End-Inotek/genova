<?php
date_default_timezone_set('America/Mexico_City');
include_once("clase_configuracion.php");
include_once("clase_huesped.php");
include_once("clase_reservacion.php");
include_once('clase_log.php');
include_once("clase_hab.php");
include_once("clase_cuenta.php");

$logs = new Log(0);

$hab= new Hab($_GET['id']);

if($hab->estado == 0) {
    die();
}


require('../fpdf/fpdf.php');

class PDF extends FPDF
{
    // Cabecera de página
    public function Header()
    {
        $cuenta= new Cuenta(0);
        $conf = new Configuracion(0);
        $hab= new Hab($_GET['id']);
        $nombre= $conf->obtener_nombre();

        $mov= $hab->mov;
        $faltante= 0;
        $faltante= $cuenta->mostrar_faltante($mov);
        if($faltante >= 0) {
            $faltante_mostrar= '$'.number_format($faltante, 2);
        } else {
            $faltante_mostrar= substr($faltante, 1);
            $faltante_mostrar= '-$'.number_format($faltante_mostrar, 2);
        }


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
        $this->SetFont('Arial', '', 20);
        $this->Cell(30, 10, iconv("UTF-8", "ISO-8859-1", 'ESTADO DE CUENTA - Habitación  '.$hab->nombre), 0, 0, 'C');
        $this->SetFont('Arial', 'B', 10);
        $this->Ln(8);
        $this->SetX(160);

        $this->Cell(30, 10, iconv("UTF-8", "ISO-8859-1", 'Saldo  Total ' .$faltante_mostrar), 0, 0, 'C');
        // Salto de línea
        $this->Ln(18);
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

$tarifa= new Tarifa(0);
$movimiento= new Movimiento($hab->mov);
$id_reservacion= $movimiento->saber_id_reservacion($hab->mov);
$reservacion= new Reservacion($id_reservacion);
$consulta = $reservacion->datos_reservacion($id_reservacion);
$contador_row = mysqli_num_rows($consulta);

if($contador_row==0) {
    //No hay datos de reservacion
    echo "<script>window.close();</script>";
}
while ($fila = mysqli_fetch_array($consulta)) {
    $id_hab= $fila['ID'];
    $id_usuario= $fila['id_usuario'];
    $usuario_reservacion= $fila['usuario'];
    $fecha_entrada= date("d-m-Y", $fila['fecha_entrada']);
    $fecha_salida= date("d-m-Y", $fila['fecha_salida']);
    $noches= $fila['noches'];
    $numero_hab= $fila['numero_hab'];
    $tarifa= $fila['habitacion'];
    $precio_hospedaje= $fila['precio_hospedaje'];
    $extra_adulto= $fila['extra_adulto'];
    $extra_junior= $fila['extra_junior'];
    $extra_infantil= $fila['extra_infantil'];
    $extra_menor= $fila['extra_menor'];
    $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
    $quien_reserva= $fila['nombre_reserva'];
    $acompanante= $fila['acompanante'];
    // Checar si suplementos esta vacio o no
    if (empty($fila['suplementos'])) {
        //echo 'La variable esta vacia';
        $suplementos= 'Ninguno';
    } else {
        $suplementos= $fila['suplementos'];
    }
    $total_suplementos= $fila['total_suplementos'];
    $total_habitacion= $fila['total_hab'];
    if($fila['descuento']>0) {
        $descuento= $fila['descuento'].'%';
    } else {
        $descuento= 'Ninguno';
    }
    // Total provisional
    $total_estancia= $fila['total'];
    $total_pago= $fila['total_pago'];
    $forma_pago= $fila['descripcion'];
    $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
}

$saldo_faltante= 0;
$total_faltante= 0;
$mov= $hab->mov;
$suma_abonos= $cuenta->obtner_abonos($mov);
$saldo_pagado= $total_pago + $suma_abonos;
$saldo_faltante= $total_estancia - $saldo_pagado;
$total_cargos= 0;
$total_abonos= 0;
$faltante= 0;
$faltante= $cuenta->mostrar_faltante($mov);
if($faltante >= 0) {
    $faltante_mostrar= '$'.number_format($faltante, 2);
} else {
    $faltante_mostrar= substr($faltante, 1);
    $faltante_mostrar= '-$'.number_format($faltante_mostrar, 2);
}



$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Fecha Entrada: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $fecha_entrada), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Fecha Salida: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $fecha_salida), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Noches: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $noches), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Tarifa: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $tarifa), 0, 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(32, 5, iconv("UTF-8", "ISO-8859-1", 'Nombre Huesped: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(80, 5, iconv("UTF-8", "ISO-8859-1", $nombre_huesped), 0, 'J');
$pdf->SetXY($pdf->GetX()+80, $pdf->GetY()-5);

$pdf->SetFont('Arial', 'B', 10);

if($quien_reserva!="checkin"){
    $pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Quién reserva: '), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $quien_reserva), 0, 0, 'L');
    
}


$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Forma Pago: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $forma_pago), 0, 0, 'L');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Suplementos: '), 0, 0, 'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $suplementos), 0, 0, 'L');

if($extra_adulto>0) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Extra Adulto: '), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $extra_adulto), 0, 0, 'L');

}
if($extra_infantil>0) {
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(28, 5, iconv("UTF-8", "ISO-8859-1", 'Extra Infantil: '), 0, 0, 'L');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(22, 5, iconv("UTF-8", "ISO-8859-1", $extra_infantil), 0, 0, 'L');
}
$pdf->SetFont('Arial', '', 15);

$pdf->Ln(10);

$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
// $pdf->Cell(22, 4, iconv("UTF-8", "ISO-8859-1", 'Cargos'), 0, 0, 'L');
// $pdf->Ln(10);
$pdf->Ln();


$consulta_cargos = $cuenta->mostrar_cargosPDF($hab->mov);
$consulta_abonos = $cuenta->mostrar_abonosPDF($hab->mov);

// Titulos tabla cargos
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Concepto'), 0, 0, 'C');
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Descripcion'), 0, 0, 'C');
$pdf->Cell(35, 4, iconv("UTF-8", "ISO-8859-1", 'Fecha'), 0, 0, 'C');
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Forma pago'), 0, 0, 'C');
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", 'Monto'), 0, 0, 'C');
$pdf->Ln();

$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Ln(10);
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", '>> Cargos'), 0, 1, 'C');

while($fila=mysqli_fetch_array($consulta_cargos)) {
   
    $pdf->Cell(40, 5, '', 0, 0, 'C');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), 0, 0, 'C');
    $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
    $pdf->Cell(40, 5,'', 0, 0, 'C');
    $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($fila['cargo'], 2)), 0, 1, 'C');
    $total_cargos+=$fila['cargo'];

}

$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Ln();
$pdf->Cell(40, 5, 'Total:', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($total_cargos, 2)), 0, 1, 'C');

//abonos
$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Ln(10);
$pdf->Cell(40, 4, iconv("UTF-8", "ISO-8859-1", '>> Abonos'), 0, 1, 'C');

while($fila=mysqli_fetch_array($consulta_abonos)) {

    $descripcion= substr($fila['concepto'], 0, 17);
    $largo= strlen($fila['concepto']);
    if($fila['edo'] == 1) {
        $total_abonos= $total_abonos + $fila['abono'];
        if($descripcion == 'Total reservacion') {
            $pdf->Cell(40, 5, '', 0, 0, 'C');
            if($largo > 17) {
                $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", "Pago al reservar*"), 1, 0, 'C');
            } else {
                $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", "Pago al reservar"), 1, 0, 'C');
            }

            $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
            $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), 0, 0, 'C');
            $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($fila['abono'], 2)), 0, 1, 'C');
        } else {
            $pdf->Cell(40, 5, '', 0, 0, 'C');
            $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", $fila['concepto']), 0, 0, 'C');
            $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
            $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), 0, 0, 'C');
            $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($fila['abono'], 2)), 0, 1, 'C');
        }
    }else{
        $pdf->Cell(40, 5, '', 0, 0, 'C');
        $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", $fila['concepto']), 0, 0, 'C');
        $pdf->Cell(35, 5, iconv("UTF-8", "ISO-8859-1", date("d-m-Y", $fila['fecha'])), 0, 0, 'C');
        $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", $fila['descripcion']), 0, 0, 'C');
        $pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($fila['abono'], 2)), 0, 1, 'C');
    }
    $total_abonos+=$fila['abono'];
}

$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Ln();
$pdf->Cell(40, 5, 'Total:', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1", number_format($total_abonos, 2)), 0, 1, 'C');


$pdf->Line($pdf->GetX(), $pdf->GetY(), 200,$pdf->GetY());
$pdf->Ln();
$pdf->Cell(40, 5, 'Saldo Total:', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(35, 5, '', 0, 0, 'C');
$pdf->Cell(40, 5,'', 0, 0, 'C');
$pdf->Cell(40, 5, iconv("UTF-8", "ISO-8859-1",$faltante_mostrar), 0, 1, 'C');


$pdf->Output("reporte_estado_cuenta_".$hab->nombre.".pdf", "I");
//$logs->guardar_log($_GET['usuario_id'], "Reporte reservacion: ". $_GET['id']);

?>

