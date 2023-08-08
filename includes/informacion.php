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
    $sentencia = "SELECT movimiento.fin_hospedaje as fin,hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno , datos_vehiculo.id as id_vehiculo
    FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id 
    LEFT JOIN movimiento ON hab.mov = movimiento.id
    LEFT JOIN datos_vehiculo on movimiento.id_reservacion = datos_vehiculo.id_reserva
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
        $icono_carro="";

        if(!empty($fila['id_vehiculo'])){
            $icono_carro='<i class="bx bxs-car car"></i>';
        }
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

            $color="";
            $tipo = $fila['tipo'];
            switch ($tipo) {
                case '1':
                    $color ="pink"; // sencilla (servidor)
                    break;
                case '2':
                    $color ="yellow"; // king
                    break;
                case '3':
                    $color ="blue"; //doble
                    break;
                case '4':
                    $color ="green";
                    break;
                case '5':
                    $color ="purple";
                    break;
                case '6':
                    $color ="yellow";
                    break;
                case '7':
                    $color ="brown";
                    break;
                case '8':
                    $color ="cyan";
                    break;
                case '9':
                    $color ="indigo";
                    break;
                case '10':
                    $color ="orange";
                    break;
                case '11':
                    $color ="salmon";
                    break;
                default:
                    # code...
                    $color ="gray";
                    break;
            }
            $estilo_tipo='style="border-left-color: '.$color.' !important;"';

            echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$estado_hab.',\''.$fila['nombre'].'\','.$reserva_entrada.','.$reserva_salida.')" >';
            switch($estado) {
                case "Disponible limpia":
                $estado="";
                echo'<div class="btn disponible-limpia" '.$estilo_tipo.'>';
                echo '<i class="bx bxs-brush-alt clean"></i>';
                break;

                case "Vacia limpia":
                echo'<div class="btn vacia-limpia" '.$estilo_tipo.'>';
                echo '<i class="bx bxs-brush-alt clean"></i>';
                break;

                case "Vacia sucia":
                echo'<div class="btn vacia-sucia" '.$estilo_tipo.'>';
                echo '<i class="bx bxs-brush-alt dirt"></i>';
                break;

                case "Ocupado":
                echo'<div class="btn ocupadoH '.$clase_expirar.'" '.$estilo_tipo.'>';
                echo '<i class="bx bxs-brush-alt clean"></i>';
                echo $icono_carro;
                break;

                case "Sucia ocupada":
                echo'<div class="btn OcupadaSucia" '.$estilo_tipo.'>';
                echo '<i class="bx bxs-brush-alt dirt"></i>';
                echo $icono_carro;

                break;

                case "Ocupada limpieza":
                echo'<div class="btn ocupada-limpieza" '.$estilo_tipo.'>';
                echo '<i class="bx bxs-brush-alt cleaning"></i>';
                echo $icono_carro;

                break;

                case "Reserva pagada":
                echo'<div class="btn reserva-pagada" '.$estilo_tipo.'>';
                break;

                case "Reserva pendiente":
                echo'<div class="btn reserva-pendiente" '.$estilo_tipo.'>';
                break;

                case "Uso casa":
                echo'<div class="btn usoCasa" '.$estilo_tipo.'>';
                break;

                case "Mantenimiento":
                echo'<div class="btn mantenimiento" '.$estilo_tipo.'>';
                break;

                case "Bloqueo":
                echo'<div class="btn bloqueo" '.$estilo_tipo.'>';
                break;

                default:
                //echo "Estado indefinido";
                break;
            }
            echo'
                <a >
                    Hab. ';
                    if($fila['id']<100){
                        echo $fila['nombre'];
                    }else{
                        echo $fila['comentario'];
                    }
                    echo '<br>'. $estado .'  <br>';

            echo '
                    <span class="nombre" id="N1">';
            $fecha_salida= $movimiento->ver_fecha_salida($fila['moviemiento']);
            $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
            if($total_faltante > 0){
                $saldo = '$'.number_format($total_faltante, 2);
                $saldo_c="green";
            }elseif($total_faltante==0){
                $saldo= '$0.0';
            }else{
                $total_faltante= substr($total_faltante, 1);
                $saldo= '-$'.number_format($total_faltante, 2);
                $saldo_c="red";
            }
            //$fecha_salida= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            if($estado_hab == 0){
            if($cronometro == 0){
            
                // echo $tipo_habitacion;
                
            }else{
                $fecha_inicio= date("d-m-Y",$cronometro);
                echo $fecha_inicio;
                echo '<br>';
                // echo $tipo_habitacion;
               
            }
            }elseif($estado_hab == 1){
            echo $fecha_salida;
            echo "<br>";
            echo $saldo;
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

echo '<i class="btn-info-custom bx bxs-info-circle" data-toggle="modal" data-target="#exampleModal" ></i>';
echo '
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          &times;
        </button>
      </div>
      <div class="modal-body">
        <ul class="list-group mb-4">
            <li class="list-group-item fw-bolder">Tipos de habitaciones</li>
            <li class="list-group-item sencilla">DOBLE</li>
            <li class="list-group-item king">KING</li>
            <li class="list-group-item doble">SENCILLA</li>
        </ul>
        <ul class="list-group mb-4">
            <li class="list-group-item fw-bolder">Estado de habitaciones</li>
            <li class="list-group-item InfoDisponible">Disponible limpia</li>
            <li class="list-group-item InfoLimpiezaVacia">Limpieza vacia</li>
            <li class="list-group-item InfoOcupadaLimpieza">Limpieza ocupada</li>
            <li class="list-group-item InfoOcupada">Ocupada</li>
            <li class="list-group-item InfoOcupadaSucia">Ocupada sucia</li>
            <li class="list-group-item InfoUsoCasa">Uso casa</li>
            <li class="list-group-item InfoBloqueado">Bloqueado</li>
            <li class="list-group-item InfoMantenimiento">Mantenimiento</li>
            <li class="list-group-item InfoReservaPagada">Reserva pagada</li>
            <li class="list-group-item InfoReservaPendiente">Reserva pendiente pago</li>
        </ul>
        <ul class="list-group mb-0">
            <li class="list-group-item fw-bolder">Estado de limpieza</li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="margin-bottom: 0;">
                Limpia
                <i class="bx bxs-brush-alt clean2"></i>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="margin-bottom: 0;">
                En limpieza
                <i class="bx bxs-brush-alt cleaning2"></i>
            </li>
            <li class="list-group-item d-flex justify-content-between align-items-center" style="margin-bottom: 0;">
                Sucia
                <i class="bx bxs-brush-alt dirt2"></i>
            </li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div> '
?>

