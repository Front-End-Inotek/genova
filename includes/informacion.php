<?php
date_default_timezone_set('America/Mexico_City');

include_once('consulta.php');

class Informacion extends ConexionMYSql
{

    const INTERNO_SUCIA ="sucia";
   

    // Constructor
    function __construct()
    {

    }

    function ver_detalle($hab_id,$estado,$nombre,$persona,$mov){
    switch ($estado) {
        case 0:
            echo $nombre;
            break;
        case 1:
            echo $persona;
            break;
        case 2:
            echo $persona;
            break;
        case 3:
            echo $persona;
            break;
        case 4:
            echo $persona;
            break;
        case 5:
            echo $persona;
            break;
        case 6:
            echo "-";
            break;
        default:
            echo "-";
            break;
    }
    }

    function mostrarhab($id,$token, $estatus_hab=""){
    include_once("clase_cuenta.php");
    include('clase_movimiento.php');
    $cuenta= NEW Cuenta(0);
    $movimiento= NEW movimiento(0);
    $cronometro=0;
    
    $tiempo_actual = time();

    $filtro="";
    if($estatus_hab!=null){
        $filtro ="AND hab.estado = " . $estatus_hab;
    }
    if (true) {
    $sentencia = "SELECT movimiento.fin_hospedaje as fin,hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id
    WHERE hab.estado_hab = 1 $filtro 
    /*AND hab.id=3*/
    ORDER BY id";
    $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
    $consulta= $this->realizaConsulta($sentencia,$comentario);
    // echo $sentencia;
    }


/*
    $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado = 1 ORDER BY id";
    $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
    $consulta= $this->realizaConsulta($sentencia,$comentario);*/

echo'
<!---
<div class="botones-mostrados" id="botones">
<h3 class="titulo-filtro">Filtrar por:</h3>
<button class="botones-estado" id="mostrar-todas" onclick="mostrar_estadorack()">Todas</button>
<button class="botones-estado" id="mostrar-bloqueo" onclick="mostrar_estadorack(99)"> Bloqueo</button>
<button class="botones-estado" id="mostrar-uso-casa" onclick="mostrar_estadorack(2)"> Uso Casa</button>
<button class="botones-estado" id="mostrar-ocupadas" onclick="mostrar_estadorack(1)"> Ocupadas</button>
<button class="botones-estado" id="mostrar-disponibles" onclick="mostrar_estadorack(0)"> Disponibles</button>
<button class="botones-estado" id="mostrar-vacias-sucias" onclick="mostrar_estadorack(5)">Sucia Vacia </button>
<button class="botones-estado" id="mostrar-mantenimiento" onclick="mostrar_estadorack(6)"> Mantenimiento</button>
<button class="botones-estado" id="mostrar-ocupada-sucias" onclick="mostrar_estadorack(7)">Sucia Ocupada</button>
<button class="botones-estado" id="mostrar-vacia-limpieza" onclick="mostrar_estadorack(8)"> Limpieza Vacia </button>
<button class="botones-estado" id="mostrar-ocupada-limpieza" onclick="mostrar_estadorack(9)"> Limpieza Ocupada</button>
<button class="botones-estado" id="mostrar-reservada-pagada" onclick="mostrar_estadorack(10)"> Reservacion pagada</button>
<button class="botones-estado" id="mostrar-reservada-pendiente" onclick="mostrar_estadorack(11)"> Reservacion deuda</button>
</div> -->
<div class="arealight"></div>

';

    echo ' <div class="containerRackOp" id="contenido-boton">';
    while ($fila = mysqli_fetch_array($consulta))
    {
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
        $reserva_entrada=0;
        $reserva_salida=0;
        $estado_hab = $fila['estado'];
        // echo $sentencia_reservaciones;
        $comentario = "Optenemos las habitaciones para el rack de habitaciones";
        $consulta_reservaciones = $this->realizaConsulta($sentencia_reservaciones, $comentario);
        $contador_row = mysqli_num_rows($consulta_reservaciones);
        
        while ($fila_r = mysqli_fetch_array($consulta_reservaciones)) {
            // echo date('Y-m-d',$tiempo_actual) ."|". date('Y-m-d',$fila_r['fecha_entrada']);
            if(date('Y-m-d',$tiempo_actual) == date('Y-m-d',$fila_r['fecha_entrada']) && $estado_hab!=1){
                $reserva_entrada=$fila_r['fecha_entrada'];
                $reserva_salida=$fila_r['fecha_salida'];
                if($fila_r['garantia'] == "garantizada"){
                    $estado_hab = 6;
                }else{
                    $estado_hab = 7;
                }
                break;
            }
        }
        $clase_expirar="";
        if(date('Y-m-d',$tiempo_actual) >= date('Y-m-d',$fila['fin']) && $estado_hab==1){
            $clase_expirar="expirarRack";
        }

        $total_faltante= 0.0;
        $estado="no definido";
        switch($estado_hab) {
            case 0:
            $estado= "Disponible limpia";
            $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
            $tipo_habitacion= $fila['tipo_nombre'];
            break;

            case 1:
            $estado= "Ocupado";
            $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
            if($fila['interno'] == self::INTERNO_SUCIA){
                $estado = "Sucia ocupada";
            }
            if($fila['interno'] == "limpieza"){
                $estado = "Ocupada limpieza";
            }
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
            $estado="Mantenimiento";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;

            case 5:
            $estado="Bloqueo";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
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

        if($fila['tipo']>0){

            echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$estado_hab.',\''.$fila['nombre'].'\','.$reserva_entrada.','.$reserva_salida.')" >';
            switch($estado) {
                case "Disponible limpia":
                echo'<div class="btn disponible-limpia">';
                break;

                case "Vacia limpia":
                echo'<div class="btn vacia-limpia">';
                break;

                case "Vacia sucia":
                echo'<div class="btn vacia-sucia">';
                break;

                case "Ocupado":
                echo'<div class="btn  supervision ocupadoH '.$clase_expirar.'">';
                break;

                case "Sucia ocupada":
                echo'<div class="btn sucia-ocupada">';
                break;

                case "Ocupada limpieza":
                echo'<div class="btn ocupada-limpieza">';
                break;

                case "Reserva pagada":
                echo'<div class="btn reserva-pagada">';
                break;

                case "Reserva pendiente":
                echo'<div class="btn reserva-pendiente">';
                break;

                case "Uso casa":
                echo'<div class="btn usoCasa">';
                break;

                case "Mantenimiento":
                echo'<div class="btn mantenimiento">';
                break;

                case "Bloqueo":
                echo'<div class="btn bloqueo">';
                break;

                default:
                //echo "Estado indefinido";
                break;
            }
            echo'
                <a >
                    Habitación ';
                    if($fila['id']<100){
                        echo $fila['nombre'];
                    }else{
                        echo $fila['comentario'];
                    }
                    echo '<br>'. $estado .'  <br>';

            echo '
                    <span class="nombre" id="N1">';
            $fecha_salida= $movimiento->ver_fecha_salida($fila['moviemiento']);
            //$fecha_salida= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            if($estado_hab == 0){
            if($cronometro == 0){
            
                echo $tipo_habitacion;
            }else{
                $fecha_inicio= date("d-m-Y",$cronometro);
                echo $fecha_inicio;
                echo '<br>';
                echo $tipo_habitacion;
            }
            }elseif($estado_hab == 1){
            echo $fecha_salida;
            }else{
            if($cronometro == 0){
                $fecha_inicio= '&nbsp';
              
            }else{
                $fecha_inicio= date("d-m-Y",$cronometro);
            }
           

            echo $fecha_inicio;
            }
            echo '</span>';

            echo '
                </a>
            </div>
            </div>';

        }else{
        echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';
        echo '</div>';
        }
       
    }
    echo ' </div>';
  
    }
    
}
?>
