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

    function CreateTable($data)
    {
        // Configurar encabezado de la tabla
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(25, 4, "", 0);
        for ($i=1; $i<=30+1; $i++){
            $this->Cell(7, 4, $i, 0);
        }
        $this->Cell(7, 4, "", 0);
        $this->Cell(7, 4, "Total", 0);
        $this->Ln();

        // Configurar datos de la tabla
        $this->SetFont('Arial', '', 6);
        for ($fila = 1; $fila <= 5; $fila++) {
            if($fila==1){
                $this->Cell(25, 4, "Cuartos noche", 1);
            }elseif($fila==2){
                $this->Cell(25, 4, "Reservadas", 1);
            }
            elseif($fila==3){
                $this->Cell(25, 4, "Reservadas web", 1);
            }
            elseif($fila==4){
                $this->Cell(25, 4, "Walk-in", 1);
            }elseif($fila==5){
                $this->Cell(25, 4, "Disponibles", 1);
            }
            for ($j=0; $j<=30; $j++){
                $this->Cell(7, 4, $j, 1);
            }
            $this->Cell(7, 4, "", 0);
            $this->Cell(7, 4, "", 1);
            $this->Ln();
        }
    }
}

// Crear instancia de PDF con orientación horizontal
$pdf = new PDF('L');
$pdf->AddPage();

// Definir una matriz de ejemplo
$miMatriz = array(
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
    array('Nombre', 'Apellido', 'Edad'),
    array('Juan', 'Pérez', 25),
    array('María', 'Gómez', 30),
    array('Carlos', 'Rodríguez', 28),
);

// Crear la tabla con la matriz
$pdf->CreateTable($miMatriz);

// Salida del PDF
$pdf->Output();
?>