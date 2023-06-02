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
        $sentencia = "SELECT hab.id ,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno ,movimiento.inicio_hospedaje AS inicio , movimiento.fin_hospedaje AS fin 
        FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id 
        WHERE hab.estado_hab = 1  
        /*AND hab.id=51*/
        ORDER BY id";
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
            echo '
                <tr id="hab_'.$fila['id'].'" >
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
            $tiempo = $tiempo_inicial;
            $hab = $fila['id'];
            //por cada hab, se tiene que consultar las preasignaciones existentes
            $sentencia_reservaciones = "SELECT hab.id,hab.nombre, reservacion.fecha_entrada, reservacion.fecha_salida,hab.estado,
            reservacion.estado_interno AS garantia
            ,movimiento.estado_interno AS interno
            FROM movimiento
            left join reservacion on movimiento.id_reservacion = reservacion.id
            LEFT JOIN hab on movimiento.id_hab = hab.id
            where reservacion.estado =1
            and movimiento.motivo='preasignar'
            and movimiento.id_hab=$hab
            and from_unixtime(fecha_entrada + 3600, '%Y-%m-%d') >= from_unixtime(UNIX_TIMESTAMP(),'%Y-%m-%d') 
            order by reservacion.fecha_entrada asc;
            ";
            $comentario = "Optenemos las habitaciones para el rack de habitaciones";
            $consulta_reservaciones = $this->realizaConsulta($sentencia_reservaciones, $comentario);
            $contador_row = mysqli_num_rows($consulta_reservaciones);
           
            $imprimi_ocupadas=false;

            //for para cargar los 31  dias dentro de las habitaciones
            for ($i = 1; $i <= 31; $i++) {
                if ($i == 1) {
                    /*echo '
                        <td class="celdaCompleta tdCheck " >
                        </td>
                    ';*/
                } else {

                    $mes = $this->convertir_mes(date('n', $tiempo));

                    $dia = date('d', $tiempo);
                    $tiempo += 86400;
                    $estado_habitacion_matutino = $this->estado_habitacion($fila['estado'], 1,$fila['interno']);
                    $estado_habitacion_vespertino = $this->estado_habitacion($fila['estado'], 2,$fila['interno']);

                    if ($i == 2 && $fila['estado'] != 1 ) {
                        echo '
                        <td class="celdaCompleta tdCheck " title="nombre huesped">
                            <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                <div >
                        ';
                        echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . '</section>';
                        echo '</div>';
                        echo '
                            </div>
                        </td>
                        ';
                    //se le suma 1 día para que no tome el dia 'actual'.
                    $tiempo_aux = time() + 86400;
                    while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
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
                            $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                            $re= date('Y-m-d',$fila_r['fecha_entrada']);
                            $rs= date('Y-m-d',$fila_r['fecha_salida']);
                            echo '';
                            echo '
                            <td class="celdaCompleta tdCheck " colspan="' . $noches_reserva . '">
                                <div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                            ';
                            echo '<section class="task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . ' </section>';
                            echo '            </div>

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
                            $tiempo_aux += 86400;
                        }
                    }
                    $i=32;

                    } else {
                        //si la habitacion esta ocupada, dibuja los dias en los que estará ocupada (ignora el dia anterior)
                        $earlier = new DateTime(date('Y-m-d'));
                        $later = new DateTime(date('Y-m-d',$fila['fin']));
                        $eltd ="";
                        $more="";
                        $noches = $later->diff($earlier)->format("%a");
                        // echo $abs_diff;

                        // $noches = ($fila['fin'] - time()) / 86400;
                        // $noches = round($noches);
                        //solo imprime una vez las ocupadas, esto evita que se sigan imprimiendo si hay reservaciones
                        // $total_noches = $noches + $contador_row;
                        // echo $total_noches;

                        // die();
                        $contador = 0;
                           
                        
                            // echo '';
                            // echo '
                            // <td class="celdaCompleta tdCheck " colspan="' . $noches  . '">';
                            // echo '<div class="ajuste" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                            // ';
                            // echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                            // echo '</div>';
                            // echo $eltd;
                            
                            // echo'
                            // </td>
                            // ';
                          
                            $imprimi_ocupadas=true;
                            $ocupada=true;
                        
                        //si no hay reservaciones se termina el ciclo.
                        if($contador_row==0){
                             echo '';
                            echo '
                            <td class="celdaCompleta tdCheck " colspan="' . $noches +1 . '">';
                            echo '<div class="ajuste" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                            ';
                            echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                            echo '</div>';
                            echo $eltd;
                            
                            echo'
                            </td>
                            ';
                            $i = 32;
                        }else{
                            //aqui van las reservas, fila_r contiene las reservas
                            $tiempo_normal = $fila['fin'];
                            $tiempo_aux = $fila['fin'] ;
                            // echo date('Y-m-d',$tiempo_normal);
                            $current=0;
                            $todo=0;

                            $ultima="";
                            $filaL=null;
                            $existetd=false;
                            $show=false;
                            $yasume=false;
                        
                            $real=[];
                            while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
                                $real [] = $fila_r;
                                $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;

                               
                               
                               
                               
                                //  echo date('Y-m-d',$fila_r['fecha_entrada']);
                               
                              

                                while(date('Y-m-d',$tiempo_aux) < date('Y-m-d',$fila_r['fecha_salida'])){
                                    // echo $current;
                                    
                                //tiempo aux será una variable que contendrá los "días actuales", esto para comparar el día actual (dentro del ciclo de 31 dias), 
                                //con el tiempo de la reservacion

                                $re= date('Y-m-d',$fila_r['fecha_entrada']);
                                $rs= date('Y-m-d',$fila_r['fecha_salida']);
                                $clase="ajuste";
                                // if($ultima == $fila_r['fecha_entrada']){
                                //     $clase="ajuste8";
                                //     $re2= date('Y-m-d',$filaL['fecha_entrada']);
                                //     $rs2= date('Y-m-d',$filaL['fecha_salida']);
                                // }
                              
                                if(date('Y-m-d',$tiempo_normal) == date('Y-m-d',$fila_r['fecha_entrada']) && $current==0 )
                                {
                                    $total_noches = 0;
                                    // $noches+=1;
                                    if($noches_reserva>1){
                                        // echo $noches;
                                        // echo $noches_reserva;
                                        // $noches=10;
                                        $total_noches = $noches+$noches_reserva;
                                        $t1 = 100 * $noches;
                                        $t1 = $t1/$total_noches;
                                        $t1+="3";

                                        $t2 = 100 * $noches_reserva;
                                        $t2 = $t2/$total_noches;

                                        $width = "width:" . $t1 ."%";
                                        $width2 = "width:" . $t2 ."%";

                                        $tiempo_aux= $fila_r['fecha_salida'] - 86400;
                                        $noches_reserva=1;
                                      
                                       
                                    }else{
                                        $noches++;
                                        $total_noches = $noches;
                                        $width="";
                                        $width2="";
                                        // echo $noches;
                                        // die();
                                        // $noches_reserva =13;
                                        $fijo=50;
                                        //echo $noches_reserva;
                                       
                                        $t = $fijo/$noches;
                                        // echo $t/$noches;
                                        // die();
                                        $ajuste = 100-$t;
                                        $width = "width:" . $ajuste ."%";
                                        
                                        $res = $t;
                                        $width2 = "width:" . $res ."%";
                                        
                                        
                                    }
                                    if($fila_r['garantia'] == "garantizada"){
                                        $estado = 6;
                                    }else{
                                        $estado = 7;
                                    }
                                    $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                    // echo $estado;
                                    
                                  
                                  
                                    echo '';
                                    echo '
                                    <td class="celdaCompleta tdCheck " colspan="' . $total_noches  . '">';
                                    echo '<div class="ajuste6" style="'.$width.'"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                    ';
                                    echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                                    echo '</div>';
                                    echo '<div class="ajuste4" style="'.$width2.'"    href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                    ';
                                    echo '<section class="task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . ' </section>';
                                    echo '            </div>';                              
                                    echo'
                                    </td>
                                    ';
                                    $existetd=true;
                                }elseif($current==0) {
                                // echo $current;
                                $noches +=1;
                                echo '';
                                echo '
                                <td class="celdaCompleta tdCheck " colspan="' . $noches  . '">';
                                echo '<div class="ajuste" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                ';
                                echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                                echo '</div>';
                                // echo $eltd;
                                
                                echo'
                                </td>
                                ';
                                $show=true;
                                }
                               
                                if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada'])  && $current!=0 ){
                                   
                                    $aux_r =($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                                    $tiempo_aux= $fila_r['fecha_salida'] - 86400;
                                    $noches_reserva=1;
                                    $estado=7;
                                    $clase="ajuste";
                                    echo '';
                                    echo '
                                    <td class="celdaCompleta tdCheck " colspan="' . $aux_r . '">';
                                    // if($tiempo_aux == $fila_r['fecha_entrada'] && $current==0) {
                                    //     echo '<div class="ajuste2" href="#caja_herramientas" data-toggle="modal "  onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                    //     ';
                                    //     echo '<section style="border-left:0px;" class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                                    //     echo '</div>';
                                    // }
                                    if($ultima == $fila_r['fecha_entrada']) {
                                        // print_r($fila_r['garantia']);
                                        if($filaL['garantia'] == "garantizada"){
                                            $estado = 6;
                                        }else{
                                            $estado = 7;
                                        }
                                        $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                        $clase="ajuste8";
                                        $re2= date('Y-m-d',$filaL['fecha_entrada']);
                                        $rs2= date('Y-m-d',$filaL['fecha_salida']);
                                        //Pedacito de la reserva 'anterior'
                                        echo '<div class="ajuste2"  style="margin-right:65px;" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                        ';
                                        echo '<section class="task ' . $estado_habitacion_reserva[0] . '" style="border-left:0px;">' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . ' </section>';
                                        echo '</div>';
                                    }else{
                                       
                                        $existetd=false;
                                    }
                                    // print_r($filaL['garantia']);
                                    // print_r($fila_r['garantia']);
                                    if($fila_r['garantia'] == "garantizada"){
                                        $estado = 6;
                                    }else{
                                        $estado = 7;
                                    }
                                    $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                    // $clase="ajuste8";
                                    echo '<div class="'.$clase.'" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                    ';
                                    echo '<section class="task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . '</section>';
                                    echo '            </div>';
                                    
                                    echo '
                                        </td>
                                    ';
                                   
                                }else{
                                   
                                   
                                    if($ultima!=""){
                                        // 
                                    }
                                    if($current!=0 && date('Y-m-d', $ultima) == date('Y-m-d', $tiempo_aux)  ) {
                                        // echo "h";
                                        // die();
                                        $noches_reserva=1;
                                        $estado=7;
                                        echo '
                                        <td class="celdaCompleta tdCheck ">';
                                        echo '<div class="ajuste2"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                        ';
                                        echo '<section class="task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . '</section>';
                                        echo '</div>';
                                        //agregar otra condicion para saber si hay una reserva.
                                        if($ultima == $fila_r['fecha_entrada']) {
                                            $clase="ajuste8";
                                            $re2= date('Y-m-d',$filaL['fecha_entrada']);
                                            $rs2= date('Y-m-d',$filaL['fecha_salida']);
                                            echo '<div class="ajuste2"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                            ';
                                            echo '<section class="task task--reserva-pendiente-pago" style="border-left:0px; margin-right:65px;"> Reserva pendiente ' . $re2 . " al " . $rs2  . ' </section>';
                                            echo '</div>';
                                           
                                        }else{

                                        echo '<div class="ajuste8" onclick="" >
                                        ';
                                        echo '<section class="" style="border-left:0px;"></section>';
                                        echo date('Y-m-d',$tiempo_aux);
                                        echo $noches_reserva;
                                        echo '</div>';
                                        // $tiempo_aux+=86400;
                                        // $existetd=false;
                                          
                                        }
                                        echo '
                                        </td>
                                        ';
                                        
                                        $show=true;
                                        // echo date('Y-m-d',$fila_r['fecha_entrada']) ."===". date('Y-m-d',$tiempo_aux);
                                        // die();
                                        
                                    }else{
                                        if($existetd){
                                            $existetd=true;
                                        }else{
                                            $existetd=false;
                                        }
                                       
                                    }  
                                    if(!$existetd){
                                        // echo "no";
                                        if($show){
                                            $tiempo_aux += 86400;
                                            
                                        }
                                        //cuando la fecha de reserva coincide con la fecha de ocupada y tiene varios dias de reservacion
                                        if(date('Y-m-d', $fila_r['fecha_entrada']) == date('Y-m-d', $tiempo_aux) ){

                                        //     echo "??";
                                        //     die();
                                        //     echo '
                                        //     <td class="celdaCompleta tdCheck ">';
                                        //     echo '<div class="ajuste2"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                        //     ';
                                        //     echo '<section class="task task--reserva-pendiente-pago" style="border-left:0px; margin-right:65px;"> Reserva pendiente ' . $re . " al " . $rs  . ' </section>';
                                        //     echo '</div>';
                                        //     echo '
                                        // </td>
                                        // ';
                                        }else{
                                            echo '
                                            <td class="celdaCompleta tdCheck ">';
                                            echo date('Y-m-d',$tiempo_aux);
                                            
                                            echo'
                                            </td>
                                            ';
                                            $show=false;

                                          
                                        }
                                       
                                       
                                        
                                       
                                    }
                                }   

                                if($show){
                    
                                    $ultima = $fila_r['fecha_salida'];
                     
                                    $filaL = $fila_r;
                                    $current++;
                                    $noches_reservas=0;
                                    $existetd=false;
                                    $show=false;
                                    continue;
                                }
                             
                                    if($noches_reserva<=1){
                                        $tiempo_aux += 86400;
                                        
                                    }else{
                                        // echo "si";
                                        // die();
                                        if($current==0){
                                           
                                            $tiempo_aux += 86400;
                                        }else{
                                            $n = 86400 * $noches_reserva;
                                            $tiempo_aux += $n;
                                            $noches_reserva=1;
                                        }
                                        // echo date('Y-m-d',$tiempo_aux);
                                        // if($yasume==false){
                                        //     echo "a";
                                        //     $tiempo_aux += 86400;
                                        // }
                                        //$tiempo_aux += 86400;
                                        // $tiempo_aux = $fila_r['fecha_salida'];
                                      
                                        
                                       
                                        // $timeset = true;
                                    }
                                   
                                
                                   
                                    $ultima = $fila_r['fecha_salida'];
                     
                                    $filaL = $fila_r;
                                   
                                    $current++;
                                    
                                    $noches_reserva=0;
                                    $existetd=false;
                                    $show=false;
                                       
                                }
                                
                                
                            }

                            
                            // die();
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
       
    }
}
