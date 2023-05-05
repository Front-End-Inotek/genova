<?php

include_once('consulta.php');
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, "es_ES");

class RackHabitacional extends ConexionMYSql
{
    public function mostrar($id)
    {
        include_once("clase_cuenta.php");
        include('clase_movimiento.php');

        $cuenta= new Cuenta(0);
        $movimiento= new movimiento(0);
        $cronometro=0;

        //Se utiliza la misma consulta para el rack de operaciones
        $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre 
AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id 
LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1 

ORDER BY id";
        $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
        $consulta= $this->realizaConsulta($sentencia, $comentario);


        echo '
<!--todo el contenido que estre por dentro de este div sera desplegado junto a la barra de nav--->
<!--tabla operativa--->

    <div class="headTable justify-content-center align-items-center">
        <div style="text-align:center;">
        <div>
            <h3>Marzo 2023<button id="btn-mes">▾</button></h3>
        </div>
        </div>
    </div>


<!-- DISPLAY USER-->
<div class="table-responsive">
    <div id="cal-largo">
    <div class="cal-sectionDiv">

        <table class="tableRack table-striped table-bordered" id="tablaTotal">
        <thead class="cal-thead">
            <tr>
            <th class="cal-viewmonth" id="changemonth"></th>';
        $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD
        $fecha_final = date('Y-m-d', strtotime('+32 days')); // Obtiene la fecha actual más 32 días en formato YYYY-MM-DD
        $fecha = $fecha_actual; // Se guarda la fecha acutal en una nueva variable
        $contador = 0;
        $total_dias = 32;   //En una nueva variable guardamos el total de dias
        $yesterday =  date('j', strtotime('-1 day'));

        $daybefore = date('d-m-Y', strtotime('-1 day'));

        // echo $daybefore;

        $dia = date('N', strtotime($fecha));

        $diaanterior = date('N', strtotime('-1 day'));

        switch ($diaanterior) {
            case 1:
                echo "<th class='cal-dia'> LUNES ". $yesterday ."</th>";
                break;

            case 2:
                echo "<th class='cal-dia'> MARTES ". $yesterday ."</th>";
                break;

            case 3:
                echo "<th class='cal-dia'> MIERCOLES ". $yesterday ."</th>";
                break;

            case 4:
                echo "<th class='cal-dia'> JUEVES ". $yesterday ."</th>";
                break;

            case 5:
                echo "<th class='cal-dia'> VIERNES ". $yesterday ."</th>";
                break;

            case 6:
                echo "<th class='cal-dia'> SABADO ". $yesterday ."</th>";
                break;

            case 7:
                echo "<th class='cal-dia'> DOMINGO ". $yesterday ."</th>";
                break;

            default:
                # code...medioDia
                break;
        }
        $todas_fechas =[];
        $aux_fecha_final = date('Y-m-d', strtotime($fecha_final . '+1 day'));
        while ($fecha <= $aux_fecha_final) {
            switch ($dia) {
                case 1:
                    echo "<th class='cal-dia'> LUNES ". date('j', strtotime($fecha)) ."</th>";
                    break;

                case 2:
                    echo "<th class='cal-dia'> MARTES ". date('j', strtotime($fecha)) ."</th>";
                    break;

                case 3:
                    echo "<th class='cal-dia'> MIERCOLES ". date('j', strtotime($fecha)) ."</th>";
                    break;

                case 4:
                    echo "<th class='cal-dia'> JUEVES ". date('j', strtotime($fecha)) ."</th>";
                    break;

                case 5:
                    echo "<th class='cal-dia'> VIERNES ". date('j', strtotime($fecha)) ."</th>";
                    break;

                case 6:
                    echo "<th class='cal-dia'> SABADO ". date('j', strtotime($fecha)) ."</th>";
                    break;

                case 7:
                    echo "<th class='cal-dia'> DOMINGO ". date('j', strtotime($fecha)) ."</th>";
                    break;

                default:
                    # code...
                    break;
            }
            $todas_fechas[] = $fecha;

            $fecha = date('Y-m-d', strtotime($fecha . ' +1 day'));
            $dia = date('N', strtotime($fecha));
            $contador++;

        }

        echo'
            </tr>
        </thead>';
        $contador_row=0;
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



                if ($fila['estado'] == 0) {
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
</div>';
    }
}
