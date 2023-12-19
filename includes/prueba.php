<?php
    echo'
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="accordion accordion-flush" id="accordionFlushExample">';
        for($i=0; $i<=10; $i++){
            echo'
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse'.+$i.'" aria-expanded="false" aria-controls="flush-collapse'.+$i.'">
                    Accordion Item #1
                    </button>
                </h2>
                <div id="flush-collapse'.+$i.'" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <table class="table table_expansion">
                            <thead>
                                <tr class="table-primary-encabezado text-center">
                                <th>Número aqui</th>
                                <th>Número Habitaciones</th>
                                <th>Fecha Entrada</th>
                                <th>Fecha Salida</th>
                                <th>Nombre Huésped</th>
                                <th>Noches</th>
                                <!-- <th>No. Habitaciones</th> -->
                                <th>Tarifa</th>
                                <th>Precio Hospedaje</th>
                                <th>Plan alimentos</th>
                                <th>Extra Adulto</th>
                                <!-- <th>Extra Junior</th> --->
                                <!-- <th>Extra Infantil</th> --->
                                <th>Extra Menor</th>
                                <th>Total Estancia</th>
                                <th>Total Pago</th>
                                <th>Forma Pago</th>
                                <!-- <th>Límite Pago</th> --->
                                <th>Status</th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>';
            }
            echo'
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
    ';
?>