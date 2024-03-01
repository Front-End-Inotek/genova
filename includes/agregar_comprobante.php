<?php

$folio = $_GET['folio'];
//$folio = 2;

echo '

    <div class="main_container">
    <header class="main_container_title">
        <h2 >Agregar compronte: '.$folio.' </h2>
    </header>

    <div class="contenedor_imagenes_fact">
        
        <img src="./assets/image.svg"/>

        <input type="file" id="inputFile" accept="image/*">
        <button type="button" class="btn btn-primary" onclick="guardarComprobante('.$folio.')" >Guardar imagen</button>
    </div>
    </div>

';


?>