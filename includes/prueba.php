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
    $unix_today=$unix_time;

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
    //var_dump($unix_time);

    //se realiza la consulta de las reservaciones y se asignan las reservaciones en la matriz segun el dia en que tiene la reserva
    $reservaciones=$reservacion->reservas_por_hab();
    while ($fila = mysqli_fetch_array($reservaciones)) {
        //var_dump($fila);
        $entrada=$fila['fecha_entrada'];
        $salida=$fila['fecha_salida'];
        if ($unix_today>=$entrada){
            $diferencia=$salida-$unix_today;
            if ($diferencia==0){
                $diferencia=86400;
            }
        }else{
            $diferencia=$salida-$entrada;
        }
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
            "reserva_id" => $fila['reserva_id'],
            "dias_reservados" => $dias_reservados
        );
        for ($i=0; $i<$dias_reservados; $i++){
            if ($unix_today>=$entrada){
                $matriz[$id_hab-1][$posicion+$i]=$datos;
            }else{
                $matriz[$id_hab-1][$posicion+$i+1]=$datos;
            }
            
        }
        $datos=[];
    }
    //var_dump($matriz);
    //funcion para imprimir la matiz
    for($i=0; $i<$nIds; $i++){
        echo '<div class="rack_habitacion">';
        echo'<div class="task_calendario nombre_hab" style="border-color: #'.$lColor[$i].' ">
                <p>Hab. '.$lNombres[$i].' </p>
            </div>';
        for($j=0; $j<=30; $j++){
            if ($matriz[$i][$j] !="-"){
                $aux=$matriz[$i][$j]['dias_reservados'];
                $anchura=150*($aux);

                $estadoHab = "vacia_sucia";
                //Switch para el estado de la habitacion 
                switch ($estadoHab) {
                    case "ocupado":
                        $estadoCss = "diaTask_ocupado";
                        $estado = "Ocupado";
                        $icono = '
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>';
                        break;
                    case "uso_casa":
                        $estadoCss = "diaTask_uso_casa";
                        $estado = "Uso casa";
                        $icono = '
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                                    <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293z"/>
                                </svg>';
                        break;
                    case "vacia_sucia":
                        $estadoCss = "diaTask_vacia_sucia";
                        $estado = "Vacia sucia";
                        $icono = '
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                                </svg>';
                        break;

                }

                echo'
                    <div class="task_calendario diaTask diaTask_estado '.$estadoCss.' " style="width:'.$anchura.'px !important">
                        <div class="task_calendario_status">
                            <p>'.$icono.'</p>
                            <p>Jose Figueroa</p>
                        </div>
                        <div class="task_calendario_status">
                            <p>'.$estado.'</p>
                        </div>
                    </div>';
                $j=$j+($aux-1);
            }
            else{
                echo'
                    <div class="task_calendario diaTask diaTask_disponible" >
                        <div class="task_calendario_status">
                            <p>Agregar</p>
                        </div>
                    </div>';
            }
            
        }
        echo '</div>';
    }

    /* echo json_encode($matriz) */
?>