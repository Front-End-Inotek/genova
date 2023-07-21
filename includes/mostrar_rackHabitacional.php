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
                $estado_texto[0] = 'task--disponible-limpia';
                $estado_texto[1] = 'Disponible';
                break;
            case 1:
                $estado_texto[0] = 'task--ocupadoH';
                $estado_texto[1] = 'Ocupada';
                if($interno == "sucia"){
                    $estado_texto[0] = 'task--ocupada-sucia';
                    $estado_texto[1] = 'Sucia ocupada';
                }
                if($interno=="limpieza"){
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
                $estado_texto[1] = 'Vacia limpieza';
                break;
            case 4:
                $estado_texto[0] = 'task--mantenimiento';
                $estado_texto[1] = 'Mantenimiento';
                break;
            case 5:
                $estado_texto[0] = 'task--bloqueado';
                $estado_texto[1] = 'Bloqueo';
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

    public function calcularWidths($noches_reserva,$noches){

        // echo $noches_reserva ."|". $noches;
        // die();
        $total_noches = 0;
        $width="";
        $width2="";
        if($noches_reserva>1){
            $total_noches = $noches+$noches_reserva;
            $t1 = 100 * $noches;
            $t1 = $t1/$total_noches;
            $t1+="2";

            $t2 = 100 * $noches_reserva;
            $t2 = $t2/$total_noches;

            $width = "width:" . $t1 ."%";
            $width2 = "width:" . $t2 ."%";

        }else{
            $noches++;
            $total_noches = $noches;
            $fijo=50;
            $t = $fijo/$noches;
            $ajuste = 100-$t;
            $width = "width:" . $ajuste ."%";
            $res = $t;
            $width2 = "width:" . $res ."%";
        }
        return [$width,$width2,$total_noches];
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
        $sentencia = "SELECT hab.id ,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno ,movimiento.inicio_hospedaje AS inicio , movimiento.fin_hospedaje AS fin 
        ,movimiento.detalle_inicio, movimiento.detalle_fin, huesped.nombre as n_huesped, huesped.apellido a_huesped
        FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id 
        LEFT JOIN huesped on huesped.id = movimiento.id_huesped
        WHERE hab.estado_hab = 1
        /*AND hab.id=43*/
        ORDER BY id";
        // echo $sentencia;
        $comentario = "Optenemos las habitaciones para el rack de habitaciones";
        $consulta = $this->realizaConsulta($sentencia, $comentario);


        echo '
            <!--todo el contenido que estre por dentro de este div sera desplegado junto a la barra de nav--->
            <!--tabla operativa--->
                <div class="headTable justify-content-center align-items-center">
                <div class="fondoWaves">
                <div style="text-align:center;">
                <div >
                    <h2 class="fechaAñoMes">' . $mes_rack . ' ' . $anio_rack . '</h2>
                </div>
                </div>

                <defs>
                <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>

                <g class="parallax">
                <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.5)" />
                <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.3)" />
                <use xlink:href="#gentle-wave" x="48" y="5" fill="rgba(255,255,255,0.1)" />
                <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
                </svg>
                </div>

                <div class="wrapper">
                    <div class="card__">
                    <br><br><br>
                        <div class="card__year">
                        <div>' . $mes_rack . '  ' . $anio_rack . '</div>
                        </div>
                        <div class="card__cometOuter">
                        </div>
                        <div class="card__circle"></div>
                        <div class="card__smallCircle"></div>
                        <div class="card__greenShine"></div>

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
        $tiempo = $tiempo_inicial;
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
            $hab_nombre =$fila['nombre'];
            $hab_nombre = strlen($hab_nombre) > 13 ? substr($hab_nombre,0,12)."..." : $hab_nombre;
            echo '
                <tr id="hab_'.$fila['id'].'" >
                    <td class="cal-userinfo">
            ';
            echo 'Habitación ';
            if ($fila['id'] < 100) {
                echo $hab_nombre;
            } else {
                echo $fila['comentario'];
            }
            echo '
                </td>
            ';
            $tiempo = $tiempo_inicial;
            $hab = $fila['id'];
            //por cada hab, se tiene que consultar las preasignaciones existentes
            $sentencia_reservaciones = "SELECT hab.id,hab.nombre, reservacion.fecha_entrada, reservacion.fecha_salida,hab.estado,
            reservacion.estado_interno AS garantia
            ,movimiento.estado_interno AS interno
            ,huesped.nombre as n_huesped, huesped.apellido as a_huesped
            FROM movimiento
            left join reservacion on movimiento.id_reservacion = reservacion.id
            LEFT JOIN hab on movimiento.id_hab = hab.id
            LEFT JOIN huesped on movimiento.id_huesped = huesped.id
            where reservacion.estado =1
            and movimiento.motivo='preasignar'
            and movimiento.id_hab=$hab
            and from_unixtime(fecha_salida + 3600, '%Y-%m-%d') >= from_unixtime(UNIX_TIMESTAMP(),'%Y-%m-%d') 
            order by reservacion.fecha_entrada asc;
            ";
            // echo $sentencia_reservaciones;
            $comentario = "Optenemos las habitaciones para el rack de habitaciones";
            $consulta_reservaciones = $this->realizaConsulta($sentencia_reservaciones, $comentario);
            $contador_row = mysqli_num_rows($consulta_reservaciones);

            //for para cargar los 31  dias dentro de las habitaciones
            for ($i = 1; $i <= 31; $i++) {
                //Se omite el día anterior.
                if ($i == 1) {
                    /*echo '
                        <td class="celdaCompleta tdCheck " >
                        </td>
                    ';*/
                } else {

                    $clase_expirar="";

                    //Se calculan los estados de las habitaciones.
                    $mes = $this->convertir_mes(date('n', $tiempo));
                    $dia = date('d', $tiempo);
                    $adicional =0;
                    $tiempo += 86400;
                    $tiempo_aux = time() + $adicional;
                    $estado_habitacion_matutino = $this->estado_habitacion($fila['estado'], 1,$fila['interno']);
                    $estado_habitacion_vespertino = $this->estado_habitacion($fila['estado'], 2,$fila['interno']);
                    // echo date('Y-m-d',$tiempo_aux);
                    if(date('Y-m-d',$tiempo_aux) >= date('Y-m-d',$fila['fin'])){
                        $clase_expirar="expirar";
                    }

                    //Si la habitación actual no está ocupada entra aqui.
                    if ($i == 2 && $fila['estado'] != 1 ) {
                        //aplica lo mismo que en una reservacion de momento solo en uso casa.
                        if($fila['estado'] == 8){
                            //Si no tiene reservaciones se imprime normal, pero si si tiene el día actual es de reservación.
                            $noches_uso = ($fila['detalle_fin'] - $fila['detalle_inicio'])/86400;
                            // echo $noches_uso;
                            if($contador_row==0){
                                $adicional=86400;
                                echo '
                            <td class="celdaCompleta tdCheck " title="nombre huesped" colspan="' . $noches_uso . '">
                                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] .',\''.$fila['nombre'].'\')" >
                                    <div >
                            ';
                            echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                            echo '</div>';
                            echo '
                                </div>
                            </td>
                            ';
                            }
                        }else{
                        //Si no tiene reservaciones se imprime normal, pero si si tiene el día actual es de reservación.
                        if($contador_row==0){
                            $adicional=86400;
                            echo '
                        <td class="celdaCompleta tdCheck " title="nombre huesped">
                            <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',\''.$fila['nombre'].'\' )" >
                                <div >
                        ';
                        $h=0;
                        echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                        echo '</div>';
                        echo '
                            </div>
                        </td>
                        ';
                        }else{
                        }
                        }
                    $c=0;
                    while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
                        $huesped_reserva = $fila_r['n_huesped'] . " " . $fila_r['a_huesped'];
                        $clase_hover = "nuevax" . $i .rand(1,100);;
                        echo '<style>
                        .'.$clase_hover.'::after {
                        content: "'.$huesped_reserva.'";
                        }
                        </style>';

                        $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                        while(date('Y-m-d',$tiempo_aux) < date('Y-m-d',$fila_r['fecha_salida'])){
                        //tiempo aux será una variable que contendrá los "días actuales", esto para comparar el día actual (dentro del ciclo de 31 dias), 
                        //con el tiempo de la reservacion
                        if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada'])){
                            if($fila_r['garantia'] == "garantizada"){
                                $estado = 6;
                            }else{
                                $estado = 7;
                            }
                            $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                            $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                            // $re= date('Y-m-d',$fila_r['fecha_entrada']);
                            // $rs= date('Y-m-d',$fila_r['fecha_salida']);
                            echo '';
                            echo '
                            <td class="celdaCompleta tdCheck " colspan="' . $noches_reserva . '">
                                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',\''.$fila['nombre'].'\',' . $fila_r['fecha_entrada'] . ',' . $fila_r['fecha_salida'] . ')" >
                            ';
                            echo '<section class="'.$clase_hover.' task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . '</section>';
                            echo '            </div>

                                </td>
                            ';
                            $n = 86400 * ($noches_reserva -1);
                            $tiempo_aux += $n;
                            $noches_reserva=1;
                            // $tiempo_aux += 86400 ;
                        }else{
                            //Uso casa.
                            $mastiempo=false;
                            if ($c == 0 && $fila['estado'] != 1 ) {
                                if($fila['estado'] == 8){
                                    //Si no tiene reservaciones se imprime normal, pero si si tiene el día actual es de reservación.
                                    $earlier = new DateTime(date('Y-m-d'));
                                    $later = new DateTime(date('Y-m-d',$fila['detalle_fin']));
                                    $noches_uso = $later->diff($earlier)->format("%a");
                                    // echo $noches_uso;
                                        echo '
                                    <td class="celdaCompleta tdCheck " title="nombre huesped" colspan="' . $noches_uso . '">
                                        <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',\''.$fila['nombre'].'\')" >
                                            <div >
                                    ';
                                    echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                                    echo '</div>';
                                    echo '
                                        </div>
                                    </td>
                                    ';
                                    $n = 86400 * ($noches_uso - 1);
                                    $tiempo_aux += $n;
                                    $noches_reserva=1;
                                }else{
                                    if($contador_row==0) {
                                        //Si no tiene reservaciones se imprime normal, pero si si tiene el día actual es de reservación.
                                        $adicional=86400;
                                        echo '
                                        <td class="celdaCompleta tdCheck " title="nombre huesped">
                                        <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',\''.$fila['nombre'].'\')" >
                                        <div >
                                        ';
                                        echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                                        echo '</div>';
                                        echo '
                                        </div>
                                        </td>
                                        ';
                                    }else{
                                        //Cuando la f.salida de la reservacion sobrepasa la fecha actual y no hay ocupadas. 
                                        if(date('Y-m-d', $tiempo_aux) > date('Y-m-d', $fila_r['fecha_entrada']) && date('Y-m-d', $tiempo_aux) < date('Y-m-d', $fila_r['fecha_salida'])  )
                                        {
                                            $earlier = new DateTime(date('Y-m-d'));
                                            $later = new DateTime(date('Y-m-d',$fila_r['fecha_salida']));
                                            $noches_uso = $later->diff($earlier)->format("%a");
                                            // echo $noches_uso;
                                            $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                                            if($fila_r['garantia'] == "garantizada"){
                                                $estado = 6;
                                            }else{
                                                $estado = 7;
                                            }
                                            $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                            echo '
                                            <td class="celdaCompleta tdCheck " title="nombre huesped" colspan="'.$noches_uso.'">
                                            <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',\''.$fila['nombre'].'\',' . $fila_r['fecha_entrada'] . ',' . $fila_r['fecha_salida'] . ')"  >
                                            <div >
                                            ';
                                            echo '<section class="task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . '</section>';
                                            echo '</div>';
                                            echo '
                                            </div>
                                            </td>
                                            ';
                                            if($noches_uso>1){
                                                $mastiempo=true;
                                                $n = 86400 * ($noches_uso);
                                                $tiempo_aux += $n;
                                            }
                                        }else{
                                            if($fila['estado'] != 1){
                                                echo '
                                                <td class="celdaCompleta tdCheck " title="nombre huesped">
                                                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',\''.$fila['nombre'].'\')" >
                                                <div >
                                                ';
                                                echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                                                echo '</div>';
                                                echo '
                                                </div>
                                                </td>
                                                ';
                                            }else{
                                                echo '
                                                <td class="celdaCompleta tdCheck " >';
                                                // echo date('Y-m-d',$tiempo_aux);
                                                echo'
                                                </td>
                                                ';
                                            }
                                        }
                                    }
                                }

                            }else{
                                echo '
                                <td class="celdaCompleta tdCheck " >';
                                // echo date('Y-m-d',$tiempo_aux);
                                echo'
                                </td>
                                ';
                            }
                        }
                        // die();
                        if(!$mastiempo){
                            $tiempo_aux += 86400;
                        }

                        $c++;
                        }
                    }
                    $i=32;
                    //Ocupadas
                    } else {
                        //si la habitacion esta ocupada, dibuja los dias en los que estará ocupada (ignora el dia anterior)
                        $mastiempo=false;
                        $huesped_ocupada = $fila['n_huesped'] . " " . $fila['a_huesped'];
                        $clase_hover = "nuevax" . $i .rand(1,100);;
                        echo '<style>
                        .'.$clase_hover.'::after {
                            content: "'.$huesped_ocupada.'";
                        }
                        </style>';
                        $inicio = new DateTime(date('Y-m-d'));
                        $fin = new DateTime(date('Y-m-d',$fila['fin']));
                        $noches = $fin->diff($inicio)->format("%a");
                        $tiempo_aux = time();
                        $noches = $noches == 0 ? 1 : $noches;

                        echo '';
                        echo '
                        <td class="celdaCompleta tdCheck " colspan="' . $noches  . '">';
                        echo '<div class="ajuste"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ', \''.$fila['nombre'].'\')" >
                        ';
                        echo '<section class="'.$clase_expirar.' '.$clase_hover.' task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . '</section>';
                        echo '</div>';
                        echo'
                        </td>
                        ';
                        if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila['fin']))
                        {
                            $mastiempo=true;
                            $tiempo_aux += 86400;
                        }
                        if($noches>1){
                            $mastiempo=true;
                            $n = 86400 * ($noches);
                            $tiempo_aux += $n;
                        }
                        //si no hay reservaciones se termina el ciclo: y solo imprime las ocupadas con un 'medio dia'  al final.
                        if($contador_row==0){

                            $i = 32;
                        }else{
                            //aqui van las reservas, fila_r contiene las reservas
                            //$tiempo_aux contendrá el tiempo 'actual', mas la suma de cada dia para cada reservación.

                            $current=0; //contador del ciclo de reservaciones.
                            $ultima=""; //penúltima fecha de la reservacion.
                            $fila_anterior=null; //contendrá los datos de la ultima penúltima reservación.
                            $existetd=false; //Sí ya se imprió un td, no volver a imprimir.
                            $show=false;
                            if(!$mastiempo){
                                $tiempo_aux = $fila['fin'];
                            }
                            // echo date('Y-m-d',$tiempo_aux);
                            while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
                                $huesped_reserva = $fila_r['n_huesped'] . " " . $fila_r['a_huesped'];
                                $clase_hover = "nuevax" . $i .rand(1,100);;
                                echo '<style>
                                .'.$clase_hover.'::after {
                                    content: "'.$huesped_reserva.'";
                                }
                                </style>';

                                $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;

                                if ($ultima!=""){
                                    if(date('Y-m-d',$ultima)==date('Y-m-d',$fila['fin'])){

                                    }
                                    // echo date('Y-m-d',$ultima)."|".date('Y-m-d',$fila['fin']);
                                    // die();
                                }


                                //ciclo para 'avanzar' atraves de los días de la reservación.
                                while(date('Y-m-d',$tiempo_aux) < date('Y-m-d',$fila_r['fecha_salida'])){
                                //Si el contador de fecha es igual a la fecha de entrada de la reservación y si trata del primer dato.
                                if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada']))
                                {
                                    //Se verifica si la reservación está garantizada o no.
                                    if($fila_r['garantia'] == "garantizada"){
                                        $estado = 6;
                                    }else{
                                        $estado = 7;
                                    }

                                    $aux_r =($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;

                                    // $tiempo_aux= $fila_r['fecha_salida'] - 86400;

                                    $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                    //Este td es para cuando se ocupa imprimir las noches ocupadas junto con la reservación que coicida en la fecha de entrada con 
                                    //la fecha de salida de la ocupada.

                                    echo '';
                                    echo '
                                    <td class="celdaCompleta tdCheck " colspan="' . $aux_r  . '">';
                                    echo '<div class="ajuste"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado. ', \''.$fila['nombre'].'\',' . $fila_r['fecha_entrada'] . ',' . $fila_r['fecha_salida'] . ')" >
                                    ';
                                    echo '<section class="'.$clase_hover.' task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . ' </section>';
                                    echo '</div>';
                                    echo'
                                    </td>
                                    ';
                                    if($noches_reserva<=1){
                                        $tiempo_aux += 86400;
                                    }else{
                                        // Si solo se trata del primero también seguirá sumando solo 1 día
                                            //Solo en casos en los que no se al primer elemento del ciclo y tenga mas de 1 noche de reserva, 
                                            //entonces el tiempo actual se le quedará  con la cantidad de noches de la reservacion 
                                            // y las noches se setean a 1, para que ya no vuelva a sumarle dichos días, sino que termine con la ultima 
                                            //fecha de reservacion.
                                            $n = 86400 * $noches_reserva;
                                            $tiempo_aux += $n;
                                            $noches_reserva=1;
                                        }

                                }else {
                                    echo '
                                    <td class="celdaCompleta tdCheck ">';
                                    // echo date('Y-m-d',$tiempo_aux);
                                    echo'
                                    </td>';
                                    $tiempo_aux += 86400;
                                    // die();
                                }

                                    //  echo date('Y-m-d',$tiempo_aux);
                                    // die();
                                }
                                $fila_anterior=$fila_r;
                                $ultima = $fila_r['fecha_entrada'];
                            }
                            

                            $i=32;
                        }

                    }
                    if ($i == 2 && $fila['estado'] != 1 ) {
                        $i = 32;
                    }
                }//end data.
            }
            echo '</tr>';
        }
    }
}
