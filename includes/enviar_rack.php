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
                $sentencia_reservaciones = "SELECT hab.id,hab.nombre, reservacion.fecha_entrada, reservacion.fecha_salida,hab.estado ,movimiento.estado_interno AS interno
                FROM movimiento
                left join reservacion on movimiento.id_reservacion = reservacion.id
                LEFT JOIN hab on movimiento.id_hab = hab.id
                where reservacion.estado =1
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
            }
        }

    }


?>