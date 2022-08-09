<?php
    include_once("clase_cuenta.php");
    include_once("clase_hab.php");
    include_once("clase_movimiento.php");
    $cuenta= NEW Cuenta(0);
    $hab= NEW Hab(0);
    $movimiento= NEW Movimiento(0);
    $ocupadas= $hab->obtener_ocupadas();
    $disponibles= $hab->obtener_disponibles();
    $salidas= $movimiento->saber_salidas();
    echo '
    <div class="container-fluid Alin-center">';
        $cuenta->resumen_actual($ocupadas,$disponibles,$salidas,$_GET['id']);
        
        /*echo '<p>Este ejemplo demuestra la utilización del control <code>&lt;input type="color"&gt;</code>.</p>
        <label for="muestrario">Color:</label>
        <input type="color" value="#ff0000" id="muestrario">

        <p>Observe cómo el color de los párrafos cambia cuando manipula el selector de colores.
        A medida que realiza cambios en el selector, el color del primer párrafo cambia,
        a manera de previsualización (esto usa el suceso <code>input</code>).
        Cuando cierra el selector, se desencadena el suceso <code>change</code>
        y podemos detectarlo para cambiar todos los párrafos al color elegido.</p>*/
    echo '</div>';  
?>