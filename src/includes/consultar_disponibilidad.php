<?php
#region Migrations
    //CREATE TABLE plaza_genova.reservas_bloqueos ( id INT AUTO_INCREMENT PRIMARY KEY NOT NULL, fecha TIMESTAMP NOT NULL, cantidad INT NOT NULL, tipo INT NOT NULL );
    //ALTER TABLE configuracion ADD COLUMN motor_reservas_activado INT(11) DEFAULT 1;

#endregion



#region Headers/ Objects 
    include_once("consulta.php");
    $conexion = new ConexionMYSql();

#endregion



#region Main variables 
    $initialDateUnix = strtotime($_GET['initial']);
    $endDateUnix = strtotime($_GET['end']);       
    $initialDate = $_GET['initial'];
    $endDate = $_GET['end'];
    $initial = new DateTime($initialDate);
    $end =  new DateTime($endDate);
    $allowanceDays = $initial->diff($end)->days;
    $cantidadPersonas = $_GET['guests']; 
    $hayDisponibles = false;
    
#endregion


#region Main Logic
    //Check if engine is enabled from visit, if not, close script
    if(!CheckIfEngineIsOpen($conexion)) {
        echo ' <div class="card" style="width: 18rem;"> <h1>No hay disponibilidad, contactenos para mas informacion</h1> </div> ';
        die();  
    }    
    
    //Check if there's any rooms with special pricing / availability
    $query_CheckForSpecialPricing = "SELECT th.id, th.nombre, rb.precio, rb.fecha, rb.disponibles
                FROM tarifa_hospedaje th
                LEFT JOIN reservas_bloqueos rb ON th.id = rb.tipo_hab
                WHERE rb.fecha BETWEEN '$initialDate' AND '$endDate'
                AND th.id < 3
                AND rb.canal = 1;
    ";

    //Iterate over the results and create an object with the averaged pricing for the selected allowance period
    $roomData = [];

    $result_SpecialPrincing = $conexion->realizaConsulta($query_CheckForSpecialPricing, '');
    if ($result_SpecialPrincing->num_rows > 0) {
        while ($row = $result_SpecialPrincing->fetch_assoc()) {
            $roomId = $row["id"];
            $price = $row["precio"];

            if (!isset($roomData[$roomId])) {
                $roomData[$roomId] = [
                    'name' => $row["nombre"],
                    'price' => [],
                    'count' => 0,
                    'available' => $row['disponibles'],
                    'totalprice' => 0,
                    'descripcion' => 0,
                    'image' => 0

                ];
            }
            array_push($roomData[$roomId]['price'], $price) ;
            $roomData[$roomId]['available'] = $row['disponibles'];

            $roomData[$roomId]['count'] += 1;
        }

    }

    $query_CheckDefaultPricing = " SELECT th.id AS id,     
                th.total_tipo - COALESCE(COUNT(r.tipo_hab), 0) AS cantidad,
                th.nombre AS tipo_habitacion,
                th.descripcion,
                th.img as img,
                thp.cantidad_maxima,
                thp.tarifa_paypal as precio
                FROM tipo_hab th
                LEFT JOIN reservacion r ON th.id = r.tipo_hab
                  AND (r.fecha_entrada BETWEEN $initialDate AND $endDate
                    OR r.fecha_salida BETWEEN $initialDate AND $endDate)
                LEFT JOIN tarifa_hospedaje thp ON th.id = thp.id
                WHERE thp.cantidad_maxima >= $cantidadPersonas AND th.id < 3
                GROUP BY th.id
    ";

    $result_DefaultPrincing = $conexion->realizaConsulta($query_CheckDefaultPricing, '');
    if ($result_DefaultPrincing->num_rows > 0) {
        while ($row = $result_DefaultPrincing->fetch_assoc()) {
            $roomId = $row["id"];
            $price = $row["precio"];
            $descripcion = $row["descripcion"];
            $image = $row["img"];
            $available = $row["cantidad"];

            if (!isset($roomData[$roomId])) {
                $roomData[$roomId] = [
                    'name' => $row["tipo_habitacion"],
                    'price' => [],
                    'count' => 0,
                    'available' => $row['cantidad'],
                    'totalprice' => 0,
                    'descripcion' => 0,
                    'img' => 0
                ];

            }
            array_push($roomData[$roomId]['price'], $price) ;
            $roomData[$roomId]['descripcion'] = $descripcion ;
            $roomData[$roomId]['img'] = $image ;
            $roomData[$roomId]['count'] += 1;
            if($roomData[$roomId]['available'] == null)$roomData[$roomId]['available'] = $row["cantidad"] ;

            while(sizeof($roomData[$roomId]['price']) < $allowanceDays){
                array_push($roomData[$roomId]['price'], $price);
            }
            $intArray = array_map('intval', $roomData[$roomId]['price']);
            $roomData[$roomId]['price'] = (array_sum($intArray) / sizeof($roomData[$roomId]['price']));

        }
        

            // foreach ($roomData as $room => $data){
            //         echo "Name: " . $data['name'] . " - Price per night: ".number_format($data['price'], 2). "<br>";
            // }
    }

    foreach ($roomData as $roomId => $data) {
        if($data['available'] > 0){
            $hayDisponibles = true;
        }
    }

