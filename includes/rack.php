<?php
echo '
<main class="calenderMain">
    <header class="calenderHeader">
        <h1 id="fecha_hoy"></h1>
    </header>

    <div class="calendario">
        <div class="contenedor_fechas" id="dias">
            <div class="task_calendario" style="width: 225px;border-bottom: 0.3px solid rgba(0,0,0, 0.164); border-right: 0.3px solid rgba(0, 0, 0, 0.164)" ></div>
        </div>
        <div class="calendario_habitacion">
            <div class="task_calendario" >Habitacion 1</div>
            <div class="task_calendario diaTask diaTask_disponible" >
                <p>Disponible</p>
            </div>
            <div class="task_calendario diaTask diaTask_ocupado" >
                <p>Ocupado</p>
            </div>
            <div class="task_calendario diaTask diaTask_uso_casa" >
                <p>Uso casa</p>
            </div>
            
            
        </div>
        
</main>

<!-- <script src="js/rack.js"></script> -->
<script>mostrarCalentario()</script>

';

?>