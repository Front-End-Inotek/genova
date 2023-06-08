<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Reservaciones</title>
    <style>
        /* Estilos CSS para la vista de rejilla */
        .grid {
            display: grid;
            grid-template-columns: repeat(31, 1fr);
            grid-gap: 1px;
        }

        .grid-item {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .occupied {
            background-color: red;
        }

        .reserved {
            background-color: yellow;
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
    array('id_habitacion' => 1, 'estado' => 'ocupada', 'fecha_ocupada' => '2023-06-07', 'fecha_salida' => '2023-06-10'),
    array('id_habitacion' => 2, 'estado' => 'reservada', 'fecha_reservacion' => '2023-06-10', 'fecha_entrada' => '2023-06-10'),
    array('id_habitacion' => 3, 'estado' => 'ocupada', 'fecha_ocupada' => '2023-06-08', 'fecha_salida' => '2023-06-12'),
    array('id_habitacion' => 4, 'estado' => 'reservada', 'fecha_reservacion' => '2023-06-16', 'fecha_entrada' => '2023-06-15'),
    // array('id_habitacion' => 4, 'estado' => 'reservada', 'fecha_reservacion' => '2023-06-17', 'fecha_entrada' => '2023-06-15'),
);

// Obtener la fecha actual
$fechaActual = date('Y-m-d');

// Obtener la fecha actual más 30 días
$fechaLimite = date('Y-m-d', strtotime('+30 days'));

// Crear matriz para almacenar los estados de las habitaciones
$habitacionesEstado = array();
foreach ($habitaciones as $habitacion) {
    $idHabitacion = $habitacion['id_habitacion'];
    $estado = $habitacion['estado'];

    if (!isset($habitacionesEstado[$idHabitacion])) {
        $habitacionesEstado[$idHabitacion] = array();
    }

    if ($estado == 'ocupada') {
        // Habitación ocupada
        $fechaOcupada = $habitacion['fecha_ocupada'];
        $fechaSalida = $habitacion['fecha_salida'];
        $habitacionesEstado[$idHabitacion][$fechaOcupada] = array('class' => 'occupied', 'fecha_salida' => $fechaSalida);
    } elseif ($estado == 'reservada') {
        // Habitación reservada
        $fechaReservacion = $habitacion['fecha_reservacion'];
        $fechaEntrada = $habitacion['fecha_entrada'];
        $habitacionesEstado[$idHabitacion][$fechaReservacion] = array('class' => 'reserved', 'fecha_entrada' => $fechaEntrada);
    }
}

// Imprimir la vista de rejilla
echo '<div class="grid">';
echo '<div class="grid-item">Habitación</div>';
for ($i = 0; $i <= 29; $i++) {
    $fecha = date('Y-m-d', strtotime("+$i days"));
    echo '<div class="grid-item">' . $fecha . '</div>';
}

$old_fecha="";
$old_reserva="";
foreach ($habitacionesEstado as $idHabitacion => $fechas) {
    echo '<div class="grid-item">' . $idHabitacion . '</div>';
    for ($i = 0; $i <= 29; $i++) {
        $fecha = date('Y-m-d', strtotime("+$i days"));
        $clase = '';
        $contenido = '';

        if (isset($fechas[$fecha])) {
            $clase = $fechas[$fecha]['class'];
            $contenido = $fecha;

            if ($clase == 'occupied' && isset($fechas[$fecha]['fecha_salida'])) {
                $fechaSalida = $fechas[$fecha]['fecha_salida'];

             
            }
        }

        if ($i == 0) {
            echo '<div class="grid-item ' . $clase . '" style="">' . $contenido . '</div>';
        } else {
            echo '<div class="grid-item ' . $clase . ' ">' . $contenido . '</div>';
        }
       
    }
    
    // print_r($fechas);
    // die();
}
echo '</div>';
?>
</body>
</html>