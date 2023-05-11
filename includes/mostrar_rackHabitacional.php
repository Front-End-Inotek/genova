<?php

include_once('consulta.php');
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, "es_ES");

class RackHabitacional extends ConexionMYSql
{
    private function estado_habitacion($estado, $turno,$interno="")
    {
        switch ($estado) {
            case 0:
                $estado_texto[0] = 'task--limpieza-vacia';
                $estado_texto[1] = 'Disponible';
                break;
            case 1:
                $estado_texto[0] = 'task--ocupadoH';
                $estado_texto[1] = 'Ocupada';
                if($interno == "sucia"){
                    $estado_texto[0] = 'task--ocupada-sucia';
                    $estado_texto[1] = 'Sucia ocupada';
                }
                if($interno== "limpieza"){
                    $estado_texto[0] = 'task--limpieza-ocupada';
                    $estado_texto[1] = 'Ocupada limpieza';
                    
                }
                
                break;
            case 2:
                $estado_texto[0] = 'task--vacia-sucia';
                $estado_texto[1] = 'Vacia Sucia';
                break;
            case 3:
                $estado_texto[0] = 'task--limpieza-vacia';
                $estado_texto[1] = 'Vacia limpia';
                break;
            case 4:
                $estado_texto[0] = 'task--ocupada-sucia';
                $estado_texto[1] = 'Sucia ocupada';
                break;
            case 5:
                $estado_texto[0] = 'task--limpieza-ocupada';
                $estado_texto[1] = 'Ocupada limpieza';
                break;
            case 6:
                $estado_texto[0] = 'task--reserva-pagada';
                $estado_texto[1] = 'Reserva pagada';
                break;
            case 7:
                $estado_texto[0] = 'task--reserva-pendiente-pago';
                $estado_texto[1] = 'Reserva pendiente';
                break;
            case 8:
                $estado_texto[0] = 'task--uso-casa';
                $estado_texto[1] = 'Uso casa';
                break;
            case 9:
                $estado_texto[0] = 'task--mantenimiento';
                $estado_texto[1] = 'Mantenimiento';
                break;
            case 10:
                $estado_texto[0] = 'task--bloqueado';
                $estado_texto[1] = 'Bloqueo';
                break;
        }

        return $estado_texto;
    }
    private function convertir_mes($mes)
    {
        // comvertir el mes de formato numero a texto
        $mes_texto = "";
        switch ($mes) {
            case 1:
                $mes_texto = "Enero";
                break;
            case 2:
                $mes_texto = "Febrero";
                break;
            case 3:
                $mes_texto = "Marzo";
                break;
            case 4:
                $mes_texto = "Abril";
                break;
            case 5:
                $mes_texto = "Mayo";
                break;
            case 6:
                $mes_texto = "Junio";
                break;
            case 7:
                $mes_texto = "Julio";
                break;
            case 8:
                $mes_texto = "Agosto";
                break;
            case 9:
                $mes_texto = "Septiembre";
                break;
            case 10:
                $mes_texto = "Octubre";
                break;
            case 11:
                $mes_texto = "Noviembre";
                break;
            default:
                $mes_texto = "Diciembre";
                break;
        }

        return $mes_texto;
    }
    public function mostrar($id, $tiempo_inicial)
    {
        include_once("clase_cuenta.php");
        include('clase_movimiento.php');
        //variable para alamcenar mes de rack
        $mes_rack = $this->convertir_mes(date('m'));
        //variable para alamcenar año de rack
        $anio_rack = date('Y');


        $cuenta = new Cuenta(0);
        $movimiento = new movimiento(0);

        $cronometro = 0;

        //Se utiliza la misma consulta para el rack de operaciones
        $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno ,movimiento.inicio_hospedaje AS inicio , movimiento.fin_hospedaje AS fin 
        FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id 
        WHERE hab.estado_hab = 1  ORDER BY id";
        $comentario = "Optenemos las habitaciones para el rack de habitaciones";
        $consulta = $this->realizaConsulta($sentencia, $comentario);


        echo '
            <!--todo el contenido que estre por dentro de este div sera desplegado junto a la barra de nav--->
            <!--tabla operativa--->

                <div class="headTable justify-content-center align-items-center">
                    <div style="text-align:center;">
                    <div>
                        <h2>' . $mes_rack . ' ' . $anio_rack . '</h2>
                    </div>
                    </div>
                </div>
        ';

        echo '
            <!-- DISPLAY USER-->
            <div class="table-responsive tableRack" style="margin-left: -10px !important;">
                <div id="cal-largo">
                    <div class="cal-sectionDiv">
                        <table class="tableRack table-striped table-bordered" id="tablaTotal">
                            <thead class="cal-thead">
                                <tr>
                                <th class="cal-viewmonth" id="changemonth"></th>
        ';
        $tiempo = $tiempo_inicial - 86400;
        //for para cargar los 31  dias
        for ($i = 1; $i <= 31; $i++) {
            $mes = $this->convertir_mes(date('n', $tiempo));
            $dia = date('d', $tiempo);
            $tiempo += 86400;
            echo "
                <th class='cal-dia'> $dia - $mes</th>
            ";
        }
        echo '
                </tr>
            </thead>
            <tbody class="cal-tbody">
        ';
        //Ciclo while que nos mostrara todas las habitaciones habilitadas y los estados de estas
        while ($fila = mysqli_fetch_array($consulta)) {
            echo '
                <tr id="u1">
                    <td class="cal-userinfo">
            ';
            echo 'Habitación ';
            if ($fila['id'] < 100) {
                echo $fila['nombre'];
            } else {
                echo $fila['comentario'];
            }
            echo '
                </td>
            ';
            $tiempo = $tiempo_inicial - 86400;
            $hab = $fila['id'];
            //por cada hab, se tiene que consultar las preasignaciones existentes
            $sentencia_reservaciones = "SELECT hab.id,hab.nombre, reservacion.fecha_entrada, reservacion.fecha_salida,hab.estado ,movimiento.estado_interno AS interno
            FROM movimiento
            left join reservacion on movimiento.id_reservacion = reservacion.id
            LEFT JOIN hab on movimiento.id_hab = hab.id
            where reservacion.estado =2
            and movimiento.motivo='preasignar'
            and movimiento.id_hab=$hab
            order by reservacion.fecha_entrada asc;
            ";
            $comentario = "Optenemos las habitaciones para el rack de habitaciones";
            $consulta_reservaciones = $this->realizaConsulta($sentencia_reservaciones, $comentario);
            $contador_row = mysqli_num_rows($consulta_reservaciones);
            $imprimi_ocupadas=false;

            //for para cargar los 31  dias dentro de las habitaciones
            for ($i = 1; $i <= 31; $i++) {
                if ($i == 1) {
                    echo '
                        <td class="celdaCompleta tdCheck " >
                        </td>
                    ';
                } else {

                    $mes = $this->convertir_mes(date('n', $tiempo));

                    $dia = date('d', $tiempo);
                    $tiempo += 86400;
                    $estado_habitacion_matutino = $this->estado_habitacion($fila['estado'], 1,$fila['interno']);
                    $estado_habitacion_vespertino = $this->estado_habitacion($fila['estado'], 2,$fila['interno']);

                    if ($i == 2 && $fila['estado'] != 1 ) {
                        echo '
                        <td class="celdaCompleta tdCheck " >
                            <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                <div >
                        ';
                        echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                        echo '</div>';
                        echo '
                            </div>
                        </td>
                        ';
                    //mismo caso 
                    //se le suma 1 día para ignorar el día actual.
                    $tiempo_aux = time()+86400;
                    while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
                        $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                        while(date('Y-m-d',$tiempo_aux) < date('Y-m-d',$fila_r['fecha_salida'])){
                        //tiempo aux será una variable que contendrá los "días actuales", esto para comparar el día actual (dentro del ciclo de 31 dias), 
                        //con el tiempo de la reservacion
                        if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada'])){
                            $estado=7;
                            echo '';
                            echo '
                            <td class="celdaCompleta tdCheck " colspan="' . $noches_reserva . '">
                                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                            ';
                            echo '<section class="task task--reserva-pendiente-pago"> Reserva pendiente ' . $noches_reserva . ' </section>';
                            echo '            </div>

                                </td>
                            ';
                        }else{
                            echo '
                            <td   td class="celdaCompleta tdCheck " >
                            </td>
                            ';
                        }
                            $tiempo_aux += 86400;
                        }
                    }
                    $i=32;

                    } else {
                        //si la habitacion esta ocupada, dibuja los dias en los que estará ocupada (ignora el dia anterior)
                        $noches = ($fila['fin'] - $fila['inicio']) / 86400;
                        //solo imprime una vez las ocupadas, esto evita que se sigan imprimiendo si hay reservaciones
                        if($imprimi_ocupadas==false){
                            echo '';
                            echo '
                            <td class="celdaCompleta tdCheck " colspan="' . $noches . '">
                                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                            ';
                            echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                            echo '            </div>
                                </td>
                            ';
                            $imprimi_ocupadas=true;
                        }
                        //si no hay reservaciones se termina el ciclo.
                        if($contador_row==0){
                            $i = 32;
                        }else{
                            //aqui van las reservas, fila_r contiene las reservas
                            $tiempo_aux = $fila['fin'];
                            while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
                                $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                                while(date('Y-m-d',$tiempo_aux) < date('Y-m-d',$fila_r['fecha_salida'])){
                                //tiempo aux será una variable que contendrá los "días actuales", esto para comparar el día actual (dentro del ciclo de 31 dias), 
                                //con el tiempo de la reservacion
                                if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada'])){
                                    $estado=7;
                                    echo '';
                                    echo '
                                    <td class="celdaCompleta tdCheck " colspan="' . $noches_reserva . '">
                                        <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                    ';
                                    echo '<section class="task task--reserva-pendiente-pago"> Reserva pendiente ' . $noches_reserva . ' </section>';
                                    echo '            </div>

                                        </td>
                                    ';
                                }else{
                                    echo '
                                    <td   td class="celdaCompleta tdCheck " >
                                    </td>
                                    ';
                                }
                                    $tiempo_aux += 86400;
                                }
                            }
                            $i=32;
                        }

                    }

