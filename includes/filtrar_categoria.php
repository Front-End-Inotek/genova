<?php

$estatus_hab = $_GET['estatus_hab'];

echo var_dump($estatus_hab);
include_once('consulta.php');

class Informacion extends ConexionMYSql
{
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
    

    function mostrarhab($id,$token){
    include_once("clase_cuenta.php");
    include('clase_movimiento.php');
    $cuenta= NEW Cuenta(0);
    $movimiento= NEW movimiento(0);
    $cronometro=0;

    if (true) {
    $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1 ORDER BY id";
    $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
    $consulta= $this->realizaConsulta($sentencia,$comentario);
    }

/*
    $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado = 1 ORDER BY id";
    $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
    $consulta= $this->realizaConsulta($sentencia,$comentario);*/

echo'
<div class="botones-mostrados" id="botones">
<h3 class="titulo-filtro">Filtrar por:</h3>
<button class="botones-estado" id="mostrar-todas" onclick="mostrar_estadorack()">Todas</button>
<button class="botones-estado" id="mostrar-bloqueo" onclick="mostrar_estadorack(1)"> Bloqueo</button>
<button class="botones-estado" id="mostrar-uso-casa" onclick="mostrar_estadorack(2)"> Uso Casa</button>
<button class="botones-estado" id="mostrar-ocupadas" onclick="mostrar_estadorack(3)"> Ocupadas</button>
<button class="botones-estado" id="mostrar-disponibles" onclick="mostrar_estadorack(4)"> Disponibles</button>
<button class="botones-estado" id="mostrar-vacias-sucias" onclick="mostrar_estadorack(5)">Sucia Vacia </button>
<button class="botones-estado" id="mostrar-mantenimiento" onclick="mostrar_estadorack(6)"> Mantenimiento</button>
<button class="botones-estado" id="mostrar-ocupada-sucias" onclick="mostrar_estadorack(7)">Sucia Ocupada</button>
<button class="botones-estado" id="mostrar-vacia-limpieza" onclick="mostrar_estadorack(8)"> Limpieza Vacia </button>
<button class="botones-estado" id="mostrar-ocupada-limpieza" onclick="mostrar_estadorack(9)"> Limpieza Ocupada</button>
<button class="botones-estado" id="mostrar-reservada-pagada" onclick="mostrar_estadorack(10)"> Reservacion pagada</button>
<button class="botones-estado" id="mostrar-reservada-pendiente" onclick="mostrar_estadorack(11)"> Reservacion deuda</button>
</div>';

    echo ' <div class="containerRackOp" id="contenido-boton">';
    while ($fila = mysqli_fetch_array($consulta))
    {
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

        if($fila['tipo']>0){

            echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
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
                echo'<div class="btn supervision ocupadoH">';
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
            if($fila['estado'] == 0){
            if($cronometro == 0){
                echo $tipo_habitacion;
            }else{
                $fecha_inicio= date("d-m-Y",$cronometro);
                echo $fecha_inicio;
                echo '<br>';
                echo $tipo_habitacion;
            }
            }elseif($fila['estado'] == 1){
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