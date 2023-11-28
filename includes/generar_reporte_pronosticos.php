<?php

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
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(50, 8, '', 0, 0, 'C');
        $this->Cell(177, 8, 'PRONOSTICO DE OCUPACION', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 8, 'Mes:', 0, 0, 'R');
        $this->Cell(25, 8, $mes, 0, 1, );
        $this->Ln(1);
        $this->Cell(50, 8, '', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(177, 8, 'Tipo de Cuarto', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(25, 8, mb_convert_encoding('Año:', 'ISO-8859-1', 'UTF-8'), 0, 0, 'R');
        $this->Cell(25, 8, $año, 0, 1, );
        $this->Ln(1);
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, mb_convert_encoding('Página ', 'ISO-8859-1', 'UTF-8') . $this->PageNo(), 0, 0, 'C');
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
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(25, 4, $tipo_de_habitacion[$ctotales], 0);
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
        $this->Cell(25, 4, mb_convert_encoding('niño', 'ISO-8859-1', 'UTF-8'), 1);
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
        $this->Cell(25, 4, mb_convert_encoding('niño', 'ISO-8859-1', 'UTF-8'), 1);
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
        $this->Cell(25, 4, mb_convert_encoding('niño', 'ISO-8859-1', 'UTF-8'), 1);
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