                    if ($i == 2 && $fila['estado'] != 1 ) {
                        $i = 32;
                    }
                }
            }

            echo '</tr>';
        }
        /*for($x=1;$x++;$x>=31){
            $tiempo_de_ayer+=86400;
            echo "
                <th class='cal-dia'> LUNES ".$x ."</th>
            ";
        }*/
        /*$fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD
        $fecha_final = date('Y-m-d', strtotime('+32 days')); // Obtiene la fecha actual más 32 días en formato YYYY-MM-DD
        $fecha = $fecha_actual; // Se guarda la fecha acutal en una nueva variable
        $contador = 0;
        $total_dias = 32;   //En una nueva variable guardamos el total de dias
        $yesterday =  date('j', strtotime('-1 day'));

        $daybefore = date('d-m-Y', strtotime('-1 day'));

        // echo $daybefore;

        $dia = date('N', strtotime($fecha));

        $diaanterior = date('N', strtotime('-1 day'));

       
        

        echo'
            </tr>
        </thead>';
       /* $contador_row=0;
        $empezar_reservas="";
        //Ciclo while que nos mostrara todas las habitaciones habilitadas y los estados de estas
        while ($fila = mysqli_fetch_array($consulta)) {



            //Se definen los estados de las habitaciones
            $total_faltante= 0.0;
            $estado="no definido";
            switch($fila['estado']) {
                case 0:
                    $estado= "Disponible limpia";
                    $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
                    $tipo_habitacion= $fila['tipo_nombre'];

                    break;

                case 1:
                    $estado= "Ocupado";
                    $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
                    break;

                case 2:
                    $estado= "Vacia sucia";
                    $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
                    break;

                case 3:
                    $estado= "Vacia limpia";
                    $cronometro= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
                    $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
                    break;

                case 4:
                    $estado= "Sucia ocupada";
                    $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
                    break;

                case 5:
                    $estado="Ocupada limpieza";
                    $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
                    break;

                case 6:
                    $estado="Reserva pagada";
                    $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
                    $tipo_habitacion= $fila['tipo_nombre'];
                    break;

                case 7:
                    $estado= "Reserva pendiente";
                    $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
                    $tipo_habitacion= $fila['tipo_nombre'];
                    break;

                case 8:
                    $estado= "Uso casa";
                    $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
                    $tipo_habitacion= $fila['tipo_nombre'];
                    break;

                case 9:
                    $estado="Mantenimiento";
                    $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
                    break;

                case 10:
                    $estado="Bloqueo";
                    $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
                    break;

                default:
                    //echo "Estado indefinido";
                    break;
            }

            //Se añade en el cuerpo de la tabla la numeracion de las habitaciones
            if($fila['tipo']>0) {
                echo'
                <tbody class="cal-tbody">
                <tr id="u1">
                <td class="cal-userinfo">';
                echo'Habitación ';
                if($fila['id']<100) {
                    echo $fila['nombre'];
                } else {
                    echo $fila['comentario'];
                }
                echo'
                </td>';

                // Se decide por las habitaciones vacias
                $fecha_salida= $movimiento->ver_fecha_salida($fila['moviemiento']);

                $fecha_salidaAux= $movimiento->ver_fecha_salida($fila['moviemiento']);
                $fecha_entradaAux = $movimiento->ver_fecha_entrada($fila['moviemiento']);

                $fecha_salidaAux = date('d-m-Y', strtotime($fecha_salidaAux));
                $fecha_entradaAux= date('d-m-Y', strtotime($fecha_entradaAux));

                // echo $fecha_entradaAux;
                // echo $fecha_salidaAux;

                $date1 = new DateTime($fecha_entradaAux);
                $date2 = new DateTime($fecha_salidaAux);

                $numColspan=0;
                $diffDias=$date2->diff($date1);
                $diffDias= $diffDias->days;

                $check=false;



                /*if ($fila['estado'] == 0) {
                    // echo $daybefore;
                    $aux_fecha_actual = date('d-m-Y', strtotime($fecha_actual));
                    // echo $aux_fecha_actual;
                    // die();
                    while(strtotime($daybefore) <= strtotime($aux_fecha_actual)) {
                        if($daybefore==$aux_fecha_actual) {
                            echo'
                    <td class="celdaCompleta ">
                        <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >
                            <section class="task task--disponible-limpia" >
                                <a> '. $estado . '<br></a>
                            </section>
                        </div>
                    </td>
                    ';
                        } else {
                            echo'
                    <td class="celdaCompleta">
        
                    </td>
                    ';
                        }

                        $daybefore = date('d-m-Y', strtotime($daybefore.'+1 day'));
                    }


                } elseif($fecha_salida < 0) {
                    echo'
                <td class="celdaCompleta">

             </td>
                ';
                } elseif($fecha_salida > 0) {
                    $empezar_reservas = $fecha_salida;
                    // print_r($fecha_entrada);
                    // print_r($fecha_salida);
                    //  die();
                    $cw=0;
                    $aux_fecha_actual = date('d-m-Y', strtotime($fecha_actual));
                    //    echo $daybefore;
                    //    echo $fecha_salidaAux;
                    $checkNormal=false;
                    while(strtotime($daybefore)<= strtotime($fecha_salidaAux)) {


                        // die("si");
                        // echo $fecha;
                        // echo $fecha_entrada;
                        if($fecha_entradaAux==$daybefore || $fecha_salidaAux == $daybefore) {


                            // }

                            if($estado != 'Ocupado') {
                                $diffDias=1;
                                $checkNormal=true;
                            }

                            if($diffDias>=1 && $estado=='Ocupado') {
                                $check=true;
                                $diffDias++;
                            }

                            if($check || $checkNormal) {

                                // echo "<button></button>"

                                // for ($i=0; $i < $total_dias+2; $i++) {
                                # code...
                                echo'
                        <td class="celdaCompleta tdCheck medioDia" >';
                                //Segunda columna que muesta los estados de las habitaciones
                                //Definimos un div que contendra un evento onclick con el que se desplegara un modal y se mostrar la informacion de la habitacion
                                echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
                                //Con esta estructura de control definimos los estados y los estilos correspondientes a los estados
                                switch($estado) {

                                    case "Disponible limpia":

                                        echo '<section class="task task--limpieza-vacia">';

                                        break;


                                    case "Vacia limpia":
                                        echo'<section class="task task--limpieza-vacia">';
                                        // echo '<section class="task task--limpieza-vacia">Limpieza Vacia</section>';

                                        break;

                                    case "Vacia sucia":
                                        echo'<section class="task task--vacia-sucia" title="aqui mas informacion">';

                                        break;

                                    case "Ocupado":
                                        echo'<section class="task task--ocupadoH">';
                                        break;

                                    case "Sucia ocupada":
                                        echo'<section class="task task--ocupada-sucia">';
                                        break;

                                    case "Ocupada limpieza":
                                        echo'<section class="task task--limpieza-ocupada">';
                                        break;

                                    case "Reserva pagada":
                                        echo'<section class="task task--reserva-pagada">';
                                        break;

                                    case "Reserva pendiente":
                                        echo'<section class="task task--reserva-pendiente-pago ajuste">';
                                        break;

                                    case "Uso casa":
                                        echo'<section class="task task--uso-casa">';
                                        break;

                                    case "Mantenimiento":
                                        echo'<section class="task task task--mantenimiento ajuste-2dias">';
                                        break;

                                    case "Bloqueo":
                                        echo'<section class="task task--bloqueado">';
                                        break;

                                    default:
                                        //echo "Estado indefinido";
                                        break;
                                }
                                echo '<a> '. $estado .'<br> </a>';
                                echo '<a> '. substr($fecha_salida, 0, -8) .'<br> </a>';

                                //Definimos la informacion que contendra las card de las habitaciones el numero de habitacion y el estado
                                echo '</section>
                    </div>
                </td>';


                                echo'
                <td class="celdaCompleta tdCheck medioDia" >';
                                //Segunda columna que muesta los estados de las habitaciones
                                //Definimos un div que contendra un evento onclick con el que se desplegara un modal y se mostrar la informacion de la habitacion
                                echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
                                //Con esta estructura de control definimos los estados y los estilos correspondientes a los estados
                                switch($estado) {

                                    case "Disponible limpia":

                                        echo '<section class="task task--limpieza-vacia">';

                                        break;


                                    case "Vacia limpia":
                                        echo'<section class="task task--limpieza-vacia">';
                                        // echo '<section class="task task--limpieza-vacia">Limpieza Vacia</section>';

                                        break;

                                    case "Vacia sucia":
                                        echo'<section class="task task--vacia-sucia" title="aqui mas informacion">';

                                        break;

                                    case "Ocupado":
                                        echo'<section class="task task--ocupadoH">';
                                        break;

                                    case "Sucia ocupada":
                                        echo'<section class="task task--ocupada-sucia">';
                                        break;

                                    case "Ocupada limpieza":
                                        echo'<section class="task task--limpieza-ocupada">';
                                        break;

                                    case "Reserva pagada":
                                        echo'<section class="task task--reserva-pagada">';
                                        break;

                                    case "Reserva pendiente":
                                        echo'<section class="task task--reserva-pendiente-pago ajuste">';
                                        break;

                                    case "Uso casa":
                                        echo'<section class="task task--uso-casa">';
                                        break;

                                    case "Mantenimiento":
                                        echo'<section class="task task task--mantenimiento ajuste-2dias">';
                                        break;

                                    case "Bloqueo":
                                        echo'<section class="task task--bloqueado">';
                                        break;

                                    default:
                                        //echo "Estado indefinido";
                                        break;
                                }
                                echo '<a> '. $estado .'<br> </a>';
                                echo '<a> '. substr($fecha_salida, 0, -8) .'<br> </a>';

                                //Definimos la informacion que contendra las card de las habitaciones el numero de habitacion y el estado
                                echo '</section>
                    </div>
                </td>';


                                if($checkNormal) {
                                    $checkNormal=false;
                                    break;
                                }


                                $diffDias=false;
                                $check=false;
                            }
                            $daybefore = date('d-m-Y', strtotime($daybefore.'+1 day'));
                            $fecha_entradaAux = date('d-m-Y', strtotime($fecha_entradaAux.'+1 day'));





                        } else {
                            // if($cw>0){
                            //     echo "??";
                            //     die();
                            // }
                            // echo "no es igual";

                            echo'
        <td class="celdaCompleta">

        </td>
        ';

                            $daybefore = date('d-m-Y', strtotime($daybefore.'+1 day'));
                            // echo $aux_fecha_actual;





                        }
                        $cw++;
                    }



                }
                $dia_inicio=0;
                $dia_actual = date('d-m-Y');

                if($empezar_reservas!=0) {
                    $dia_inicio = $empezar_reservas;
                } else {
                    $dia_inicio=$dia_actual;
                }

                $dia_inicio = date('d-m-Y', strtotime($dia_inicio.'.+1 day'));



                $hab= $fila['id'];
                //consultar las reservaciones "pendientes" sobre esa habitación.
                $sentencia_reservaciones = "SELECT hab.id,hab.nombre, reservacion.fecha_entrada, reservacion.fecha_salida,hab.estado ,movimiento.estado_interno AS interno
        FROM movimiento 
        left join reservacion on movimiento.id_reservacion = reservacion.id
        LEFT JOIN hab on movimiento.id_hab = hab.id 
        where reservacion.estado =4
        and movimiento.id_hab=$hab";





                $consulta_reservaciones = $this->realizaConsulta($sentencia_reservaciones, "");


                $h=0;

                $ultima_fecha = $todas_fechas[sizeof($todas_fechas)-1];



                while ($fila = mysqli_fetch_array($consulta_reservaciones)) {


                    $fr_salida = $fila['fecha_salida'];
                    $entrada_reservacion = date('d-m-Y', $fila['fecha_entrada']);

                    print_r($dia_inicio);
                    print_r($entrada_reservacion);
                    print_r(date('Y-m-d', $fr_salida));


                    if(strtotime($entrada_reservacion)<strtotime($dia_actual)) {

                        continue;
                    }


                    //   if($h==0){
                    //     $dia_inicio = $entrada_reservacion;
                    //   }

                    //   die($dia_inicio);

                    while(strtotime($dia_inicio) <= $fr_salida) {
                        if(strtotime($dia_inicio) == $fr_salida) {
                            echo "<td>igual?</td>";
                        }


                        if(strtotime($dia_inicio) == strtotime($entrada_reservacion)) {
                            echo'
                <td class="celdaCompleta">
                    <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['id'].')" >
                        <section class="task task--disponible-limpia" >
                            <a> '. "nada" . '<br></a>
                        </section>
                    </div>
                </td>
                ';

                            $entrada_reservacion = date('d-m-Y', strtotime($entrada_reservacion.'+1 day'));

                        } else {
                            echo'
                        <td class="celdaCompleta">
                
                        </td>
                        ';
                        }
                        $dia_inicio = date('d-m-Y', strtotime($dia_inicio.'+1 day'));
                    }
                    $dia_inicio =date('d-m-Y', $fr_salida);
                    $dia_inicio = date('d-m-Y', strtotime($dia_inicio.'.+1 day'));

                    // echo "el nuevo dia "  .  $dia_inicio;
                    // die();



                    // while(strtotime($dia_actual) <= strtotime($ultima_fecha)) {
                    //     // print_r($entrada_reservacion);
                    //     // print_r($entrada_reservacion);
                    //     if(strtotime($entrada_reservacion)==strtotime($dia_actual)) {


                    //         echo'
                    //         <td class="celdaCompleta">
                    //             <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['id'].')" >
                    //                 <section class="task task--disponible-limpia" >
                    //                     <a> '. "nada" . '<br></a>
                    //                 </section>
                    //             </div>
                    //         </td>
                    //         ';
                    //         $entrada_reservacion = date('d-m-Y', strtotime($entrada_reservacion.'+1 day'));
                    //     }else{

                    //         echo'
                    //         <td class="celdaCompleta">

                    //         </td>
                    //         ';
                    //     }

                    //     $dia_actual = date('d-m-Y', strtotime($dia_actual.'+1 day'));

                    //     //die("pass");
                    //     $i++;
                    // }





                    $h++;
                }



                echo '
            </tr>
        </tbody>';
            } else {
                //echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';
            }

            $daybefore = date('d-m-Y', strtotime('-1 day'));
            $fecha_salidaAux="";
            $fecha_entradaAux="";
            $contador_row++;
            // echo $contador_row;
        }
        echo'</table>
        </div>
    </div>
</div>';*/
    }
}
