<?php
    date_default_timezone_set('America/Mexico_City');
    //se realizan las importaciones de los archivos que se van a requerir
    include_once "clase_reservacion.php";
    include_once "clase_hab.php";

    // Funciom para darle estado a la habitaciom

    function setRoomStatus( $hab ) {

        $result = array();
        $estadoHab = "Disponible";
        $estadoCss = "diaTask_disponible";
        $icono = '<span class="material-symbols-outlined">add_circle</span>';
        $dias = 150;
        $nombre = "Disponible";
        $apellido = "";
        $funcion = "mostrar_herramientas()";

        if(is_object($hab)){
        $estado = $hab->estado;
        $dias = 150 * ($hab->dias_reservados);
        $nombre = $hab->n_huesped;
        $apellido = $hab->a_huesped;
        switch ( $estado ) {
            case "ocupado":
                $estadoCss = "diaTask_ocupado diaTask_estado";
                $estadoHab = "Ocupado";
                $icono = '
                        <span class="material-symbols-outlined">
                            night_shelter
                        </span>';
                break;
            case "uso_casa":
                $estadoCss = "diaTask_uso_casa diaTask_estado";
                $estadoHab = "Uso casa";
                $icono = '
                        <span class="material-symbols-outlined">
                            home
                        </span>';
                break;
            case "vacia_sucia":
                $estadoCss = "diaTask_vacia_sucia diaTask_estado";
                $estadoHab = "Vacia sucia";
                $icono = '
                            <span class="material-symbols-outlined">
                                delete
                            </span>';
                break;
            case "limpieza":
                $estadoCss = "diaTask_limpieza diaTask_estado";
                $estadoHab = "Limpieza";
                $icono = '
                    <span class="material-symbols-outlined">
                        cleaning_bucket
                    </span>';
                break;
            case "mantenimiento":
                $estadoCss = "diaTask_mantenimiento diaTask_estado";
                $estadoHab = "Mantenimiento";
                $icono = '
                    <span class="material-symbols-outlined">
                        handyman
                    </span>';
                break;
            case "bloqueado":
                $estadoCss = "diaTask_bloqueado diaTask_estado";
                $estadoHab = "Bloqueado";
                $icono = '
                        <span class="material-symbols-outlined">
                            block
                        </span>';
                break;
            case "1":
                $estadoCss = "diaTask_bloqueado diaTask_estado";
                $estadoHab = "Reservada";
                $icono = '
                        <span class="material-symbols-outlined">
                            menu_book
                        </span>';
                break;
            }
        }
        //$result["dias"] = $hab['dias_reservados'];
        $result["dias"] = $dias;
        $result["estadoCss"] = $estadoCss;
        $result["estado"] = $estadoHab;
        $result["icono"] = $icono;
        $result["nombre"] = $nombre;
        $result["apellido"] = $apellido;
        $result["funcion"] = $funcion;
        
        return $result;
    }

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
        $datos = (object)array(
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
        var_dump($datos);
        for ($i=0; $i<$dias_reservados; $i++){
            if ($unix_today>=$entrada){
                $matriz[$id_hab-1][$posicion+$i]=$datos;
            }else{
                $matriz[$id_hab-1][$posicion+$i+1]=$datos;
            }
            
        }
        //$datos=[];
    }


    //se realiza la consulta de las reservaciones y se asignan las reservaciones en la matriz segun el dia en que tiene la reserva
    $reservaciones=$reservacion->ocupacion_rack();
    while ($fila = mysqli_fetch_array($reservaciones)) {
        //var_dump($fila);
        $entrada=$fila['inicio'];
        $salida=$fila['fin'];
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
        $datos = (object)array(
            "id" => $fila['id'],
            "nombre" => $fila['nombre'],
            "fecha_entrada" => $fila['inicio'],
            "fecha_salida" => $fila['fin'],
            "estado" => $fila['estado'],
            "garantia" => "",
            "interno" => $fila['interno'],
            "n_huesped" => $fila['n_huesped'],
            "a_huesped" => $fila['a_huesped'],
            "mov" => $fila['movimiento'],
            "reserva_id" => "",
            "dias_reservados" => $dias_reservados
        );
        var_dump($datos);
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
            //$bandera = null;
        for($j=0; $j<=30; $j++){
            $estado = $matriz[$i][$j];

            /* if($bandera == $estado ){
                continue;
            } */
            $bandera = $estado;
            $roomStatus = setRoomStatus( $estado );
            $estadoCss  = $roomStatus['estadoCss'];
            $estadoHab  = $roomStatus['estado'];
            $icono      = $roomStatus['icono'];
            $anchura    = $roomStatus['dias'] ;
            $nombre     = $roomStatus['nombre'];
            $apellido   = $roomStatus['apellido'];
            $funcion    = $roomStatus['funcion'];

            echo '
                <div href="#caja_herramientas" class="task_calendario diaTask '.$estadoCss.' " style="width:'.$anchura.'px !important" data-toggle="modal" onclick="'.$funcion.'" >
                    <div class="task_calendario_status">
                        <p>'.$icono.'</p>
                        <p>'.$estadoHab.'</p>
                    </div>
                    <div class="task_calendario_status">
                        <p>'.$nombre.' '.$apellido.'</p>
                    </div>
                </div>
            ';

            //$estado = "diaTask_estado"; //diaTask_estado
            //$estadoCss = "disponible";
            //$anchura=150*($aux);
            //$anchura= 150 ;

           /*  echo '
                <div class="task_calendario diaTask diaTask_estado '.$estadoCss.' " style="width:'.$anchura.'px !important">
                    <div class="task_calendario_status">
                        <p>'.$icono.'</p>
                        <p>Jose Figueroa</p>
                    </div>
                    <div class="task_calendario_status">
                        <p>'.$estadoHab.'</p>
                    </div>
                </div>
            '; */
/* 
            if ($matriz[$i][$j] != "-"){
                $aux=$matriz[$i][$j]['dias_reservados'];

                //$estadoHab = "reservada";
                
                
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
                        <div class="task_calendario_status">
                            <p>
                                <span class="material-symbols-outlined">
                                    add_circle
                                </span>
                            </p>
                            <p>Agregar</p>
                        </div>
                        </div>
                    </div>';
            } */
            
        }
        echo '</div>';
    }

    /* echo json_encode($matriz) */
?>