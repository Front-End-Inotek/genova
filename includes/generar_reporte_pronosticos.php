<?php
include_once("clase_configuracion.php");
require('../fpdf/fpdf.php');
session_start();


class PDF extends FPDF
{
    function Header()
    {
        // Cabecera
        
        $mes=$_SESSION["mes"];
        $año=$_SESSION["año"];
        if($mes==1){
            $mes="Enero";
        }elseif($mes==2){
            $mes="Febrero";
        }elseif($mes==3){
            $mes="Marzo";
        }elseif($mes==4){
            $mes="Abril";
        }elseif($mes==5){
            $mes="Mayo";
        }elseif($mes==6){
            $mes="Junio";
        }elseif($mes==7){
            $mes="Julio";
        }elseif($mes==8){
            $mes="Agosto";
        }elseif($mes==9){
            $mes="Septiembre";
        }elseif($mes==10){
            $mes="Octubre";
        }elseif($mes==11){
            $mes="Noviembre";
        }elseif($mes==12){
            $mes="Diciembre";
        }
        $conf = NEW Configuracion(0);
        $imagenHotel = '../images/'.$conf->imagen.'';
        $this->Image("../images/encabezado_pdf_2.jpg"  , 0   , -8  , 300 );
        $this->Image("../images/rectangulo_pdf.png"    , 260 , 2   , 20  , 20);
        $this->Image("../images/rectangulo_pdf_2.png"  , 10  , 10  , 85  , 12);
        $this->Image( $imagenHotel  , 260 , 1   , 20  , 20);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor( 255 , 255 , 255 );
        $this->Cell(85, 8, iconv("UTF-8", "ISO-8859-1" ,"PRONOSTICO DE OCUPACIÓN"), 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 7);
        $this->Cell( 20 , 1, 'Mes:', 0, 0, 'R');
        $this->Cell(20, 1, $mes, 0, 1, );
        $this->Cell(65, 0, utf8_decode('Año:'), 0, 0, 'R');
        $this->Cell(65, 0, $año, 0, 1, );
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(35, 15, 'Tipo de Cuarto', 0, 0, 'C');
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
        
        $listaMatrices=$_SESSION["lista_matrices"];
        $total_cuartos_noche=$_SESSION["total_cuartos_noche"];
        $totales=$_SESSION["totales"];
        $ocupacion=$_SESSION["ocupacion"];
        $listaAdultos=$_SESSION["listaAdultos"];
        $listaInfantiles=$_SESSION["listaInfantiles"];
        $listaLlegadasAdultos=$_SESSION["listaLlegadasAdultos"];
        $listaLlegadasInfantiles=$_SESSION["listaLlegadasInfantiles"];
        $listaSalidasAdultos=$_SESSION["listaSalidasAdultos"];
        $listaSalidasInfantiles=$_SESSION["listaSalidasInfantiles"];
        $tipo_de_habitacion=$_SESSION["tipo_de_habitacion"];
        $ctotales=0;
        // Configurar encabezado de la tabla
        $this->SetFont('Arial', '', 6);
        $this->Cell(25, 4, $tipo_de_habitacion[$ctotales], 0);
        $this->SetFont('Arial', 'B', 6);
        for ($i=1; $i<=count($total_cuartos_noche[0]); $i++){
            $this->Cell(7, 4, $i, 0);
        }
        $this->Cell(7, 4, "", 0);
        $this->Cell(7, 4, "Total", 0);

        // Configurar datos de la tabla
        $this->SetFont('Arial', '', 6);
        for($index_matriz = 0; $index_matriz < count($listaMatrices); $index_matriz++) {
            if($ctotales!=0){
                $this->Cell(25, 4, $tipo_de_habitacion[$ctotales], 0);
            }
            $this->Ln();
            for ($fila = 1; $fila <= count($listaMatrices[$index_matriz]); $fila++) {
                if($fila == 1) {
                    $this->Cell(25, 4, "Cuartos noche", 1);
                } elseif($fila == 2) {
                    $this->Cell(25, 4, "Reservadas", 1);
                } elseif($fila == 3) {
                    $this->Cell(25, 4, "Reservadas web", 1);
                } elseif($fila == 4) {
                    $this->Cell(25, 4, "Walk-in", 1);
                } elseif($fila == 5) {
                    $this->Cell(25, 4, "Disponibles", 1);
                }
                for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
                    $this->Cell(7, 4, $listaMatrices[$index_matriz][$fila - 1][$j], 1);
                }
                $this->Cell(7, 4, "", 0);
                $this->Cell(7, 4, $totales[$ctotales][$fila-1], 1);
                
                $this->Ln();
                }
            $ctotales=$ctotales+1;
            $this->Ln();
        }
        
        $this->Cell(25, 4, "Total cuartos noche", 0);
        $this->Ln();
        for ($fila = 1; $fila <= 5; $fila++) {
            if($fila == 1) {
                $this->Cell(25, 4, "Cuartos noche", 1);
            } elseif($fila == 2) {
                $this->Cell(25, 4, "Reservadas", 1);
            } elseif($fila == 3) {
                $this->Cell(25, 4, "Reservadas web", 1);
            } elseif($fila == 4) {
                $this->Cell(25, 4, "Walk-in", 1);
            } elseif($fila == 5) {
                $this->Cell(25, 4, "Disponibles", 1);
            }
            for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
                $this->Cell(7, 4, $total_cuartos_noche[$fila - 1][$j], 1);
            }
            $this->Cell(7, 4, "", 0);
            $this->Cell(7, 4, $totales[$ctotales][$fila-1], 1);
            $this->Ln();
            }
        $ctotales=$ctotales+1;
        $this->Ln();
        $this->Cell(25, 4, "Ocupacion", 0);
        $this->Ln();
        $this->Cell(25, 4, "Ocupacion bruta (%)", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $ocupacion[$j], 1);
        }
        $this->Cell(7, 4, "", 0);
        $this->Cell(7, 4, $totales[$ctotales][0], 1);
        $this->Ln();
        $this->Ln();
        

        $this->Cell(25, 4, "Adultos", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaAdultos[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, utf8_decode('niño'), 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaInfantiles[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, "Llegadas", 0);
        $this->Ln();

        $this->Cell(25, 4, "Adultos", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaLlegadasAdultos[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, utf8_decode('niño'), 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaLlegadasInfantiles[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, "Salidas", 0);
        $this->Ln();

        $this->Cell(25, 4, "Adultos", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaSalidasAdultos[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, utf8_decode('niño'), 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaSalidasInfantiles[$j], 1);
        }
        $this->Ln();
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