<?php
    include_once("consulta.php");
    $conexion = new ConexionMYSql();
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);       
    $cantidadPersonas = $_GET['guests']; 

//Agregar filtros de busqueda
$sentencia = "SELECT th.id AS tipo_hab, COALESCE(COUNT(r.tipo_hab), 0) AS cantidad, th.nombre AS tipo_habitacion
FROM tipo_hab th
LEFT JOIN reservacion r ON th.id = r.tipo_hab
    AND (r.fecha_entrada BETWEEN $initialDate AND $endDate
    OR r.fecha_salida BETWEEN $initialDate AND $endDate)
GROUP BY th.id, th.nombre
ORDER BY th.id;
"; 

$sentencia2 = "SELECT tipo, COUNT(*) AS cantidad
FROM hab 
WHERE estado = 0 OR estado = 2 OR estado = 3
GROUP BY tipo
"; 

$resultado = $conexion->realizaConsulta($sentencia, "");
$resultado2 = $conexion->realizaConsulta($sentencia2, "");
$noDisponibleCantidad = [];
$disponibleNombre= [];
$totalCantidad = [];
$totalID = [];


while ($fila = mysqli_fetch_array($resultado)) {
    array_push($noDisponibleCantidad, $fila['cantidad']);
    array_push($disponibleNombre, $fila['tipo_habitacion']);
}

while ($fila2 = mysqli_fetch_array($resultado2)) {
    array_push($totalCantidad, $fila2['cantidad']);
    array_push($totalID, $fila2['tipo']);
}

for ($i = 0; $i < sizeof($disponibleNombre); $i++){
    $totalCantidad[$i] = $totalCantidad[$i] - $noDisponibleCantidad[$i];
    if($totalCantidad[$i]>= 1){
        echo '
            <div class="card_hab">
                <div class="card_hab_header">
                    <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
                </div>
                <div class="card_body">
                    <h5>' .$disponibleNombre[$i].'. Disponible: '.$totalCantidad[$i].'</h5>
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

                    <button class="btn_select" value="'. $totalID[$i] . '">Seleccionar</button>
                </div>
            </div>
            ';
        }
} 


