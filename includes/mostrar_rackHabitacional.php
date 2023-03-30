<?php
include_once('consulta.php');
class RackHabitacional extends ConexionMYSql{
    function mostrar($id){
        include_once("clase_cuenta.php");
        include('clase_movimiento.php');
        $cuenta= NEW Cuenta(0);
        $movimiento= NEW movimiento(0);
        $cronometro=0;
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
            <th class="cal-viewmonth" id="changemonth"></th>
            <th class="cal-dia" id="ayer">Miercoles 1</th>
            <th class="cal-dia" id="hoy">Jueves 2</th>
            <th class="cal-dia" id="dia1">Viernes 3</th>
            <th class="cal-dia" id="dia2">Sabado 4</th>
            <th class="cal-dia" id="dia3">Domingo 5</th>
            <th class="cal-dia" id="dia4">Lunes 6</th>
            <th class="cal-dia" id="dia5">Martes 7</th>
            <th class="cal-dia" id="dia6">Miercoles 8</th>
            <th class="cal-dia" id="dia7">Jueves 9</th>
            <th class="cal-dia" id="dia8">Viernes 10</th>
            <th class="cal-dia" id="dia9">Sabado 11</th>
            <th class="cal-dia" id="dia10">Domingo 12</th>
            <th class="cal-dia" id="dia11">Lunes 13</th>
            <th class="cal-dia" id="dia12">Martes 14</th>
            <th class="cal-dia" id="dia13">Miercoles 15</th>
            <th class="cal-dia" id="dia14">Jueves 16</th>
            <th class="cal-dia" id="dia15">Viernes 17</th>
            <th class="cal-dia" id="dia16">Sabado 18</th>
            <th class="cal-dia" id="dia17">Domingo 19</th>
            <th class="cal-dia" id="dia18">Lunes 20</th>
            <th class="cal-dia" id="dia19">Martes 21</th>
            <th class="cal-dia" id="dia20">Miercoles 22</th>
            <th class="cal-dia" id="dia21">Jueves 23</th>
            <th class="cal-dia" id="dia22">Viernes 24</th>
            <th class="cal-dia" id="dia23">Sabado 25</th>
            <th class="cal-dia" id="dia24">Domingo 26</th>
            <th class="cal-dia" id="dia25">Lunes 27</th>
            <th class="cal-dia" id="dia26">Martes 28</th>
            <th class="cal-dia" id="dia27">Miercoles 29</th>
            <th class="cal-dia" id="dia28">Jueves 30</th>
            <th class="cal-dia" id="dia29">Viernes 31</th>
            </tr>
        </thead>';

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
        if($fila['tipo']>0){
        echo'
        <tbody class="cal-tbody">
            <tr id="u1">
                <td class="cal-userinfo">';
                    echo'Habitación ';
                    if($fila['id']<100){
                        echo $fila['nombre'];
                    }else{
                        echo $fila['comentario'];
                    }
        echo'
                </td>
                <td class="cal-userinfo">';
                echo'Habitación ';
                if($fila['id']<100){
                    echo $fila['nombre'];
                }else{
                    echo $fila['comentario'];
                }
        echo'
            </td>
            </tr>
        </tbody>';
        }else{
            echo '<div class="hidden-xs hidden-sm col-md-1 espacio">';
        }
            }
        echo'</table>
        </div>
    </div>
</div>';
        }
    }


?>