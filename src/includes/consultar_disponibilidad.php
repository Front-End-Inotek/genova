<?php
#region Migrations
    //ALTER TABLE configuracion ADD COLUMN motor_reservas_activado INT(11) DEFAULT 1;
#endregion

    include_once("consulta.php");
    $conexion = new ConexionMYSql();
    $initialDate = strtotime($_GET['initial']);
    $endDate = strtotime($_GET['end']);       
    $cantidadPersonas = $_GET['guests']; 

$sentencia3 = "SELECT motor_reservas_activado FROM configuracion";
$puedeReservar = mysqli_fetch_array($conexion->realizaConsulta($sentencia3, ""))['motor_reservas_activado'];
$hayDisponibles = false;

if($puedeReservar == 1){

//Agregar filtros de busqueda
    $sentencia = "SELECT th.id AS tipo_hab, COALESCE(COUNT(r.tipo_hab), 0) AS cantidad, 
        th.nombre AS tipo_habitacion,
        th.descripcion,
        th.img as imagen,
        thp.cantidad_maxima,
        thp.tarifa_paypal as precio
    FROM tipo_hab th
    LEFT JOIN reservacion r ON th.id = r.tipo_hab
            AND (r.fecha_entrada BETWEEN $initialDate AND $endDate
            OR r.fecha_salida BETWEEN $initialDate AND $endDate)
    LEFT JOIN tarifa_hospedaje thp ON th.id = thp.id
    WHERE thp.cantidad_maxima >= $cantidadPersonas AND th.id < 3
    GROUP BY th.id, th.nombre, thp.cantidad_maxima, th.descripcion, th.img, thp.tarifa_paypal
    ORDER BY th.id;
    "; 

    $sentencia2 = "SELECT h.tipo, COUNT(*) AS cantidad
    FROM hab h
    LEFT JOIN tarifa_hospedaje th ON h.tipo = th.id
    WHERE th.cantidad_maxima >= $cantidadPersonas
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
    $precios = [];
    
    
    while ($fila = mysqli_fetch_array($resultado)) {
        array_push($noDisponibleCantidad, $fila['cantidad']);
        array_push($disponibleNombre, $fila['tipo_habitacion']);
        array_push($descripcion, $fila['descripcion']);
        array_push($imagenes, $fila['imagen']);
        array_push($precios, $fila['precio']);
        
    }
    
    while ($fila2 = mysqli_fetch_array($resultado2)) {
        array_push($totalCantidad, $fila2['cantidad']);
            array_push($totalID, $fila2['tipo']);
    }
    
    for ($i = 0; $i < sizeof($disponibleNombre); $i++) {
        $totalCantidad[$i] = $totalCantidad[$i] - $noDisponibleCantidad[$i];
        //echo $totalCantidad[$i];
        if ($totalCantidad[$i] >= 1) {
            $hayDisponibles = true;
            break;
        }
    }
}


if ($hayDisponibles) {
    for ($i = 0; $i < sizeof($disponibleNombre); $i++){
        if($totalCantidad[$i]>= 1){
            echo '
                <label for="'. $totalID[$i] .'" class="card_hab">
                    <div class="card_hab_header">
                        <img src="./public/roomDescription/'.$imagenes[$i].'" loading="lazy" />
                    </div>
                    <div class="card_body">
                        <h5>' .$disponibleNombre[$i].'</h5>
                        <h6> '.$descripcion[$i].' </h6> 
                        <h6>Noche <span class="card_money" >$'.$precios[$i].'</span> </h6>
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
                        <label  class="btn_select" >
                            <input type="radio" name="hab" id="'. $totalID[$i] .'" value="'. $totalID[$i] .'" onclick="selectCard(this)" />
                            Seleccionar
                        </label>
                    </div>
                </label>
                ';
            } 
    }
} else {
    echo '
        <div class="card" style="width: 18rem;">
            <h1>Sin habitaciones disponibles</h1>
    </div>
    ';
}



