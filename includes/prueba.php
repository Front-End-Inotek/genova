<?php
    date_default_timezone_set('America/Mexico_City');
    //se realizan las importaciones de los archivos que se van a requerir
    include_once "clase_reservacion.php";
    include_once "clase_hab.php";
    $reservacion= NEW Reservacion(0);
    $hab=NEW Hab(0);

    //se llena una lista con los ids de cada una de las habitaciones que se tienen registradas y activas
    $Habs=$hab->numero_de_hab();
    $lIds=[];
    $lNombres=[];
    $lColor=[];
    while ($fila = mysqli_fetch_array($Habs)) {
        array_push($lIds,$fila['id']);
        array_push($lNombres,$fila['nombre']);
        array_push($lColor, $fila['color']);
    }
    //var_dump($lColor);
    $nIds=count($lIds);

    //encabezado
    /* echo'
    <h1>matriz</h1>
    '; */

    // se inicializan las matrices y se saca el tiempo unix del dia de hoy
    $matriz=[];
    $lHab=[];
    $lDias=[];
    $now = new DateTime();
    $midnight = new DateTime($now->format('Y-m-d') . ' 00:00:00');
    $unix_time = $midnight->getTimestamp();

    //se llena una matriz vacia de nxm n son la cantidad de habitaciones activas m es el numero de dias
    for($i=0; $i<=$nIds; $i++){
        for($j=0; $j<=30; $j++){
            array_push($lHab,"-");
        }
        array_push($matriz,$lHab);
    }

    //se crea una lista donde contiene los dias a partir del dia de hoy en tiempo unix con la finalidad de obtener el indice del dia
    for ($i=0; $i<=100;$i++){
        array_push($lDias,$unix_time);
        $unix_time=$unix_time+86400;
    }

    //se realiza la consulta de las reservaciones y se asignan las reservaciones en la matriz segun el dia en que tiene la reserva
    $reservaciones=$reservacion->reservas_por_hab();
    while ($fila = mysqli_fetch_array($reservaciones)) {
        //var_dump($fila);
        $entrada=$fila['fecha_entrada'];
        $salida=$fila['fecha_salida'];
        $diferencia=$salida-$entrada;
        $dias_reservados=$diferencia/86400;
        //echo $dias_reservados;
        $id_hab=$fila['id'];
        $posicion = array_search($entrada, $lDias);
        $datos = array(
            "id" => $fila['id'],
            "nombre" => $fila['nombre'],
            "fecha_entrada" => $fila['fecha_entrada'],
            "fecha_salida" => $fila['fecha_salida'],
            "estado" => $fila['estado'],
            "garantia" => $fila['garantia'],
            "interno" => $fila['interno'],
            "n_huesped" => $fila['n_huesped'],
            "a_huesped" => $fila['a_huesped'],
            "mov" => $fila['mov'],
            "reserva_id" => $fila['reserva_id']
        );
        for ($i=0; $i<$dias_reservados; $i++){
            $matriz[$id_hab-1][$posicion+$i]=$datos;
        }
        $datos=[];
    }
    //funcion para imprimir la matiz
    for($i=0; $i<$nIds; $i++){
        echo '<div class="rack_habitacion">';
        echo'<div class="task_calendario nombre_hab" style="border-color: #'.$lColor[$i].' ">
                <p>Hab. '.$lNombres[$i].' </p>
            </div>';
        for($j=0; $j<=30; $j++){
            if ($matriz[$i][$j]!="-"){
                //var_dump($matriz[$i][$j]);
                echo'
                    <div class="task_calendario diaTask diaTask_ocupado diaTask_estado" >
                        <p>Ocupado</p>
                    </div>';
            }
            else{
                echo'
                    <div class="task_calendario diaTask diaTask_disponible" >
                        <p></p>
                    </div>';
            }
            
        }
        echo '</div>';
    }

    /* echo json_encode($matriz) */
?>