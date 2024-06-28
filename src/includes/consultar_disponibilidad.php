<?php
    include_once("consulta.php");
    $conexion = new ConexionMYSql();
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);       
    $cantidadPersonas = $_GET['guests']; 

//Agregar filtros de busqueda
$sentencia = "SELECT th.id AS tipo_hab, COALESCE(COUNT(r.tipo_hab), 0) AS cantidad, 
    th.nombre AS tipo_habitacion,
    th.descripcion,
    th.img as imagen,
    thp.cantidad_maxima
FROM tipo_hab th
LEFT JOIN reservacion r ON th.id = r.tipo_hab
        AND (r.fecha_entrada BETWEEN $initialDate AND $endDate
        OR r.fecha_salida BETWEEN $initialDate AND $endDate)
LEFT JOIN tarifa_hospedaje thp ON th.id = thp.id
WHERE thp.cantidad_maxima >= $cantidadPersonas
GROUP BY th.id, th.nombre, thp.cantidad_maxima, th.descripcion, th.img
ORDER BY th.id;
"; 


$sentencia2 = "SELECT h.tipo, COUNT(*) AS cantidad
FROM hab h
LEFT JOIN tarifa_hospedaje th ON h.tipo = th.id
WHERE h.estado IN (0, 2, 3)
  AND th.cantidad_maxima >= $cantidadPersonas
GROUP BY h.tipo;
"; 

$resultado = $conexion->realizaConsulta($sentencia, "");
$resultado2 = $conexion->realizaConsulta($sentencia2, "");
$noDisponibleCantidad = [];
$disponibleNombre= [];
$totalCantidad = [];
$totalID = [];
$descripcion = [];
$imagenes = [];


while ($fila = mysqli_fetch_array($resultado)) {
    array_push($noDisponibleCantidad, $fila['cantidad']);
    array_push($disponibleNombre, $fila['tipo_habitacion']);
    array_push($descripcion, $fila['descripcion']);
    array_push($imagenes, $fila['imagen']);
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
                    <img src="'.$imagenes[$i].'" />
                </div>
                <div class="card_body">
                    <h5>' .$disponibleNombre[$i].'</h5>
                    <h6> '.$descripcion[$i] .' </h6>
                    <div class="card_body_info">
                        <img src="./src/assets/svg/available.svg" />
                        <p>Disponible '.$totalCantidad[$i].'</p>
                    </div>
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


