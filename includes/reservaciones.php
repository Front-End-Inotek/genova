<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Reservaciones</title>
    <style>
        /* Estilos CSS para la vista de rejilla */
        .grid {
            display: grid;
            grid-template-columns: repeat(31, 1fr);
            
        }

        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .ocupada {
            background-color: red;
        }

        .reservada {
            background-color: yellow;
        }
        .vacia {
            background-color: blue;
        }
        .ajuste{
            width:100%;
        }
    </style>
</head>
<body>
<?php
date_default_timezone_set('America/Mexico_City');
// Simulación de datos de habitaciones y reservaciones
$habitaciones = array(
    array('id' => 1, 'estado' => 'ocupada', 'fecha_entrada' => '2023-06-08', 'fecha_salida' => '2023-06-10'),
    array('id' => 2, 'estado' => 'reservada', 'fecha_entrada' => '2023-06-10', 'fecha_salida' => '2023-06-12'),
    array('id' => 3, 'estado' => 'ocupada', 'fecha_entrada' => '2023-06-08', 'fecha_salida' => '2023-06-12'),
    array('id' => 4, 'estado' => 'reservada', 'fecha_entrada' => '2023-06-16', 'fecha_salida' => '2023-06-17'),
    // array('id_habitacion' => 4, 'estado' => 'reservada', 'fecha_reservacion' => '2023-06-17', 'fecha_entrada' => '2023-06-15'),
);

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Obtener la fecha actual más 30 días
$fechaLimite = date('Y-m-d', strtotime('+30 days'));

// // Crear matriz para almacenar los estados de las habitaciones
// $habitacionesEstado = array();
// foreach ($habitaciones as $habitacion) {
//     $idHabitacion = $habitacion['id_habitacion'];
//     $estado = $habitacion['estado'];

//     if (!isset($habitacionesEstado[$idHabitacion])) {
//         $habitacionesEstado[$idHabitacion] = array();
//     }

//     if ($estado == 'ocupada') {
//         // Habitación ocupada
//         $fechaOcupada = $habitacion['fecha_ocupada'];
//         $fechaSalida = $habitacion['fecha_salida'];
//         $habitacionesEstado[$idHabitacion][$fechaOcupada] = array('class' => 'occupied', 'fecha_salida' => $fechaSalida);
//     } elseif ($estado == 'reservada') {
//         // Habitación reservada
//         $fechaReservacion = $habitacion['fecha_reservacion'];
//         $fechaEntrada = $habitacion['fecha_entrada'];
//         $habitacionesEstado[$idHabitacion][$fechaReservacion] = array('class' => 'reserved', 'fecha_entrada' => $fechaEntrada);
//     }
// }

// Imprimir la vista de rejilla
echo '<div class="grid">';
echo '<div class="grid-item">Habitación</div>';
for ($i = 0; $i <= 29; $i++) {
    $fecha = date('Y-m-d', strtotime("+$i days"));
    echo '<div class="grid-item">' . $fecha . '</div>';
}

$old_fecha="";
$old_reserva="";
$tiempo_aux = time();

$tiempo_n = time();

foreach ($habitaciones as $idHabitacion => $reservacion) {
    echo '<div class="grid-item">' . $reservacion['id'] . '</div>';
   
    // die();
    for ($i = 0; $i <= 29; $i++) {
    while(date('Y-m-d', $tiempo_aux) < $reservacion['fecha_salida']) {
        if(date('Y-m-d', $tiempo_aux) == $reservacion['fecha_entrada']){
            echo '<div class="grid-item ocupada" style="border:0px;">' . date('Y-m-d', $tiempo_aux) . '</div>';
            if(true){
                echo '<div class="grid-item ocupada" style="border:0px; width:12%;">' . date('Y-m-d', $tiempo_aux) . '
                </div>';

           
            }else{
                echo '<div class="grid-item ocupada" style="border:0px;">' . date('Y-m-d', $tiempo_aux) . '</div>';
            }
           
            $tiempo_aux += 86400;
            $i++;
            $i++;
            
        }else{
            echo '<div class="grid-item vacia" style="">' . date('Y-m-d', $tiempo_aux) . '</div>';
            $i++;
        }
        // echo date('Y-m-d', $tiempo_aux) ."|". $reservacion['fecha_entrada'];
        $tiempo_aux += 86400;
    }
    
    echo '<div class="grid-item vacia" style="">s</div>';
    }
   
   
    // print_r($fechas);
   
    $tiempo_aux = time();
    // echo date('Y-m-d', $tiempo_aux);   
    // die();
}
echo '</div>';

?>
</body>
</html>