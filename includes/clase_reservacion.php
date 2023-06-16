<?php

date_default_timezone_set('America/Mexico_City');
include_once('consulta.php');

class Reservacion extends ConexionMYSql
{
    public $id;//
    public $id_usuario;
    public $id_huesped;
    public $id_cuenta;
    public $tipo_hab;
    public $fecha_entrada;
    public $fecha_salida;
    public $noches;
    public $numero_hab;
    public $precio_hospedaje;
    public $cantidad_hospedaje;
    public $extra_adulto;
    public $extra_junior;
    public $extra_infantil;
    public $extra_menor;
    public $tarifa;
    public $nombre_reserva;
    public $acompanante;
    public $forma_pago;
    public $limite_pago;
    public $suplementos;
    public $total_suplementos;
    public $total_hab;
    public $forzar_tarifa;
    public $codigo_descuento;
    public $descuento;
    public $total;
    public $total_pago;
    public $fecha_cancelacion;
    public $nombre_cancela;
    public $tipo_descuento;
    public $estado;
    public $pax_extra;
    public $plan_alimentos;
    public $sobrevender;
    public $canal_reserva;
    //mejor poner el autoincrement de la tabla con ese valor inicial
    //public const INIT_ID=10000;

    // Constructor
    public function __construct($id)
    {
        if($id==0) {
            $this->id= 0;
            $this->id_usuario= 0;
            $this->id_huesped= 0;
            $this->id_cuenta= 0;
            $this->tipo_hab= 0;
            $this->fecha_entrada= 0;
            $this->fecha_salida= 0;
            $this->noches= 0;
            $this->numero_hab= 0;
            $this->precio_hospedaje= 0;
            $this->cantidad_hospedaje= 0;
            $this->extra_adulto= 0;
            $this->extra_junior= 0;
            $this->extra_infantil= 0;
            $this->extra_menor= 0;
            $this->tarifa= 0;
            $this->nombre_reserva= 0;
            $this->acompanante= 0;
            $this->forma_pago= 0;
            $this->limite_pago= 0;
            $this->suplementos= 0;
            $this->total_suplementos= 0;
            $this->total_hab= 0;
            $this->forzar_tarifa= 0;
            $this->codigo_descuento= 0;
            $this->descuento= 0;
            $this->total= 0;
            $this->total_pago= 0;
            $this->fecha_cancelacion= 0;
            $this->nombre_cancela= 0;
            $this->tipo_descuento= 0;
            $this->estado= 0;
            $this->pax_extra= 0;
            $this->plan_alimentos= 0;
            $this->sobrevender= 0;
            $this->canal_reserva=0;
        } else {
            $sentencia = "SELECT * FROM reservacion WHERE id = $id LIMIT 1 ";
            $comentario="Obtener todos los valores de una reservacion";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            while ($fila = mysqli_fetch_array($consulta)) {
                $this->id= $fila['id'];
                $this->id_usuario= $fila['id_usuario'];
                $this->id_huesped= $fila['id_huesped'];
                $this->id_cuenta= $fila['id_cuenta'];
                $this->tipo_hab= $fila['tipo_hab'];
                $this->fecha_entrada= $fila['fecha_entrada'];
                $this->fecha_salida= $fila['fecha_salida'];
                $this->noches= $fila['noches'];
                $this->numero_hab= $fila['numero_hab'];
                $this->precio_hospedaje= $fila['precio_hospedaje'];
                $this->cantidad_hospedaje= $fila['cantidad_hospedaje'];
                $this->extra_adulto= $fila['extra_adulto'];
                $this->extra_junior= $fila['extra_junior'];
                $this->extra_infantil= $fila['extra_infantil'];
                $this->extra_menor= $fila['extra_menor'];
                $this->tarifa= $fila['tarifa'];
                $this->nombre_reserva= $fila['nombre_reserva'];
                $this->acompanante= $fila['acompanante'];
                $this->forma_pago= $fila['forma_pago'];
                $this->limite_pago= $fila['limite_pago'];
                $this->suplementos= $fila['suplementos'];
                $this->total_suplementos= $fila['total_suplementos'];
                $this->total_hab= $fila['total_hab'];
                $this->forzar_tarifa= $fila['forzar_tarifa'];
                $this->codigo_descuento= $fila['codigo_descuento'];
                $this->descuento= $fila['descuento'];
                $this->total= $fila['total'];
                $this->total_pago= $fila['total_pago'];
                $this->fecha_cancelacion= $fila['fecha_cancelacion'];
                $this->nombre_cancela= $fila['nombre_cancela'];
                $this->tipo_descuento= $fila['tipo_descuento'];
                $this->estado= $fila['estado'];
                $this->pax_extra= $fila['pax_extra'];
                $this->plan_alimentos=$fila['plan_alimentos'];
                $this->sobrevender=$fila['sobrevender'];
                $this->canal_reserva=$fila['canal_reserva'];
            }
        }
    }

