<?php
include_once('consulta.php');
date_default_timezone_set('America/Mexico_City');
setlocale(LC_ALL, "es_ES");

class RackHabitacional extends ConexionMYSql{
function mostrar($id){
include_once("clase_cuenta.php");
include('clase_movimiento.php');

$cuenta= NEW Cuenta(0);
$movimiento= NEW movimiento(0);
$cronometro=0;

//Se utiliza la misma consulta para el rack de operaciones
$sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1 ORDER BY id";
$comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
$consulta= $this->realizaConsulta($sentencia,$comentario);

echo '
<!--todo el contenido que estre por dentro de este div sera desplegado junto a la barra de nav--->
<!--tabla operativa--->

    <div class="row justify-content-center align-items-center">
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

        <table class="table table-striped table-bordered" id="tablaTotal">
        <thead class="cal-thead">
            <tr>
            <th class="cal-viewmonth" id="changemonth"></th>';
            $fecha_actual = date('Y-m-d'); // Obtiene la fecha actual en formato YYYY-MM-DD
            $fecha_final = date('Y-m-d', strtotime('+32 days')); // Obtiene la fecha actual más 32 días en formato YYYY-MM-DD
            $fecha = $fecha_actual;
            $contador = 0;
            $yesterday =  date('j', strtotime('-1 day'));
            $total_dias = 32;

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
                    # code...
                    break;
            }

            while ($fecha <= $fecha_final) {
            $dia = date('N', strtotime($fecha));
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

            $fecha = date('Y-m-d', strtotime($fecha . ' +1 day'));
            $contador++;

            if ($contador > $total_dias) {
                break;
            }
            }
            echo'
            </tr>
        </thead>';

/////////////////////////////////////////////////////////////////////////////////////////////////
        //Ciclo while que nos mostrara todas las habitaciones habilitadas y los estados de estas
/////////////////////////////////////////////////////////////////////////////////////////////////

        while ($fila = mysqli_fetch_array($consulta))
        {
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
            $estado= "Vacia limpia";
            $cronometro= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
            break;

            case 2:
            $estado= "Vacia sucia";
            $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
            break;

            case 3:
            $estado= "Limpieza";
            $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
            break;

            case 4:
            $estado= "Sucia ocupada";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;

            case 5:
            $estado="Ocupada limpieza";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;

            case 6:
            $estado="Reserva pagada";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;

            case 7:
            $estado= "Reserva pendiente";
            $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
            break;

            case 8:
            $estado= "Uso casa";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
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
        if($fila['tipo']>0){
        echo'
        <tbody class="cal-tbody">
            <tr><td class="cal-userinfo">
                    Habitación ';
                    if($fila['id']<100){
                        echo $fila['nombre'];
                    }else{
                        echo $fila['comentario'];
                    }
        echo'</td>';

/////////////////////// Inicia la columna de los estados de las habitaciones
                    if($estado == "Disponible limpia" ){
                        echo'
                        <td class="celdaCompleta">';
                        //Segunda columna que muesta los estados de las habitaciones
                        //Definimos un div que contendra un evento onclick con el que se desplegara un modal y se mostrar la informacion de la habitacion
                        echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
                        //Con esta estructura de control definimos los estados y los estilos correspondientes a los estados
                        switch($estado) {
                            case "Disponible limpia":
                            echo'<section class="task task--disponible-limpia" > <a> '. $estado .'<br> </a>';
                            break;

                            default:
                            //echo "Estado indefinido";
                            break;

                        //Definimos la informacion que contendra las card de las habitaciones el numero de habitacion y el estado
                        echo '
                        <a> '. $estado .'<br> </a>
                                </section>
                            </div>
                        </td>';
                    }

                    }else{
                        for ($i=0; $i < $total_dias+2; $i++) {
                            echo'
                            <td class="celdaCompleta">';
                            //Segunda columna que muesta los estados de las habitaciones
                            //Definimos un div que contendra un evento onclick con el que se desplegara un modal y se mostrar la informacion de la habitacion
                            echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
                            //Con esta estructura de control definimos los estados y los estilos correspondientes a los estados
                            switch($estado) {
                                case "Disponible limpia":
                                echo'<section class="task task--disponible-limpia" > <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Vacia limpia":
                                echo'<section class="task task--limpieza-vacia"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Vacia sucia":
                                echo'<section class="task task--vacia-sucia" title="aqui mas informacion"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Limpieza":
                                echo'<div class="btn ocupada-limpieza"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Sucia ocupada":
                                echo'<section class="task task--ocupada-sucia"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Ocupada limpieza":
                                echo'<section class="task task--limpieza-ocupada"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Reserva pagada":
                                echo'<section class="task task--reserva-pagada"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Reserva pendiente":
                                echo'<section class="task task--reserva-pendiente-pago ajuste"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Uso casa":
                                echo'<section class="task task--uso-casa"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Mantenimiento":
                                echo'<section class="task task task--mantenimiento ajuste-2dias"> <a> '. $estado .'<br> </a>';
                                break;
    
                                case "Bloqueo":
                                echo'<section class="task task--bloqueado"> <a> '. $estado .'<br> </a>';
                                break;
    
                                default:
                                //echo "Estado indefinido";
                                break;
    
                            //Definimos la informacion que contendra las card de las habitaciones el numero de habitacion y el estado
                            echo '
                            <a> '. $estado .'<br> </a>
                                    </section>
                                </div>
                            </td>';
                        }
                    }
                    }



            /*echo'
                <td class="celdaCompleta">';
                //Segunda columna que muesta los estados de las habitaciones
                //Definimos un div que contendra un evento onclick con el que se desplegara un modal y se mostrar la informacion de la habitacion
                echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
                //Con esta estructura de control definimos los estados y los estilos correspondientes a los estados
                switch($estado) {
                    case "Disponible limpia":
                    echo'<section class="task task--disponible-limpia" >';
                    break;

                    case "Vacia limpia":
                    echo'<section class="task task--limpieza-vacia">';
                    break;

                    case "Vacia sucia":
                    echo'<section class="task task--vacia-sucia" title="aqui mas informacion">';
                    break;

                    case "Limpieza":
                    echo'<div class="btn ocupada-limpieza">';
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

                //Definimos la informacion que contendra las card de las habitaciones el numero de habitacion y el estado
                echo '
                <a> '. $estado .'<br> </a>
                        </section>
                    </div>
                </td>';*/

/////////////////////// Finaliza la columna de los estados de las habitaciones

            echo '
            </tr>
        </tbody>';

        }else{
            //echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';
        }
            }
        echo'</table>
        </div>
    </div>
</div>';
        }
    }


?>