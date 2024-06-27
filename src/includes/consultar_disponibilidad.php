<?php
    include_once("consulta.php");
    $conexion = new ConexionMYSql();
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);        

    
//Agregar filtros de busqueda


$sentencia = "SELECT tipo_hab, COUNT(*) AS cantidad
FROM reservacion
WHERE (fecha_entrada BETWEEN $initialDate AND $endDate)
AND (fecha_salida BETWEEN $initialDate AND $endDate)
GROUP BY tipo_hab
";
echo $initialDate . "  " . $endDate;
$resultado = $conexion->realizaConsulta($sentencia, "");
$fila = mysqli_fetch_array($resultado);
var_dump($fila);

// while ($fila = mysqli_fetch_array($resultado)) {
//     // echo '
//     // <div class="card_hab">
//     //     <div class="card_hab_header">
//     //         <img src="https://images.pexels.com/photos/1457842/pexels-photo-1457842.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" />
//     //     </div>
//     //     <div class="card_body">
//     //         <h5>Hab continental</h5>
//     //         <div class="card_body_info">
//     //             <img src="./src/assets/svg/air.svg" />
//     //             <p>Aire acondionado</p>
//     //         </div>
//     //         <div class="card_body_info">
//     //             <img src="./src/assets/svg/tv.svg" />
//     //             <p>TV</p>
//     //         </div>
//     //         <div class="card_body_info">
//     //             <img src="./src/assets/svg/wifi.svg" />
//     //             <p>Wifi gratis</p>
//     //         </div>

//     //         <button class="btn_select" >Seleccionar</button>
//     //     </div>
//     // </div>
//     // ';

