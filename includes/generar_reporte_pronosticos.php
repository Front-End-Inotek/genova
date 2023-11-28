<?php

require('../fpdf/fpdf.php');


class PDF extends FPDF
{
    function Header()
    {
        // Cabecera
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'PRONOSTICO DE OCUPACION', 0, 1, 'C');
        $this->Ln(1);
        $this->Cell(0, 10, 'Tipo de Cuarto', 0, 1, 'C');
        $this->Ln(1);
    }

    function Footer()
    {
        // Pie de página
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 6);
        $this->Cell(0, 10, 'Página ' . $this->PageNo(), 0, 0, 'C');
    }

    function CreateTable()
    {
        session_start();
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
        $ctotales=0;
        // Configurar encabezado de la tabla
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(25, 4, "", 0);
        for ($i=1; $i<=count($total_cuartos_noche[0]); $i++){
            $this->Cell(7, 4, $i, 0);
        }
        $this->Cell(7, 4, "", 0);
        $this->Cell(7, 4, "Total", 0);
        $this->Ln();

        // Configurar datos de la tabla
        $this->SetFont('Arial', '', 6);
        for($index_matriz = 0; $index_matriz < count($listaMatrices); $index_matriz++) {
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
        $this->Cell(25, 4, "Niños", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaInfantiles[$j], 1);
        }
        $this->Ln();
        $this->Ln();

        $this->Cell(25, 4, "Adultos", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaLlegadasAdultos[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, "Niños", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaLlegadasInfantiles[$j], 1);
        }
        $this->Ln();
        $this->Ln();

        $this->Cell(25, 4, "Adultos", 1);
        for ($j = 0; $j < count($total_cuartos_noche[0]); $j++) {
            $this->Cell(7, 4, $listaSalidasAdultos[$j], 1);
        }
        $this->Ln();
        $this->Cell(25, 4, "Niños", 1);
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