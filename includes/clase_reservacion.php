<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Reservacion extends ConexionMYSql{

      public $id;
      public $id_usuario;
      public $id_huesped;
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
      public $descuento;
      public $total;
      public $total_pago;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_usuario= 0;
          $this->id_huesped= 0;
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
          $this->descuento= 0;
          $this->total= 0;
          $this->total_pago= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM reservacion WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de una reservacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->id_usuario= $fila['id_usuario'];
              $this->id_huesped= $fila['id_huesped'];
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
              $this->descuento= $fila['descuento'];
              $this->total= $fila['total'];
              $this->total_pago= $fila['total_pago'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar la reservacion
      function guardar_reservacion($id_huesped,$id_movimiento,$fecha_entrada,$fecha_salida,$noches,$numero_hab,$precio_hospedaje,$cantidad_hospedaje,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$nombre_reserva,$acompanante,$forma_pago,$limite_pago,$suplementos,$total_suplementos,$total_hab,$forzar_tarifa,$descuento,$total,$total_pago,$usuario_id){
        $fecha_entrada=strtotime($fecha_entrada);
        $fecha_salida=strtotime($fecha_salida);
        $sentencia = "INSERT INTO `reservacion` (`id_usuario`, `id_huesped`,`fecha_entrada`, `fecha_salida`, `noches`, `numero_hab`, `precio_hospedaje`, `cantidad_hospedaje`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `acompanante`, `forma_pago`, `limite_pago`, `suplementos`, `total_suplementos`, `total_hab`, `forzar_tarifa`, `descuento`, `total`, `total_pago`, `estado`)
        VALUES ('$usuario_id', '$id_huesped', '$fecha_entrada', '$fecha_salida', '$noches', '$numero_hab', '$precio_hospedaje', '$cantidad_hospedaje', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa', '$nombre_reserva', '$acompanante', '$forma_pago', '$limite_pago', '$suplementos', '$total_suplementos', '$total_hab', '$forzar_tarifa', '$descuento', '$total', '$total_pago', '1');";
        $comentario="Guardamos la reservacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);  
        
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $sentencia = "SELECT id FROM reservacion ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id de la reservacion agregada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id,"Agregar reservacion: ". $id);

        // Poner id reservacion al numero de movimiento que corresponde
        $sentencia = "UPDATE `movimiento` SET
        `id_reservacion` = '$id'
        WHERE `id` = '$id_movimiento';";
        $comentario="Cambiar id reservacion del movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el total de las reservaciones
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT *,count(reservacion.id) AS cantidad,reservacion.id AS ID,tipo_hab.nombre AS habitacion
        FROM reservacion
        INNER JOIN tipo_hab ON reservacion .tarifa = tipo_hab.id WHERE reservacion .estado = 1 ORDER BY reservacion.id DESC;";
        //echo $sentencia;
        $comentario="Obtengo el total de las reservaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos las reservaciones
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;

        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0){
          $cat_paginas++;
        }
        $ultimoid=0;

        $sentencia = "SELECT *,reservacion.id AS ID,tarifa_hospedaje.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario
        FROM reservacion
        INNER JOIN tarifa_hospedaje ON reservacion.tarifa = tarifa_hospedaje.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.estado = 1 ORDER BY reservacion.id DESC;";
        $comentario="Mostrar las reservaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_reservacion">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Numero</th>
            <th>Usuario</th>
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
            <th>Nombre Huesped</th>
            <th>Quién Reserva</th>
            <th>Acompañante</th>
            <th>Suplementos</th>
            <th>Total Suplementos</th>
            <th>Total Habitacion</th>
            <th>Descuento</th>
            <th>Total Estancia</th>
            <th>Total Pago</th>
            <th>Forma Pago</th>
            <th>Limite Pago</th>';
            if($editar==1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1){
              echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            echo '</tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                echo '<tr class="text-center">
                <td>'.$fila['ID'].'</td> 
                <td>'.$fila['usuario'].'</td> 
                <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
                <td>'.$fila['noches'].'</td> 
                <td>'.$fila['numero_hab'].'</td> 
                <td>'.$fila['habitacion'].'</td> 
                <td>$'.number_format($fila['precio_hospedaje'], 2).'</td>
                <td>'.$fila['cantidad_hospedaje'].'</td>  
                <td>'.$fila['extra_adulto'].'</td> 
                <td>'.$fila['extra_junior'].'</td> 
                <td>'.$fila['extra_infantil'].'</td> 
                <td>'.$fila['extra_menor'].'</td>
                <td>'.$fila['persona'].'</td> 
                <td>'.$fila['nombre_reserva'].' '.$fila['apellido'].'</td>
                <td>'.$fila['acompanante'].'</td>
                <td>'.$fila['suplementos'].'</td>  
                <td>$'.number_format($fila['total_suplementos'], 2).'</td> 
                <td>$'.number_format($fila['total_hab'], 2).'</td>
                <td>'.$fila['descuento'].'%</td>'; 
                if($fila['forzar_tarifa']>0){
                  echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                }else{
                  echo '<td>$'.number_format($fila['total'], 2).'</td>'; 
                }
                echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                echo '<td>'.$fila['descripcion'].'</td>';  
                echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</.$fila>';  
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                }
                echo '</tr>';
              }
              $cont++;
            }
            echo '
          </tbody>
        </table>
        </div>';
        return $cat_paginas;
      }
      // Barra de busqueda en ver reservaciones
      function buscar_reservacion($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        
        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT *,reservacion.id AS ID,tarifa_hospedaje.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario
          FROM reservacion
          INNER JOIN tarifa_hospedaje ON reservacion.tarifa = tarifa_hospedaje.id 
          INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
          INNER JOIN huesped ON reservacion.id_huesped = huesped.id
          INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND reservacion.estado = 1 ORDER BY reservacion.id DESC";
          $comentario="Mostrar diferentes busquedas en ver reservaciones"; 
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo ' 
            <div class="table-responsive" id="tabla_reservacion">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="table-primary-encabezado text-center">
                <th>Numero</th>
                <th>Usuario</th>
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
                <th>Nombre Huesped</th>
                <th>Quién Reserva</th>
                <th>Acompañante</th>
                <th>Suplementos</th>
                <th>Total Suplementos</th>
                <th>Total Habitacion</th>
                <th>Descuento</th>
                <th>Total Estancia</th>
                <th>Total Pago</th>
                <th>Forma Pago</th>
                <th>Limite Pago</th>';
                if($editar==1){
                  echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
                }
                if($borrar==1){
                  echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
                }
                echo '</tr>
              </thead>
            <tbody>';
                while ($fila = mysqli_fetch_array($consulta))
                {
                  echo '<tr class="text-center">
                  <td>'.$fila['ID'].'</td> 
                  <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                  <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
                  <td>'.$fila['noches'].'</td> 
                  <td>'.$fila['numero_hab'].'</td> 
                  <td>'.$fila['habitacion'].'</td> 
                  <td>$'.number_format($fila['precio_hospedaje'], 2).'</td>
                  <td>'.$fila['cantidad_hospedaje'].'</td>  
                  <td>'.$fila['extra_adulto'].'</td> 
                  <td>'.$fila['extra_junior'].'</td> 
                  <td>'.$fila['extra_infantil'].'</td> 
                  <td>'.$fila['extra_menor'].'</td>
                  <td>'.$fila['persona'].'</td> 
                  <td>'.$fila['nombre_reserva'].' '.$fila['apellido'].'</td>
                  <td>'.$fila['acompanante'].'</td>
                  <td>'.$fila['suplementos'].'</td>  
                  <td>$'.number_format($fila['total_suplementos'], 2).'</td> 
                  <td>$'.number_format($fila['total_hab'], 2).'</td>
                  <td>'.$fila['descuento'].'%</td>'; 
                  if($fila['forzar_tarifa']>0){
                    echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                  }else{
                    echo '<td>$'.number_format($fila['total'], 2).'</td>'; 
                  }
                  echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                  echo '<td>'.$fila['descripcion'].'</td>';  
                  echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</.$fila>'; 
                  if($editar==1){
                    echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                  }
                  if($borrar==1){
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
      // Busqueda por fecha en ver reservaciones
      function mostrar_reservacion_fecha($fecha_ini_tiempo,$fecha_fin_tiempo,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo =$fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo=$fecha_fin_tiempo . " 23:59:59";
        $fecha_ini =strtotime($fecha_ini_tiempo);
        $fecha_fin =strtotime($fecha_fin_tiempo);
        
        if(strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT *,reservacion.id AS ID,tarifa_hospedaje.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario
          FROM reservacion
          INNER JOIN tarifa_hospedaje ON reservacion.tarifa = tarifa_hospedaje.id 
          INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
          INNER JOIN huesped ON reservacion.id_huesped = huesped.id
          INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_ini &&reservacion.fecha_entrada <= $fecha_fin && reservacion.fecha_entrada > 0 AND reservacion.estado = 1 ORDER BY reservacion.fecha_entrada DESC;";
          $comentario="Mostrar las rquisiciones";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_reservacion">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Numero</th>
              <th>Usuario</th>
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
              <th>Nombre Huesped</th>
              <th>Quién Reserva</th>
              <th>Acompañante</th>
              <th>Suplementos</th>
              <th>Total Suplementos</th>
              <th>Total Habitacion</th>
              <th>Descuento</th>
              <th>Total Estancia</th>
              <th>Total Pago</th>
              <th>Forma Pago</th>
              <th>Limite Pago</th>';
              if($editar==1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
              }
              if($borrar==1){
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
              }
              echo '</tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)) 
              {
                echo '<tr class="text-center">
                <td>'.$fila['ID'].'</td> 
                <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
                <td>'.$fila['noches'].'</td> 
                <td>'.$fila['numero_hab'].'</td> 
                <td>'.$fila['habitacion'].'</td> 
                <td>$'.number_format($fila['precio_hospedaje'], 2).'</td>
                <td>'.$fila['cantidad_hospedaje'].'</td>  
                <td>'.$fila['extra_adulto'].'</td> 
                <td>'.$fila['extra_junior'].'</td> 
                <td>'.$fila['extra_infantil'].'</td> 
                <td>'.$fila['extra_menor'].'</td>
                <td>'.$fila['persona'].'</td> 
                <td>'.$fila['nombre_reserva'].' '.$fila['apellido'].'</td>
                <td>'.$fila['acompanante'].'</td>
                <td>'.$fila['suplementos'].'</td>  
                <td>$'.number_format($fila['total_suplementos'], 2).'</td> 
                <td>$'.number_format($fila['total_hab'], 2).'</td>
                <td>'.$fila['descuento'].'%</td>'; 
                if($fila['forzar_tarifa']>0){
                  echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                }else{
                  echo '<td>$'.number_format($fila['total'], 2).'</td>'; 
                }
                echo '<td>$'.number_format($fila['total_pago'], 2).'</td>';  
                echo '<td>'.$fila['descripcion'].'</td>';  
                echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</.$fila>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
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
      // Editar una reservacion
      function editar_reservacion($id,$id_huesped,$fecha_entrada,$fecha_salida,$noches,$numero_hab,$precio_hospedaje,$cantidad_hospedaje,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$nombre_reserva,$acompanante,$forma_pago,$limite_pago,$suplementos,$total_suplementos,$total_hab,$forzar_tarifa,$descuento,$total,$total_pago){
        $fecha_entrada=strtotime($fecha_entrada);
        $fecha_salida=strtotime($fecha_salida);
        $sentencia = "UPDATE `reservacion` SET
            `id_huesped` = '$id_huesped',
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
            `descuento` = '$descuento',
            `total` = '$total'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una reservacion dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar una reservacion
      function borrar_reservacion($id){
        $sentencia = "UPDATE `reservacion` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una reservacion como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Mostramos el pago
      function mostrar_nombre_pago($id){ 
        $sentencia = "SELECT limite_pago FROM pago WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $limite_pago = 0;
        $comentario="Obtengo el pago";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $limite_pago= $fila['limite_pago'];
        }
        return $limite_pago;
      }
      // Obtengo los datos de una reservacion
      function datos_reservacion($id){
        $sentencia = "SELECT *,reservacion.id AS ID,tarifa_hospedaje.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario
        FROM reservacion
        INNER JOIN tarifa_hospedaje ON reservacion.tarifa = tarifa_hospedaje.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id 
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.id = $id AND reservacion.estado = 1 ORDER BY reservacion.id DESC";
        $comentario="Mostrar los datos de la reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
             
  }
?>