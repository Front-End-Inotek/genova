<?php
//error_reporting(0);
date_default_timezone_set('America/Mexico_City');
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
    $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1 ORDER BY id";
    $comentario="Mostrar hab archivo areatrabajo.php funcion mostrarhab";
    $consulta= $this->realizaConsulta($sentencia,$comentario);
    //se recibe la consulta y se convierte a arreglo
    echo ' <div class="container" id="contenido-boton">';
    while ($fila = mysqli_fetch_array($consulta))
    {
        $total_faltante= 0.0;
        $estado="no definido";
        switch($fila['estado']) {
            case 0:
            $estado= "Disponible";
            $cronometro= $movimiento->saber_tiempo_ultima_renta($fila['id']);
            $tipo_habitacion= $fila['tipo_nombre'];
            break;

            case 1:
            $estado= "Ocupada";
            $cronometro= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
            break;

            case 2:
            $estado= "Sucia";
            $cronometro= $movimiento->saber_inicio_sucia($fila['moviemiento']);
            break;

            case 3:
            $estado= "Limpieza";
            $cronometro= $movimiento->saber_inicio_limpieza($fila['moviemiento']);
            break;

            case 4:
            $estado= "Mant.";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;
            case 5:
            $estado="Super.";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;
            case 6:
            $estado="Cancelada";
            $cronometro= $movimiento->saber_detalle_inicio($fila['moviemiento']);
            break;
            default:
            //echo "Estado indefinido";
            break;
        }

        if($fila['tipo']>0){

            echo'<div href="#caja_herramientas" data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$fila['estado'].','.$fila['nombre'].')" >';
            switch($estado) {
                case "Disponible":
                echo'<div class="btn disponible-limpia">';
                break;

                case "Ocupada":
                echo'<div class="btn sucia-ocupada">';
                break;

                case "Sucia":
                echo'<div class="btn vacia-sucia">';
                break;

                case "Limpieza":
                echo'<div class="btn ocupada-limpieza">';
                break;

                case "Mant.":
                echo'<div class="btn mantenimiento">';
                break;

                case "Super.":
                echo'<div class="btn bloqueo">';
                break;

                case "Cancelada":
                echo'<div class="btn reserva-pendiente">';
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
