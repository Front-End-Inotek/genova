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
          while ($fila = mysqli_fetch_array($consulta))
          {
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
      // Obtener cuenta total de la habitacion
      function cuenta_total($mov){
        $id_reservacion=0;
        $total=0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
            $id_reservacion= $fila['id_reservacion']; 
        }

        $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener la cuenta total de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
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
        $id_reservacion=0;
        $fecha_salida=0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id_reservacion= $fila['id_reservacion']; 
        }

        $sentencia = "SELECT * FROM reservacion WHERE id = $id_reservacion LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener la fecha de salida de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
        }
        return $fecha_salida;
      }
      // Obtengo los datos del cargo por noche de la habitacio 
      function datos_cargo_noche(){
        /*$sentencia = "SELECT *, reservacion.id_huesped AS huesped_id 
        FROM reservacion
        INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion WHERE movimiento.id_hab = $id_hab AND reservacion.estado = 1";*/
        $sentencia = "SELECT * 
        FROM hab
        INNER JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1";
        $comentario="Obtengo los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtener el ultimo movimiento ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM movimiento ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo movimiento ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
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
        while ($fila = mysqli_fetch_array($consulta))
        {
          $motivo= $fila['motivo'];
        }
        return $motivo;
      }
      // Obtener el tiempo de fin de hospedaje
      function saber_fin_hospedaje($mov){
        $fin_hospedaje= 0;
        $sentencia = "SELECT fin_hospedaje FROM  movimiento WHERE id = $mov LIMIT 1";
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
      // Obener el tiempo de utlima rente de fin hospedaje
      function saber_tiempo_ultima_renta($hab){
        $finalizado= 0;
        $sentencia = "SELECT * FROM movimiento WHERE id_hab = $hab  ORDER BY id DESC LIMIT 1 ";
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
        while ($fila = mysqli_fetch_array($consulta))
        {
            $mov=$fila['mov'];
        }
  
        $sentencia2 = "SELECT id_reservacion FROM movimiento WHERE id = $mov LIMIT 1";
        $comentario2="Obtener el id reservacion de movimiento de id reservacion";
        $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
        while ($fila2 = mysqli_fetch_array($consulta2))
        {
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
        while ($fila = mysqli_fetch_array($consulta))
        {
          $finalizado= $fila['finalizado'];
        }
        return $finalizado;
      }
      // Obtener el detalle inicio de un movimiento
      function saber_detalle_inicio($id){
        $sentencia = "SELECT detalle_inicio FROM movimiento WHERE id = $id LIMIT 1 ";
        $comentario="Obtener el detalle inicio de un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $detalle_inicio= $fila['detalle_inicio'];
        }
        return $detalle_inicio;
      }
      // Agregar una reservacion en la habitacion
      function disponible_asignar($mov,$hab_id,$id_huesped,$noches,$fecha_entrada,$fecha_salida,$usuario_id,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$nombre_reserva,$descuento,$total,$total_pago){
        $fecha_entrada= strtotime($fecha_entrada);
        $fecha_salida= strtotime($fecha_salida);
        //$inicio=time();
        $hora=date("G");
        if($hora<7){
          $horaactual=strtotime(date("Y/n/j")." 12:00");
        }else{
          $horaactual=strtotime(date("Y/n/j")." 12:00");
          $horaactual=$horaactual+86400;
        }
        
        //$fin=  $inicio+($tiempo*60*60);
        if($noches>1){
          $horaactual= $horaactual+($noches*86400);
        }
        //echo $fin;
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `descuento`, `total`, `total_pago`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `estado_interno`)
        VALUES ('$hab_id', '$id_huesped', '$hab_id', '$fecha_entrada', '$fecha_salida', '0', '0', '$usuario_id', '0', '0', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa', '$nombre_reserva', '$descuento', '$total', '$total_pago', '0', '0', '0', '0', 'reservar', 'sin estado');";
        $comentario="Agregar una reservacion en la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      
        $id= $this->ultima_insercion();
        return $id;
      }
      // Agregar una habitacion en estado limpieza
      function guardar_limpieza($hab_id,$usuario_id,$usuario){
        $fecha_entrada= time();
        $sentencia="INSERT INTO `movimiento` (`id_hab`, `id_huesped`, `id_reservacion`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `finalizado`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `descuento`, `total`, `total_pago`, `inicio_limpieza`, `fin_limpieza`, `persona_limpio`, `liberacion`, `motivo`, `estado_interno`)
        VALUES ('$hab_id', '0', '0', '0', '0', '0', '0', '$usuario_id', '0', '0', '0', '0', '0', '0', '0', '', '0', '0', '0', '$fecha_entrada', '0', '$usuario', '0', 'limpiar', 'sin estado');";
        $comentario="Agregar limpieza en la habitacion";
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
      // Modificar la persona limpio del movimiento
      function editar_persona_limpio($mov,$usuario){
        $sentencia = "UPDATE `movimiento` SET
        `persona_limpio` = '$usuario'
        WHERE `id` = '$mov';";
        $comentario="Modificar la persona limpio del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar el motivo del movimiento
      function editar_motivo($mov,$opcion){///**AQUI */
        $estado= '';
        switch($opcion){
          case 0:
              $estado= 'sin estado';
              break;
          case 1.1:
              $estado= 'sucia';
              break;
          case 1.2:
              $estado= 'limpieza';
              break;
        }

        $sentencia = "UPDATE `movimiento` SET
        `motivo` = '$estado'
        WHERE `id` = '$mov';";
        $comentario="Modificar el motivo del movimiento";
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
        }

        $sentencia = "UPDATE `movimiento` SET
        `estado_interno` = '$estado_interno'
        WHERE `id` = '$mov';";
        $comentario="Modificar el estado interno del movimiento";
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
        $sentencia= "SELECT estado_interno FROM movimiento WHERE id =$mov LIMIT 1";
        $estado_interno= '';
        $comentario="Obtner el estado interno del movimiento de una habitacion ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $estado_interno= $fila['estado_interno'];
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
  
  }
?>
