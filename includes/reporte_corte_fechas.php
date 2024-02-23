<?php

require('../fpdf/fpdf.php');
include_once('clase_ticket.php');
include_once('clase_usuario.php');
session_start();

$inicio = $_GET['inicio'] ?? null;
$final = $_GET['final'] ?? null;
echo date('Y-m-d',$inicio);
echo date('Y-m-d',$final);

class PDF extends FPDF
{
    function Header()
    {
        
        // Cabecera
        $this->Image("../images/encabezado_pdf_2.jpg"  , 0   , -8  , 300 );
        $this->Image("../images/rectangulo_pdf.png"    , 260 , 2   , 20  , 20);
        $this->Image("../images/rectangulo_pdf_2.png"  , 10  , 10  , 85  , 12);
        $this->Image("../images/hotelexpoabastos.png"  , 260 , 1   , 20  , 20);
        $this->SetFont('Arial', 'B', 12);
        $this->SetTextColor( 255 , 255 , 255 );
        $this->Cell(85, 8, iconv("UTF-8", "ISO-8859-1" ,"Reporte de corte"), 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', 'B', 7);
        /* $this->Cell( 20 , 1, 'Mes:', 0, 0, 'R');
        $this->Cell(20, 1, $mes, 0, 1, );
        $this->Cell(65, 0, utf8_decode('Año:'), 0, 0, 'R');
        $this->Cell(65, 0, self::$año, 0, 1, ); */
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 12);
        //$this->Cell(35, 15, 'Turno:', 0, 0, 'C');
        $this->SetFont('Arial', 'B', 7);
        $this->Ln();
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

        $fechaInicio = new DateTime('2024-01-01');
        $fechaFin = new DateTime('2024-02-23');

        // Crear un array para almacenar las fechas
        $listaFechas = array();

        // Generar las fechas y agregarlas al array
        while ($fechaInicio <= $fechaFin) {
            $listaFechas[] = $fechaInicio->format('Y-m-d');
            $fechaInicio->add(new DateInterval('P1D')); // Añadir un día a la fecha de inicio
        }
        $listaFechas[] = $fechaInicio->format('Y-m-d');
        //var_dump($listaFechas);
        //var_dump($listaFechas);
        $ticket= NEW Ticket(0);
        $usuario= NEW Usuario(0);
        $abonos=array();
        $consulta_abono=$ticket->tipo_abonos();
        while ($fila = mysqli_fetch_array($consulta_abono))
        {
            $abonos[$fila['id']]=$fila['descripcion'];
        }
        for ($fecha=0; $fecha<count($listaFechas)-1; $fecha++){
            

            
            
            foreach ($abonos as $clave => $valor){
                $fecha_inicio=$listaFechas[$fecha].' 07:00:00';
                $fecha_fin=$listaFechas[$fecha].' 15:00:00';
                $fecha_inicio_unix = strtotime($fecha_inicio);
                $fecha_fin_unix = strtotime($fecha_fin);
                $consulta=$ticket->tickets_intervalo($fecha_inicio_unix,$fecha_fin_unix,$clave);
                //var_dump($consulta);
                $total_cargo=0;
                $total_abono=0;
                if ($consulta->num_rows > 0){
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 278 , 5, $listaFechas[$fecha], 0, 0,'C');
                    $this->ln();
                    $this->SetFont('Arial', '', 10);
                    $this->Cell( 278 , 5, 'Turno Matutino 07:00:00 - 15:00:00', 0, 0,'C');
                    $this->ln();

                    /* $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 278 , 5, 'NOMBRE', 0, 0);
                    $this->ln(); */

                    $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C');
                    $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Cargos', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Abonos', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C');
                    $this->ln();


                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 30 , 5, $valor, 0, 0, 'C');
                    $this->ln();
                    $this->SetFont('Arial', '', 10);
                    while ($fila = mysqli_fetch_array($consulta))
                        {
                            $this->Cell( 30 , 5, $fila['fecha'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['id_hab'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['id'], 1, 0, 'C');
                            $this->Cell( 68 , 5, $fila['comentario'],1, 0, 'C');
                            $cargo=0;
                            $abono=0;
                            $consulta_cuenta=$ticket->obtener_cargo_abono($fila['id']);
                            while ($fila_cuenta = mysqli_fetch_array($consulta_cuenta))
                                {
                                    $cargo+=$fila_cuenta['cargo'];
                                    $abono+=$fila_cuenta['abono'];
                                }
                            $this->Cell( 30 , 5,"$". number_format($cargo,2), 1, 0, 'C');
                            $this->Cell( 30 , 5,"$". number_format($abono,2), 1, 0, 'C');
                            $total_cargo+=$cargo;
                            $total_abono+=$abono;
                            $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                            $this->ln();
                    }
                    $this->Cell( 158 , 5, "", 0, 0, 'C');
                    $this->Cell( 30 , 5, "Total:", 1, 0, 'C');
                    $this->Cell( 30 , 5, "$".number_format($total_cargo,2), 1, 0, 'C');
                    $this->Cell( 30 , 5, "$".number_format($total_abono,2), 1, 0, 'C');
                    $this->ln();
                }
            }
            

            
            foreach ($abonos as $clave => $valor){
                $fecha_inicio=$listaFechas[$fecha].' 15:01:00';
                $fecha_fin=$listaFechas[$fecha].' 22:00:00';
                $fecha_inicio_unix = strtotime($fecha_inicio);
                $fecha_fin_unix = strtotime($fecha_fin);
                $consulta=$ticket->tickets_intervalo($fecha_inicio_unix,$fecha_fin_unix,$clave);
                $total_cargo=0;
                $total_abono=0;
                //var_dump($consulta);
                if ($consulta->num_rows > 0){
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 278 , 5, $listaFechas[$fecha], 0, 0,'C');
                    $this->ln();
                    $this->SetFont('Arial', '', 10);
                    $this->Cell( 278 , 5, 'Turno Matutino 07:00:00 - 15:00:00', 0, 0,'C');
                    $this->ln();

                    /* $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 278 , 5, 'NOMBRE', 0, 0);
                    $this->ln(); */

                    $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C');
                    $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Cargos', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Abonos', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C');
                    $this->ln();


                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 30 , 5, $valor, 0, 0, 'C');
                    $this->ln();
                    $this->SetFont('Arial', '', 10);
                    while ($fila = mysqli_fetch_array($consulta))
                        {
                            $this->Cell( 30 , 5, $fila['fecha'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['id_hab'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['id'], 1, 0, 'C');
                            $this->Cell( 68 , 5, $fila['comentario'],1, 0, 'C');
                            $cargo=0;
                            $abono=0;
                            $consulta_cuenta=$ticket->obtener_cargo_abono($fila['id']);
                            while ($fila_cuenta = mysqli_fetch_array($consulta_cuenta))
                                {
                                    $cargo+=$fila_cuenta['cargo'];
                                    $abono+=$fila_cuenta['abono'];
                                }
                            $this->Cell( 30 , 5,"$". number_format($cargo,2), 1, 0, 'C');
                            $this->Cell( 30 , 5,"$". number_format($abono,2), 1, 0, 'C');
                            $total_cargo+=$cargo;
                            $total_abono+=$abono;
                            $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                            $this->ln();
                    }
                    $this->Cell( 158 , 5, "", 0, 0, 'C');
                    $this->Cell( 30 , 5, "Total:", 1, 0, 'C');
                    $this->Cell( 30 , 5, "$".number_format($total_cargo,2), 1, 0, 'C');
                    $this->Cell( 30 , 5, "$".number_format($total_abono,2), 1, 0, 'C');
                    $this->ln();
                }
            }


            
            foreach ($abonos as $clave => $valor){
                $fecha_inicio=$listaFechas[$fecha].' 22:00:00';
                $fecha_fin=$listaFechas[$fecha+1].' 06:59:00';
                $fecha_inicio_unix = strtotime($fecha_inicio);
                $fecha_fin_unix = strtotime($fecha_fin);
                $consulta=$ticket->tickets_intervalo($fecha_inicio_unix,$fecha_fin_unix,$clave);
                $total_cargo=0;
                $total_abono=0;
                //var_dump($consulta);
                if ($consulta->num_rows > 0){
                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 278 , 5, $listaFechas[$fecha], 0, 0,'C');
                    $this->ln();
                    $this->SetFont('Arial', '', 10);
                    $this->Cell( 278 , 5, 'Turno Matutino 07:00:00 - 15:00:00', 0, 0,'C');
                    $this->ln();

                    /* $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 278 , 5, 'NOMBRE', 0, 0);
                    $this->ln(); */

                    $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C');
                    $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Cargos', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Abonos', 1, 0, 'C');
                    $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C');
                    $this->ln();


                    $this->SetFont('Arial', 'B', 10);
                    $this->Cell( 30 , 5, $valor, 0, 0, 'C');
                    $this->ln();
                    $this->SetFont('Arial', '', 10);
                    while ($fila = mysqli_fetch_array($consulta))
                        {
                            $this->Cell( 30 , 5, $fila['fecha'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['id_hab'], 1, 0, 'C');
                            $this->Cell( 30 , 5, $fila['id'], 1, 0, 'C');
                            $this->Cell( 68 , 5, $fila['comentario'],1, 0, 'C');
                            $cargo=0;
                            $abono=0;
                            $consulta_cuenta=$ticket->obtener_cargo_abono($fila['id']);
                            while ($fila_cuenta = mysqli_fetch_array($consulta_cuenta))
                                {
                                    $cargo+=$fila_cuenta['cargo'];
                                    $abono+=$fila_cuenta['abono'];
                                }
                            $this->Cell( 30 , 5,"$". number_format($cargo,2), 1, 0, 'C');
                            $this->Cell( 30 , 5,"$". number_format($abono,2), 1, 0, 'C');
                            $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                            $this->ln();
                    }
                    $this->Cell( 158 , 5, "", 0, 0, 'C');
                    $this->Cell( 30 , 5, "Total:", 1, 0, 'C');
                    $this->Cell( 30 , 5, "$".number_format($total_cargo,2), 1, 0, 'C');
                    $this->Cell( 30 , 5, "$".number_format($total_abono,2), 1, 0, 'C');
                    $this->ln();
                }
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