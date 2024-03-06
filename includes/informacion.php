<?php
date_default_timezone_set('America/Mexico_City');

include_once('consulta.php');
include_once("clase_info_mesas.php");


class Informacion extends ConexionMYSql
{
    const INTERNO_SUCIA ="sucia";
    // Constructor
    function __construct(){
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
    $sentencia = "SELECT movimiento.fin_hospedaje as fin,hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,
    movimiento.estado_interno AS interno , datos_vehiculo.id as id_vehiculo,datos_vehiculo.estado as estado_vehiculo, tipo_hab.color as color_tipo, huesped.nombre as n_huesped, huesped.apellido as a_huesped
    FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id
    LEFT JOIN movimiento ON hab.mov = movimiento.id
    LEFT JOIN datos_vehiculo on movimiento.id_reservacion = datos_vehiculo.id_reserva
    LEFT JOIN huesped on movimiento.id_huesped = huesped.id
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

/* echo'
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

'; */

    echo ' <div class="container_rack_main" id="contenido-boton">';
    while ($fila = mysqli_fetch_array($consulta)){
        $icono_carro="";
        if($fila['estado_vehiculo']==1){
            $icono_carro='<i class="bx bxs-car car"></i>';
        }
        $hab = $fila['id'];
        //por cada hab, se tiene que consultar las preasignaciones existentes
        $sentencia_reservaciones = "SELECT hab.id,hab.nombre, reservacion.fecha_entrada, reservacion.fecha_salida,hab.estado,
                reservacion.estado_interno AS garantia
                ,movimiento.estado_interno AS interno
                ,huesped.nombre as n_huesped, huesped.apellido as a_huesped, movimiento.id as mov,reservacion.id as reserva_id
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
            $tipo_habitacion= $fila['tipo_nombre'];
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
            $estado= "Vacia limpieza";
            $cronometro= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
            $tipo_habitacion= $fila['tipo_nombre'];
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
            $tipo_habitacion= $fila['tipo_nombre'];
            //echo "Estado indefinido";
            break;
        }
        if($fila['tipo']>0){
            $color = $fila['color_tipo'];
            $color = "#".$color;
            $mov=0;
            $reserva=0;
            $estilo_tipo='style="border-left: '.$color.' solid 7px;"';
            if (isset($fila_r)) {
                $mov=$fila_r['mov'];
                $reserva=$fila_r['reserva_id'];
                echo'<div href="#caja_herramientas" class="habitacion_container" '.$estilo_tipo.' data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$estado_hab.',\''.$fila['nombre'].'\','.$reserva_entrada.','.$reserva_salida.','.$mov.','.$reserva.')" >';
            } else {
                echo'<div href="#caja_herramientas" class="habitacion_container" '.$estilo_tipo.' data-toggle="modal" onclick="mostrar_herramientas('.$fila['id'].','.$estado_hab.',\''.$fila['nombre'].'\','.$reserva_entrada.','.$reserva_salida.')" >';
            
            }
            switch($estado) {
                case "Disponible limpia":
                $estado="";
                echo'<div class="habitacion_container_main disponible_limpia" >
                        <section class="habitacion_container_encabezado">
                            <div class="habitacion_container_encabezado_pildora disponible_limpia_fondo ">
                                <div class="habitacion_container_encabezado_circle  disponible_limpia" style="background-color: '.$color.' ;"></div>
                                <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                            </div>
                            <div class="habitacion_container_encabezado_iconos disponible_limpia_fondo">
                                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/disponible_limpia.svg"/>
                            </div>
                        </section>

                        <section class="habitacion_container_body disponible_limpia_fondo">
                        <div class="pildora_nombre ">'.$fila['nombre'].'</div>
                ';
                break;
                case "Vacia limpieza":
                echo'<div class="habitacion_container_main disponible_limpieza" >
                        <section class="habitacion_container_encabezado">
                            <div class="habitacion_container_encabezado_pildora disponible_limpieza_fondo">
                                <div class="habitacion_container_encabezado_circle disponible_limpieza" style="background-color: '.$color.' ;"></div>
                                <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                            </div>
                            <div class="habitacion_container_encabezado_iconos disponible_limpieza_fondo">
                                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/disponible_limpieza.svg"/>
                            </div>
                        </section>

                        <section class="habitacion_container_body disponible_limpieza_fondo">
                        <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                break;
                case "Vacia sucia":
                echo'<div class="habitacion_container_main vacia_sucia" >
                        <section class="habitacion_container_encabezado">
                            <div class="habitacion_container_encabezado_pildora vacia_sucia_fondo">
                                <div class="habitacion_container_encabezado_circle vacia_sucia" style="background-color: '.$color.' ;"></div>
                                <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                            </div>
                            <div class="habitacion_container_encabezado_iconos vacia_sucia_fondo">
                                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/vacia_sucia.svg"/>
                            </div>
                        </section>

                        <section class="habitacion_container_body vacia_sucia_fondo">
                        <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';

                break;
                case "Ocupado":
                echo'<div class="habitacion_container_main ocupado '.$clase_expirar.'" >
                        <section class="habitacion_container_encabezado">
                            <div class="habitacion_container_encabezado_pildora ocupada_fondo">
                                <div class="habitacion_container_encabezado_circle ocupado" style="background-color: '.$color.' ;"></div>
                                <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                            </div>
                            <div class="habitacion_container_encabezado_iconos ocupada_fondo">
                                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/ocupado.svg"/>
                            </div>
                        </section>

                        <section class="habitacion_container_body ocupada_fondo">
                        <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                echo $icono_carro;
                break;
                case "Sucia ocupada":
                echo'<div class="habitacion_container_main ocupado_sucia '.$clase_expirar.'" >
                        <section class="habitacion_container_encabezado">
                            <div class="habitacion_container_encabezado_pildora ocupado_sucio_fondo">
                                <div class="habitacion_container_encabezado_circle ocupado_sucia" style="background-color: '.$color.' ;"></div>
                                <span class="filtro_text_pildora">'.$fila['tipo_nombre'] .'</span>
                            </div>
                            <div class="habitacion_container_encabezado_iconos ocupado_sucio_fondo">
                                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/ocupado_sucia.svg"/>
                            </div>
                        </section>

                        <section class="habitacion_container_body ocupado_sucio_fondo">
                        <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                echo $icono_carro;
                break;
                case "Ocupada limpieza":
                echo'<div class="habitacion_container_main ocupado_limpieza '.$clase_expirar.'" >
                        <section class="habitacion_container_encabezado">
                            <div class="habitacion_container_encabezado_pildora ocupado_limpieza_fondo">
                                <div class="habitacion_container_encabezado_circle ocupado_limpieza" style="background-color: '.$color.' ;"></div>
                                <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                            </div>
                            <div class="habitacion_container_encabezado_iconos ocupado_limpieza_fondo">
                                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/ocupado_limpieza.svg"/>
                            </div>
                        </section>

                        <section class="habitacion_container_body ocupado_limpieza_fondo">
                        <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                echo $icono_carro;
                break;
                case "Reserva pagada":
                    echo'<div class="habitacion_container_main reserva_pagada " >
                    <section class="habitacion_container_encabezado">
                        <div class="habitacion_container_encabezado_pildora reserva_pagada_fondo">
                            <div class="habitacion_container_encabezado_circle reserva_pagada" style="background-color: '.$color.' ;"></div>
                            <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                        </div>
                        <div class="habitacion_container_encabezado_iconos reserva_pagada_fondo">
                            <img class="habitacion_container_encabezado_iconos_icon" src="./assets/reserva_pagada.svg"/>
                        </div>
                    </section>

                    <section class="habitacion_container_body reserva_pagada_fondo">
                    <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                break;
                case "Reserva pendiente":
                    echo'<div class="habitacion_container_main reserva_pendiente " >
                    <section class="habitacion_container_encabezado">
                        <div class="habitacion_container_encabezado_pildora reserva_pendiente_fondo">
                            <div class="habitacion_container_encabezado_circle reserva_pendiente" style="background-color: '.$color.' ;"></div>
                            <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                        </div>
                        <div class="habitacion_container_encabezado_iconos reserva_pendiente_fondo">
                            <img class="habitacion_container_encabezado_iconos_icon" src="./assets/reserva_pendiente.svg"/>
                        </div>
                    </section>

                    <section class="habitacion_container_body reserva_pendiente_fondo">
                    <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                break;
                case "Uso casa":
                    echo'<div class="habitacion_container_main uso_casa " >
                    <section class="habitacion_container_encabezado">
                        <div class="habitacion_container_encabezado_pildora uso_casa_fondo">
                            <div class="habitacion_container_encabezado_circle uso_casa" style="background-color: '.$color.' ;"></div>
                            <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                        </div>
                        <div class="habitacion_container_encabezado_iconos uso_casa_fondo">
                            <img class="habitacion_container_encabezado_iconos_icon" src="./assets/uso_casa.svg"/>
                        </div>
                    </section>

                    <section class="habitacion_container_body uso_casa_fondo">
                    <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
        
                break;
                case "Mantenimiento":
                    echo'<div class="habitacion_container_main mantenimiento " >
                    <section class="habitacion_container_encabezado">
                        <div class="habitacion_container_encabezado_pildora mantenimiento_fondo">
                            <div class="habitacion_container_encabezado_circle mantenimiento" style="background-color: '.$color.' ;"></div>
                            <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                        </div>
                        <div class="habitacion_container_encabezado_iconos mantenimiento_fondo">
                            <img class="habitacion_container_encabezado_iconos_icon" src="./assets/mantenimiento.svg"/>
                        </div>
                    </section>

                    <section class="habitacion_container_body mantenimiento_fondo">
                    <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                break;
                case "Bloqueo":
                    echo'<div class="habitacion_container_main bloqueado " >
                    <section class="habitacion_container_encabezado">
                        <div class="habitacion_container_encabezado_pildora bloqueado_fondo">
                            <div class="habitacion_container_encabezado_circle bloqueado" style="background-color: '.$color.' ;"></div>
                            <span class="filtro_text_pildora">'.$fila['tipo_nombre'].'</span>
                        </div>
                        <div class="habitacion_container_encabezado_iconos bloqueado_fondo">
                            <img class="habitacion_container_encabezado_iconos_icon" src="./assets/bloqueado.svg"/>
                        </div>
                    </section>

                    <section class="habitacion_container_body bloqueado_fondo">
                    <div class="pildora_nombre">'.$fila['nombre'].'</div>
                ';
                break;
                default:
                //echo "Estado indefinido";
                break;
            }
            
            echo '
                    <span  id="N1">';
            if($estado_hab == 1){
                //echo $estado_hab;
                $fecha_salida= $movimiento->ver_fecha_salida($fila['moviemiento']);
                $fecha_entrada= $movimiento->ver_fecha_entrada($fila['moviemiento']);
                $total_faltante= $cuenta->mostrar_faltante($fila['moviemiento']);
            }
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
                        /*icono de habitacion sucia*/
            if($estado_hab == 2){
                echo '  
                <span class="habitacion_texto_contenedor" >
                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/broom-svgrepo-sucia.svg"/>
                    </svg>
                    <p class="habitacion_text_text">Sucia</p>
                </span>';
            }
            /*icono de habitacion en limpieza*/
            if($estado_hab == 3){
                echo '  
                <span class="habitacion_texto_contenedor" >
                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/broom-svgrepo-com.svg"/>
                    </svg>
                    <p class="habitacion_text_text">Limpieza</p>
                </span>';
            }
            if($estado_hab == 4){
                echo '  
                <span class="habitacion_texto_contenedor" >
                <img class="habitacion_container_encabezado_iconos_icon" src="./assets/mantenimiento.svg"/>
                    </svg>
                    <p class="habitacion_text_text">Mantenimiento</p>
                </span>';
            }
            /* AQUI EL ESTADO DE BLOQUEO ERA 7 PERO FUNCIONO CON EL 5 */
            if($estado_hab == 5){
                echo '  
                <span class="habitacion_texto_contenedor" >
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-ban" viewBox="0 0 16 16">
                 <path d="M15 8a6.973 6.973 0 0 0-1.71-4.584l-9.874 9.875A7 7 0 0 0 15 8M2.71 12.584l9.874-9.875a7 7 0 0 0-9.874 9.874ZM16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
                </svg>
                    <p class="habitacion_text_text">Bloqueo</p>
                </span>';
            }
            if($estado_hab == 7){
                echo '  
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">
                    <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9z"/>
                    <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1zm1.038 3.018a6 6 0 0 1 .924 0 6 6 0 1 1-.924 0M0 3.5c0 .753.333 1.429.86 1.887A8.04 8.04 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5M13.5 1c-.753 0-1.429.333-1.887.86a8.04 8.04 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1"/>
                </svg>
                    <p class="habitacion_text_text">Reserva pendiente</p>
                </span>';
            }

            //$fecha_salida= $movimiento->saber_fin_hospedaje($fila['moviemiento']);
            if($estado_hab == 0){
                if($cronometro == 0){
                    // echo $tipo_habitacion;
                    $fecha_inicio= date("d-m-Y",$cronometro);
                    echo '<span class="habitacion_texto_contenedor" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-x-fill" viewBox="0 0 16 16">
                                <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M6.854 8.146 8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z"/>
                            </svg>
                            <p class="habitacion_text_text">'.$fecha_inicio.'</p>
                        </span>
                    ';
                }else{
                    $fecha_inicio= date("d-m-Y",$cronometro);
                    $fecha_inicio= date("d-m-Y",$cronometro);
                    echo '<span class="habitacion_texto_contenedor" >
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-x-fill" viewBox="0 0 16 16">
                                <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M6.854 8.146 8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z"/>
                            </svg>
                            <p class="habitacion_text_text">'.$fecha_inicio.'</p>
                        </span>
                    ';
                    // echo $tipo_habitacion;
                }
            }elseif($estado_hab == 1){
            $nombre = $fila['n_huesped'] . " " . $fila['a_huesped'];
            echo '<span class="habitacion_texto_contenedor" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                    </svg>
                    <p class="habitacion_text_text">'.$nombre.'</p>
                </span>
            ';
            echo '<span class="habitacion_texto_contenedor" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                    </svg>
                    <p class="habitacion_text_text">'.$fecha_entrada.'</p>
                    </span>
                    ';
            
            echo '<span class="habitacion_texto_contenedor" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-x-fill" viewBox="0 0 16 16">
                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M6.854 8.146 8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z"/>
                    </svg>
                    <p class="habitacion_text_text">'.$fecha_salida.'</p>
                </span>
            ';
            echo '<span class="habitacion_texto_contenedor" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-stack" viewBox="0 0 16 16">
                        <path d="M1 3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1zm7 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4"/>
                        <path d="M0 5a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1zm3 0a2 2 0 0 1-2 2v4a2 2 0 0 1 2 2h10a2 2 0 0 1 2-2V7a2 2 0 0 1-2-2z"/>
                    </svg>
                    <p class="habitacion_text_text">'.$saldo.'</p>
                </span>
            ';

            }else{
            if($cronometro == 0){
                $fecha_inicio= '<span class="habitacion_texto_contenedor" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-check-fill" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                    <path d="m8 3.293 4.712 4.712A4.5 4.5 0 0 0 8.758 15H3.5A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z"/>
                    <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m1.679-4.493-1.335 2.226a.75.75 0 0 1-1.174.144l-.774-.773a.5.5 0 0 1 .708-.707l.547.547 1.17-1.951a.5.5 0 1 1 .858.514Z"/>
                </svg>
                <p class="habitacion_text_text">USO CASA</p>
            </span>';
            }else{
                echo '<span class="habitacion_texto_contenedor" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-x-fill" viewBox="0 0 16 16">
                            <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M6.854 8.146 8 9.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 10l1.147 1.146a.5.5 0 0 1-.708.708L8 10.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 10 6.146 8.854a.5.5 0 1 1 .708-.708z"/>
                        </svg>
                        <p class="habitacion_text_text">'.$fecha_inicio= date("d-m-Y",$cronometro).'</p>
                    </span>
            ';
            }
            /* echo $fecha_inicio; */
            /* AQUI EL ESTADO DE USO CASA ERA 6 PERO FUNCIONO CON EL 8*/
            if($estado_hab == 8){
                $nombre = $fila['n_huesped'] . " " . $fila['a_huesped'];
                echo '<span class="habitacion_texto_contenedor" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                 <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                </svg>
                 <p class="habitacion_text_text">Uso casa</p>
                 </span>
            ';
            }

            /* AQUI EL ESTADO DE RESERVA PAGADA ERA 9 PERO FUNCIONO CON EL 6 */
            if($estado_hab == 6){
                echo '  
                <span class="habitacion_texto_contenedor" >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check-fill" viewBox="0 0 16 16">
                        <path d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2m-5.146-5.146-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708.708z"/>
                    </svg>
                    <p class="habitacion_text_text">Reserva pagada</p>
                </span>';
            }
           
        
            }
            echo '</span>';
            echo'
                    <div class="habitacion_tipo_capsul">
                     ';
                    if($fila['id']<100){
                     
                    }else{
                        echo $fila['comentario'];
                    }
                    // echo '<br>'. $estado .'  <br>';
            echo '</div>';
            
            echo '
                
                </section>
            </div>
            </div>';
        }else{
        
        }
    }
    echo ' </div>';
    }
}

echo '<i class="btn-info-custom bx bxs-info-circle d-none"  data-toggle="modal" onclick="mostrar_info()" data-target="#exampleModal" ></i>';
echo '
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" id="info_here">
  </div>
</div>'
?>

