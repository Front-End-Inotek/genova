<?php

    //Check if there's any special rules for pricing / availability
    $query_CheckForSpecialPricing = "SELECT th.id, th.nombre, rb.precio, rb.fecha, rb.disponibles,
    rb.extra_adulto_tipo_1,
    rb.extra_adulto_tipo_2,
    rb.id as ruleId
    FROM tarifa_hospedaje th
    LEFT JOIN reservas_bloqueos rb ON th.id = rb.tipo_hab
    WHERE rb.fecha BETWEEN '$initialDate' AND '$endDate'
    AND th.id < 3
    AND rb.canal = 3;
    ";
    //Iterate over the results and create an object with the averaged pricing for the selected allowance period
    $roomData = [];

    $result_SpecialPrincing = $conexion->realizaConsulta($query_CheckForSpecialPricing, '');
    if ($result_SpecialPrincing->num_rows > 0) {
    while ($row = $result_SpecialPrincing->fetch_assoc()) {
    $roomId = $row["id"];
    $price = $row["precio"];
    $extra = $row["extra_adulto_tipo_1"];
    $extra2 = $row["extra_adulto_tipo_2"];
    $ruleId= $row['ruleId'];


    if (!isset($roomData[$roomId])) {
    $roomData[$roomId] = [
        'name' => $row["nombre"],
        'price' => [],
        'averagePrice' => 0,
        'count' => 0,
        'available' => $row['disponibles'],
        'totalprice' => 0,
        'descripcion' => 0,
        'image' => 0, 
        'additional' => 0,
        'extraPrice' => 0,
        'highestPrice' => 0,
        'ruleId' => [],

    ];

    }
    array_push($roomData[$roomId]['price'], $price);
    array_push($roomData[$roomId]['ruleId'], $ruleId);

    if ($roomData[$roomId]['available'] != 0){
    $roomData[$roomId]['available'] = $row['disponibles'];
    }

    if($cantidadPersonas >= 3 && $extra != null){
    $roomData[$roomId]['additional'] =  $extra;
    } 

    if($roomData[$roomId]['highestPrice'] < $price){
        $roomData[$roomId]['highestPrice'] = $price;
    }

    if($cantidadPersonas == 4 && $extra != null){
    $roomData[$roomId]['additional'] = $roomData[$roomId]['additional'] +  $extra2;
    }
    $roomData[$roomId]['count'] += 1;
    }

    }

    $query_CheckDefaultPricing = " SELECT th.id AS id,     
    th.total_tipo - COALESCE(COUNT(r.tipo_hab), 0) AS cantidad,
    th.nombre AS tipo_habitacion,
    th.descripcion,
    th.img as img,
    thp.cantidad_maxima,
    thp.precio_adulto as extra,
    thp.tarifa_paypal as precio
    FROM tipo_hab th
    LEFT JOIN reservacion r ON th.id = r.tipo_hab
    AND (r.fecha_entrada BETWEEN $initialDateUnix AND $endDateUnix
        OR r.fecha_salida BETWEEN $initialDateUnix AND $endDateUnix)
    LEFT JOIN tarifa_hospedaje thp ON th.id = thp.id
    WHERE thp.cantidad_maxima >= $cantidadPersonas AND th.id <3
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
    $extra= $row['extra'];
    if (!isset($roomData[$roomId])) {
    $roomData[$roomId] = [
        'name' => $row["tipo_habitacion"],
        'price' => [],
        'averagePrice' => 0,
        'count' => 0,
        'available' => $row['cantidad'],
        'totalprice' => 0,
        'descripcion' => 0,
        'img' => 0, 
        'additional' => 0,
        'extraPrice' => 0,
        'highestPrice' => 0,
        'ruleId' => [],

    ];

    }
    $roomData[$roomId]['descripcion'] = $descripcion ;
    $roomData[$roomId]['img'] = $image ;
    $roomData[$roomId]['count'] += 1;
    if($roomData[$roomId]['available'] == null){
    $roomData[$roomId]['available'] = $row["cantidad"] ;
    }

    if($cantidadPersonas >= 3 && $roomData[$roomId]['additional'] == null){
            $roomData[$roomId]['additional'] =  $extra;
            $roomData[$roomId]['extraPrice'] =  $extra;
            if($cantidadPersonas == 4){
                $roomData[$roomId]['additional'] = $roomData[$roomId]['additional'] +  $extra;
                echo $roomData[$roomId]['additional'] . ', ';
            }
        } 
        


    if($roomData[$roomId]['highestPrice'] < $price){
            $roomData[$roomId]['highestPrice'] = $price;
        }

    while(sizeof($roomData[$roomId]['price']) < ($allowanceDays)){
    array_push($roomData[$roomId]['price'], $price);
    }
    $intArray = array_map('intval', $roomData[$roomId]['price']);
    $roomData[$roomId]['averagePrice'] =  (array_sum($intArray)) / sizeof($intArray);
    $roomData[$roomId]['price'] = (array_sum($intArray)) + ($roomData[$roomId]['additional'] * $allowanceDays);
        }
    }