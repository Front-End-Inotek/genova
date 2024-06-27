<?php
    include_once("consulta.php");
    $conexion = new ConexionMYSql();
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);        

    
//Agregar filtros de busqueda


$sentencia = "SELECT h.nombre AS nombre_habitacion, th.nombre AS tipo_habitacion
FROM hab h
JOIN tipo_hab th ON h.tipo = th.id
WHERE h.id NOT IN (
    SELECT m.id_hab
    FROM movimiento m
    WHERE m.fin_hospedaje > $initialDate
    AND m.inicio_hospedaje < $endDate
);";

$resultado = $conexion->realizaConsulta($sentencia, "");
//var_dump($resultado);
while ($fila = mysqli_fetch_array($resultado)) {
    echo '
    <div class="card_hab">
        <div class="card_hab_header">
            <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
        </div>
        <div class="card_body">
            <h5>Hab continental</h5>
            <div class="card_body_info">
                <img src="./src/assets/svg/air.svg" />
                <p>Aire acondionado</p>
            </div>
            <div class="card_body_info">
                <img src="./src/assets/svg/tv.svg" />
                <p>TV</p>
            </div>
            <div class="card_body_info">
                <img src="./src/assets/svg/wifi.svg" />
                <p>Wifi gratis</p>
            </div>

            <button class="btn_select" >Seleccionar</button>
        </div>
    </div>
    ';
}