// $sentencia2 = "SELECT h.tipo, COUNT(*) AS cantidad
//         FROM hab h
//         LEFT JOIN tarifa_hospedaje th ON h.tipo = th.id
//         WHERE th.cantidad_maxima >= $cantidadPersonas
//         GROUP BY h.tipo;
//         "; 

//         $sentencia3 = "SELECT *  from reservas_bloqueos WHERE fecha BETWEEN $initialDate AND $endDate";

//         $resultadoDisponibilidad = $conexion->realizaConsulta($sentencia3,"");  
//         $alaVenta = [0, 0, 0];

//         while ($fila3 = mysqli_fetch_array($resultadoDisponibilidad)) {
//                 $alaVenta[$fila3['tipo']] = $fila3['cantidad'];
//         }



//         $resultado = $conexion->realizaConsulta($sentencia, "");
//         $resultado2 = $conexion->realizaConsulta($sentencia2, "");
//         $noDisponibleCantidad = [];
//         $disponibleNombre= [];
//         $totalCantidad = [];
//         $totalID = [];
//         $descripcion = [];
//         $imagenes = [];
//         $precios = [];
//         $preciosEspeciales = [];

        
        
//         while ($fila = mysqli_fetch_array($resultado)) {
//             array_push($noDisponibleCantidad, $fila['cantidad']);
//             array_push($disponibleNombre, $fila['tipo_habitacion']);
//             array_push($descripcion, $fila['descripcion']);
//             array_push($imagenes, $fila['imagen']);
//             array_push($preciosEspeciales, $fila['precio_especial']);
//             array_push($precios, $fila['precio']);
        
//         }
        
//         while ($fila2 = mysqli_fetch_array($resultado2)) {
//             array_push($totalCantidad, $fila2['cantidad']);
//             array_push($totalID, $fila2['tipo']);
//         }

        
//         for ($i = 0; $i < sizeof($disponibleNombre); $i++) {
//             if($alaVenta){ 
//                 $totalCantidad[$i] = $alaVenta[$i] - $noDisponibleCantidad[$i];
//             }
//             else {
//                 $totalCantidad[$i] = $totalCantidad[$i] - $noDisponibleCantidad[$i];
//             }
//             if ($totalCantidad[$i] >= 1) {
//                 $hayDisponibles = true;
//                 break;
//             }
//         }
// #endregion


if ($hayDisponibles) {
    foreach ($roomData as $roomId => $data) {
        if($data['available'] < 1){
            continue;
        }
    echo '
        <label for="'. $data['name'] .'" class="card_hab">
                    <div class="card_hab_header">
                        <img src="./public/roomDescription/'.$data['img'].'" loading="lazy" />
                    </div>
                    <div class="card_body">
                        <h5>' .$data['name'].'</h5>
                        <h6> '.$data['descripcion'].' </h6> 
                        <h6>Noche <span class="card_money" >$'.number_format($data['price'], 1).'</span> </h6>
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
                            <input type="radio" name="hab" id="'. $data['name'] .'" value="'. $data['name'].'" onclick="selectCard(this)" />
                            Seleccionar
                        </label>
                    </div>
                </label>';
            }   
        }
            else {
                echo ' <div class="card" style="width: 18rem;"> <h1>Sin habitaciones disponibles</h1> </div>
    ';
}




#region Methods
    function CheckIfEngineIsOpen($conexion){
        $sentencia3 = "SELECT motor_reservas_activado FROM configuracion";
        $puedeReservar = mysqli_fetch_array($conexion->realizaConsulta($sentencia3, ""))['motor_reservas_activado'];
        return $puedeReservar;
    }



#endregion