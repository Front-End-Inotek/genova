<?php

require('../fpdf/fpdf.php');
include_once('clase_ticket.php');
include_once('clase_usuario.php');
include_once("clase_cuenta.php");

include_once("clase_hab.php");
session_start();


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
        $inicio = $_GET['inicio'] ?? null;
        $final = $_GET['final'] ?? null;
        $finicio=date('Y-m-d',$inicio);
        $ffin=date('Y-m-d',$final);

        $fechaInicio = new DateTime($finicio);
        $fechaFin = new DateTime($ffin);

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
        $cuenta= NEW Cuenta(0);
        $hab= NEW Hab(0);
        $abonos=array();
        $consulta_abono=$ticket->tipo_abonos();
        while ($fila = mysqli_fetch_array($consulta_abono))
        {
            $abonos[$fila['id']]=$fila['descripcion'];
        }
        for ($fecha=0; $fecha<count($listaFechas)-1; $fecha++){
            $totalescargo=0;
            $totalesabono=0;
            $imprime_fecha=1;
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
                    if($imprime_fecha==1){
                        $imprime_fecha=0;
                        $this->SetFillColor(52, 73, 94); // Rojo
                        $this->SetFont('Arial', 'B', 9);
                        $this->SetTextColor(255, 255, 255);
                        $this->Cell( 278 , 5, $listaFechas[$fecha]." Turno matutino 07:00-15:00", 1, 0,'C',true);
                        $this->ln();
                        $this->SetTextColor(0, 0, 0);
                    }
                    $this->SetFillColor(128, 139, 150);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell( 278 , 5, $valor, 1, 0,'C', true);
                    $this->ln();
                    $this->SetFont('Arial', 'B', 7);
                    $this->SetFillColor(171, 178, 185);
                    $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C', true);
                    $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Cargo', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Abono', 1, 0, 'C', true);
                    $this->ln();
                    $this->SetFont('Arial', 'I', 6);
                    while ($fila = mysqli_fetch_array($consulta))
                        {
                            if ($fila['total']>0){
                                $this->Cell( 30 , 5, $fila['fecha'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $hab->mostrar_nombre_hab($fila['id_hab']), 1, 0, 'C');
                                $this->Cell( 30 , 5, $fila['id'], 1, 0, 'C');
                                $fila_cuenta=$cuenta->sacar_cargo_abono($fila['id']);
                                $this->Cell( 68 , 5, $fila_cuenta['observacion'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                                $this->Cell( 30 , 5, '$'.number_format('0',2), 1, 0, 'C');
                                $this->Cell( 30 , 5, '$'.number_format($fila_cuenta['abono'],2), 1, 0, 'C');
                                $total_abono+=$fila_cuenta['abono'];
                                $this->ln();
                            }
                        }
                        $this->SetFont('Arial', 'B', 6);
                        $this->Cell( 188 , 5, '', 0, 0, 'C');
                        $this->Cell( 30 , 5, 'Total:', 1, 0, 'C');
                        $this->SetFont('Arial', 'I', 6);
                        $this->Cell( 30 , 5, '$'.number_format('0',2), 1, 0, 'C');
                        $this->Cell( 30 , 5, '$'.number_format($total_abono,2), 1, 0, 'C');
                        $this->ln();
                        $this->ln();
                }
                $totalesabono+=$total_abono;
            }
            $consulta2=$cuenta->tickets_intervalo_cargo($fecha_inicio_unix,$fecha_fin_unix);
            if ($consulta2->num_rows > 0){
                $this->SetFillColor(128, 139, 150);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell( 278 , 5, "Cargos", 1, 0,'C', true);
                $this->ln();
                $this->SetFont('Arial', 'B', 7);
                $this->SetFillColor(171, 178, 185);
                $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C', true);
                $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Cargo', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Abono', 1, 0, 'C', true);
                $this->ln();
                $this->SetFont('Arial', 'I', 6);
                while ($fila = mysqli_fetch_array($consulta2))
                {
                    $this->Cell( 30 , 5, date("Y-m-d H:i", $fila['fecha']), 1, 0, 'C');
                    $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                    $this->Cell( 30 , 5, $hab->mostrar_nombre_hab($ticket->saber_hab_ticket($fila['mov'])), 1, 0, 'C');
                    $this->Cell( 30 , 5, "-", 1, 0, 'C');
                    $this->Cell( 68 , 5, $fila['observacion'], 1, 0, 'C');
                    $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                    $this->Cell( 30 , 5, '$'.number_format($fila['cargo'],2), 1, 0, 'C');
                    $this->Cell( 30 , 5, '$'.number_format($fila['abono'],2), 1, 0, 'C');
                    $total_cargo+=$fila['cargo'];
                    $total_abono+=$fila['abono'];
                    $this->ln();
                }
                $this->SetFont('Arial', 'B', 6);
                $this->Cell( 188 , 5, '', 0, 0, 'C');
                $this->Cell( 30 , 5, 'Total:', 1, 0, 'C');
                $this->SetFont('Arial', 'I', 6);
                $this->Cell( 30 , 5, '$'.number_format($total_cargo,2), 1, 0, 'C');
                $this->Cell( 30 , 5, '$'.number_format($total_abono,2), 1, 0, 'C');
                $this->ln();
            }
            $totalescargo+=$total_cargo;
            $difencia=0;
            $this->SetFont('Arial', 'I', 7);
            $this->Cell( 145 , 5, '', 0, 0, 'C');
            $this->Cell( 15 , 5, 'Total cargos:', 0, 0, 'C');
            $this->Cell( 30 , 5, '$'.number_format($totalescargo,2), 0, 0, 'C');
            $this->Cell( 15 , 5, 'Total abonos:', 0, 0, 'C');
            $this->Cell( 30 , 5, '$'.number_format($totalesabono,2), 0, 0, 'C');
            $this->Cell( 15 , 5, 'Diferencia:', 0, 0, 'C');
            if ($totalesabono>$totalescargo){
                $difencia=$totalesabono-$totalescargo;
            }else{
                $difencia=$totalescargo-$totalesabono;
            }
            $this->Cell( 30 , 5, '$'.number_format($difencia,2), 0, 0, 'C');
            $this->ln();
            $this->ln();


            $totalescargo=0;
            $totalesabono=0;
            $imprime_fecha=1;
            foreach ($abonos as $clave => $valor){
                $fecha_inicio=$listaFechas[$fecha].' 15:00:01';
                $fecha_fin=$listaFechas[$fecha].' 22:00:00';
                $fecha_inicio_unix = strtotime($fecha_inicio);
                $fecha_fin_unix = strtotime($fecha_fin);
                $consulta=$ticket->tickets_intervalo($fecha_inicio_unix,$fecha_fin_unix,$clave);
                //var_dump($consulta);
                $total_cargo=0;
                $total_abono=0;
                if ($consulta->num_rows > 0){
                    if($imprime_fecha==1){
                        $imprime_fecha=0;
                        $this->SetFillColor(52, 73, 94); // Rojo
                        $this->SetFont('Arial', 'B', 9);
                        $this->SetTextColor(255, 255, 255);
                        $this->Cell( 278 , 5, $listaFechas[$fecha]." Turno vespertino 15:00-22:00", 1, 0,'C',true);
                        $this->ln();
                        $this->SetTextColor(0, 0, 0);
                    }
                    $this->SetFillColor(128, 139, 150);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell( 278 , 5, $valor, 1, 0,'C', true);
                    $this->ln();
                    $this->SetFont('Arial', 'B', 7);
                    $this->SetFillColor(171, 178, 185);
                    $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C', true);
                    $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Cargo', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Abono', 1, 0, 'C', true);
                    $this->ln();
                    $this->SetFont('Arial', 'I', 6);
                    while ($fila = mysqli_fetch_array($consulta))
                        {
                            if ($fila['total']>0){
                                $this->Cell( 30 , 5, $fila['fecha'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $hab->mostrar_nombre_hab($fila['id_hab']), 1, 0, 'C');
                                $this->Cell( 30 , 5, $fila['id'], 1, 0, 'C');
                                $fila_cuenta=$cuenta->sacar_cargo_abono($fila['id']);
                                $this->Cell( 68 , 5, $fila_cuenta['observacion'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                                $this->Cell( 30 , 5, '$'.number_format('0',2), 1, 0, 'C');
                                $this->Cell( 30 , 5, '$'.number_format($fila_cuenta['abono'],2), 1, 0, 'C');
                                $total_abono+=$fila_cuenta['abono'];
                                $this->ln();
                            }
                        }
                        $this->SetFont('Arial', 'B', 6);
                        $this->Cell( 188 , 5, '', 0, 0, 'C');
                        $this->Cell( 30 , 5, 'Total:', 1, 0, 'C');
                        $this->SetFont('Arial', 'I', 6);
                        $this->Cell( 30 , 5, '$'.number_format('0',2), 1, 0, 'C');
                        $this->Cell( 30 , 5, '$'.number_format($total_abono,2), 1, 0, 'C');
                        $this->ln();
                        $this->ln();
                }
                $totalesabono+=$total_abono;
            }
            $consulta2=$cuenta->tickets_intervalo_cargo($fecha_inicio_unix,$fecha_fin_unix);
            if ($consulta2->num_rows > 0){
                $this->SetFillColor(128, 139, 150);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell( 278 , 5, "Cargos", 1, 0,'C', true);
                $this->ln();
                $this->SetFont('Arial', 'B', 7);
                $this->SetFillColor(171, 178, 185);
                $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C', true);
                $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Cargo', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Abono', 1, 0, 'C', true);
                $this->ln();
                $this->SetFont('Arial', 'I', 6);
                while ($fila = mysqli_fetch_array($consulta2))
                {
                    $this->Cell( 30 , 5, date("Y-m-d H:i", $fila['fecha']), 1, 0, 'C');
                    $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                    $this->Cell( 30 , 5, $hab->mostrar_nombre_hab($ticket->saber_hab_ticket($fila['mov'])), 1, 0, 'C');
                    $this->Cell( 30 , 5, "-", 1, 0, 'C');
                    $this->Cell( 68 , 5, $fila['observacion'], 1, 0, 'C');
                    $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                    $this->Cell( 30 , 5, '$'.number_format($fila['cargo'],2), 1, 0, 'C');
                    $this->Cell( 30 , 5, '$'.number_format($fila['abono'],2), 1, 0, 'C');
                    $total_cargo+=$fila['cargo'];
                    $total_abono+=$fila['abono'];
                    $this->ln();
                }
                $this->SetFont('Arial', 'B', 6);
                $this->Cell( 188 , 5, '', 0, 0, 'C');
                $this->Cell( 30 , 5, 'Total:', 1, 0, 'C');
                $this->SetFont('Arial', 'I', 6);
                $this->Cell( 30 , 5, '$'.number_format($total_cargo,2), 1, 0, 'C');
                $this->Cell( 30 , 5, '$'.number_format($total_abono,2), 1, 0, 'C');
                $this->ln();
            }
            $totalescargo+=$total_cargo;
            $difencia=0;
            $this->SetFont('Arial', 'I', 7);
            $this->Cell( 145 , 5, '', 0, 0, 'C');
            $this->Cell( 15 , 5, 'Total cargos:', 0, 0, 'C');
            $this->Cell( 30 , 5, '$'.number_format($totalescargo,2), 0, 0, 'C');
            $this->Cell( 15 , 5, 'Total abonos:', 0, 0, 'C');
            $this->Cell( 30 , 5, '$'.number_format($totalesabono,2), 0, 0, 'C');
            $this->Cell( 15 , 5, 'Diferencia:', 0, 0, 'C');
            if ($totalesabono>$totalescargo){
                $difencia=$totalesabono-$totalescargo;
            }else{
                $difencia=$totalescargo-$totalesabono;
            }
            $this->Cell( 30 , 5, '$'.number_format($difencia,2), 0, 0, 'C');
            $this->ln();
            $this->ln();


            $totalescargo=0;
            $totalesabono=0;
            $imprime_fecha=1;
            foreach ($abonos as $clave => $valor){
                $fecha_inicio=$listaFechas[$fecha].' 22:00:01';
                $fecha_fin=$listaFechas[$fecha+1].' 06:59:59';
                $fecha_inicio_unix = strtotime($fecha_inicio);
                $fecha_fin_unix = strtotime($fecha_fin);
                $consulta=$ticket->tickets_intervalo($fecha_inicio_unix,$fecha_fin_unix,$clave);
                //var_dump($consulta);
                $total_cargo=0;
                $total_abono=0;
                if ($consulta->num_rows > 0){
                    if($imprime_fecha==1){
                        $imprime_fecha=0;
                        $this->SetFillColor(52, 73, 94); // Rojo
                        $this->SetFont('Arial', 'B', 9);
                        $this->SetTextColor(255, 255, 255);
                        $this->Cell( 278 , 5, $listaFechas[$fecha]." Turno nocturno 22:00-07:00", 1, 0,'C',true);
                        $this->ln();
                        $this->SetTextColor(0, 0, 0);
                    }
                    $this->SetFillColor(128, 139, 150);
                    $this->SetFont('Arial', 'B', 8);
                    $this->Cell( 278 , 5, $valor, 1, 0,'C', true);
                    $this->ln();
                    $this->SetFont('Arial', 'B', 7);
                    $this->SetFillColor(171, 178, 185);
                    $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C', true);
                    $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Cargo', 1, 0, 'C', true);
                    $this->Cell( 30 , 5, 'Abono', 1, 0, 'C', true);
                    $this->ln();
                    $this->SetFont('Arial', 'I', 6);
                    while ($fila = mysqli_fetch_array($consulta))
                        {
                            if ($fila['total']>0){
                                $this->Cell( 30 , 5, $fila['fecha'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $hab->mostrar_nombre_hab($fila['id_hab']), 1, 0, 'C');
                                $this->Cell( 30 , 5, $fila['id'], 1, 0, 'C');
                                $fila_cuenta=$cuenta->sacar_cargo_abono($fila['id']);
                                $this->Cell( 68 , 5, $fila_cuenta['observacion'], 1, 0, 'C');
                                $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                                $this->Cell( 30 , 5, '$'.number_format('0',2), 1, 0, 'C');
                                $this->Cell( 30 , 5, '$'.number_format($fila_cuenta['abono'],2), 1, 0, 'C');
                                $total_abono+=$fila_cuenta['abono'];
                                $this->ln();
                            }
                        }
                        $this->SetFont('Arial', 'B', 6);
                        $this->Cell( 188 , 5, '', 0, 0, 'C');
                        $this->Cell( 30 , 5, 'Total:', 1, 0, 'C');
                        $this->SetFont('Arial', 'I', 6);
                        $this->Cell( 30 , 5, '$'.number_format('0',2), 1, 0, 'C');
                        $this->Cell( 30 , 5, '$'.number_format($total_abono,2), 1, 0, 'C');
                        $this->ln();
                        $this->ln();
                }
                $totalesabono+=$total_abono;
            }
            $consulta2=$cuenta->tickets_intervalo_cargo($fecha_inicio_unix,$fecha_fin_unix);
            if ($consulta2->num_rows > 0){
                $this->SetFillColor(128, 139, 150);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell( 278 , 5, "Cargos", 1, 0,'C', true);
                $this->ln();
                $this->SetFont('Arial', 'B', 7);
                $this->SetFillColor(171, 178, 185);
                $this->Cell( 30 , 5, 'Fecha', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Folio casa', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Cuarto', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'FPosteo', 1, 0, 'C', true);
                $this->Cell( 68 , 5, 'Observaciones', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Usuario', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Cargo', 1, 0, 'C', true);
                $this->Cell( 30 , 5, 'Abono', 1, 0, 'C', true);
                $this->ln();
                $this->SetFont('Arial', 'I', 6);
                while ($fila = mysqli_fetch_array($consulta2))
                {
                    $this->Cell( 30 , 5, date("Y-m-d H:i", $fila['fecha']), 1, 0, 'C');
                    $this->Cell( 30 , 5, $fila['mov'], 1, 0, 'C');
                    $this->Cell( 30 , 5, $hab->mostrar_nombre_hab($ticket->saber_hab_ticket($fila['mov'])), 1, 0, 'C');
                    $this->Cell( 30 , 5, "-", 1, 0, 'C');
                    $this->Cell( 68 , 5, $fila['observacion'], 1, 0, 'C');
                    $this->Cell( 30 , 5, $usuario->obtengo_nombre_completo($fila['id_usuario']), 1, 0, 'C');
                    $this->Cell( 30 , 5, '$'.number_format($fila['cargo'],2), 1, 0, 'C');
                    $this->Cell( 30 , 5, '$'.number_format($fila['abono'],2), 1, 0, 'C');
                    $total_cargo+=$fila['cargo'];
                    $total_abono+=$fila['abono'];
                    $this->ln();
                }
                $this->SetFont('Arial', 'B', 6);
                $this->Cell( 188 , 5, '', 0, 0, 'C');
                $this->Cell( 30 , 5, 'Total:', 1, 0, 'C');
                $this->SetFont('Arial', 'I', 6);
                $this->Cell( 30 , 5, '$'.number_format($total_cargo,2), 1, 0, 'C');
                $this->Cell( 30 , 5, '$'.number_format($total_abono,2), 1, 0, 'C');
                $this->ln();
            }
            $totalescargo+=$total_cargo;
            $difencia=0;
            $this->SetFont('Arial', 'I', 7);
            $this->Cell( 145 , 5, '', 0, 0, 'C');
            $this->Cell( 15 , 5, 'Total cargos:', 0, 0, 'C');
            $this->Cell( 30 , 5, '$'.number_format($totalescargo,2), 0, 0, 'C');
            $this->Cell( 15 , 5, 'Total abonos:', 0, 0, 'C');
            $this->Cell( 30 , 5, '$'.number_format($totalesabono,2), 0, 0, 'C');
            $this->Cell( 15 , 5, 'Diferencia:', 0, 0, 'C');
            if ($totalesabono>$totalescargo){
                $difencia=$totalesabono-$totalescargo;
            }else{
                $difencia=$totalescargo-$totalesabono;
            }
            $this->Cell( 30 , 5, '$'.number_format($difencia,2), 0, 0, 'C');
            $this->ln();
            $this->ln();
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