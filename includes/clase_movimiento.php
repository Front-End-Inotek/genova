<?php
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
  date_default_timezone_set('America/Mexico_City');

  include_once('consulta.php');
  //include_once('class_hab.php');
  //$hab = NEW habitacion();
    /**
     *
     */
    class Movimiento extends ConexionMYSql
    {
      public $mov;
      public $rec_realiza;
      public $id_reservacion;
      function __construct($id)
      {
        if($id>0){
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
        }
      }

      // Obtengo los datos del cargo por noche de la habitacio 
      function datos_cargo_noche(){
        /*$sentencia = "SELECT *, reservacion.id_huesped AS huesped_id 
        FROM reservacion
        INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion WHERE movimiento.habitacion = $id_hab AND reservacion.estado = 1";*/
        $sentencia = "SELECT * 
        FROM hab
        INNER JOIN movimiento ON hab.mov = movimiento.id WHERE hab.estado_hab = 1";
        $comentario="Obtengo los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }

      function id_mysql(){
        $id=0;
        $sentencia = "SELECT id FROM movimiento ORDER BY id DESC LIMIT 1";
        $comentario="Recojer el id del movimiento anterior";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
  			     $id= $fila['id'];
  		  }
        return $id;
      }
      function saber_tipo_hab($id) {
        $tipo_hab=0;
        $sentencia = "SELECT tipo_hab.nombre AS nombre FROM hab INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.id = $id ";
        $comentario="Recojer el id del movimiento anterior";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $tipo_hab= $fila['nombre'];
  		  }
        return $tipo_hab;
      }
      function estado_hab($est){
        $estado	=array();
  
        switch ($est) {
          case 0:
            $estado[0]="Disponible";
            $estado[1]='<img src="images/home.png"  class="espacio-imagen center-block img-responsive">';
          break;
          case 1:
            $estado[0]="Detallado";
            $estado[1]='<img src="images/detallando.png"  class="espacio-imagen center-block img-responsive">';
            
          break;
          case 2:
            $estado[0]="Lavar";
            $estado[1]='<img src="images/lavando.png"  class="espacio-imagen center-block img-responsive">';
            
          break;
          case 3:
              $estado[0]="Limpiar";
              $estado[1]='<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 4:
              $estado[0]="Mantto.";
              $estado[1]='<img src="images/mantenimiento.png"  class="espacio-imagen center-block img-responsive">';
             
          break;
          case 5:
              $estado[0]="Cancelado";
              $estado[1]='<img src="images/bloqueo.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 6:
              $estado[0]="Espera";
              $estado[1]='<img src="images/cobrando.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 7:
              $estado[0]="Ocupada";
              $estado[1]='<img src="images/cama.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 8:
              $estado[0]="Sucia";
              $estado[1]='<img src="images/basura.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 9:
            $estado[0]="Limpieza";
            $estado[1]='<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
            
          break;
          case 10:
              # code...
           
          break;
          case 11:
          
            $estado[0]="Restaurante";
            $estado[1]='<img src="images/restaurant.png"  class="espacio-imagen center-block img-responsive">';
          break;
          case 12:
              $estado[0]="Hospedada";
              $estado[1]='<img src="images/cama.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 13:
            $estado[1]='<img src="images/restaurant.png"  class="espacio-imagen center-block img-responsive">';
            
            $estado[0]="Restaurante";
          break;
          case 14:
            $estado[0]="Limpieza";
            $estado[1]= '<img src="images/limpieza.png"  class="espacio-imagen center-block img-responsive">';
            
          case 15:
              $estado[0]="Paseo";
              $estado[1]='<img src="images/home.png"  class="espacio-imagen center-block img-responsive">';
              
          break;
          case 16:
            $estado[0]="Restaurante";
            $estado[1]='<img src="images/restaurant.png"  class="espacio-imagen center-block img-responsive">';
          break;

          case 17:
             $estado[0]="Supervision";
             $estado[1]='<img src="images/supervision.png"  class="espacio-imagen center-block img-responsive">';
          break;
      }
        return $estado;
      }
      function obtener_estado($hab){
        $sentencia = "SELECT estado FROM hab WHERE nombre = $hab";
        $comentario="obtener el estado de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $estado= $fila['estado'];
        }
       return $estado;
      }
      function mov_asignar($hab_id,$id,$id_recam){
        $tiempo_inicio=time();
        $tiempo_fin=0;
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `comentario`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id', '$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'rentar', '', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function saber_tipo_mov($mov){
        $motivo=0;
        $sentencia = "SELECT motivo FROM movimiento WHERE id  = $mov LIMIT 1";
       //echo $sentencia;
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $motivo= $fila['motivo'];
        }
        return $motivo;
      }
      function saber_per_deta($mov){//
        $detalle_realiza= 0;//
        $sentencia = "SELECT detalle_realiza FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $detalle_realiza= $fila['detalle_realiza'];
        }
        return $detalle_realiza;
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
      function saber_tiempo_fin($mov){//
        $detalle_fin= 0;//
        $sentencia = "SELECT detalle_fin FROM  movimiento WHERE id = $mov LIMIT 1";
        //echo $sentencia;
        $comentario="obtener el tiempo de fin de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $detalle_fin= $fila['detalle_fin'];
        }
        return $detalle_fin;

        /*$id_reservacion=0;
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
        return $total;*/
      }
      function saber_tiempo_ultima_renta($hab){
        $detalle_fin=0;
        $sentencia = "SELECT * FROM movimiento WHERE habitacion = $hab  ORDER BY id DESC LIMIT 1 ";
        $comentario="obtener el tiempo de fin de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila['motivo']=="rentar"){
            $detalle_fin= $fila['liberacion'];
          }else{
            $detalle_fin= $fila['finalizado'];
          }
          
        }
        return $detalle_fin;
      }
  

      
 
      function reporte_checkin($hab_id){//
        $id_reservacion=0;
        $sentencia = "SELECT mov FROM hab WHERE id =$hab_id LIMIT 1 ";
        $comentario="Obtenemos el movimiento de habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $mov=$fila['mov'];
        }
  
        $sentencia2 = "SELECT id_reservacion FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario2="Obtener el id reservacion de movimiento de id reservacion";
        $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
        while ($fila2 = mysqli_fetch_array($consulta2))
        {
            $id_reservacion= $fila2['id_reservacion'];
        }
        return $id_reservacion;
      }
      function saber_tiempo_inicio($mov){
        $sentencia = "SELECT detalle_inicio FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Obtener el tiempo de inicio de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $detalle_inicio= '';
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $detalle_inicio= $fila['detalle_inicio'];
        }
        return $detalle_inicio;
      }
    
      function saber_tiempo_fin_limpieza($mov){
        $sentencia = "SELECT fin_limpieza FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_limpieza= $fila['fin_limpieza'];
        }
        return $fin_limpieza;
      }
      function saber_fin_hospedaje($mov){
        $sentencia = "SELECT fin_hospedaje FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_hospedaje= $fila['fin_hospedaje'];
        }
        return $fin_hospedaje;
      }
      function saber_inicio_sucia($mov){
        $sentencia = "SELECT finalizado FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $finalizado= $fila['finalizado'];
        }
        return $finalizado;
      }
      function timepo_entrada($id){
        $sentencia = "SELECT detalle_inicio FROM movimiento WHERE id = $id LIMIT 1 ";
        $comentario="Obtener el inicio de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $detalle_inicio= $fila['detalle_inicio'];
        }
        return $detalle_inicio;
      }


      function saber_nombre($id_usuario){
        $usuario='';
        $sentencia = "SELECT usuario FROM usuario WHERE id = $id_usuario LIMIT 1";
        $comentario="selecciona el nombre del usuario ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
             $usuario= $fila['usuario'];
        }
        return $usuario;
      }
      function saberusuario(){
        $sentencia = "SELECT * FROM usuario WHERE estado >= 1 ";
        $comentario="saber los usuarios";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<option value="'.$fila['id'].'">'.$fila['usuario'].'</option>';
        }
      }
      function id_hab($buscar){
        $sentencia = "SELECT id FROM hab WHERE nombre =$buscar LIMIT 2";
        $comentario="saber los usuarios";
        $hab=0;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $hab=$fila['id'];
        }
        return $hab;
      }
      function hab_nombre($id){
        $sentencia = "SELECT nombre FROM hab WHERE id =$id LIMIT 1";
        echo $sentencia;
        $comentario="saber los usuarios";
        $hab_nombre=0;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $hab_nombre=$fila['nombre'];
        }
        return $hab_nombre;
      }

      // Agregar una reservacion en la habitacion
      function disponible_asignar($mov,$hab,$id_huesped,$noches,$fecha_entrada,$fecha_salida,$usuario_id,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$nombre_reserva,$descuento,$total,$total_pago){
        $fecha_entrada=strtotime($fecha_entrada);
        $fecha_salida=strtotime($fecha_salida);
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
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `id_huesped`, `id_reservacion`, `inicio_hospedaje`, `fin_hospedaje`, `detalle_inicio`, `detalle_manda`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `descuento`, `total`, `total_pago`, `motivo`)
        VALUES ('$hab', '$id_huesped', '$hab', '$fecha_entrada', '$fecha_salida', '$fecha_entrada', '$usuario_id', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa', '$nombre_reserva', '$descuento', '$total', '$total_pago', 'reservar');";
        $comentario="Agregar una reservacion en la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //$MYSql_id=$this->id_mysql();
        //return $MYSql_id;

        $sentencia = "SELECT id FROM movimiento ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id del movimiento agregado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
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
      // Modificar el detalle fin del movimiento
      function editar_detalle_fin($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `detalle_fin` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="Modificar el detalle fin del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar el estado interno del movimiento
      function editar_estado_interno($mov,$opcion){
        $estado_interno= '';
        switch($opcion){
          case 0:
              $estado_interno= 'Sin estado';
              break;
          case 1.1:
              $estado_interno= 'Sucia';
              break;
          case 1.2:
              $estado_interno= 'Limpieza';
              break;
        }

        $sentencia = "UPDATE `movimiento` SET
        `estado_interno` = '$estado_interno'
        WHERE `id` = '$mov';";
        $comentario="Modificar el estado interno del movimiento";
        $this->realizaConsulta($sentencia,$comentario);
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
  
  }
?>
