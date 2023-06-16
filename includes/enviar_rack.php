<?php
include_once('consulta.php');
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, "es_ES");
    class Rack  extends ConexionMYSql{

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

    public function calcularWidths($noches_reserva,$noches){
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
            $hab_id=$id;
            $anio_rack = date('Y');
            $cuenta = new Cuenta(0);
            $movimiento = new movimiento(0);
            $cronometro = 0;
            //Se utiliza la misma consulta para el rack de operaciones
            $sentencia = "SELECT hab.id ,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno ,movimiento.inicio_hospedaje AS inicio , movimiento.fin_hospedaje AS fin 
            FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id 
            WHERE hab.id=$hab_id
            AND hab.estado_hab = 1  ORDER BY id";
            $comentario = "Optenemos las habitaciones para el rack de habitaciones";
            $consulta = $this->realizaConsulta($sentencia, $comentario);
            //Ciclo while que nos mostrara todas las habitaciones habilitadas y los estados de estas
            while ($fila = mysqli_fetch_array($consulta)) {
                echo ' <td class="cal-userinfo">
                ';
                    echo 'Habitación ------';
                        echo $hab_id;
                echo '
                    </td>´
                ';
                $tiempo = $tiempo_inicial - 86400;
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
                    //Se omite el día anterior.
                    if ($i == 1) {
                        /*echo '
                            <td class="celdaCompleta tdCheck " >
                            </td>
                        ';*/
                    } else {
    
                        //Se calculan los estados de las habitaciones.
                        $mes = $this->convertir_mes(date('n', $tiempo));
                        $dia = date('d', $tiempo);
                        $tiempo += 86400;
                        $estado_habitacion_matutino = $this->estado_habitacion($fila['estado'], 1,$fila['interno']);
                        $estado_habitacion_vespertino = $this->estado_habitacion($fila['estado'], 2,$fila['interno']);
    
                        //Si la habitación actual no está ocupada entra aqui.
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
                            $contador = 0;
                            $imprimi_ocupadas=true;
                            $ocupada=true;
                            //si no hay reservaciones se termina el ciclo: y solo imprime las ocupadas con un 'medio dia'  al final.
                            if($contador_row==0){
                                $noches++;
                                $noches_reserva=1;
                                $widths = $this->calcularWidths($noches_reserva,$noches);
                                $width = $widths[0];
                                $width2 = $widths[1];
                                echo '';
                                echo '
                                <td class="celdaCompleta tdCheck " colspan="' . $noches  . '">';
                                echo '<div class="ajuste7" style="'.$width.'" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                ';
                                echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . '</section>';
                                echo '</div>';
                                echo '<div class="ajuste3" style="'.$width2.';">';
    
                                echo '</div>';
                                echo'
                                </td>
                                ';
                                $i = 32;
                            }else{
                                //aqui van las reservas, fila_r contiene las reservas
                                //$tiempo_aux contendrá el tiempo 'actual', mas la suma de cada dia para cada reservación.
                                $tiempo_aux = $fila['fin'] ;
                                $current=0; //contador del ciclo de reservaciones.
                                $ultima=""; //penúltima fecha de la reservacion.
                                $filaL=null; //contendrá los datos de la ultima penúltima reservación.
                                $existetd=false; //Sí ya se imprió un td, no volver a imprimir.
                                $show=false;
                                while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
                                    $noches_reserva = ($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                                    //ciclo para 'avanzar' atraves de los días de la reservación.
                                    while(date('Y-m-d',$tiempo_aux) < date('Y-m-d',$fila_r['fecha_salida'])){
                                    //tiempo aux será una variable que contendrá los "días actuales", esto para comparar el día actual (dentro del ciclo de 31 dias), 
                                    //con el tiempo de la reservacion
                                    $re= date('Y-m-d',$fila_r['fecha_entrada']);
                                    $rs= date('Y-m-d',$fila_r['fecha_salida']);
                                    $clase="ajuste";
                                    //Si el contador de fecha es igual a la fecha de entrada de la reservación y si trata del primer dato.
                                    if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada']) && $current==0 )
                                    {
                                        //Se verifica si la reservación está garantizada o no.
                                        if($fila_r['garantia'] == "garantizada"){
                                            $estado = 6;
                                        }else{
                                            $estado = 7;
                                        }
                                        //Se calcula el tamaño de los divs dependiendo de las noches de reserva.
                                        $widths = $this->calcularWidths($noches_reserva,$noches);
                                        $width = $widths[0];
                                        $width2 = $widths[1];
                                        $total_noches = $widths[2];
    
                                        //?????x
                                        $tiempo_aux= $fila_r['fecha_salida'] - 86400;
    
                                        $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                        //Este td es para cuando se ocupa imprimir las noches ocupadas junto con la reservación que coicida en la fecha de entrada con 
                                        //la fecha de salida de la ocupada.
    
    
                                        echo '';
                                        echo '
                                        <td class="celdaCompleta tdCheck " colspan="' . $total_noches  . '">';
                                        echo '<div class="ajuste6" style="'.$width.'"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                        ';
                                        echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . ' </section>';
                                        echo '</div>';
                                        echo '<div class="ajuste4" style="'.$width2.'"    href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                        ';
                                        echo '<section class="task ' . $estado_habitacion_reserva[0] . ' dio"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . ' </section>';
                                        echo '            </div>';
                                        echo'
                                        </td>
                                        ';
    
                                        $existetd=true;
                                    }elseif($current==0) {
                                        //Este td es para cuando no coicide la fecha de reservación con la ocupada.
                                        //Cuando está ocupada, pero no tiene reserva que conicida.
                                        $noches +=1;
                                        $widths = $this->calcularWidths(1,$noches);
                                        $width  = $widths[0];
                                        $width2 = $widths[1];
                                        echo '';
                                        echo '
                                        <td class="celdaCompleta tdCheck " colspan="' . $noches  . '">';
                                        echo '<div class="ajuste7" style="'.$width.'" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $fila['estado'] . ',' . $fila['nombre'] . ')" >
                                        ';
                                        echo '<section class="task ' . $estado_habitacion_matutino[0] . '"> ' . $estado_habitacion_matutino[1] . ' ' . $noches . '</section>';
                                        echo '</div>';
                                        //Div adicional para el mediodia
                                        echo '<div class="ajuste3" style="'.$width2.'">
                                        ';
                                        echo '</div>';
    
                                        echo'
                                        </td>
                                        ';
                                        $show=true;
                                    }
                                    //Si la fecha 'actual' ($tiempo_aux) es igual a la fecha de entrada de la reservación.
                                    //Aqui es para cuando la fecha actual coincide con la fecha de entrada de la reservación.
                                    if(date('Y-m-d',$tiempo_aux) == date('Y-m-d',$fila_r['fecha_entrada'])  && $current!=0 ){
                                        $aux_r =($fila_r['fecha_salida'] - $fila_r['fecha_entrada'])/86400;
                                        $tiempo_aux= $fila_r['fecha_salida'] - 86400;
                                        $noches_reserva=1;
                                        $estado=7;
                                        $clase="ajuste";
                                        echo '';
                                        echo '
                                        <td class="celdaCompleta tdCheck " colspan="' . $aux_r   . '">';
                                        //Y si la ultima reservación coincide con la reservación actual.
                                        if($ultima == $fila_r['fecha_entrada']) {
                                            // print_r($fila_r['garantia']);
                                            if($filaL['garantia'] == "garantizada"){
                                                $estado = 6;
                                            }else{
                                                $estado = 7;
                                            }
                                            $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                            $clase="ajuste6";
                                            $re2= date('Y-m-d',$filaL['fecha_entrada']);
                                            $rs2= date('Y-m-d',$filaL['fecha_salida']);
                                            //Pedacito de la reserva 'anterior'
                                            echo '<div class="ajuste4 "  style="margin-right:2%;" href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                            ';
                                            echo '<section class="cacho task  ' . $estado_habitacion_reserva[0] . '" style="border-left:0px;">' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . '</section>';
                                            echo '</div>';
                                            //script para hacer que el div 'anterior' al hacerle hover afecte al 'hijo'.
                                            // echo "<script> 
                                            // elemento1 = document.querySelector('.dio')
                                            // elemento2 = document.querySelector('.cacho')
                                            // elemento1.addEventListener('mouseenter', function() {
    
                                            //elemento2.classList.add('elhover');
                                            //});
                                            //elemento1.addEventListener('mouseleave', function() {
    
                                            //elemento2.classList.remove('elhover');
                                            //});
    
                                            //elemento2.addEventListener('mouseenter', function() {
                                            //elemento1.classList.add('elhover');
                                            // });
                                            //elemento2.addEventListener('mouseleave', function() {
                                            //elemento1.classList.remove('elhover');
                                            //});
    
                                            // </script>";
                                        }else{
                                            //Si no existe se toma como que no hay td aún.
                                            $existetd=false;
                                        }
                                        if($fila_r['garantia'] == "garantizada"){
                                            $estado = 6;
                                        }else{
                                            $estado = 7;
                                        }
                                        //Si hay concidencias de una reserva anterior con la actual se cambiará la clase del div, sino, el div "normal" rellenará todo el div.
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
                                        //Dada la condición siempre pasará a esta parte cuando $current==0.
                                        if($ultima!=""){}
                                        //Si la "ultima" reserva coincide con la fecha actual. (omitiendo el primer valor current==0)
                                        if($current!=0 && date('Y-m-d', $ultima) == date('Y-m-d', $tiempo_aux)  ) {
                                            $noches_reserva=1;
                                            $estado=7;
                                            echo '
                                            <td class="celdaCompleta tdCheck ">';
                                            echo '<div class="ajuste2"  href="#caja_herramientas"  data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                            ';
                                            echo '<section style="border-left:0px;" class="task ' . $estado_habitacion_reserva[0] . '"> ' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . '</section>';
                                            echo '</div>';
                                            if($ultima == $fila_r['fecha_entrada']) {
                                                $clase="ajuste8";
                                                $re2= date('Y-m-d',$filaL['fecha_entrada']);
                                                $rs2= date('Y-m-d',$filaL['fecha_salida']);
                                                echo '<div class="ajuste2"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                                ';
                                                echo '<section class="task task--reserva-pendiente-pago" style="border-left:0px; margin-right:2%;"> Reserva pendiente ' . $re2 . " al " . $rs2  . '</section>';
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
                                            //Se mantiene el estado de $existetd, para no alterarlo.
                                            if($existetd){
                                                $existetd=true;
                                            }else{
                                                $existetd=false;
                                            }
    
                                        }
                                        //Si no existe ya el td.
                                        if(!$existetd){
                                            //show cumple la función similar a existetd, sería como si no existe el td, pero ya se mostró uno en algún punto
                                            //se le suma 1 día al tiempo actual.
                                            if($show){
                                                $tiempo_aux += 86400;
    
                                            }
                                            //cuando la fecha de reserva coincide con la fecha de ocupada y tiene varios dias de reservacion
                                            if(date('Y-m-d', $fila_r['fecha_entrada']) == date('Y-m-d', $tiempo_aux) ){
                                            }else{
                                                //Como no existe el existe el td y la fecha de entrada de la reserva no es igual al tiempo actual, imprime un td vacío.
                                                echo '
                                                <td class="celdaCompleta tdCheck ">';
                                                echo date('Y-m-d',$tiempo_aux);
    
                                                echo'
                                                </td>
                                                ';
                                                //Se resetea show., para que no sume nuevamente otros días.
                                                $show=false;
    
    
                                            }
    
                                        }
                                    }
                                    //Si ya se mostró algún td, ya no suma dias, ni muestra td, solo avanza a la siguiente fecha de la reservación.
                                    if($show){
                                        $ultima = $fila_r['fecha_salida'];
                                        $filaL = $fila_r;
                                        $current++;
                                        $noches_reservas=0;
                                        $existetd=false;
                                        $show=false;
                                        continue;
                                    }
                                    //Condiciones para el numero de noches de reserva, si es 1 sola noche el tiempo actual se estará sumando solo en 1 día.
                                    if($noches_reserva<=1){
                                        $tiempo_aux += 86400;
                                    }else{
                                        // Si solo se trata del primero también seguirá sumando solo 1 día
                                        if($current==0){
                                            $tiempo_aux += 86400;
                                        }else{
                                            //Solo en casos en los que no se al primer elemento del ciclo y tenga mas de 1 noche de reserva, 
                                            //entonces el tiempo actual se le quedará  con la cantidad de noches de la reservacion 
                                            // y las noches se setean a 1, para que ya no vuelva a sumarle dichos días, sino que termine con la ultima 
                                            //fecha de reservacion.
                                            $n = 86400 * $noches_reserva;
                                            $tiempo_aux += $n;
                                            $noches_reserva=1;
                                        }
    
                                    }
    
                                    //ultima guarda la penultima fecha de salida de la reservación para compararla con la reserva "siguiente", y dibujarla en el mismo td si coiciden.
                                    $ultima = $fila_r['fecha_salida'];
                                    $filaL = $fila_r;
                                    $current++;
                                    $noches_reserva=0;
                                    $existetd=false;
                                    $show=false;
                                    }
    
                                }
                                if($filaL['garantia'] == "garantizada"){
                                    $estado = 6;
                                }else{
                                    $estado = 7;
                                }
                                $estado_habitacion_reserva = $this->estado_habitacion($estado, "","");
                                $clase="ajuste6";
                                $re2= date('Y-m-d',$filaL['fecha_entrada']);
                                $rs2= date('Y-m-d',$filaL['fecha_salida']);
                                echo '<td class="celdaCompleta tdCheck " colspan="' . 1  . '">';
                                echo '<div class="ajuste6"  href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas(' . $fila['id'] . ',' . $estado . ',' . $fila['nombre'] . ')" >
                                ';
                                echo '<section class="cacho task  ' . $estado_habitacion_reserva[0] . '" style="border-left:0px;">' . $estado_habitacion_reserva[1] . ' ' . $noches_reserva . '</section>';
                                echo '</div>';
                                echo '<div class="ajuste4"  style="margin:0; padding:0;"></div>';
                                echo'
                                </td>
                                ';
                                // die();
                                $i=32;
                            }
                           
                        }
                        if ($i == 2 && $fila['estado'] != 1 ) {
                            $i = 32;
                        }
                    }
                }
            }
        }

    }


?>