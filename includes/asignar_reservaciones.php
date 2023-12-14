<?php 
    date_default_timezone_set('America/Mexico_City');
    $numero_reserva = $_GET['id_reserva'];

    echo '
    <div class="main_container">
        <div class="main_container_title">
            <h2>Asignar habitaciones a la reserva '.$numero_reserva.' </h2>
        </div>


    </div>
    '

?>