    public function preasignar_hab($id, $preasignada)
    {



        $sentencia = "UPDATE movimiento
		INNER JOIN reservacion ON reservacion.id = movimiento.id_reservacion
        SET movimiento.id_hab = '$preasignada', movimiento.motivo ='preasignar'
	    WHERE reservacion.id = '$id' ";
        $comentario="Preasignar una habitacion a una reservacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        if($consulta) {
            return "BIEN";

        } else {
            return "MAL";
        }


    }
    public function obtener_ultimo_id()
    {
        //esta sentencia trae el ultimo valor registrado.
        // $sentencia = "SELECT reservacion.id
        // FROM reservacion
        // INNER JOIN usuario ON reservacion.id_usuario = usuario.id
        // INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        // INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.estado = 1 || reservacion.estado = 2)  ORDER BY reservacion.id DESC LIMIT 1;";
        // $comentario="Mostrar las reservaciones";
        //esta sentencia trae el valor "actual" del autoincrement de la tabla.
        $sentencia="SELECT `AUTO_INCREMENT` as id
        FROM  INFORMATION_SCHEMA.TABLES
        WHERE TABLE_SCHEMA = 'visit'
        AND   TABLE_NAME   = 'reservacion';";
        $ultimo_id=0;
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        while ($fila = mysqli_fetch_array($consulta)) {
            $ultimo_id= $fila['id'];
        }
        // $ultimo_id = self::INIT_ID + $ultimo_id;
        return $ultimo_id;
    }

    public function obtenerTipoDesdeTarifa($tipo_hab)
    {
        $real_tipo_hab =0;
        $sentencia_tarifa = "SELECT tipo FROM tarifa_hospedaje WHERE id = $tipo_hab";
        $comentario="Consultar el el tipo de habitación en base a la tarifa dada.";
        $consulta = $this->realizaConsulta($sentencia_tarifa, $comentario);

        while ($fila = mysqli_fetch_array($consulta)) {
            $real_tipo_hab= $fila['tipo'];
        }
        return $real_tipo_hab;
    }


    //función para obtener las fechas en un rango de fechas.
    public function date_range($first, $last, $step = '+1 day', $output_format = 'Y-m-d')
    {

        $dates = array();
        $current = $first;
        $last = $last;

        while($current < $last) {

            $dates[] = date($output_format, $current);
            $current = strtotime($step, $current);
        }

        return $dates;
    }


     // Obtener el id de reservacion de un movimiento
     public function saber_id_movimiento($id)
     {
         $id_mov= 0;
         $sentencia = "SELECT id, id_hab,motivo  FROM movimiento WHERE id_reservacion = $id LIMIT 1";
         $comentario="Obtener el id de movimiento desde una reservacion";
         $consulta= $this->realizaConsulta($sentencia, $comentario);
         $datos=[];
         //se recibe la consulta y se convierte a arreglo
         while ($fila = mysqli_fetch_array($consulta)) {
             $datos=$fila;
         }
         return $datos;
     }

    public function comprobarFechaReserva($fecha_entrada, $fecha_salida, $hab_id, $preasignada)
    {

        $agregar_editar ="";
        $agregar_="";
        if($preasignada!=0) {
            $agregar_editar ="AND m.id_hab !=$preasignada";
        }

        $agregar_id="";
        //se agrega filtro para el id de la habitación.

        if($preasignada!=0 && $hab_id!=0) {
            $agregar_="AND m.id_hab=".$hab_id." AND m.motivo!='reservar'";
            $agregar_editar="";
        } else {
            $agregar_ ="AND m.id_hab=".$hab_id."  AND m.motivo!='preasignar'";

        }

        if($hab_id!=0) {
            $agregar_id ="AND m.id_hab=".$hab_id;
        } else {
            $agregar_="";
        }



        $fecha_entrada = strtotime($fecha_entrada);
        //se toma en cuenta un 'dia antes' porque puede salir el dia que otro entra.
        $fecha_salida=strtotime($fecha_salida);
        $no_disponibles=[];
        $disponibles=[];

        //hacer otra sentencia para comprobar las ocupadas y que la reservacion no intervenga con estas
        $ocupadas = "SELECT * 
        FROM hab
        INNER JOIN movimiento as m on hab.mov = m.id
        INNER JOIN reservacion on m.id_reservacion = reservacion.id
        WHERE hab.estado = 1 
        AND ('$fecha_salida' > reservacion.fecha_entrada AND '$fecha_entrada' <  reservacion.fecha_salida)
        " .$agregar_;
        ;

        // print_r($ocupadas);


        $consulta = $this->realizaConsulta($ocupadas, "");
        while($fila=mysqli_fetch_array($consulta)) {
            $no_disponibles [] = $fila['id_hab'];
        }


        $sentencia ="SELECT r.id, m.id_hab AS hab_id FROM reservacion AS r
		LEFT JOIN tarifa_hospedaje ON r.tipo_hab = tarifa_hospedaje.id
		INNER JOIN usuario ON r.id_usuario = usuario.id
		INNER JOIN huesped ON r.id_huesped = huesped.id
		INNER JOIN movimiento AS m ON m.id_reservacion= r.id
		WHERE ('$fecha_salida' > r.fecha_entrada AND '$fecha_entrada' <  r.fecha_salida)
		AND m.motivo = 'preasignar'
        AND r.estado = 1
		"
        .$agregar_editar
        .$agregar_id;
        // print_r($sentencia);
        // die();
        $consulta = $this->realizaConsulta($sentencia, "");
        while($fila=mysqli_fetch_array($consulta)) {
            $no_disponibles [] = $fila['hab_id'];
        }

        // print_r($no_disponibles);


        //cuando hay  id de habitación y si la fecha conciide con otra fecha (de la misma habitación) entonces el array $no disponibles es mayor a 0.
        if($hab_id!=0) {
            // echo ($fecha_entrada) . "\n" . ($fecha_salida) ."||".strtotime($fecha_salida);
            if(sizeof($no_disponibles)<=0) {
                //Si hay disponibilidad
                return true;
            } else {
                //No hay disponibilidad
                return false;
            }
        } else {
            $result =[];
            //cuando se trata de una reservación se retornan todas las habitaciones disponibles.
            if(sizeof($no_disponibles)>=0) {
                array_push($result, true);
                // $result = array("existe"=>true);
            } else {
                array_push($result, false);
            }
            $arraySQL = implode("','", $no_disponibles);
            $sentencia = "SELECT * FROM hab  WHERE id NOT IN ('".$arraySQL."') AND estado_hab=1";
            $consulta = $this->realizaConsulta($sentencia, "");
            $opciones ="";
            while($fila=mysqli_fetch_array($consulta)) {
                $disponibles [] = $fila['id'];
                // echo '
                // <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>
                // ';
                if($preasignada == $fila['id']) {
                    $opciones .= '<option selected value="'.$fila['id'].'">Habitación: '.$fila['nombre'].'</option>';
                } else {
                    $opciones .= '<option value="'.$fila['id'].'">Habitación: '.$fila['nombre'].'</option>';
                }

            }
            $opciones = '<option value="">Seleccionar una habitación
                '.$opciones.'
            </option>';
            array_push($result, $opciones);
            // $result = array("opciones"=>$opciones);
            return $result;
            //echo $opciones;
            // print_r($disponibles);
        }

        //fechas en timestamp
        // echo ($fecha_entrada) . "\n" . ($fecha_salida) ."||".strtotime($fecha_salida);


    }
      // Guardar la reservacion (nuevo)
    public function guardar_reservacionNew(
          $id_huesped,
          $tipo_hab,
          $id_movimiento,
          $fecha_entrada,
          $fecha_salida,
          $noches,
          $numero_hab,
          $precio_hospedaje,
          $cantidad_hospedaje,
          $extra_adulto,
          $extra_junior,
          $extra_infantil,
          $extra_menor,
          $tarifa,
          $nombre_reserva,
          $acompanante,
          $forma_pago,
          $limite_pago,
          $suplementos,
          $total_suplementos,
          $total_hab,
          $forzar_tarifa,
          $codigo_descuento,
          $descuento,
          $total,
          $total_pago,
          $hab_id,
          $usuario_id,
          $cuenta,
          $cantidad_cupon,
          $tipo_descuento,
          $estado,
          $pax_extra,
          $canal_reserva,
          $plan_alimentos,
          $tipo_reservacion,
          $sobrevender,
          $estado_interno,
      ) 
      {
          $fecha_entrada= strtotime($fecha_entrada);
          $fecha_salida= strtotime($fecha_salida);
          $id_cuenta= 0;
          $total_cargo= $total_suplementos;
          if($forzar_tarifa > 0) {
              $total_cargo= $total_suplementos + $forzar_tarifa;
          }
          if($cuenta == 1 && $id_movimiento != 0) {
              $pago_total= $total_pago + $cantidad_cupon;
              //Se guarda como cuenta el cargo del total suplementos y como abono del total pago de la reservacion
              $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
              VALUES ('$usuario_id', '$id_movimiento', 'Total reservacion', '$fecha_entrada', '$forma_pago', '$total_cargo', '$pago_total', '1');";
              $comentario="Se guarda como cuenta el cargo del total suplementos y como abono del total pago en la base de datos";
              $consulta= $this->realizaConsulta($sentencia, $comentario);

              $sentencia = "SELECT id FROM cuenta ORDER BY id DESC LIMIT 1";
              $comentario="Obtengo el id de la cuenta agregada";
              $consulta= $this->realizaConsulta($sentencia, $comentario);
              while ($fila = mysqli_fetch_array($consulta)) {
                  $id_cuenta= $fila['id'];
              }
          }
          $sentencia = "INSERT INTO `reservacion` (`id_usuario`, `id_huesped`, `id_cuenta`, `tipo_hab`,`fecha_entrada`, `fecha_salida`, `noches`, `numero_hab`, `precio_hospedaje`, `cantidad_hospedaje`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `acompanante`, `forma_pago`, `limite_pago`, `suplementos`, `total_suplementos`, `total_hab`, `forzar_tarifa`, `codigo_descuento`, `descuento`, `total`, `total_pago`, `fecha_cancelacion`, `nombre_cancela`, `tipo_descuento`, 
          `estado`,`pax_extra`,`canal_reserva`,`plan_alimentos`,`tipo_reservacion`,`sobrevender`,`estado_interno`)
          VALUES ('$usuario_id', '$id_huesped', '$id_cuenta', '$tipo_hab', '$fecha_entrada', '$fecha_salida', '$noches', '$numero_hab', '$precio_hospedaje', '$cantidad_hospedaje', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa', '$nombre_reserva', '$acompanante', '$forma_pago', '$limite_pago', '$suplementos', '$total_suplementos', '$total_hab', '$forzar_tarifa', '$codigo_descuento', '$descuento', '$total', '$total_pago', '0', '', '$tipo_descuento', 
          '$estado','$pax_extra','$canal_reserva','$plan_alimentos','$tipo_reservacion',$sobrevender,'$estado_interno');";
          $comentario="Guardamos la reservacion en la base de datos";

          $consulta= $this->realizaConsulta($sentencia, $comentario);
          include_once("clase_log.php");
          $logs = new Log(0);
          $sentencia = "SELECT id FROM reservacion ORDER BY id DESC LIMIT 1";
          $comentario="Obtengo el id de la reservacion agregada";
          $consulta= $this->realizaConsulta($sentencia, $comentario);
          while ($fila = mysqli_fetch_array($consulta)) {
              $id= $fila['id'];
          }
          $logs->guardar_log($usuario_id, "Agregar reservacion: ". $id);



          // Poner id reservacion al numero de movimiento que corresponde
          $sentencia = "UPDATE `movimiento` SET
          `id_reservacion` = '$id'
          WHERE `id` = '$id_movimiento';";
          $comentario="Cambiar id reservacion del movimiento";
          $consulta= $this->realizaConsulta($sentencia, $comentario);

          //retornamos el id de la reservacion para comprobar y guardar un log de preasignada
          return $id;

      }
    // Guardar la reservacion
    public function guardar_reservacion(
        $id_huesped,
        $tipo_hab,
        $id_movimiento,
        $fecha_entrada,
        $fecha_salida,
        $noches,
        $numero_hab,
        $precio_hospedaje,
        $cantidad_hospedaje,
        $extra_adulto,
        $extra_junior,
        $extra_infantil,
        $extra_menor,
        $tarifa,
        $nombre_reserva,
        $acompanante,
        $forma_pago,
        $limite_pago,
        $suplementos,
        $total_suplementos,
        $total_hab,
        $forzar_tarifa,
        $codigo_descuento,
        $descuento,
        $total,
        $total_pago,
        $hab_id,
        $usuario_id,
        $cuenta,
        $cantidad_cupon,
        $tipo_descuento,
        $estado
    ) {
        $fecha_entrada= strtotime($fecha_entrada);
        $fecha_salida= strtotime($fecha_salida);
        $id_cuenta= 0;
        $total_cargo= $total_suplementos;
        if($forzar_tarifa > 0) {
            $total_cargo= $total_suplementos + $forzar_tarifa;
        }
        if($cuenta == 1 && $id_movimiento != 0) {
            $pago_total= $total_pago + $cantidad_cupon;
            //Se guarda como cuenta el cargo del total suplementos y como abono del total pago de la reservacion
            $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
		    VALUES ('$usuario_id', '$id_movimiento', 'Total reservacion', '$fecha_entrada', '$forma_pago', '$total_cargo', '$pago_total', '1');";
            $comentario="Se guarda como cuenta el cargo del total suplementos y como abono del total pago en la base de datos";
            $consulta= $this->realizaConsulta($sentencia, $comentario);

            $sentencia = "SELECT id FROM cuenta ORDER BY id DESC LIMIT 1";
            $comentario="Obtengo el id de la cuenta agregada";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            while ($fila = mysqli_fetch_array($consulta)) {
                $id_cuenta= $fila['id'];
            }
        }
        $sentencia = "INSERT INTO `reservacion` (`id_usuario`, `id_huesped`, `id_cuenta`, `tipo_hab`,`fecha_entrada`, `fecha_salida`, `noches`, `numero_hab`, `precio_hospedaje`, `cantidad_hospedaje`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `acompanante`, `forma_pago`, `limite_pago`, `suplementos`, `total_suplementos`, `total_hab`, `forzar_tarifa`, `codigo_descuento`, `descuento`, `total`, `total_pago`, `fecha_cancelacion`, `nombre_cancela`, `tipo_descuento`, 
        `estado`)
		VALUES ('$usuario_id', '$id_huesped', '$id_cuenta', '$tipo_hab', '$fecha_entrada', '$fecha_salida', '$noches', '$numero_hab', '$precio_hospedaje', '$cantidad_hospedaje', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa', '$nombre_reserva', '$acompanante', '$forma_pago', '$limite_pago', '$suplementos', '$total_suplementos', '$total_hab', '$forzar_tarifa', '$codigo_descuento', '$descuento', '$total', '$total_pago', '0', '', '$tipo_descuento', 
        '$estado');";
        $comentario="Guardamos la reservacion en la base de datos";

        $consulta= $this->realizaConsulta($sentencia, $comentario);
        include_once("clase_log.php");
        $logs = new Log(0);
        $sentencia = "SELECT id FROM reservacion ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id de la reservacion agregada";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        while ($fila = mysqli_fetch_array($consulta)) {
            $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id, "Agregar reservacion: ". $id);

        // Poner id reservacion al numero de movimiento que corresponde
        $sentencia = "UPDATE `movimiento` SET
		`id_reservacion` = '$id'
		WHERE `id` = '$id_movimiento';";
        $comentario="Cambiar id reservacion del movimiento";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
    }
    // Obtengo el total de las reservaciones
    public function total_elementos($sentencia="")
    {
        $cantidad=0;
        if($sentencia=="") {
            $sentencia = "SELECT *,count(reservacion.id) AS cantidad,reservacion.id AS ID,tipo_hab.nombre AS habitacion
		FROM reservacion
		INNER JOIN tipo_hab ON reservacion .tarifa = tipo_hab.id WHERE reservacion .estado = 1 ORDER BY reservacion.id DESC;";
        }

        //echo $sentencia;
        $comentario="Obtengo el total de las reservaciones";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        while ($fila = mysqli_fetch_array($consulta)) {
            $cantidad= $cantidad + 1;
        }
        return $cantidad;
    }

    public function seleccion_reporte($fecha_inicio, $inicio_dia, $opcion)
    {
        $sentencia="";
        $comentario="";
        $where="";
        $where_fecha ="";

        $inicio_normal= date("Y-m-d");

        if($fecha_inicio!="") {

            $inicio_normal=$fecha_inicio;
            $inicio_dia  = strtotime($fecha_inicio);
        }

        switch ($opcion) {
            case 1:
                //llegadas probables
                //reservaciones con estado 1, del día seleccionado.
                $where="WHERE (reservacion.estado = 1)";
                $where_fecha ="AND (reservacion.fecha_entrada = '$inicio_dia')";
                $comentario="Mostrar las llegas probables (reservaciones)";

                break;
            case 2:
                //llegadas efectivas
                $where ="WHERE (reservacion.estado = 2)";
                $where_fecha ="AND (reservacion.fecha_entrada = '$inicio_dia')";
                $comentario="Mostrar las llegas efectivas (reservaciones)";
                break;
            case 3:
                //salidas probables
                $where="
                LEFT JOIN hab on movimiento.id_hab = hab.id
                WHERE (reservacion.estado = 1 || reservacion.estado=2)";
                $where_fecha="AND (reservacion.fecha_salida = '$inicio_dia')";

                $comentario="Mostrar las salidas probables (reservaciones y ocupadas)";
                break;
            case 4:
                //salidas efectivas
                $where="WHERE (reservacion.estado=2)";
                $where_fecha=" AND (from_unixtime(movimiento.finalizado,'%Y-%m-%d') =('$inicio_normal'))";
                $comentario="Mostrar las salidas efectivas";
                break;
            default:
                # code...
                break;
        }
        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
        FROM reservacion
        LEFT JOIN tarifa_hospedaje ON reservacion.tipo_hab = tarifa_hospedaje.id 
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id 
        INNER JOIN movimiento on reservacion.id = movimiento.id_reservacion
        ".$where."
        ".$where_fecha."
        ORDER BY reservacion.id DESC;";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        return $consulta;
    }

    // Mostramos las los reportes segun lo pasado en la vista.
    public function mostrar_reportes_reservas($posicion, $id, $opcion, $fecha_inicio="")
    {
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("Y-m-d");

        $inicio_dia= strtotime($inicio_dia);
        $fin_dia= $inicio_dia + 86399;
        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0) {
            $cat_paginas++;
        }
        $ultimoid=0;

        $comentario="";
        $where="";
        $where_fecha ="";



        $consulta = $this->seleccion_reporte($fecha_inicio, $inicio_dia, $opcion);
        //se recibe la consulta y se convierte a arreglo
        $this->buscador_reportes($inicio_dia, $opcion);
        echo '<div class="table-responsive" id="tabla_reservacion">';
        echo '<table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-primary-encabezado text-center">
                            <th>Número</th>
                            <th>Fecha Entrada</th>
                            <th>Fecha Salida</th>
                            <th>Noches</th>
                            <th>No. Habitaciones</th>
                            <th>Tarifa</th>
                            <th>Precio Hospedaje</th>
                            <th>Cantidad Hospedaje</th>
                            <th>Extra Adulto</th>
                            <th>Extra Junior</th>
                            <th>Extra Infantil</th>
                            <th>Extra Menor</th>
                            <th>Nombre Huésped</th>
                            <th>Teléfono Huésped</th>
                            <th>Total Estancia</th>
                            <th>Total Pago</th>
                            <th>Forma Pago</th>
                            <th>Límite Pago</th>
                            <th>Status</th>';
        echo '</tr>
                    </thead>
        <tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            if($cont>=$posicion & $cont<$final) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
                            <td>'.$fila['ID'].'</td> 
                            <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
                            <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
                            <td>'.$fila['noches'].'</td> 
                            <td>'.$fila['numero_hab'].'</td> 
                            <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
                            <td>'.$fila['extra_adulto'].'</td> 
                            <td>'.$fila['extra_junior'].'</td> 
                            <td>'.$fila['extra_infantil'].'</td> 
                            <td>'.$fila['extra_menor'].'</td>
                            <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
                            <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
                            <td>'.$fila['ID'].'</td> 
                            <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
                            <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
                            <td>'.$fila['noches'].'</td> 
                            <td>'.$fila['numero_hab'].'</td> 
                            <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
                            <td>'.$fila['extra_adulto'].'</td> 
                            <td>'.$fila['extra_junior'].'</td> 
                            <td>'.$fila['extra_infantil'].'</td> 
                            <td>'.$fila['extra_menor'].'</td>
                            <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
                            <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
                    <td>'.$fila['noches'].'</td> 
                    <td>'.$fila['numero_hab'].'</td> 
                    <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
                    <td>'.$fila['extra_adulto'].'</td> 
                    <td>'.$fila['extra_junior'].'</td> 
                    <td>'.$fila['extra_infantil'].'</td> 
                    <td>'.$fila['extra_menor'].'</td>
                    <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
                    <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    echo '</tr>';
                }
            }
            $cont++;
        }
        echo '
            </tbody>
            </table>
            </div>
        ';
        return $cat_paginas;
    }


    //mostramos las salidas.
    public function mostrar_salidas($posicion, $id, $inicio_dia="")
    {
        include_once('clase_usuario.php');
        $usuario =  new Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        date_default_timezone_set('America/Mexico_City');
        $ruta="ver_reportes_salidas()";
        if(empty($inicio_dia)) {

            $inicio_dia= date("d-m-Y");
            $inicio_dia= strtotime($inicio_dia);
        } else {
            $inicio_dia = strtotime($inicio_dia);
        }
        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $ultimoid=0;
        //Consulta para traer la información de habitaciones ocupadas, con fecha de salida dada por el usuario.
        $sentencia ="SELECT *,movimiento.id_hab,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
        FROM hab 
        LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id 
        INNER JOIN movimiento ON hab.mov = movimiento.id 
        INNER JOIN reservacion ON movimiento.id_reservacion = reservacion.id 
        INNER JOIN tarifa_hospedaje ON reservacion.tipo_hab = tarifa_hospedaje.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id 
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id
        WHERE  reservacion.fecha_salida = '$inicio_dia' AND hab.estado_hab = 1 ORDER BY hab.id";
        // echo $sentencia;
        $cat_paginas=($this->total_elementos($sentencia)/20);
        $extra=($this->total_elementos($sentencia)%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0) {
            $cat_paginas++;
        }
        $comentario="Mostrar las reservaciones que llegan hoy";
        $consulta= $this->realizaConsulta($sentencia, $comentario);

        echo '
		<button class="btn btn-success" href="" data-toggle="modal" onclick="agregar_reservaciones()">Agregar reservaciones</button>
		<br>
		<br>

		<div class="table-responsive" id="tabla_reservacion" style="max-height:560px; overflow-x: scroll; ">
		<table class="table table-bordered table-hover">
		<thead>
			<tr class="table-primary-encabezado text-center">
			<th>Número</th>
			<th>Fecha Entrada</th>
			<th>Fecha Salida</th>
			<th>Noches</th>
			<th>No. Habitaciones</th>
			<th>Tarifa</th>
			<th>Precio Hospedaje</th>
			<th>Cantidad Hospedaje</th>
			<th>Extra Adulto</th>
			<th>Extra Junior</th>
			<th>Extra Infantil</th>
			<th>Extra Menor</th>
			<th>Nombre Huésped</th>
			<th>Teléfono Huésped</th>
			<th>Total Estancia</th>
			<th>Total Pago</th>
			<th>Forma Pago</th>
			<th>Límite Pago</th>
			<th>Status</th>';
        if($agregar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Check-in</th>';
        }
        //preasignar.
        echo '<th><span class=" glyphicon glyphicon-cog"></span> Preasignar</th>';


        echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
        if($editar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
        }
        if($borrar==1 && $fila['edo'] != 0) {
            echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
            echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
        }

        echo '</tr>
		</thead>
		<tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            if($cont>=$posicion & $cont<$final) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					<td>'.$fila['ID'].'</td>
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td>
					<td>'.$fila['numero_hab'].'</td>
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>
					<td>'.$fila['extra_adulto'].'</td>
					<td>'.$fila['extra_junior'].'</td>
					<td>'.$fila['extra_infantil'].'</td>
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';

                        if($agregar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }

                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        if($agregar==1 && $fila['edo'] = 1) {

                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }

                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
				  <td>'.$fila['ID'].'</td> 
				  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
				  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
				  <td>'.$fila['noches'].'</td> 
				  <td>'.$fila['numero_hab'].'</td> 
				  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
				  <td>'.$fila['extra_adulto'].'</td> 
				  <td>'.$fila['extra_junior'].'</td> 
				  <td>'.$fila['extra_infantil'].'</td> 
				  <td>'.$fila['extra_menor'].'</td>
				  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
				  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';

                    if($agregar==1 && $fila['fecha_entrada'] == $inicio_dia && $fila['edo'] = 2) {
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_checkin('.$fila['ID'].','.$fila['numero_hab'].','.$fila['id_hab'].')"> Asignar</button></td>';
                    }

                    if($agregar==1 && $fila['edo'] = 1) {
                        //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        echo '<td></td>';
                    }
                    //botón para preasignar una habitación.
                    if($fila['id_hab']==0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="preasignar_reservacion('.$fila['ID'].')"> Preasignar</button></td>';
                    } else {
                        echo '<td></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion(' . $fila['ID'] . ', \'' . $ruta . '\')"> Reporte</button></td>';
                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                }
            }
            $cont++;
        }
        echo '
		  </tbody>
		</table>
		</div>';
        return $cat_paginas;
    }

    //Mostramos las llegadas.
    public function mostrar_llegadas($posicion, $id, $inicio_dia="")
    {
        include_once('clase_usuario.php');
        $usuario =  new Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        $ruta="ver_reportes_llegadas()";
        date_default_timezone_set('America/Mexico_City');
        if(empty($inicio_dia)) {

            $inicio_dia= date("d-m-Y");
            $inicio_dia= strtotime($inicio_dia);
        } else {
            $inicio_dia = strtotime($inicio_dia);
        }

        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0) {
            $cat_paginas++;
        }
        $ultimoid=0;

        $sentencia = "SELECT *,movimiento.id as mov, movimiento.id_hab,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		FROM reservacion
        LEFT JOIN tarifa_hospedaje  ON reservacion.tipo_hab = tarifa_hospedaje.id 
        INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
		INNER JOIN usuario ON reservacion.id_usuario = usuario.id
		INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.estado = 1 || reservacion.estado = 2)  AND reservacion.fecha_entrada = '$inicio_dia'  ORDER BY reservacion.id DESC;";
        // echo $sentencia;
        $comentario="Mostrar las reservaciones que llegan hoy";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        //se recibe la consulta y se convierte a arreglo
        //<button class="btn btn-success" href="#caja_herramientas" data-toggle="modal" onclick="agregar_reservaciones()">Agregar reservaciones</button>
        echo '
		<button class="btn btn-success" href="" data-toggle="modal" onclick="agregar_reservaciones()">Agregar reservaciones</button>
		<br>
		<br>

		<div class="table-responsive" id="tabla_reservacion" style="max-height:560px; overflow-x: scroll; ">
		<table class="table table-bordered table-hover">
		<thead>
			<tr class="table-primary-encabezado text-center">
			<th>Número</th>
			<th>Fecha Entrada</th>
			<th>Fecha Salida</th>
			<th>Noches</th>
			<th>No. Habitaciones</th>
			<th>Tarifa</th>
			<th>Precio Hospedaje</th>
			<th>Cantidad Hospedaje</th>
			<th>Extra Adulto</th>
			<th>Extra Junior</th>
			<th>Extra Infantil</th>
			<th>Extra Menor</th>
			<th>Nombre Huésped</th>
			<th>Teléfono Huésped</th>
			<th>Total Estancia</th>
			<th>Total Pago</th>
			<th>Forma Pago</th>
			<th>Límite Pago</th>
			<th>Status</th>';
        if($agregar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Check-in</th>';
        }
        //preasignar.
        echo '<th><span class=" glyphicon glyphicon-cog"></span> Preasignar</th>';


        echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
        if($editar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
        }
        if($borrar==1 && $fila['edo'] != 0) {
            echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
            echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
        }

        echo '</tr>
		</thead>
		<tbody>';

        while ($fila = mysqli_fetch_array($consulta)) {

            if($cont>=$posicion & $cont<$final) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					<td>'.$fila['ID'].'</td>
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td>
					<td>'.$fila['numero_hab'].'</td>
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>
					<td>'.$fila['extra_adulto'].'</td>
					<td>'.$fila['extra_junior'].'</td>
					<td>'.$fila['extra_infantil'].'</td>
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        if($agregar==1 && $fila['fecha_entrada'] == $inicio_dia && $fila['edo'] == 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_checkin('.$fila['ID'].','.$fila['numero_hab'].','.$fila['id_hab'].','.$fila['mov'].')"> Asignar</button></td>';
                        }
                        //este abre modal para hacer checkin sin habitacion
                        // if($agregar==1 && $fila['edo'] == 1) {
                        //     echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].','.$fila['id'].')"> Asignar</button></td>';
                        // }
                        if($fila['id_hab']==0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="preasignar_reservacion('.$fila['ID'].',1)"> Preasignar</button></td>';
                        } else {
                            echo '<td></td>';
                        }
                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] == 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        if($agregar==1 && $fila['edo'] = 1) {

                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }

                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
				  <td>'.$fila['ID'].'</td> 
				  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
				  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
				  <td>'.$fila['noches'].'</td> 
				  <td>'.$fila['numero_hab'].'</td> 
				  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
				  <td>'.$fila['extra_adulto'].'</td> 
				  <td>'.$fila['extra_junior'].'</td> 
				  <td>'.$fila['extra_infantil'].'</td> 
				  <td>'.$fila['extra_menor'].'</td>
				  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
				  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';

                    //no se puede hacer chekin en estado 2.
                    echo '<td></td>';

                    if($agregar==1 && $fila['edo'] == 1) {
                        //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        echo '<td></td>';
                    }
                    //botón para preasignar una habitación.
                    if($fila['id_hab']==0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="preasignar_reservacion('.$fila['ID'].')"> Preasignar</button></td>';
                    } else {
                        echo '<td></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion(' . $fila['ID'] . ', \'' . $ruta . '\')"> Reporte</button></td>';

                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                }
            }
            $cont++;
        }
        echo '
		  </tbody>
		</table>
		</div>';
        return $cat_paginas;
    }

    // Mostramos las reservaciones
    public function mostrar($posicion, $id)
    {
        include_once('clase_usuario.php');
        $usuario =  new Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);
        //cantidad de dias a visualizar. (se añaden 15 dias)
        $fin_dia= $inicio_dia + 1.296e+6;

        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $ultimoid=0;

        $sentencia = "SELECT *, movimiento.id as mov,movimiento.id_hab,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		FROM reservacion
        LEFT JOIN tarifa_hospedaje  ON reservacion.tipo_hab = tarifa_hospedaje.id 
        INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
		INNER JOIN usuario ON reservacion.id_usuario = usuario.id
		INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.estado = 1 || reservacion.estado = 2)  AND (reservacion.fecha_entrada >= $inicio_dia && reservacion.fecha_entrada <= $fin_dia) ORDER BY reservacion.id DESC;";
        $comentario="Mostrar las reservaciones";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        // echo $sentencia;
        $cat_paginas=($this->total_elementos($sentencia)/20);
        // print_r($cat_paginas);
        $extra=($this->total_elementos($sentencia)%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0) {
            $cat_paginas++;
        }

        //se recibe la consulta y se convierte a arreglo
        //<button class="btn btn-success" href="#caja_herramientas" data-toggle="modal" onclick="agregar_reservaciones()">Agregar reservaciones</button>
        echo '
		<button class="btn btn-success" href="" data-toggle="modal" onclick="agregar_reservaciones()">Agregar reservaciones</button>
		<br>
		<br>

		<div class="table-responsive" id="tabla_reservacion" style="max-height:560px; overflow-x: scroll; ">
		<table class="table table-bordered table-hover">
		<thead>
			<tr class="table-primary-encabezado text-center">
			<th>Número</th>
			<th>Fecha Entrada</th>
			<th>Fecha Salida</th>
			<th>Noches</th>
			<th>No. Habitaciones</th>
			<th>Tarifa</th>
			<th>Precio Hospedaje</th>
			<th>Cantidad Hospedaje</th>
			<th>Extra Adulto</th>
			<th>Extra Junior</th>
			<th>Extra Infantil</th>
			<th>Extra Menor</th>
			<th>Nombre Huésped</th>
			<th>Teléfono Huésped</th>
			<th>Total Estancia</th>
			<th>Total Pago</th>
			<th>Forma Pago</th>
			<th>Límite Pago</th>
			<th>Status</th>';
        if($agregar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Check-in</th>';
        }
        //preasignar.
        echo '<th><span class=" glyphicon glyphicon-cog"></span> Preasignar</th>';


        echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
        if($editar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
        }
        if($borrar==1 && $fila['edo'] != 0) {
            echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
            echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
        }

        echo '</tr>
		</thead>
		<tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            if($cont>=$posicion & $cont<$final) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					<td>'.$fila['ID'].'</td>
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td>
					<td>'.$fila['numero_hab'].'</td>
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>
					<td>'.$fila['extra_adulto'].'</td>
					<td>'.$fila['extra_junior'].'</td>
					<td>'.$fila['extra_infantil'].'</td>
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        // echo $fila['fecha_entrada'] . "/" . $inicio_dia;
                        // die();
                        if($agregar==1 && date('Y-m-d', $fila['fecha_entrada']) == date('Y-m-d', $inicio_dia) && $fila['edo'] == 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_checkin('.$fila['ID'].','.$fila['numero_hab'].','.$fila['id_hab'].','.$fila['mov'].')"> Asignar</button></td>';
                        } else {
                            echo '<td></td>';
                        }
                        if($fila['id_hab']==0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="preasignar_reservacion('.$fila['ID'].')"> Preasignar</button></td>';
                        } else {
                            echo '<td>Preasignada '.$fila['id_hab'].'</td>';
                        }

                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacionNew('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].','.$fila['id_hab'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].','.$fila['id_hab'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        if($agregar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_checkin('.$fila['ID'].','.$fila['numero_hab'].','.$fila['id_hab'].','.$fila['mov'].')"> Asignarx</button></td>';
                        }
                        if($fila['id_hab']==0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="preasignar_reservacion('.$fila['ID'].')"> Preasignar</button></td>';
                        } else {
                            echo '<td>Preasignada '.$fila['id_hab'].'</td>';
                        }

                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacionNew('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].','.$fila['id_hab'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].','.$fila['id_hab'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
				  <td>'.$fila['ID'].'</td> 
				  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
				  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
				  <td>'.$fila['noches'].'</td> 
				  <td>'.$fila['numero_hab'].'</td> 
				  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
				  <td>'.$fila['extra_adulto'].'</td> 
				  <td>'.$fila['extra_junior'].'</td> 
				  <td>'.$fila['extra_infantil'].'</td> 
				  <td>'.$fila['extra_menor'].'</td>
				  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
				  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    //no se puede hacer chekin en estado 2.
                    echo '<td></td>';

                    // if($agregar==1 && $fila['edo'] = 1) {
                    //     //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    //     echo '<td></td>';
                    // }
                    //botón para preasignar una habitación.
                    if($fila['id_hab']==0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="preasignar_reservacion('.$fila['ID'].')"> Preasignar</button></td>';
                    } else {
                        echo '<td></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'regresar_reservacion()\', \'CHECK-IN\')"> Reporte</button></td>';
                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_checkin('.$fila['ID'].','.$fila['id_hab'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                }
            }
            $cont++;
        }
        echo '
		  </tbody>
		</table>
		</div>';
        return $cat_paginas;
    }
    //Barra de busqueda en ver llegadas y salidas, se usará la misma función.

    public function buscar_entradas_salidas_recep($a_buscar, $id, $inicio_dia, $opcion)
    {
        include_once('clase_usuario.php');
        $usuario =  new Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        if(empty($inicio_dia)) {
            $inicio_dia= date("d-m-Y");
            $inicio_dia= strtotime($inicio_dia);
        } else {
            $inicio_dia = strtotime($inicio_dia);
        }
        if(strlen($a_buscar) == 0) {
            //$cat_paginas = $this->mostrar(1, $id)
            $where_buscar="";
        } else {
            $where_buscar="WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || huesped.telefono LIKE '%$a_buscar%')";
        }
        $sentencia="";
        $ruta="";
        if($opcion == 1) {
            $ruta="ver_reportes_llegadas()";
            $sentencia="SELECT *,movimiento.id_hab,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            LEFT JOIN tarifa_hospedaje  ON reservacion.tipo_hab = tarifa_hospedaje.id 
            INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion
            LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id 
            ".$where_buscar."
            AND (reservacion.estado = 1 || reservacion.estado = 2)  AND reservacion.fecha_entrada = '$inicio_dia'  ORDER BY reservacion.id DESC;";

        } else {
            $ruta="ver_reportes_salidas()";
            $sentencia="SELECT *,movimiento.id_hab,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM hab 
            LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id 
            INNER JOIN movimiento ON hab.mov = movimiento.id 
            INNER JOIN reservacion ON movimiento.id_reservacion = reservacion.id 
            LEFT JOIN tarifa_hospedaje ON reservacion.tipo_hab = tarifa_hospedaje.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id 
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id
            ".$where_buscar."
            AND reservacion.fecha_salida = '$inicio_dia' AND hab.estado_hab = 1 ORDER BY hab.id";
        }
        // echo $sentencia;
        $comentario="Mostrar diferentes busquedas en ver reservaciones";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        //se recibe la consulta y se convierte a arreglo
        echo ' 
			<div class="table-responsive" id="tabla_reservacion">
			<table class="table table-bordered table-hover">
			  <thead>
				<tr class="table-primary-encabezado text-center">
				<th>Número</th>
				<th>Fecha Entrada</th>
				<th>Fecha Salida</th>
				<th>Noches</th>
				<th>No. Habitaciones</th>
				<th>Tarifa</th>
				<th>Precio Hospedaje</th>
				<th>Cantidad Hospedaje</th>
				<th>Extra Adulto</th>
				<th>Extra Junior</th>
				<th>Extra Infantil</th>
				<th>Extra Menor</th>
				<th>Nombre Huésped</th>
				<th>Teléfono Huésped</th>
				<th>Total Estancia</th>
				<th>Total Pago</th>
				<th>Forma Pago</th>
				<th>Límite Pago</th>
				<th>Status</th>';
        if($agregar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Check-in</th>';
        }
        echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
        if($editar==1 && $fila['edo'] = 1) {
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
        }
        if($borrar==1 && $fila['edo'] != 0) {
            echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
            echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
        }
        echo '</tr>
			  </thead>
			<tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            if($fila['edo'] == 1) {
                if($fila['total_pago'] <= 0) {
                    echo '<tr class="text-center">
					  <td>'.$fila['ID'].'</td> 
					  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					  <td>'.$fila['noches'].'</td> 
					  <td>'.$fila['numero_hab'].'</td> 
					  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					  <td>'.$fila['extra_adulto'].'</td> 
					  <td>'.$fila['extra_junior'].'</td> 
					  <td>'.$fila['extra_infantil'].'</td> 
					  <td>'.$fila['extra_menor'].'</td>
					  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Abierta</td>';
                    if($agregar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                } else {
                    echo '<tr class="table-success text-center">
					  <td>'.$fila['ID'].'</td> 
					  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					  <td>'.$fila['noches'].'</td> 
					  <td>'.$fila['numero_hab'].'</td> 
					  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					  <td>'.$fila['extra_adulto'].'</td> 
					  <td>'.$fila['extra_junior'].'</td> 
					  <td>'.$fila['extra_infantil'].'</td> 
					  <td>'.$fila['extra_menor'].'</td>
					  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Garantizada</td>';
                    if($agregar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                }
            } else {
                echo '<tr class="table-secondary text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                if($fila['forzar_tarifa']>0) {
                    echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                } else {
                    echo '<td>$'.number_format($fila['total'], 2).'</td>';
                }
                echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                echo '<td>'.$fila['descripcion'].'</td>';
                echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                echo '<td>Activa</td>';
                if($agregar==1 && $fila['edo'] = 1) {
                    //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    echo '<td></td>';
                }
                echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].', \'' . $ruta . '\')"> Reporte</button></td>';
                if($editar==1 && $fila['edo'] = 1) {
                    echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                }
                if($borrar==1 && $fila['edo'] != 0) {
                    echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                    echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
        }

        echo '
			  </tbody>
			</table>
			</div>';
    }


    // Barra de busqueda en ver reservaciones
    public function buscar_reservacion($a_buscar, $id)
    {
        include_once('clase_usuario.php');
        $usuario =  new Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        /*date_default_timezone_set('America/Mexico_City');
        $inicio_dia = date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);
        $fin_dia= $inicio_dia + 86399;*/
        // AND (reservacion.fecha_entrada >= $inicio_dia && reservacion.fecha_entrada <= $fin_dia)

        if(strlen($a_buscar) == 0) {
            $cat_paginas = $this->mostrar(1, $id);
        } else {
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		  FROM reservacion
		--   INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
		  INNER JOIN tarifa_hospedaje  ON reservacion.tipo_hab = tarifa_hospedaje.id 
		  INNER JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
		  INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
		  INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		  INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || huesped.telefono LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.id DESC";//|| reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%'
            $comentario="Mostrar diferentes busquedas en ver reservaciones";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            //se recibe la consulta y se convierte a arreglo
            echo ' 
			<div class="table-responsive" id="tabla_reservacion">
			<table class="table table-bordered table-hover">
			  <thead>
				<tr class="table-primary-encabezado text-center">
				<th>Número</th>
				<th>Fecha Entrada</th>
				<th>Fecha Salida</th>
				<th>Noches</th>
				<th>No. Habitaciones</th>
				<th>Tarifa</th>
				<th>Precio Hospedaje</th>
				<th>Cantidad Hospedaje</th>
				<th>Extra Adulto</th>
				<th>Extra Junior</th>
				<th>Extra Infantil</th>
				<th>Extra Menor</th>
				<th>Nombre Huésped</th>
				<th>Teléfono Huésped</th>
				<th>Total Estancia</th>
				<th>Total Pago</th>
				<th>Forma Pago</th>
				<th>Límite Pago</th>
				<th>Status</th>';
            if($agregar==1 && $fila['edo'] = 1) {
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Check-in</th>';
            }
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
            if($editar==1 && $fila['edo'] = 1) {
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1 && $fila['edo'] != 0) {
                echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            echo '</tr>
			  </thead>
			<tbody>';
            while ($fila = mysqli_fetch_array($consulta)) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					  <td>'.$fila['ID'].'</td> 
					  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					  <td>'.$fila['noches'].'</td> 
					  <td>'.$fila['numero_hab'].'</td> 
					  <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					  <td>'.$fila['extra_adulto'].'</td> 
					  <td>'.$fila['extra_junior'].'</td> 
					  <td>'.$fila['extra_infantil'].'</td> 
					  <td>'.$fila['extra_menor'].'</td>
					  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					  <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        if($agregar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }
                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					  <td>'.$fila['ID'].'</td> 
					  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					  <td>'.$fila['noches'].'</td> 
					  <td>'.$fila['numero_hab'].'</td> 
					  <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					  <td>'.$fila['extra_adulto'].'</td> 
					  <td>'.$fila['extra_junior'].'</td> 
					  <td>'.$fila['extra_infantil'].'</td> 
					  <td>'.$fila['extra_menor'].'</td>
					  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					  <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        if($agregar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }
                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    if($agregar==1 && $fila['edo'] = 1) {
                        //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        echo '<td></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                }
            }
        }
        echo '
			  </tbody>
			</table>
			</div>';
    }
    // Busqueda por fecha en ver reservaciones
    public function mostrar_reservacion_fecha($fecha_ini_tiempo, $fecha_fin_tiempo, $a_buscar, $combinada, $id)
    {
        include_once('clase_usuario.php');
        $usuario =  new Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo= $fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo= $fecha_fin_tiempo  . " 23:59:59";
        $fecha_ini= strtotime($fecha_ini_tiempo);
        $fecha_fin= strtotime($fecha_fin_tiempo);



        if($a_buscar == ' ' && strlen($fecha_ini) == 0 && strlen($fecha_fin) == 0) {
            $cat_paginas = $this->mostrar(1, $id);
        } else {
            if($a_buscar != ' ') {
                $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
			FROM reservacion
			INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
			INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
			INNER JOIN huesped ON reservacion.id_huesped = huesped.id
			INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.id DESC";
            } elseif($a_buscar != ' ' && strlen($fecha_ini) > 0 && strlen($fecha_fin) > 0 && $combinada == 1) {
                $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
			FROM reservacion
			INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
			INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
			INNER JOIN huesped ON reservacion.id_huesped = huesped.id
			INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_ini && reservacion.fecha_entrada <= $fecha_fin && reservacion.fecha_entrada > 0 AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
            } else {

                //old
                // $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
                // FROM reservacion
                // INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id
                // INNER JOIN usuario ON reservacion.id_usuario = usuario.id
                // INNER JOIN huesped ON reservacion.id_huesped = huesped.id
                // INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_ini && reservacion.fecha_entrada <= $fecha_fin && reservacion.fecha_entrada > 0 AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";

                $sentencia = "SELECT *,reservacion.id AS ID,tarifa_hospedaje.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
			    FROM reservacion
                INNER JOIN tarifa_hospedaje ON reservacion.tipo_hab = tarifa_hospedaje.id 
                INNER JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id 
			    INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
			    INNER JOIN huesped ON reservacion.id_huesped = huesped.id
			    INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_ini && reservacion.fecha_entrada <= $fecha_fin  && reservacion.fecha_entrada > 0  AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";

            }
            $comentario="Mostrar por fecha en ver reservaciones";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            //se recibe la consulta y se convierte a arreglo
            echo '<div class="table-responsive" id="tabla_reservacion">
		  <table class="table table-bordered table-hover">
			<thead>
			  <tr class="table-primary-encabezado text-center">
			  <th>Número</th>
			  <th>Fecha Entrada</th>
			  <th>Fecha Salida</th>
			  <th>Noches</th>
			  <th>No. Habitaciones</th>
			  <th>Tarifa</th>
			  <th>Precio Hospedaje</th>
			  <th>Cantidad Hospedaje</th>
			  <th>Extra Adulto</th>
			  <th>Extra Junior</th>
			  <th>Extra Infantil</th>
			  <th>Extra Menor</th>
			  <th>Nombre Huésped</th>
			  <th>Teléfono Huésped</th>
			  <th>Total Estancia</th>
			  <th>Total Pago</th>
			  <th>Forma Pago</th>
			  <th>Límite Pago</th>
			  <th>Status</th>';
            if($agregar==1 && $fila['edo'] = 1) {
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Check-in</th>';
            }
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
            if($editar==1 && $fila['edo'] = 1) {
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1 && $fila['edo'] != 0) {
                echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            echo '</tr>
			</thead>
		  <tbody>';
            while ($fila = mysqli_fetch_array($consulta)) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        if($agregar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }
                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        if($agregar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        }
                        echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                        if($editar==1 && $fila['edo'] = 1) {
                            echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                        }
                        if($borrar==1 && $fila['edo'] != 0) {
                            echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                            echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                        }
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
				  <td>'.$fila['ID'].'</td> 
				  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
				  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
				  <td>'.$fila['noches'].'</td> 
				  <td>'.$fila['numero_hab'].'</td> 
				  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
				  <td>'.$fila['extra_adulto'].'</td> 
				  <td>'.$fila['extra_junior'].'</td> 
				  <td>'.$fila['extra_infantil'].'</td> 
				  <td>'.$fila['extra_menor'].'</td>
				  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
				  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    if($agregar==1 && $fila['edo'] = 1) {
                        //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                        echo '<td></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';
                    if($editar==1 && $fila['edo'] = 1) {
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0) {
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                }
            }
        }
        echo '
		  </tbody>
		</table>
		</div>';
    }
    // Obtengo el total del porcentaje de ocupacion de las reservaciones por dia - Comienza por dia tabla
    public function porcentaje_ocupacion($dia, $a_buscar)
    {
        $numero_hab= 0;
        $cantidad= 0;
        $porcentaje= 0;
        $salida= $dia + 86399;

        if($a_buscar != ' ') {
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		  FROM reservacion
		  INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
		  INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
		  INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		  INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.fecha_entrada = $dia || (reservacion.fecha_entrada > $dia && reservacion.fecha_salida <= $salida)) AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
        } else {
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		  FROM reservacion
		  INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
		  INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
		  INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		  INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.fecha_entrada = $dia || (reservacion.fecha_entrada > $dia && reservacion.fecha_salida <= $salida)) AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
        } //(reservacion.fecha_entrada = $dia || reservacion.fecha_salida <= $salida)
        //echo $sentencia;
        $comentario="Obtengo el total del porcentaje de ocupacion de las reservaciones por dia";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        while ($fila = mysqli_fetch_array($consulta)) {
            $numero_hab= $numero_hab + $fila['numero_hab'];
        }

        $sentencia = "SELECT *,count(hab.id) AS cantidad,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
		FROM hab 
		INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado_hab = 1 ORDER BY hab.nombre;";
        //echo $sentencia;
        $comentario="Obtengo el total de las reservaciones";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        while ($fila = mysqli_fetch_array($consulta)) {
            $cantidad= $fila['cantidad'];
        }

        $porcentaje= ($cantidad / 100) * $numero_hab;
        $porcentaje= round($porcentaje, 1, PHP_ROUND_HALF_UP);
        return $porcentaje;
    }

    // Mostramos los datos de reservaciones por dia
    public function datos_por_dia($dia, $a_buscar)
    {
        $dia_actual= date("Y-m-d", $dia);
        $fecha_dia_dia = substr($dia_actual, 8, 2);
        $fecha_dia_mes = substr($dia_actual, 5, 2);
        $fecha_dia_anio = substr($dia_actual, 0, 4);
        $porcentaje= $this->porcentaje_ocupacion($dia, $a_buscar);
        //$a_buscar= rawurlencode($a_buscar);
        echo '<div class="row">
		  <div class="col-sm-2">';
        //echo '<input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_reservacion_por_dia()" class="color_black form-control form-control" autofocus="autofocus"/>';
        echo '<input type="text" id="a_buscar" placeholder="Buscar" class="color_black form-control form-control" autofocus="autofocus"/>';
        echo '</div>
		  <div class="col-sm-1">Dia:</div>
		  <div class="col-sm-2">';
        //<input class="form-control form-control" type="date"  id="dia"  placeholder="Reservacion dia" onchange="busqueda_reservacion_por_dia()" autofocus="autofocus"/>
        echo '<input class="form-control form-control" type="date" id="dia" placeholder="Reservacion dia" autofocus="autofocus"/>
		  </div>
		  <div class="col-sm-1"><button class="btn btn-success btn-block btn-default" onclick="busqueda_reservacion_combinada_por_dia()"> Buscar</button></div>
		  <div class="col-sm-1"><button class="btn btn-primary btn-block" onclick="reporte_reservacion_por_dia('.$dia.')"> Reporte</button></div>
		  <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_reservacion()"> ←</button></div>
		  <div class="col-sm-1"></div>
		  <div class="col-sm-3"><h4><p><a href="#" class="text-dark">Día '.$fecha_dia_dia.'-'.$fecha_dia_mes.'-'.$fecha_dia_anio.' - '.$porcentaje.'% de Ocupación</a></p></h4></div>
		</div><br>';
    }

      // Mostramos los datos de reportes seleccionados
    public function buscador_reportes($dia, $opcion)
    {
        //Para el mensaje que se ve en donde selecciona la fecha.
        $mensaje = $opcion<=2 ? "Llegada:" : "Salida:";

        $dia_actual= date("Y-m-d", $dia);
        $fecha_dia_dia = substr($dia_actual, 8, 2);
        $fecha_dia_mes = substr($dia_actual, 5, 2);
        $fecha_dia_anio = substr($dia_actual, 0, 4);
        //$a_buscar= rawurlencode($a_buscar);
        echo '<div class="row">
            <div class="col-sm-2">';
        //echo '<input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_reservacion_por_dia()" class="color_black form-control form-control" autofocus="autofocus"/>';
        echo '<input type="text" id="a_buscar" placeholder="Buscar"  class="color_black form-control form-control" onkeyup="buscador_reportes_reservas('.$opcion.')" autofocus="autofocus"/>';
        echo '</div>
            <div class="col-sm-1">'.$mensaje.'</div>
            <div class="col-sm-2">';
        //<input class="form-control form-control" type="date"  id="dia"  placeholder="Reservacion dia" onchange="busqueda_reservacion_por_dia()" autofocus="autofocus"/>
        echo '<input class="form-control form-control" type="date" id="dia" placeholder="Reservacion dia" autofocus="autofocus"/>
            </div>
            <div class="col-sm-1"><button class="btn btn-success btn-block btn-default" onclick="ver_reportes_reservaciones('.$opcion.',1)"> Buscar</button></div>
            <div class="col-sm-1"><button class="btn btn-primary btn-block" onclick="imprimir_reportes('.$opcion.')"> Reporte</button></div>
            <div class="col-sm-1"></div>
        </div><br>';
    }

      // Mostramos las los reportes segun lo pasado en la vista.
    public function buscar_entradas_salidas($posicion, $id, $opcion, $fecha_inicio="", $a_buscar="")
    {
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("Y-m-d");
        $inicio_normal = $inicio_dia;
        $inicio_dia= strtotime($inicio_dia);
        $fin_dia= $inicio_dia + 86399;
        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0) {
            $cat_paginas++;
        }
        $ultimoid=0;
        $sentencia="";
        $comentario="";
        $where="";
        $where_fecha ="";

        if($fecha_inicio!="") {
            $inicio_normal = $fecha_inicio;
            $inicio_dia  = strtotime($fecha_inicio);
        }
        if(!empty($a_buscar)) {
            $a_buscar=" AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%')";
        }

        //según la opción proporcionada, será una consulta distinta para cada caso.

        switch ($opcion) {
            case 1:
                //llegadas probables
                //reservaciones con estado 1, del día seleccionado.
                $where="WHERE (reservacion.estado = 1)";
                $where_fecha ="AND (reservacion.fecha_entrada = '$inicio_dia')";
                $comentario="Mostrar las llegas probables (reservaciones)";

                break;
            case 2:
                //llegadas efectivas
                $where ="WHERE (reservacion.estado = 2)";
                $where_fecha ="AND (reservacion.fecha_entrada = '$inicio_dia')";
                $comentario="Mostrar las llegas efectivas (reservaciones)";
                break;
            case 3:
                //salidas probables
                $where="
                  LEFT JOIN hab on movimiento.id_hab = hab.id
                  WHERE (reservacion.estado = 1 || reservacion.estado=2)";
                $where_fecha="AND (reservacion.fecha_salida = '$inicio_dia')";
                $comentario="Mostrar las salidas probables (reservaciones y ocupadas)";
                break;
            case 4:
                //salidas efectivas
                $where="WHERE (reservacion.estado=2)";
                $where_fecha=" AND (from_unixtime(movimiento.finalizado,'%Y-%m-%d') ='$inicio_normal')";
                $comentario="Mostrar las salidas efectivas";
                break;
            default:
                # code...
                break;
        }
        //Para que la fecha no intervenga en el filtro.
        // if($fecha_inicio=="" && $a_buscar!=""){
        //   $where_fecha="";
        // }

        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            LEFT JOIN tarifa_hospedaje ON reservacion.tipo_hab = tarifa_hospedaje.id 
            LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id 
            INNER JOIN movimiento on reservacion.id = movimiento.id_reservacion
            ".$where."
            ".$where_fecha."
            ".$a_buscar."
            ORDER BY reservacion.id DESC;";
        // echo $sentencia;
        //die();
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_reservacion">';

        echo '<table class="table table-bordered table-hover">
                <thead>
                <tr class="table-primary-encabezado text-center">
                <th>Número</th>
                <th>Fecha Entrada</th>
                <th>Fecha Salida</th>
                <th>Noches</th>
                <th>No. Habitaciones</th>
                <th>Tarifa</th>
                <th>Precio Hospedaje</th>
                <th>Cantidad Hospedaje</th>
                <th>Extra Adulto</th>
                <th>Extra Junior</th>
                <th>Extra Infantil</th>
                <th>Extra Menor</th>
                <th>Nombre Huésped</th>
                <th>Teléfono Huésped</th>
                <th>Total Estancia</th>
                <th>Total Pago</th>
                <th>Forma Pago</th>
                <th>Límite Pago</th>
                <th>Status</th>';
        echo '</tr>
              </thead>
            <tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            if($cont>=$posicion & $cont<$final) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
                        <td>'.$fila['ID'].'</td> 
                        <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
                        <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
                        <td>'.$fila['noches'].'</td> 
                        <td>'.$fila['numero_hab'].'</td> 
                        <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
                        <td>'.$fila['extra_adulto'].'</td> 
                        <td>'.$fila['extra_junior'].'</td> 
                        <td>'.$fila['extra_infantil'].'</td> 
                        <td>'.$fila['extra_menor'].'</td>
                        <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
                        <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
                        <td>'.$fila['ID'].'</td> 
                        <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
                        <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
                        <td>'.$fila['noches'].'</td> 
                        <td>'.$fila['numero_hab'].'</td> 
                        <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
                        <td>'.$fila['extra_adulto'].'</td> 
                        <td>'.$fila['extra_junior'].'</td> 
                        <td>'.$fila['extra_infantil'].'</td> 
                        <td>'.$fila['extra_menor'].'</td>
                        <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
                        <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
                      <td>'.$fila['ID'].'</td> 
                      <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
                      <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
                      <td>'.$fila['noches'].'</td> 
                      <td>'.$fila['numero_hab'].'</td> 
                      <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
                      <td>'.$fila['extra_adulto'].'</td> 
                      <td>'.$fila['extra_junior'].'</td> 
                      <td>'.$fila['extra_infantil'].'</td> 
                      <td>'.$fila['extra_menor'].'</td>
                      <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
                      <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    echo '</tr>';
                }
            }
            $cont++;
        }
        echo '
                </tbody>
            </table>
            </div>';
        return $cat_paginas;
    }

    // Mostramos las reservaciones por dia
    public function mostrar_por_dia($posicion, $id)
    {
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);
        $fin_dia= $inicio_dia + 86399;
        $a_buscar= ' ';

        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0) {
            $cat_paginas++;
        }
        $ultimoid=0;

        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		FROM reservacion
		INNER JOIN tarifa_hospedaje ON reservacion.tipo_hab = tarifa_hospedaje.id 
        INNER JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id 
		INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
		INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.estado = 1 || reservacion.estado = 2)  AND (reservacion.fecha_entrada >= $inicio_dia && reservacion.fecha_entrada <= $fin_dia) ORDER BY reservacion.id DESC;";
        $comentario="Mostrar las reservaciones por dia";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_reservacion">';
        $this->datos_por_dia($inicio_dia, $a_buscar);

        echo '<table class="table table-bordered table-hover">
		  <thead>
			<tr class="table-primary-encabezado text-center">
			<th>Número</th>
			<th>Fecha Entrada</th>
			<th>Fecha Salida</th>
			<th>Noches</th>
			<th>No. Habitaciones</th>
			<th>Tarifa</th>
			<th>Precio Hospedaje</th>
			<th>Cantidad Hospedaje</th>
			<th>Extra Adulto</th>
			<th>Extra Junior</th>
			<th>Extra Infantil</th>
			<th>Extra Menor</th>
			<th>Nombre Huésped</th>
			<th>Teléfono Huésped</th>
			<th>Total Estancia</th>
			<th>Total Pago</th>
			<th>Forma Pago</th>
			<th>Límite Pago</th>
			<th>Status</th>';
        echo '</tr>
		  </thead>
		<tbody>';
        while ($fila = mysqli_fetch_array($consulta)) {
            if($cont>=$posicion & $cont<$final) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
				  <td>'.$fila['ID'].'</td> 
				  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
				  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
				  <td>'.$fila['noches'].'</td> 
				  <td>'.$fila['numero_hab'].'</td> 
				  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
				  <td>'.$fila['extra_adulto'].'</td> 
				  <td>'.$fila['extra_junior'].'</td> 
				  <td>'.$fila['extra_infantil'].'</td> 
				  <td>'.$fila['extra_menor'].'</td>
				  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
				  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    echo '</tr>';
                }
            }
            $cont++;
        }
        echo '
		  </tbody>
		</table>
		</div>';
        return $cat_paginas;
    }
    // Barra de busqueda en ver reservaciones por dia
    public function buscar_reservacion_por_dia($a_buscar, $id)
    {
        $inicio_dia= date("d-m-Y");
        $inicio_dia= strtotime($inicio_dia);

        if(strlen($a_buscar) == 0) {
            $cat_paginas = $this->mostrar_por_dia(1, $id);
        } else {
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		  FROM reservacion
		  INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
		  INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
		  INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		  INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || huesped.telefono LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.id DESC";
            $comentario="Mostrar diferentes busquedas en ver reservaciones por dia";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            //se recibe la consulta y se convierte a arreglo
            echo ' 
			<div class="table-responsive" id="tabla_reservacion">';
            $this->datos_por_dia($inicio_dia, $a_buscar);

            echo '<table class="table table-bordered table-hover">
			  <thead>
				<tr class="table-primary-encabezado text-center">
				<th>Número</th>
				<th>Fecha Entrada</th>
				<th>Fecha Salida</th>
				<th>Noches</th>
				<th>No. Habitaciones</th>
				<th>Tarifa</th>
				<th>Precio Hospedaje</th>
				<th>Cantidad Hospedaje</th>
				<th>Extra Adulto</th>
				<th>Extra Junior</th>
				<th>Extra Infantil</th>
				<th>Extra Menor</th>
				<th>Nombre Huésped</th>
				<th>Teléfono Huésped</th>
				<th>Total Estancia</th>
				<th>Total Pago</th>
				<th>Forma Pago</th>
				<th>Límite Pago</th>
				<th>Status</th>';
            echo '</tr>
			  </thead>
			<tbody>';
            while ($fila = mysqli_fetch_array($consulta)) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					  <td>'.$fila['ID'].'</td> 
					  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					  <td>'.$fila['noches'].'</td> 
					  <td>'.$fila['numero_hab'].'</td> 
					  <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					  <td>'.$fila['extra_adulto'].'</td> 
					  <td>'.$fila['extra_junior'].'</td> 
					  <td>'.$fila['extra_infantil'].'</td> 
					  <td>'.$fila['extra_menor'].'</td>
					  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					  <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					  <td>'.$fila['ID'].'</td> 
					  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					  <td>'.$fila['noches'].'</td> 
					  <td>'.$fila['numero_hab'].'</td> 
					  <td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					  <td>'.$fila['extra_adulto'].'</td> 
					  <td>'.$fila['extra_junior'].'</td> 
					  <td>'.$fila['extra_infantil'].'</td> 
					  <td>'.$fila['extra_menor'].'</td>
					  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					  <td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    echo '</tr>';
                }
            }
        }
        echo '
			  </tbody>
			</table>
			</div>';
    }
    // Busqueda por fecha en ver reservaciones por dia
    public function mostrar_reservacion_por_dia($fecha_dia_tiempo, $a_buscar, $combinada, $id)
    {
        date_default_timezone_set('America/Mexico_City');
        $fecha_dia_tiempo= $fecha_dia_tiempo. " 0:00:00";
        $fecha_dia= strtotime($fecha_dia_tiempo);

        if($a_buscar != ' ' && strlen($fecha_dia) == 0) {
            $cat_paginas = $this->mostrar_por_dia(1, $id);
        } else {
            if($a_buscar != ' ' || $combinada == 1) {
                $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
			FROM reservacion
			INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
			INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
			INNER JOIN huesped ON reservacion.id_huesped = huesped.id
			INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_dia && reservacion.fecha_entrada <= $fecha_dia && reservacion.fecha_entrada > 0 AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
            } elseif($a_buscar != ' ' && strlen($fecha_dia) == 0) {
                $fecha_dia = date("d-m-Y");
                $fecha_dia= strtotime($fecha_dia);
                $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
			FROM reservacion
			INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
			INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
			INNER JOIN huesped ON reservacion.id_huesped = huesped.id
			INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_dia && reservacion.fecha_entrada <= $fecha_dia && reservacion.fecha_entrada > 0 AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
            } else {
                $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
			FROM reservacion
            LEFT JOIN tarifa_hospedaje  ON reservacion.tipo_hab = tarifa_hospedaje.id 
		    LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
			INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
			INNER JOIN huesped ON reservacion.id_huesped = huesped.id
			INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_dia && reservacion.fecha_entrada <= $fecha_dia && reservacion.fecha_entrada > 0 AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
            }

            $comentario="Mostrar por fecha en ver reservaciones por dia";
            $consulta= $this->realizaConsulta($sentencia, $comentario);
            //se recibe la consulta y se convierte a arreglo
            echo '<div class="table-responsive" id="tabla_reservacion">';
            $this->datos_por_dia($fecha_dia, $a_buscar);

            echo '<table class="table table-bordered table-hover">
			<thead>
			  <tr class="table-primary-encabezado text-center">
			  <th>Número</th>
			  <th>Fecha Entrada</th>
			  <th>Fecha Salida</th>
			  <th>Noches</th>
			  <th>No. Habitaciones</th>
			  <th>Tarifa</th>
			  <th>Precio Hospedaje</th>
			  <th>Cantidad Hospedaje</th>
			  <th>Extra Adulto</th>
			  <th>Extra Junior</th>
			  <th>Extra Infantil</th>
			  <th>Extra Menor</th>
			  <th>Nombre Huésped</th>
			  <th>Teléfono Huésped</th>
			  <th>Total Estancia</th>
			  <th>Total Pago</th>
			  <th>Forma Pago</th>
			  <th>Límite Pago</th>
			  <th>Status</th>';
            echo '</tr>
			</thead>
		  <tbody>';
            while ($fila = mysqli_fetch_array($consulta)) {
                if($fila['edo'] == 1) {
                    if($fila['total_pago'] <= 0) {
                        echo '<tr class="text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Abierta</td>';
                        echo '</tr>';
                    } else {
                        echo '<tr class="table-success text-center">
					<td>'.$fila['ID'].'</td> 
					<td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
					<td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
					<td>'.$fila['noches'].'</td> 
					<td>'.$fila['numero_hab'].'</td> 
					<td>'.$fila['habitacion'].'</td>';
                        echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                        echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
					<td>'.$fila['extra_adulto'].'</td> 
					<td>'.$fila['extra_junior'].'</td> 
					<td>'.$fila['extra_infantil'].'</td> 
					<td>'.$fila['extra_menor'].'</td>
					<td>'.$fila['persona'].' '.$fila['apellido'].'</td>
					<td>'.$fila['tel'].'</td>';
                        if($fila['forzar_tarifa']>0) {
                            echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                        } else {
                            echo '<td>$'.number_format($fila['total'], 2).'</td>';
                        }
                        echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                        echo '<td>'.$fila['descripcion'].'</td>';
                        echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                        echo '<td>Garantizada</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr class="table-secondary text-center">
				  <td>'.$fila['ID'].'</td> 
				  <td>'.date("d-m-Y", $fila['fecha_entrada']).'</td>
				  <td>'.date("d-m-Y", $fila['fecha_salida']).'</td>
				  <td>'.$fila['noches'].'</td> 
				  <td>'.$fila['numero_hab'].'</td> 
				  <td>'.$fila['habitacion'].'</td>';
                    echo '<td>$'.number_format($fila['precio_hospedaje'], 2).'</td>';
                    echo '<td>'.$fila['cantidad_hospedaje'].'</td>  
				  <td>'.$fila['extra_adulto'].'</td> 
				  <td>'.$fila['extra_junior'].'</td> 
				  <td>'.$fila['extra_infantil'].'</td> 
				  <td>'.$fila['extra_menor'].'</td>
				  <td>'.$fila['persona'].' '.$fila['apellido'].'</td>
				  <td>'.$fila['tel'].'</td>';
                    if($fila['forzar_tarifa']>0) {
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>';
                    } else {
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';
                    echo '<td>'.$fila['descripcion'].'</td>';
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';
                    echo '<td>Activa</td>';
                    echo '</tr>';
                }
            }
        }
        echo '
		  </tbody>
		</table>
		</div>';
    }

    //editar una reservacion "nueva"

        // Guardar la reservacion (nuevo)
    public function editar_reservacionNew(
        $id_huesped,
        $tipo_hab,
        $id_movimiento,
        $fecha_entrada,
        $fecha_salida,
        $noches,
        $numero_hab,
        $precio_hospedaje,
        $cantidad_hospedaje,
        $extra_adulto,
        $extra_junior,
        $extra_infantil,
        $extra_menor,
        $tarifa,
        $nombre_reserva,
        $acompanante,
        $forma_pago,
        $limite_pago,
        $suplementos,
        $total_suplementos,
        $total_hab,
        $forzar_tarifa,
        $codigo_descuento,
        $descuento,
        $total,
        $total_pago,
        $hab_id,
        $usuario_id,
        $cantidad_cupon,
        $tipo_descuento,
        $estado,
        $pax_extra,
        $canal_reserva,
        $plan_alimentos,
        $tipo_reservacion,
        $sobrevender,
        $id_cuenta,
        $estado_interno,
    ) 
    {
        $fecha_entrada= strtotime($fecha_entrada);
        $fecha_salida= strtotime($fecha_salida);
        if($forzar_tarifa > 0) {
            $total_cargo= $total_suplementos + $forzar_tarifa;
        } else {
            $total_cargo=$total_pago;
        }
        if($cantidad_cupon > 0) {
            $pago_total= $total_pago + $cantidad_cupon;
        } else {
            $pago_total= $total_pago;
        }
        $sentencia = "UPDATE `reservacion` SET
			`id_huesped` = '$id_huesped',
			`tipo_hab` = '$tipo_hab',
			`fecha_entrada` = '$fecha_entrada',
			`fecha_salida` = '$fecha_salida',
			`noches` = '$noches',
			`numero_hab` = '$numero_hab',
			`precio_hospedaje` = '$precio_hospedaje',
			`cantidad_hospedaje` = '$cantidad_hospedaje',
			`extra_adulto` = '$extra_adulto',
			`extra_junior` = '$extra_junior',
			`extra_infantil` = '$extra_infantil',
			`extra_menor` = '$extra_menor',
			`tarifa` = '$tarifa',
			`nombre_reserva` = '$nombre_reserva',
			`acompanante` = '$acompanante',
			`forma_pago` = '$forma_pago',
			`limite_pago` = '$limite_pago',
			`suplementos` = '$suplementos',
			`total_suplementos` = '$total_suplementos',
			`total_hab` = '$total_hab',
			`forzar_tarifa` = '$forzar_tarifa',
			`codigo_descuento` = '$codigo_descuento',
			`descuento` = '$descuento',
			`total` = '$total',
			`total_pago` = '$total_pago',
			`tipo_descuento` = '$tipo_descuento',
            `id_usuario` = '$usuario_id',
            `pax_extra` = '$pax_extra',
            `canal_reserva` = '$canal_reserva',
            `plan_alimentos` = '$plan_alimentos',
            `tipo_reservacion` = '$tipo_reservacion',
            `sobrevender` = '$sobrevender',
            `estado_interno` = '$estado_interno'
			WHERE `id` = '$id_cuenta'";
        //echo $sentencia;
        $comentario="Editar una reservacion dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia, $comentario);

        // $sentencia = "UPDATE `cuenta` SET
        // `cargo` = '$total_cargo',
        // `abono` = '$pago_total'
        // WHERE `id` = '$id_cuenta';";
        // //echo $sentencia;
        // $comentario="Editar una cuenta proveniente de una reservacion dentro de la base de datos";
        // $consulta= $this->realizaConsulta($sentencia, $comentario);


    }

    // Editar una reservacion
    public function editar_reservacion($id, $id_huesped, $tipo_hab, $id_cuenta, $fecha_entrada, $fecha_salida, $noches, $numero_hab, $precio_hospedaje, $cantidad_hospedaje, $extra_adulto, $extra_junior, $extra_infantil, $extra_menor, $tarifa, $nombre_reserva, $acompanante, $forma_pago, $limite_pago, $suplementos, $total_suplementos, $total_hab, $forzar_tarifa, $codigo_descuento, $descuento, $total, $total_pago, $cantidad_cupon, $tipo_descuento)
    {
        $fecha_entrada=strtotime($fecha_entrada);
        $fecha_salida=strtotime($fecha_salida);
        if($forzar_tarifa > 0) {
            $total_cargo= $total_suplementos + $forzar_tarifa;
        }
        if($cantidad_cupon > 0) {
            $pago_total= $total_pago + $cantidad_cupon;
        } else {
            $pago_total= $total_pago;
        }
        $sentencia = "UPDATE `reservacion` SET
			`id_huesped` = '$id_huesped',
			`tipo_hab` = '$tipo_hab',
			`fecha_entrada` = '$fecha_entrada',
			`fecha_salida` = '$fecha_salida',
			`noches` = '$noches',
			`numero_hab` = '$numero_hab',
			`precio_hospedaje` = '$precio_hospedaje',
			`cantidad_hospedaje` = '$cantidad_hospedaje',
			`extra_adulto` = '$extra_adulto',
			`extra_junior` = '$extra_junior',
			`extra_infantil` = '$extra_infantil',
			`extra_menor` = '$extra_menor',
			`tarifa` = '$tarifa',
			`nombre_reserva` = '$nombre_reserva',
			`acompanante` = '$acompanante',
			`forma_pago` = '$forma_pago',
			`limite_pago` = '$limite_pago',
			`suplementos` = '$suplementos',
			`total_suplementos` = '$total_suplementos',
			`total_hab` = '$total_hab',
			`forzar_tarifa` = '$forzar_tarifa',
			`codigo_descuento` = '$codigo_descuento',
			`descuento` = '$descuento',
			`total` = '$total',
			`total_pago` = '$total_pago',
			`tipo_descuento` = '$tipo_descuento'
			WHERE `id` = '$id';";
        //echo $sentencia;
        $comentario="Editar una reservacion dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia, $comentario);

        $sentencia = "UPDATE `cuenta` SET
			`cargo` = '$total_cargo',
			`abono` = '$pago_total'
			WHERE `id` = '$id_cuenta';";
        //echo $sentencia;
        $comentario="Editar una cuenta proveniente de una reservacion dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
    }
    // Borrar una reservacion
    public function borrar_reservacion($id)
    {
        $sentencia = "UPDATE `reservacion` SET
		`estado` = '0'
		WHERE `id` = '$id';";
        $comentario="Poner estado de una reservacion como inactivo";
        $consulta= $this->realizaConsulta($sentencia, $comentario);

    }
    // Modificar estado de una reservacion
    public function modificar_estado($id, $estado)
    {
        // 0=borrada  1=activa  2=cliente en hotel  3=cancelada
        $sentencia = "UPDATE `reservacion` SET
		`estado` = '$estado'
		WHERE `id` = '$id';";
        $comentario="Poner nuevo estado de una reservacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
    }
    // Modificar id_cuenta de una reservacion
    public function modificar_id_cuenta($id, $id_cuenta)
    {
        $sentencia = "UPDATE `reservacion` SET
		`id_cuenta` = '$id_cuenta'
		WHERE `id` = '$id';";
        $comentario="Poner nuevo id cuenta de una reservacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
    }
    // Modificar datos por realizar una cancelacion de una reservacion
    public function modificar_cancelada($id, $nombre_cancela)
    {
        $fecha_cancelacion= time();
        $sentencia = "UPDATE `reservacion` SET
		`fecha_cancelacion` = '$fecha_cancelacion',
		`nombre_cancela` = '$nombre_cancela'
		WHERE `id` = '$id';";
        $comentario="Poner datos por realizar una cancelacion de una reservacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
    }
    // Mostramos el pago
    public function mostrar_nombre_pago($id)
    {
        $sentencia = "SELECT limite_pago FROM pago WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $limite_pago = 0;
        $comentario="Obtengo el pago";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        while ($fila = mysqli_fetch_array($consulta)) {
            $limite_pago= $fila['limite_pago'];
        }
        return $limite_pago;
    }
    // Obtengo los datos de una reservacion
    public function datos_reservacion($id)
    {
        //cambié a left join por el hecho de que una reservacion "forzada" no tiene tarifa_hospedaje asignada como tal.
        $sentencia = "SELECT *,tipo_hab.nombre as tipohab,reservacion.precio_hospedaje as precio_hospe, planes_alimentos.nombre_plan as nombre_alimentos ,  
        planes_alimentos.costo_plan as costo_plan,
        reservacion.id AS ID,tarifa_hospedaje.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario
		FROM reservacion
		LEFT JOIN tarifa_hospedaje ON reservacion.tarifa = tarifa_hospedaje.id
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
        LEFT JOIN planes_alimentos ON reservacion.plan_alimentos = planes_alimentos.id
		INNER JOIN usuario ON reservacion.id_usuario = usuario.id
		INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.id = $id AND (reservacion.estado = 2 OR reservacion.estado = 1) ORDER BY reservacion.id DESC";
        $comentario="Mostrar los datos de la reservacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        return $consulta;
    }
    // Obtengo los datos del cargo por noche de la habitacio
    public function datos_reservacion_por_dia($dia)
    {
        $salida= $dia + 86399;
        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
		FROM reservacion
        LEFT JOIN tarifa_hospedaje  ON reservacion.tipo_hab = tarifa_hospedaje.id 
		LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
		INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
		INNER JOIN huesped ON reservacion.id_huesped = huesped.id
		INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.fecha_entrada = $dia || (reservacion.fecha_entrada > $dia && reservacion.fecha_salida <= $salida)) AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
        $comentario="Obtengo los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        return $consulta;
    }
}
