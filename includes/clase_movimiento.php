<?php
 /* error_reporting(E_ALL);
  ini_set('display_errors', '1');*/
  date_default_timezone_set('America/Mexico_City');

  include_once('consulta.php');
  //include_once('class_hab.php');
  //$hab = NEW habitacion();
    /**
     *
     */
    class Movimiento extends ConexionMYSql
    {
      /*public $mov;
      public $rec_realiza;
      public $id_reservacion;*/
      function __construct($id)
      {
        /*if($id>0){
          $sentencia = "SELECT * FROM movimiento WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores del movimiento";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta)){
            $this->mov= $fila['id'];
            $this->rec_realiza= $fila['detalle_realiza'];
            $this->id_reservacion= $fila['id_reservacion'];
          }
        }
        else{
          $this->mov= 0;
          $this->rec_realiza="";
          $this->id_reservacion= 0;
        }*/
      }
      function sacar_movimiento($mov){
        $sentencia="SELECT * FROM movimiento WHERE id=$mov LIMIT 1;";
        $comentario ="Obtner el numero de preasignadas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function obtener_preasignadas(){
        $preasignadas=0;
        $sentencia="SELECT count(hab.id) as preasignadas
        FROM movimiento
        left join reservacion on movimiento.id_reservacion = reservacion.id
        LEFT JOIN hab on movimiento.id_hab = hab.id
        where reservacion.estado =1
        and movimiento.motivo='preasignar'
        and from_unixtime(fecha_entrada + 3600, '%Y-%m-%d') >= from_unixtime(UNIX_TIMESTAMP(),'%Y-%m-%d') 
        order by reservacion.fecha_entrada asc";
        $comentario ="Obtner el numero de preasignadas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
            $preasignadas= $fila['preasignadas'];
        }
        return $preasignadas;
      }
      // Obtener cuenta total de la habitacion
      function cuenta_total($mov){
        $id_reservacion= 0;
        $total= 0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
            $id_reservacion= $fila['id_reservacion'];
        }
        $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener la cuenta total de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
            if($fila['forzar_tarifa']>0){
              $total= $fila['forzar_tarifa'];
            }else{
              $total= $fila['total'];
            }
        }
        return $total;
      }
      // Obtener la fecha de salida de la habitacion
      function ver_fecha_salida($mov){
        $id_reservacion= 0;
        $fecha_salida= 0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $id_reservacion= $fila['id_reservacion'];
        }
        $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener la fecha de salida de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
        }
        return $fecha_salida;
      }
      function ver_fecha_entrada($mov){
        $id_reservacion= 0;
        $fecha_salida= 0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $id_reservacion= $fila['id_reservacion'];
        }
        $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener la fecha de salida de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $fecha_salida= date("d-m-Y",$fila['fecha_entrada']);
        }
        return $fecha_salida;
      }
      function saberMovimientosHabiles($fechaAnterior, $fechaLimite){
        // $sentencia = "SELECT hab.id,hab.nombre,hab.tipo,hab.mov as moviemiento,hab.estado,hab.comentario,tipo_hab.nombre AS tipo_nombre,movimiento.estado_interno AS interno FROM hab LEFT JOIN tipo_hab ON hab.tipo = tipo_hab.id LEFT JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1 $filtro ORDER BY id";
        // $comentario="Mostrar los movimientos habiles para una habitacion (futuro) ";
        // $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener el ultimo movimiento ingresado
      function ultima_insercion(){
        $sentencia= "SELECT id FROM movimiento ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo movimiento ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $id= $fila['id'];
        }
        return $id;
      }
      function saber_motivo($mov){// LO VOY A MODIFICAR PARA SUCIA O LIMPIANDO //
        $sentencia = "SELECT motivo FROM movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $motivo= '...';
         //echo '<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $motivo= $fila['motivo'];
        }
        return $motivo;
      }
      // Obtener el tiempo de fin de hospedaje
      function saber_fin_hospedaje($mov){
        $fin_hospedaje= 0;
        $sentencia = "SELECT fin_hospedaje FROM movimiento WHERE id = $mov LIMIT 1";
        //echo $sentencia;
        $comentario="Obtener el tiempo de fin de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_hospedaje= $fila['fin_hospedaje'];
        }
        return $fin_hospedaje;
      }
      function cambiar_finalizado($mov){
        $sentencia = "UPDATE `movimiento` SET
        `finalizado` = '0'
        WHERE `id` = '$mov';";
        $comentario="Modificar el detalle inicio del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener el tiempo de finalizado
      function saber_tiempo_finalizado_renta($mov){
        $finalizado= 0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov ORDER BY id DESC LIMIT 1 ";
        $comentario="Obtener el tiempo de fin de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
            $finalizado= $fila['finalizado'];
        }
        return $finalizado;
      }
      // Obtener el tiempo de utlima rente de fin hospedaje
      function saber_tiempo_ultima_renta($hab){
        $finalizado= 0;
        $sentencia = "SELECT * FROM movimiento WHERE id_hab = $hab ORDER BY id DESC LIMIT 1 ";
        $comentario="Obtener el tiempo de fin de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila['motivo'] == "reservar"){
            $finalizado= $fila['liberacion'];
          }else{
            $finalizado= $fila['finalizado'];
          }
        }
        return $finalizado;
      }
      // Realiza el reporte de las habitaciones por noche
      function reporte_checkin($hab_id){
        $id_reservacion=0;
        $sentencia = "SELECT mov FROM hab WHERE id =$hab_id LIMIT 1 ";
        $comentario="Obtenemos el movimiento de habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
            $mov=$fila['mov'];
        }
        $sentencia2 = "SELECT id_reservacion FROM movimiento WHERE id = $mov LIMIT 1";
        $comentario2="Obtener el id reservacion de movimiento de id reservacion";
        $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
        while ($fila2 = mysqli_fetch_array($consulta2)){
            $id_reservacion= $fila2['id_reservacion'];
        }
        return $id_reservacion;
      }
      // Obtener en que momento comenzo a estar sucio una habitacion
      function saber_inicio_sucia($mov){
        $finalizado= 0;
        $sentencia = "SELECT finalizado FROM movimiento WHERE id = $mov LIMIT 1";
        $comentario="Obtener en que momento comenzo a estar sucio una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $finalizado= $fila['finalizado'];
        }
        return $finalizado;
      }
      // Obtener el detalle inicio de un movimiento
      function saber_detalle_inicio($id){
        $detalle_inicio= 0;
        $sentencia = "SELECT detalle_inicio FROM movimiento WHERE id = $id LIMIT 1 ";
        $comentario="Obtener el detalle inicio de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $detalle_inicio= $fila['detalle_inicio'];
        }
        return $detalle_inicio;
      }
      // Obtener el inicio limpieza de un movimiento
      function saber_inicio_limpieza($id){
        $inicio_limpieza= 0;
        $sentencia = "SELECT inicio_limpieza FROM movimiento WHERE id = $id LIMIT 1 ";
        $comentario="Obtener el inicio limpieza de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $inicio_limpieza= $fila['inicio_limpieza'];
        }
        return $inicio_limpieza;
      }
      // Obtener la persona limpio de un movimiento
      function saber_persona_limpio($id){
        $persona_limpio= 0;
        $sentencia = "SELECT persona_limpio FROM movimiento WHERE id = $id LIMIT 1 ";
        $comentario="Obtener la persona limpio de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $persona_limpio= $fila['persona_limpio'];
        }
        return $persona_limpio;
      }
      // Obtener la persona detalle realiza de un movimiento
      function saber_detalle_realiza($id){
        $detalle_realiza= 0;
        $sentencia = "SELECT detalle_realiza FROM movimiento WHERE id = $id LIMIT 1";
        $comentario="Obtener la persona detalle realiza de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $detalle_realiza= $fila['detalle_realiza'];
        }
        return $detalle_realiza;
      }
      // Obtener el id de huesped de un movimiento
      function saber_id_huesped($id){
        $id_huesped= 0;
        $sentencia = "SELECT id_huesped FROM movimiento WHERE id = $id LIMIT 1";
        $comentario="Obtener el id de huesped de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $id_huesped= $fila['id_huesped'];
        }
        return $id_huesped;
      }
      // Obtener el id de reservacion de un movimiento
      function saber_id_reservacion($id){
        $id_reservacion= 0;
        $sentencia = "SELECT id_reservacion FROM movimiento WHERE id = $id LIMIT 1";
        $comentario="Obtener el id de reservacion de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id_reservacion= $fila['id_reservacion'];
        }
        return $id_reservacion;
      }
      // Obtener el id de mesa de un movimiento
      function saber_id_mesa($id){
        $id_mesa= 0;
        $sentencia = "SELECT id_mesa FROM movimiento WHERE id = $id LIMIT 1";
        $comentario="Obtener el id de mesa de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $id_mesa= $fila['id_mesa'];
        }
        return $id_mesa;
      }
      // Obtener la cantidad de personas de un movimiento
      function saber_personas($id){
        $personas= 0;
        $sentencia = "SELECT personas FROM movimiento WHERE id = $id LIMIT 1";
        $comentario="Obtener la cantidad de personas de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta)){
          $personas= $fila['personas'];
        }
        return $personas;
      }
      // Agregar una reservacion en la habitacion
      function disponible_asignar($mov,$hab_id,$id_huesped,$fecha_entrada,$fecha_salida,$usuario_id,$tarifa,$motivo="reservar"){
        //codigo que verifica si las fechas  ya son tiempo 'unix', si ya lo son, las guarda tal cual, sino, las convierte a tiempo 'unix'
        $fecha_entradaF="";
        $fecha_salidaF="";
        $fecha_entradaP= strtotime($fecha_entrada);
        $fecha_salidaP= strtotime($fecha_salida);
        if(empty($fecha_entradaP)){
            $fecha_entradaF = $fecha_entrada;
        }else{
          $fecha_entradaF = $fecha_entradaP;
        }
        if(empty($fecha_salidaP)){
          $fecha_salidaF = $fecha_salida;
        }else{
          $fecha_salidaF = $fecha_salidaP;
        }
        $fecha_salidaF = empty($fecha_salidaF) ? 0 : $fecha_salidaF;
        $inicio=time();
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `id_mesa`, `personas`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `tarifa`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `comentario`, `estado_interno`)
        VALUES ('$hab_id', '$id_huesped', '$mov', '0', '0', '$fecha_entradaF', '$fecha_salidaF', '$inicio', '0', '$usuario_id', '0', '0', '$tarifa', '0', '0', '0', '0', '$motivo', '', 'sin estado');";
        $comentario="Agregar una reservacion en la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id= $this->ultima_insercion();
        return $id;
      }
      function guardar_usocasa($hab_id,$usuario_id,$nombre_uso,$fecha_entrada,$fecha_salida){
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `id_mesa`, `personas`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `tarifa`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `comentario`, `estado_interno`,persona_uso)
        VALUES ('$hab_id', '0', '0', '0', '0', '0', '0', '$fecha_entrada', '$fecha_salida', '$usuario_id', '0', '0', '0', '0', '0', '0', '0', 'limpiar', '', 'sin estado', '$nombre_uso');";
        $comentario="Agregar uso casa  en la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id= $this->ultima_insercion();
        return $id;
      }
      // Agregar una habitacion en estado limpieza
      function guardar_limpieza($hab_id,$usuario_id,$usuario){
        $fecha_entrada= time();
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `id_mesa`, `personas`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `tarifa`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `comentario`, `estado_interno`)
        VALUES ('$hab_id', '0', '0', '0', '0', '0', '0', '0', '0', '$usuario_id', '0', '0', '0', '$fecha_entrada', '0', '$usuario', '0', 'limpiar', '', 'sin estado');";
        $comentario="Agregar limpieza en la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id= $this->ultima_insercion();
        return $id;
      }
      // Asignar una mesa en estado ocupado
      function mesa_asignar($id_mesa,$usuario_id,$personas){
        $fecha_inicio= time();
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `id_mesa`, `personas`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `tarifa`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `comentario`, `estado_interno`)
        VALUES ('0', '0', '0', '$id_mesa', '$personas', '0', '0', '$fecha_inicio', '0', '$usuario_id', '$usuario_id', '0', '0', '0', '0', '0', '0', 'asignar mesa', '', 'sin estado');";
        $comentario="Asignar una mesa en estado ocupado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id= $this->ultima_insercion();
        return $id;
      }
      // Agregar una habitacion en estado seleccionado con un comentario especifico
      function guardar_comentario($hab_id,$usuario_id,$usuario,$estado,$comentario){
        $fecha_entrada= time();
        switch($estado){
          case 4:// Enviar a mantenimiento
              $motivo= 'mantenimiento';
              break;
          case 5:// Enviar a supervision
              $motivo= 'supervisar';
              break;
          case 6:// Enviar a
              $motivo= 'cancelar';
              break;
          default:
              //echo "Estado indefinido";
              break;
        }
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `id_mesa`, `personas`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `tarifa`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `comentario`, `estado_interno`)
        VALUES ('$hab_id', '0', '0', '0', '0', '0', '0', '$fecha_entrada', '0', '$usuario_id', '$usuario', '0', '0', '0', '0', '0', '0', '$motivo', '$comentario', 'sin estado');";
        $comentario="Agregar una habitacion en estado seleccionado con un comentario especifico";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id= $this->ultima_insercion();
        return $id;
      }
      // Modificar el detalle inicio del movimiento
      function editar_detalle_inicio($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `detalle_inicio` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="Modificar el detalle inicio del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar el detalle fin del movimiento
      function editar_detalle_fin($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `detalle_fin` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="Modificar el detalle fin del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar persona del detalle realiza del movimiento
      function editar_detalle_realiza($mov,$usuario){
        $sentencia = "UPDATE `movimiento` SET
        `detalle_realiza` = '$usuario'
        WHERE `id` = '$mov';";
        $comentario="Modificar persona del detalle realiza del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar el fin limpieza del movimiento
      function editar_fin_limpieza($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `fin_limpieza` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="Modificar el fin limpieza del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar la liberacion del movimiento
      function editar_liberacion($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `liberacion` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="Modificar la liberacion del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar la persona limpio del movimiento
      function editar_persona_limpio($mov,$usuario){
        $sentencia = "UPDATE `movimiento` SET
        `persona_limpio` = '$usuario'
        WHERE `id` = '$mov';";
        $comentario="Modificar la persona limpio del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar el estado interno del movimiento
      function editar_estado_interno($mov,$opcion){
        $estado_interno= '';
        switch($opcion){
          case 0:
              $estado_interno= 'sin estado';
              break;
          case 1.1:
              $estado_interno= 'sucia';
              break;
          case 1.2:
              $estado_interno= 'limpieza';
              break;
          case 1.3:
              $estado_interno= 'uso casa';
              break;
        }
        $sentencia = "UPDATE `movimiento` SET
        `estado_interno` = '$estado_interno'
        WHERE `id` = '$mov';";
        echo $sentencia;
        $comentario="Modificar el estado interno del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar movimiento por estado limpieza
      function editar_estado_usocasa($mov,$usuario_id,$nombre_uso,$fecha_entrada,$fecha_salida){
        $fecha_entrada = strtotime($fecha_entrada);
        $fecha_salida = strtotime($fecha_salida);
        $sentencia = "UPDATE `movimiento` SET
        `detalle_manda` = '$usuario_id',
        `detalle_inicio` = '$fecha_entrada',
        `detalle_fin` = '$fecha_salida',
        `persona_uso` = '$nombre_uso'
        WHERE `id` = '$mov';";
        $comentario="Modificar la persona limpio del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar movimiento por estado limpieza
      function editar_estado_limpieza($mov,$usuario_id,$usuario,$motivo){
        $tiempo= time();
        if($motivo == 0){
          $sentencia = "UPDATE `movimiento` SET
          `detalle_manda` = '$usuario_id',
          `inicio_limpieza` = '$tiempo',
          `fin_limpieza` = '0',
          `persona_limpio` = '$usuario'
          WHERE `id` = '$mov';";
          $comentario="Modificar la persona limpio del movimiento";
          $this->realizaConsulta($sentencia,$comentario);
        }else{
          $sentencia = "UPDATE `movimiento` SET
          `detalle_manda` = '$usuario_id',
          `inicio_limpieza` = '$tiempo',
          `fin_limpieza` = '0',
          `persona_limpio` = '$usuario',
          `motivo` = 'limpiar'
          WHERE `id` = '$mov';";
          $comentario="Modificar la persona limpio del movimiento";
          $this->realizaConsulta($sentencia,$comentario);
        }
      }
      // Obtner el estado interno del movimiento de una habitacion 
      function mostrar_estado_interno($mov){
        if($mov >0){
          $sentencia= "SELECT estado_interno FROM movimiento WHERE id =$mov LIMIT 1";
          $estado_interno= '';
          $comentario="Obtner el estado interno del movimiento de una habitacion ";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $estado_interno= $fila['estado_interno'];
          }
        }else{
          $estado_interno="Disponible";
        }
        
        return $estado_interno;
      }
      // Poner tiempo en campo finalizado al desocupar una habitacion
      function desocupar_mov($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `finalizado` = '$tiempo',
        `estado_interno` = 'sin estado'
        WHERE `id` = '$mov';";
        $comentario="Poner tiempo en campo finalizado al desocupar una habitacion";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener las habitaciones que han salido
      function saber_salidas(){
        $cantidad=0;
        $fecha_actual= time();
        $dia_actual= date("d-m-Y",$fecha_actual);
        $dia_actual= strtotime($dia_actual);
        $sentencia = "SELECT count(movimiento.id) AS cantidad,movimiento.finalizado FROM movimiento WHERE finalizado >= $dia_actual";
        $comentario="Obtener las habitaciones que han salido";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Cambiar la cantidad de personas en la mesa
      function cambiar_personas($mov,$personas){
        $sentencia = "UPDATE `movimiento` SET
        `personas` = '$personas'
        WHERE `id` = '$mov';";
        $comentario="Cambiar la cantidad de personas en la mesa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function actualizarHab($mov,$preasignada){
        // echo $mov . "|" . $preasignada;
        // die();
        $sentencia = "UPDATE `movimiento` SET
        `id_hab` = '$preasignada'
        WHERE `id` = '$mov';";
        $comentario="Cambiar la habitacion preasignada de una reservacion/movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function actualizarFechasMov($mov,$fecha_entrada,$fecha_salida){
        $sentencia = "UPDATE `movimiento` SET
        `inicio_hospedaje` = '$fecha_entrada',
        `fin_hospedaje` = '$fecha_salida'
        WHERE `id` = '$mov';";
        $comentario="Actualizando las fechas de hospedaje del movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function duplicar($id_mov, $id_reserva){
        $sentencia="INSERT INTO movimiento
        (id_hab, id_huesped, id_reservacion, id_mesa, personas, inicio_hospedaje, fin_hospedaje, detalle_inicio, detalle_fin, detalle_manda, detalle_realiza, finalizado, tarifa, fin_limpieza, persona_limpio, liberacion, motivo, comentario, estado_interno, persona_uso)
        SELECT id_hab, id_huesped, '$id_reserva', id_mesa, personas, inicio_hospedaje, fin_hospedaje, detalle_inicio, detalle_fin, detalle_manda, detalle_realiza, finalizado, tarifa, fin_limpieza, persona_limpio, liberacion, motivo, comentario, estado_interno, persona_uso
        FROM movimiento
        WHERE id = $id_mov";
        $comentario="Duplicar movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function cancelar_preasignada($id_mov){
        $sentencia="UPDATE movimiento set id_hab = NULL
        WHERE id = $id_mov";
        $comentario="Cancelar preasignada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function saber_fecha_inicio($mov){
        $sentencia="SELECT inicio_hospedaje FROM movimiento
        WHERE id = $mov";
        $comentario="Cancelar preasignada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $fila = mysqli_fetch_array($consulta);
        $fecha= $fila['inicio_hospedaje'];
        return $fecha;
      }
      function saber_fecha_fin($mov){
        $sentencia="SELECT fin_hospedaje FROM movimiento
        WHERE id = $mov";
        $comentario="Cancelar preasignada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $fila = mysqli_fetch_array($consulta);
        $fecha= $fila['fin_hospedaje'];
        return $fecha;
      }
      function saber_id_con_id_reservacion($id){
        $sentencia="SELECT id FROM movimiento
        WHERE id_reservacion = $id";
        //echo $sentencia;
        $comentario="Cancelar preasignada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $fila = mysqli_fetch_array($consulta);
        $result= $fila['id'];
        //echo $result;
        return $result;
      }
  }
?>
