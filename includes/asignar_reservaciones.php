<?php 
    date_default_timezone_set('America/Mexico_City');
    $numero_reserva = $_GET['id_reserva'];

    echo '
    <div class="main_container">
        <div class="main_container_title">
            <h2>Asignar habitaciones a la reserva '.$numero_reserva.' </h2>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-expansion">
                <thead>
                    <tr class=" text-center">
                        <th>Número</th>
                        <th>Fecha Entrada</th>
                        <th>Fecha Salida</th>
                        <th>Nombre Huésped</th>
                        <th>Noches</th>
                        <th>Tarifa</th>
                        <th>Precio Hospedaje</th>
                        <th>Plan alimentos</th>
                        <th>Extra Adulto</th>
                        <th>Extra Menor</th>
                        <th>Total Estancia</th>
                        <th>Total Pago</th>
                        <th>Forma Pago</th>
                        <th>Preasugnar</th>
                        <th>Herramientas</th>
                    </tr>
                </thead>
            </table>
        </div>


    </div>
    '

?>