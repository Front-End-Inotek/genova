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
      public $checkin;
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
               $this->checkin= $fila['checkin'];
    		  }
        }
        else{
          $this->mov= 0;
          $this->rec_realiza="";
          $this->checkin= 0;
        }
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
      function obtener_matricula($mov){
        $matricula="";
        $sentencia = "SELECT matricula FROM movimiento WHERE id = $mov LIMIT 1 ;";
        $comentario="obtener el estado de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $matricula= $fila['matricula'];
        }
        return $matricula;
      }
      function cambiar_matricula($mov,$matricula,$modelo,$color){
        $modelo_new=$modelo.'-'.$color;
        $sentencia = "UPDATE `movimiento` SET
        `matricula` = '$matricula',
        `modelo` = '$modelo_new'
        WHERE `id` = '$mov';";
        $comentario="obtener el estado de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function reporte_matricula($placa_anterior,$placa_nueva,$realizo,$mov){
        $tiempo=time();
        $sentencia = "INSERT INTO `cambio_placa` (`placa_anterior`, `placa_nueva`, `tiempo`, `realizo`, `mov`, `estado`)
        VALUES ('$placa_anterior', '$placa_nueva', '$tiempo', '$realizo', '$mov', '0');";
        $comentario="Guardar el reporte de cambio de matricula";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function mov_detalle($hab_id,$id,$id_recam,$tiempo){
        $tiempo_inicio=time();
        $tiempo_fin=$tiempo_inicio+$tiempo;
        $sentencia = "INSERT INTO `movimiento` (`habitacion`,`detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id','$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'detalle', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_manteni_retorno($hab_id,$id,$id_recam,$comentario,$mov){
        $tiempo_inicio=time();
        $tiempo_fin=0;
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `comentario` ,`id_huesped`, `matricula`, `modelo`, `color`, `anotacion`, `retorno`)
        VALUES ('$hab_id', '$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'mantenimiento', '$comentario', '', '', '', '', '', '$mov');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      
        


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_super_retorno($hab_id,$id,$id_recam,$comentario,$mov){
        $tiempo_inicio=time();
        $tiempo_fin=0;
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `comentario` ,`id_huesped`, `matricula`, `modelo`, `color`, `anotacion`, `retorno`)
        VALUES ('$hab_id', '$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'supervision', '$comentario', '', '', '', '', '', '$mov');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_manteni($hab_id,$id,$id_recam,$comentario){
        $tiempo_inicio=time();
        $tiempo_fin=0;
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `comentario` ,`id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id', '$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'mantenimiento', '$comentario', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_super($hab_id,$id,$id_recam,$comentario){//
        $tiempo_inicio=time();
        $tiempo_fin=0;
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `comentario` ,`id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id', '$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'supervision', '$comentario', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_bloqueo($hab_id,$id,$id_recam,$comentario){
        $tiempo_inicio=time();
        $tiempo_fin=0;
        $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `comentario`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id', '$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'bloqueo', '$comentario', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
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
      function mov_lavado($hab_id,$id,$id_recam,$tiempo){
        $tiempo_inicio=time();
        $tiempo_fin=$tiempo_inicio+$tiempo;
        $sentencia = "INSERT INTO `movimiento` (`habitacion`,`detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id','$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'lavado', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_sucio($hab_id,$id){
        $tiempo_inicio=time();
        $tiempo_fin=$tiempo_inicio;
        $sentencia = "INSERT INTO `movimiento` (`habitacion`,`detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`, `inicio_hospedaje`, `fin_hospedaje`, `finalizado`)
        VALUES ('$hab_id','$tiempo_inicio', '$tiempo_fin', '$id', '', 'sucio', '', '', '', '', '','$tiempo_inicio','$tiempo_inicio','$tiempo_inicio');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function saber_tipo_mov($mov){
        $motivo=0;
        $sentencia = "SELECT motivo FROM movimiento WHERE id  = $mov LIMIT 1 ";
       //echo $sentencia;
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $motivo= $fila['motivo'];
        }
        return $motivo;
      }
      function mov_lavado_retorno($hab_id,$id,$id_recam,$tiempo,$mov){
        $tiempo_inicio=time();
        $tiempo_fin=$tiempo_inicio+$tiempo;
        $sentencia = "INSERT INTO `movimiento` (`habitacion`,`detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`, `retorno`)
        VALUES ('$hab_id','$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'lavado', '', '', '', '', '', '$mov');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_limpieza($hab_id,$id,$id_recam,$tiempo){
        $tiempo_inicio=time();
        $tiempo_fin=$tiempo_inicio+$tiempo;
        $sentencia = "INSERT INTO `movimiento` (`habitacion`,`detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `motivo`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`)
        VALUES ('$hab_id','$tiempo_inicio', '$tiempo_fin', '$id', '$id_recam', 'limpieza', '', '', '', '', '');";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);


        $MYSql_id=$this->id_mysql();
        return $MYSql_id;
      }
      function mov_limpieza_sucio($mov,$id_recam,$tiempo){
        $tiempo_inicio=time();
        $tiempo_fin=$tiempo_inicio+$tiempo;
        $sentencia = "UPDATE `movimiento` SET
        `inicio_limpieza` = '$tiempo_inicio',
        `fin_limpieza` = '$tiempo_fin',
        `persona_limpio` = '$id_recam'
        WHERE `id` = '$mov';";
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return 1;
      }
      function sabermodelo_porplaca($matricula){
        $modelo=0;
        $sentencia = "SELECT modelo FROM movimiento WHERE matricula LIKE '$matricula' ORDER BY id DESC LIMIT 1 ";
       //echo $sentencia;
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $modelo= $fila['modelo'];
        }
        return $modelo;
      }
      function agregar_limpieza_hospedaje($mov,$realiza){
        $inicio = time();
        $sentencia = "INSERT INTO `hospdeje_limpieza` (`mov`, `realiza`, `inicio`, `fin`)
          VALUES ('$mov', '$realiza', '$inicio', '0');";
        $comentario="Guardar los datos de limpieza del hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function mov_cambio_persona($mov,$id_recam){
        $sentencia = "UPDATE `movimiento` SET
        `detalle_realiza` = '$id_recam'
        WHERE `id` = '$mov';";
        echo $sentencia;
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return 1;
      }
      function mov_cambio_persona_hab($mov,$id_recam){
        $sentencia = "UPDATE `movimiento` SET
        `persona_limpio` = '$id_recam'
        WHERE `id` = '$mov';";
        echo $sentencia;
        $comentario="Inicio de movimiento para detalle en la clase movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return 1;
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
      function saber_motivo($mov){
        $sentencia = "SELECT comentario FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $comentario= $fila['comentario'];
        }
        return $comentario;
      }
      function saber_per_limpia($mov){
        $sentencia = "SELECT persona_limpio FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $persona_limpio= $fila['persona_limpio'];
        }
        return $persona_limpio;
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

        /*$checkin=0;
        $total=0;
        $sentencia = "SELECT * FROM movimiento WHERE id = $mov LIMIT 1;";
        //echo  $sentencia;
        $comentario="Obtener el numero de reservacion correspondiente de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
            $checkin= $fila['checkin']; 
        }

        $sentencia = "SELECT * FROM reservacion WHERE id = $checkin LIMIT 1;";
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
      function agregar_personas($mov,$personas){
        $sentencia = "SELECT persona_extra FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="obtener la cantidad de personas extras";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        //echo $sentencia;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $persona_extra= $fila['persona_extra'];
        }
        $persona_extra =$persona_extra+$personas;
        $sentencia = "UPDATE `movimiento` SET
          `persona_extra` = '$persona_extra'
          WHERE `id` = '$mov';
           ";
        $comentario="agregar las personas extras";
        $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia;
      }
      function agregartiempo($horas, $mov){
        $fin_hospedaje=0;
        $cantidad_horas=0;
        $sentencia = "SELECT *  FROM movimiento WHERE id  = $mov LIMIT 1 ";
        $comentario="obtener el tiempo actual de la hab";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_hospedaje= $fila['fin_hospedaje'];
          $cantidad_horas=$fila['horaextra'];
        }

        $fin_hospedaje=$fin_hospedaje+($horas*3600);
        if($cantidad_horas>0){

        }else{
          $cantidad_horas =0;
        }
        $cantidad_horas =$cantidad_horas+$horas;
        $sentencia = "UPDATE `movimiento` SET
          `horaextra` = '$cantidad_horas',
          `fin_hospedaje` = '$fin_hospedaje'
          WHERE `id` = '$mov';
           ";
        $comentario="agregar a la habitacion el nuevo tiempo de salida";
        $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia;
      }
      function agregartiempo_reca($horas, $mov,$reca){
        $fin_hospedaje=0;
        $cantidad_horas=0;
        $sentencia = "SELECT *  FROM movimiento WHERE id  = $mov LIMIT 1 ";
        $comentario="obtener el tiempo actual de la hab";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_hospedaje= $fila['fin_hospedaje'];
          $cantidad_horas=$fila['horaextra'];
        }

        $fin_hospedaje=$fin_hospedaje+($horas*3600);
        if($cantidad_horas>0){

        }else{
          $cantidad_horas =0;
        }
        $cantidad_horas =$cantidad_horas+$horas;
        $sentencia = "UPDATE `movimiento` SET
          `horaextra` = '$cantidad_horas',
          `detalle_realiza` = '$reca',
          `fin_hospedaje` = '$fin_hospedaje'
          WHERE `id` = '$mov';
           ";
          echo  $sentencia;
        $comentario="agregar a la habitacion el nuevo tiempo de salida";
        $this->realizaConsulta($sentencia,$comentario);
        //echo $sentencia;
      }
      function agregar_hospedaje($segundos, $mov){
        $fin_hospedaje=0;
        $sentencia = "SELECT *  FROM movimiento WHERE id  = $mov LIMIT 1 ";
        $comentario="obtener el tiempo actual de la hab";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_hospedaje= $fila['fin_hospedaje'];

        }

        $fin_hospedaje=$fin_hospedaje+$segundos;
        $sentencia = "UPDATE `movimiento` SET
          `fin_hospedaje` = '$fin_hospedaje'
          WHERE `id` = '$mov';
           ";
        $comentario="agregar a la habitacion el nuevo tiempo de salida";
        $this->realizaConsulta($sentencia,$comentario);
      }
      function reporte_checkin($hab_id){//
        $checkin=0;
        $sentencia = "SELECT mov FROM hab WHERE id =$hab_id LIMIT 1 ";
        $comentario="Obtenemos el movimiento de habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $mov=$fila['mov'];
        }
  
        $sentencia2 = "SELECT checkin FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario2="Obtener el checkin de movimiento de checkin";
        $consulta2= $this->realizaConsulta($sentencia2,$comentario2);
        while ($fila2 = mysqli_fetch_array($consulta2))
        {
            $checkin= $fila2['checkin'];
        }
        return $checkin;
      }
      function saber_tiempo_inicio($mov){
        $sentencia = "SELECT detalle_inicio FROM  movimiento WHERE id = $mov LIMIT 1";
        $comentario="Obtener el tiempo de inicio de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $detalle_inicio= $fila['detalle_inicio'];
        }
        return $detalle_inicio;
      }
      function saber_cobro_rest($mov){
        $tiempo=0;
        $sentencia = "SELECT tiempo FROM pedido WHERE mov = $mov AND  estado = 0  ORDER BY id DESC LIMIT 1 ";
        $comentario="saber el timpo en que se hizo el pedido de restaurante";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $tiempo= $fila['tiempo'];
        }

        $tiempo =strtotime($tiempo);
        return $tiempo;
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
      function mov_aplicarcobro($mov,$tiempo,$cobro,$matricula,$modelo,$color,$anotacion,$f_interno){
        $inicio=$this->timepo_entrada($mov);
        $fin=  $inicio+($tiempo*60*60);
        $sentencia = "UPDATE `movimiento` SET
        `inicio_hospedaje` = '$inicio',
        `inicio_cobro` = '$cobro',
        `fin_hospedaje` = '$fin',
        `matricula` = '$matricula',
        `modelo` = '$modelo',
        `color` = '$color',
        `folio_interno` = '$f_interno',
        `anotacion` = '$anotacion'
        WHERE `id` = '$mov';";
        $comentario="Iniciar la renta de la habitacion";
        echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        return 1;
      }
      function guardar_cortesia($mov,$usuario,$hab,$tarifa){
        $fecha = time();
        $sentencia = "INSERT INTO `cortesia` (`mov`, `fecha`, `usuairo`, `hab`, `estado`, `tarifa`, `cantidad`)
        VALUES ('$mov', '$fecha', '$usuario', '$hab', '0', '$tarifa ', '1');";
        $comentario="terminar detalle movimiento en la clase movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      function terminar_mov_det($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `finalizado` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="terminar detalle movimiento en la clase movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      function terminar_mov_cancelado($mov,$motivo,$cancelado,$id){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET 
        `cancelado` = '$cancelado',
        `motivo_cancelado` = '$motivo',
        `persona_cancelo` = '$id',
        `finalizado` = '$tiempo'
        WHERE `id` = '$mov';";
        echo $sentencia;
        $comentario="terminar detalle movimiento en la clase movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      function terminar_mov_limpieza($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `liberacion` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="terminar detalle movimiento en la clase movimiento";
        $this->realizaConsulta($sentencia,$comentario);
      }
      function terminar_hospedaje_terminado($mov){
        $tiempo=time();
        $sentencia = "UPDATE `movimiento` SET
        `finalizado` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="terminar detalle movimiento en la clase movimiento";
        $this->realizaConsulta($sentencia,$comentario);
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
      function mostrar_busqueda_hospedaje($buscar, $tipo){
        if(strlen($buscar)==0){
          $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' ORDER BY movimiento.id DESC LIMIT 300;";

        }else{
          switch ($tipo) {
            case 1:
              $buscar=$this->id_hab($buscar);
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND habitacion = $buscar ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            case 3:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND detalle_manda = $buscar ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            case 4:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND detalle_realiza = $buscar ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            case 9:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND persona_limpio = $buscar ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            case 10:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND matricula LIKE '%$buscar%' ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            case 11:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND modelo LIKE '%$buscar%' ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            case 12:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND folio_interno = $buscar ORDER BY movimiento.id DESC LIMIT 300;";
              break;
            default:
              $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' ORDER BY movimiento.id DESC LIMIT 300;";
              break;
          }
        }

        $comentario="Busqueda de registros ";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['detalle_inicio']).'</td>';
          if($fila['detalle_manda']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_manda']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['detalle_realiza']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_realiza']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['inicio_hospedaje']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['inicio_hospedaje']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['fin_hospedaje']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['fin_hospedaje']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          /*if($fila['inicio_limpieza']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['inicio_limpieza']).'</td>';
          }else{
            echo '<td>---</td>';
          }*/
          if($fila['liberacion']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['liberacion']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['persona_limpio']>0){
            echo '<td>'.$this->saber_nombre($fila['persona_limpio']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if(strlen($fila['matricula'])>0){
            echo '<td>'.$fila['matricula'].'</td>';
          }else{
            echo '<td>---</td>';
          }
          if(strlen($fila['modelo'])>0){
            echo '<td>'.$fila['modelo'].'</td>';
          }else{
            echo '<td>---</td>';
          }
          if(strlen($fila['folio_interno'])>0){
            echo '<td>'.$fila['folio_interno'].'</td>';
          }else{
            echo '<td>---</td>';
          }
          echo '</tr>';
      }
      }
      function saber_tiempo($id){
        $tiempo=0;
        $sentencia = "SELECT tiempo FROM ticket WHERE id = $id LIMIT 1 ;";
        //echo $sentencia; 
        $comentario="obtener el ticket de los cortes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $tiempo=$fila['tiempo'];
        } 
        return $tiempo;
      }
      function saber_ticket($corte,$ob){
        $ticket=0;
        if($ob==0){
          $sentencia = "SELECT tiket_ini AS ticket FROM corte WHERE id  = $corte LIMIT 1;";
        }else{
          $sentencia = "SELECT tiket_fin AS ticket FROM corte WHERE id  = $corte LIMIT 1 ;";
        }
        //echo $sentencia;  
        $comentario="obtener el ticket de los cortes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $ticket=$fila['ticket'];
        } 
        return $ticket;
      }
      function saber_ticket_mov($corte,$ob){
        $ticket=0;
        if($ob==0){
          $sentencia = "SELECT tiket_ini AS ticket FROM corte WHERE id  = $corte LIMIT 1;";
        }else{
          $sentencia = "SELECT tiket_fin AS ticket FROM corte WHERE id  = $corte LIMIT 1 ;";
        }
        //echo $sentencia;  
        $comentario="obtener el ticket de los cortes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $ticket=$fila['ticket'];
        } 
        $ticket=$this->saber_tiempo($ticket);
        return $ticket;
      }
      function mostrar_hospedaje_corte($inicial,$final){
        $mov_ini=$this->saber_ticket_mov($inicial,0);
        $mov_fin=$this->saber_ticket_mov($final,1);
        $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo = 'rentar' AND movimiento.detalle_inicio >= $mov_ini AND movimiento.detalle_inicio <= $mov_fin ORDER BY movimiento.id  ASC ;";
        //echo $sentencia;   

        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn</th>
                <th>Entrada</th>
                <th>Persona/Ingreso</th>
                <th>Persona/Cobro</th>
                
                <th>Salida</th>

                <th>Fin Limpieza</th>
                <th>Limpio</th>
                <th>Matricula</th>
                <th>Modelo</th>
                <th>Folio interno</th>
              </tr>
            </thead>
            
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['detalle_inicio']).'</td>';
          if($fila['detalle_manda']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_manda']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['detalle_realiza']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_realiza']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          
          if($fila['fin_hospedaje']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['fin_hospedaje']).'</td>';
          }else{
            echo '<td>---</td>';
          }
        /*  if($fila['inicio_limpieza']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['inicio_limpieza']).'</td>';
          }else{
            echo '<td>---</td>';
          }*/
          if($fila['liberacion']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['liberacion']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['persona_limpio']>0){
            echo '<td>'.$this->saber_nombre($fila['persona_limpio']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if(strlen($fila['matricula'])>0){
            echo '<td>'.$fila['matricula'].'</td>';
          }else{
            echo '<td>---</td>';
          }
          if(strlen($fila['modelo'])>0){
            echo '<td>'.$fila['modelo'].'</td>';
          }else{
            echo '<td>---</td>';
          }
          if(strlen($fila['folio_interno'])>0){
            echo '<td>'.$fila['folio_interno'].'</td>';
          }else{
            echo '<td>---</td>';
          }
          echo '</tr>';
      }


          echo '</table>
            </div>';

      }
      
      function mostrar_hospedaje_corte_ventas($inicial,$final){
        $mov_ini=$this->saber_ticket($inicial,0);
        $mov_fin=$this->saber_ticket($final,1);
        $sentencia = "SELECT * ,  concepto.id AS idconcepto ,concepto.total AS totalconcepto FROM  concepto LEFT JOIN  ticket ON  concepto.ticket=ticket.id WHERE ticket.id >= $mov_ini AND  ticket.id <= $mov_fin ORDER BY ticket.id ;";
        //echo $sentencia;   

        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn</th>
                <th>Ticket</th>
                <th>Fecha</th>
                <th>Cajera</th>
                
                <th>Concepto</th>
                <th>Total</th>
              </tr>
            </thead>
            
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['habitacion'].'</td>';
          echo '<td>'.$fila['id'].'</td>';
          echo '<td>'.$fila['fecha'].'</td>';
          echo '<td>'.$this->saber_nombre($fila['recep']).'</td>';
          
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>$'.$fila['totalconcepto'].'</td>';
          
          echo '</tr>';
      }


          echo '</table>
            </div>';

      }
      function mostrar_hospedaje($orden){

        switch ($orden) {
          case 1:
            // code...
            break;

          default:
            $sentencia = "SELECT * FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.motivo IS NULL  ORDER BY movimiento.id DESC LIMIT 300;";
            break;
        }

        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn</th>
                <th>Entrada</th>
                
                <th>Salida </th>
               
                <th>Matricula</th>
                <th>id_huesped</th>
                
              </tr>
            </thead>
           
            <tbody id="div_busqueda">
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['inicio_hospedaje']).'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['fin_hospedaje']).'</td>';
          
          echo '<td>'.$fila['matricula'].'</td>';
          echo '<td>'.$fila['id_huesped'].'</td>';
          echo '</tr>';
        }


          echo '</table>
            </div>';

      }
      function mostrar_movi($fecha_ini_tiempo,$fecha_fin_tiempo,$tipo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);

        switch ($tipo) {
          case 1:
              $tipo="";
            break;
          case 2:
              $tipo="mantenimiento";
                $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.detalle_inicio >= $fecha_ini AND movimiento.detalle_inicio <= $fecha_fin AND movimiento.motivo = '$tipo' AND movimiento.detalle_realiza = 0  ORDER BY movimiento.id DESC ;";
            break;
          case 3:
              $tipo="supervision";
                $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.detalle_inicio >= $fecha_ini AND movimiento.detalle_inicio <= $fecha_fin AND movimiento.motivo = '$tipo' AND movimiento.detalle_realiza != 0  ORDER BY movimiento.id DESC ;";
            break;
          case 4:
              $tipo="detalle";
                $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.detalle_inicio >= $fecha_ini AND movimiento.detalle_inicio <= $fecha_fin AND movimiento.motivo = '$tipo'  ORDER BY movimiento.id DESC ;";
            break;
          case 5:
              $tipo="limpieza";
                $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.detalle_inicio >= $fecha_ini AND movimiento.detalle_inicio <= $fecha_fin AND movimiento.motivo = '$tipo'  ORDER BY movimiento.id DESC ;";
            break;
          case 9:
            $tipo="supervision";
              $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.detalle_inicio >= $fecha_ini AND movimiento.detalle_inicio <= $fecha_fin AND movimiento.motivo = '$tipo'  ORDER BY movimiento.id DESC ;";
          break;
          default:
              $tipo="lavado";
                $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.detalle_inicio >= $fecha_ini AND movimiento.detalle_inicio <= $fecha_fin AND movimiento.motivo = '$tipo'  ORDER BY movimiento.id DESC ;";
            break;
        }
        //echo $sentencia; '.$fecha_ini.' - '.$fecha_fin.' - '.$fecha_ini_tiempo.' - '.$fecha_fin_tiempo.'
        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn </th>
                <th>Entrada</th>
                <th>Recepcionista</th>
                <th>Realizo</th>
                <th>Termino</th>
                <th>Motivo</th>


              </tr>
            </thead>

            <tbody id="div_busqueda">
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['detalle_inicio']).'</td>';
          if($fila['detalle_manda']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_manda']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['detalle_realiza']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_realiza']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['finalizado']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['finalizado']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          echo '<td>'.$fila['com'].'</td>';
          /*if($fila['com']>0){
            echo '<td>'.$fila['com'].'</td>';
          }else{
            echo '<td>---</td>';
          }*/
        /*  if($fila['inicio_limpieza']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['inicio_limpieza']).'</td>';
          }else{
            echo '<td>---</td>';
          }*/

          echo '</tr>';
      }


          echo '</table>
            </div>';

      }
      function mostrar_movi_canceladas($fecha_ini_tiempo,$fecha_fin_tiempo,$tipo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);
        $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.finalizado >=  $fecha_ini AND movimiento.finalizado <= $fecha_fin AND movimiento.cancelado > 0 ORDER BY movimiento.id DESC ;";
        //echo $sentencia;
        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn </th>
                <th>Hora de Entrada</th>
                <th>Recepcionista</th>
                <th>Realizo</th>
                <th>Hora de cancelado</th>
                <th>Duracion</th>
                <th>Motivo</th>


              </tr>
            </thead>

            <tbody id="div_busqueda">
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['detalle_inicio']).'</td>';
          if($fila['detalle_manda']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_manda']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['detalle_realiza']>0){
            echo '<td>'.$this->saber_nombre($fila['persona_cancelo']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['finalizado']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['finalizado']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          $tiempo_cancelarse=round (($fila['finalizado']-$fila['detalle_inicio'])/60,2);
          echo '<td>'.$tiempo_cancelarse.' min.</td>';
          echo '<td>'.$fila['motivo_cancelado'].'</td>';
          /*if($fila['com']>0){
            echo '<td>'.$fila['com'].'</td>';
          }else{
            echo '<td>---</td>';
          }*/
        /*  if($fila['inicio_limpieza']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['inicio_limpieza']).'</td>';
          }else{
            echo '<td>---</td>';
          }*/

          echo '</tr>';
      }


          echo '</table>
            </div>';

      }
      function saber_fin($mov){
        $fin_hospedaje=0;
        $sentencia = "SELECT fin_hospedaje FROM movimiento WHERE id  = $mov;";
        $comentario="obtener de la habitacion  por cobrar ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $fin_hospedaje=$fila['fin_hospedaje'];
          
        }
        return $fin_hospedaje;
      }
      function restar_fin($mov,$tiempo){
        $sentencia = "UPDATE `movimiento` SET
        `fin_hospedaje` = '$tiempo'
        WHERE `id` = '$mov';";
        $comentario="modificar el tiempode salida ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function mostrar_movi_ocupada($fecha_ini_tiempo,$fecha_fin_tiempo,$tipo){
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);
        $sentencia = "SELECT * , movimiento.comentario AS com FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.inicio_limpieza >= $fecha_ini AND movimiento.inicio_limpieza <= $fecha_fin AND movimiento.motivo = 'rentar'  AND movimiento.inicio_limpieza > 0 ORDER BY movimiento.inicio_limpieza ASC ;";
        //echo  $sentencia;   
        //echo $sentencia; '.$fecha_ini.' - '.$fecha_fin.' - '.$fecha_ini_tiempo.' - '.$fecha_fin_tiempo.'
        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn </th>
                <th>Inicio de limpieza</th>
                <th>Recepcionista</th>
                <th>Realizo</th>
                <th>Termino</th>
                


              </tr>
            </thead>

            <tbody id="div_busqueda">
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['inicio_limpieza']).'</td>';
          if($fila['detalle_manda']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_manda']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['persona_limpio']>0){
            echo '<td>'.$this->saber_nombre($fila['persona_limpio']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['fin_limpieza']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['fin_limpieza']).'</td>';
          }else{
            echo '<td>---</td>';
          }

          echo '</tr>';
        }


          echo '</table>
            </div>';

      }
      function mostrar_registro_checkin($fecha_ini_tiempo){//*
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $sentencia = "SELECT * ,  FROM movimiento LEFT JOIN hab ON movimiento.habitacion= hab.id WHERE movimiento.inicio_limpieza >= $fecha_ini AND movimiento.inicio_limpieza <= $fecha_fin AND movimiento.motivo = 'rentar'  AND movimiento.inicio_limpieza > 0 ORDER BY movimiento.inicio_limpieza ASC ;";
        //echo  $sentencia;   
        //echo $sentencia; '.$fecha_ini.' - '.$fecha_fin.' - '.$fecha_ini_tiempo.' - '.$fecha_fin_tiempo.'
        $comentario="seleccionar el ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        echo '<div class="table-responsive" id="tabla_surtir">
          <table class="table">
            <thead>
              <tr>
                <th>Habitaciòn </th>
                <th>Inicio de limpieza</th>
                <th>Recepcionista</th>
                <th>Realizo</th>
                <th>Termino</th>
                


              </tr>
            </thead>

            <tbody id="div_busqueda">
            ';

        while ($fila = mysqli_fetch_array($consulta))
        {

          echo '<tr>';
          echo '<td>'.$fila['nombre'].'</td>';
          echo '<td>'.date("Y-m-d H:i",$fila['inicio_limpieza']).'</td>';
          if($fila['detalle_manda']>0){
            echo '<td>'.$this->saber_nombre($fila['detalle_manda']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['persona_limpio']>0){
            echo '<td>'.$this->saber_nombre($fila['persona_limpio']).'</td>';
          }else{
            echo '<td>---</td>';
          }
          if($fila['fin_limpieza']>0){
            echo '<td>'.date("Y-m-d H:i",$fila['fin_limpieza']).'</td>';
          }else{
            echo '<td>---</td>';
          }

          echo '</tr>';
        }


          echo '</table>
            </div>';

      }
    ///
    // Agregar una reservacion en la habitacion
    function disponible_asignar($mov,$hab,$id_huesped,$noches,$fecha_entrada,$fecha_salida,$total){
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
      $sentencia="INSERT INTO `movimiento` (`habitacion`, `detalle_inicio`, `detalle_fin`, `detalle_manda`, `detalle_realiza`, `inicio_hospedaje`, `id_huesped`, `matricula`, `modelo`, `color`, `anotacion`, `checkin`, `total`)
      VALUES ('$hab', '$fecha_entrada', '$fecha_salida', '$fecha_entrada', '$fecha_entrada', '$horaactual', '$id_huesped', '', '', '', '$fecha_entrada','$hab','$total');";
      $comentario="Agregar una reservacion en la habitacion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //$MYSql_id=$this->id_mysql();
      //return $MYSql_id;
    }
    // Obtner el ultimo movimiento ingresado 
    function ultima_insercion(){
      $sentencia= "SELECT id FROM movimiento ORDER BY id DESC LIMIT 1";
      $id= 0;
      $comentario="Obtner el ultimo movimiento ingresado";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $id= $fila['id'];
      }
      return $id;
    }
  
  }
?>
