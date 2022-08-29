<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Reservacion extends ConexionMYSql{

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
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
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
        }else{
          $sentencia = "SELECT * FROM reservacion WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de una reservacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
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
          }
        }
      }
      // Guardar la reservacion
      function guardar_reservacion($id_huesped,$tipo_hab,$id_movimiento,$fecha_entrada,$fecha_salida,$noches,$numero_hab,$precio_hospedaje,$cantidad_hospedaje,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$nombre_reserva,$acompanante,$forma_pago,$limite_pago,$suplementos,$total_suplementos,$total_hab,$forzar_tarifa,$codigo_descuento,$descuento,$total,$total_pago,$hab_id,$usuario_id,$cuenta,$cantidad_cupon,$tipo_descuento,$estado){
        $fecha_entrada= strtotime($fecha_entrada);
        $fecha_salida= strtotime($fecha_salida);
        $id_cuenta= 0;
        $total_cargo= $total_suplementos;
        if($forzar_tarifa > 0){
          $total_cargo= $total_suplementos + $forzar_tarifa;
        }
        if($cuenta == 1 && $id_movimiento != 0){
          $pago_total= $total_pago + $cantidad_cupon;
          //Se guarda como cuenta el cargo del total suplementos y como abono del total pago de la reservacion
          $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
          VALUES ('$usuario_id', '$id_movimiento', 'Total reservacion', '$fecha_entrada', '$forma_pago', '$total_cargo', '$pago_total', '1');";
          $comentario="Se guarda como cuenta el cargo del total suplementos y como abono del total pago en la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);

          $sentencia = "SELECT id FROM cuenta ORDER BY id DESC LIMIT 1";
          $comentario="Obtengo el id de la cuenta agregada";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $id_cuenta= $fila['id'];
          }
        }
        
        $sentencia = "INSERT INTO `reservacion` (`id_usuario`, `id_huesped`, `id_cuenta`, `tipo_hab`,`fecha_entrada`, `fecha_salida`, `noches`, `numero_hab`, `precio_hospedaje`, `cantidad_hospedaje`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `nombre_reserva`, `acompanante`, `forma_pago`, `limite_pago`, `suplementos`, `total_suplementos`, `total_hab`, `forzar_tarifa`, `codigo_descuento`, `descuento`, `total`, `total_pago`, `fecha_cancelacion`, `nombre_cancela`, `tipo_descuento`, `estado`)
        VALUES ('$usuario_id', '$id_huesped', '$id_cuenta', '$tipo_hab', '$fecha_entrada', '$fecha_salida', '$noches', '$numero_hab', '$precio_hospedaje', '$cantidad_hospedaje', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa', '$nombre_reserva', '$acompanante', '$forma_pago', '$limite_pago', '$suplementos', '$total_suplementos', '$total_hab', '$forzar_tarifa', '$codigo_descuento', '$descuento', '$total', '$total_pago', '0', '', '$tipo_descuento', '$estado');";
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
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        date_default_timezone_set('America/Mexico_City');
        $inicio_dia= date("d-m-Y");   
        $inicio_dia= strtotime($inicio_dia);
        $fin_dia= $inicio_dia + 86399;

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

        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
        FROM reservacion
        INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.estado = 1 || reservacion.estado = 2)  AND (reservacion.fecha_entrada >= $inicio_dia && reservacion.fecha_entrada <= $fin_dia) ORDER BY reservacion.id DESC;";
        $comentario="Mostrar las reservaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
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
            if($agregar==1 && $fila['edo'] = 1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Che-ckin</th>';
            }
            echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
            if($editar==1 && $fila['edo'] = 1){
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
            }
            if($borrar==1 && $fila['edo'] != 0){
              echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
              echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
            }
            echo '</tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                if($fila['edo'] == 1){
                  if($fila['total_pago'] <= 0){
                    echo '<tr class="text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';  
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>'; 
                    echo '<td>Abierta</td>'; 
                    if($agregar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                    if($editar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0){
                      echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                  }else{
                    echo '<tr class="table-success text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';   
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                    echo '<td>Garantizada</td>';
                    if($agregar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                    if($editar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0){
                      echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                  }
                }else{
                  echo '<tr class="table-secondary text-center">
                  <td>'.$fila['ID'].'</td> 
                  <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                  <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                  if($fila['forzar_tarifa']>0){
                    echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                  }else{
                    echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                  }
                  echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                  echo '<td>'.$fila['descripcion'].'</td>';  
                  echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                  echo '<td>Activa</td>';
                  if($agregar==1 && $fila['edo'] = 1){
                    //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    echo '<td></td>';
                  }
                  echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                  if($editar==1 && $fila['edo'] = 1){
                    echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                  }
                  if($borrar==1 && $fila['edo'] != 0){
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
      // Barra de busqueda en ver reservaciones
      function buscar_reservacion($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        /*date_default_timezone_set('America/Mexico_City');
        $inicio_dia = date("d-m-Y");   
        $inicio_dia= strtotime($inicio_dia);
        $fin_dia= $inicio_dia + 86399;*/
        // AND (reservacion.fecha_entrada >= $inicio_dia && reservacion.fecha_entrada <= $fin_dia)
        
        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
          FROM reservacion
          INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
          INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
          INNER JOIN huesped ON reservacion.id_huesped = huesped.id
          INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || huesped.telefono LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.id DESC";//|| reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%'
          $comentario="Mostrar diferentes busquedas en ver reservaciones"; 
          $consulta= $this->realizaConsulta($sentencia,$comentario);
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
                if($agregar==1 && $fila['edo'] = 1){
                  echo '<th><span class=" glyphicon glyphicon-cog"></span> Che-ckin</th>';
                }
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
                if($editar==1 && $fila['edo'] = 1){
                  echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
                }
                if($borrar==1 && $fila['edo'] != 0){
                  echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
                  echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
                }
                echo '</tr>
              </thead>
            <tbody>';
                while ($fila = mysqli_fetch_array($consulta))
                {
                  if($fila['edo'] == 1){
                    if($fila['total_pago'] <= 0){
                      echo '<tr class="text-center">
                      <td>'.$fila['ID'].'</td> 
                      <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                      <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                      if($fila['forzar_tarifa']>0){
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                      }else{
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                      }
                      echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                      echo '<td>'.$fila['descripcion'].'</td>';     
                      echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>'; 
                      echo '<td>Abierta</td>'; 
                      if($agregar==1 && $fila['edo'] = 1){
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                      }
                      echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                      if($editar==1 && $fila['edo'] = 1){
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                      }
                      if($borrar==1 && $fila['edo'] != 0){
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                      }
                      echo '</tr>';
                    }else{
                      echo '<tr class="table-success text-center">
                      <td>'.$fila['ID'].'</td> 
                      <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                      <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                      if($fila['forzar_tarifa']>0){
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                      }else{
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                      }
                      echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                      echo '<td>'.$fila['descripcion'].'</td>';   
                      echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                      echo '<td>Garantizada</td>';
                      if($agregar==1 && $fila['edo'] = 1){
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                      }
                      echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                      if($editar==1 && $fila['edo'] = 1){
                        echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                      }
                      if($borrar==1 && $fila['edo'] != 0){
                        echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                        echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                      }
                      echo '</tr>';
                    }
                  }else{
                    echo '<tr class="table-secondary text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';    
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                    echo '<td>Activa</td>';
                    if($agregar==1 && $fila['edo'] = 1){
                      //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                      echo '<td></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                    if($editar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0){
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
      function mostrar_reservacion_fecha($fecha_ini_tiempo,$fecha_fin_tiempo,$a_buscar,$combinada,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $agregar = $usuario->reservacion_agregar;
        $editar = $usuario->reservacion_editar;
        $borrar = $usuario->reservacion_borrar;
        date_default_timezone_set('America/Mexico_City');
        $fecha_ini_tiempo= $fecha_ini_tiempo. " 0:00:00";
        $fecha_fin_tiempo= $fecha_fin_tiempo . " 23:59:59";
        $fecha_ini= strtotime($fecha_ini_tiempo);
        $fecha_fin= strtotime($fecha_fin_tiempo);
        
        if($a_buscar == ' ' && strlen ($fecha_ini) == 0 && strlen ($fecha_fin) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          if($a_buscar != ' '){
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.id DESC";
          }elseif($a_buscar != ' ' && strlen ($fecha_ini) > 0 && strlen ($fecha_fin) > 0 && $combinada == 1){
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_ini && reservacion.fecha_entrada <= $fecha_fin && reservacion.fecha_entrada > 0 AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
          }else{
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_ini && reservacion.fecha_entrada <= $fecha_fin && reservacion.fecha_entrada > 0 AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
          }
          $comentario="Mostrar por fecha en ver reservaciones";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
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
              if($agregar==1 && $fila['edo'] = 1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Che-ckin</th>';
              }
              echo '<th><span class=" glyphicon glyphicon-cog"></span> Ver</th>';
              if($editar==1 && $fila['edo'] = 1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
              }
              if($borrar==1 && $fila['edo'] != 0){
                echo '<th><span class="glyphicon glyphicon-cog"></span> Cancelar</th>';
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
              }
              echo '</tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)) 
              {
                if($fila['edo'] == 1){
                  if($fila['total_pago'] <= 0){
                    echo '<tr class="text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';    
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>'; 
                    echo '<td>Abierta</td>'; 
                    if($agregar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                    if($editar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0){
                      echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                  }else{
                    echo '<tr class="table-success text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';   
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                    echo '<td>Garantizada</td>';
                    if($agregar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    }
                    echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                    if($editar==1 && $fila['edo'] = 1){
                      echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                    }
                    if($borrar==1 && $fila['edo'] != 0){
                      echo '<td><button class="btn btn-secondary" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cancelar_reservacion('.$fila['ID'].')"> Cancelar</button></td>';
                      echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_reservacion('.$fila['ID'].')"> Borrar</button></td>';
                    }
                    echo '</tr>';
                  }
                }else{
                  echo '<tr class="table-secondary text-center">
                  <td>'.$fila['ID'].'</td> 
                  <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                  <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                  if($fila['forzar_tarifa']>0){
                    echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                  }else{
                    echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                  }
                  echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                  echo '<td>'.$fila['descripcion'].'</td>';    
                  echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                  echo '<td>Activa</td>';
                  if($agregar==1 && $fila['edo'] = 1){
                    //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="select_asignar_reservacion('.$fila['ID'].','.$fila['numero_hab'].')"> Asignar</button></td>';
                    echo '<td></td>';
                  }
                  echo '<td><button class="btn btn-success" onclick="ver_reporte_reservacion('.$fila['ID'].')"> Reporte</button></td>';  
                  if($editar==1 && $fila['edo'] = 1){
                    echo '<td><button class="btn btn-warning" onclick="editar_reservacion('.$fila['ID'].')"> Editar</button></td>';
                  }
                  if($borrar==1 && $fila['edo'] != 0){
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
      function porcentaje_ocupacion($dia,$a_buscar){
        $numero_hab= 0;
        $cantidad= 0;
        $porcentaje= 0;
        $salida= $dia + 86399;
       
        if($a_buscar != ' '){
          $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
          FROM reservacion
          INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
          INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
          INNER JOIN huesped ON reservacion.id_huesped = huesped.id
          INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.fecha_entrada = $dia || (reservacion.fecha_entrada > $dia && reservacion.fecha_salida <= $salida)) AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
        }else{
          $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
          FROM reservacion
          INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
          INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
          INNER JOIN huesped ON reservacion.id_huesped = huesped.id
          INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.fecha_entrada = $dia || (reservacion.fecha_entrada > $dia && reservacion.fecha_salida <= $salida)) AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
        } //(reservacion.fecha_entrada = $dia || reservacion.fecha_salida <= $salida)
        //echo $sentencia;
        $comentario="Obtengo el total del porcentaje de ocupacion de las reservaciones por dia";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $numero_hab= $numero_hab + $fila['numero_hab'];
        }

        $sentencia = "SELECT *,count(hab.id) AS cantidad,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab 
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado_hab = 1 ORDER BY hab.nombre;";
        //echo $sentencia;
        $comentario="Obtengo el total de las reservaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }

        $porcentaje= ($cantidad / 100) * $numero_hab;
        $porcentaje= round($porcentaje, 1, PHP_ROUND_HALF_UP); 
        return $porcentaje;
      }
      // Mostramos los datos de reservaciones por dia
      function datos_por_dia($dia,$a_buscar){
        $dia_actual= date("Y-m-d",$dia);
        $fecha_dia_dia = substr($dia_actual, 8, 2);
        $fecha_dia_mes = substr($dia_actual, 5, 2); 
        $fecha_dia_anio = substr($dia_actual, 0, 4);  
        $porcentaje= $this->porcentaje_ocupacion($dia,$a_buscar);
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
      // Mostramos las reservaciones por dia
      function mostrar_por_dia($posicion,$id){
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
        if($extra>0){
          $cat_paginas++;
        }
        $ultimoid=0;

        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
        FROM reservacion
        INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.estado = 1 || reservacion.estado = 2)  AND (reservacion.fecha_entrada >= $inicio_dia && reservacion.fecha_entrada <= $fin_dia) ORDER BY reservacion.id DESC;";
        $comentario="Mostrar las reservaciones por dia";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_reservacion">';
        $this->datos_por_dia($inicio_dia,$a_buscar);
       
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
            while ($fila = mysqli_fetch_array($consulta))
            {
              if($cont>=$posicion & $cont<$final){
                if($fila['edo'] == 1){
                  if($fila['total_pago'] <= 0){
                    echo '<tr class="text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';   
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>'; 
                    echo '<td>Abierta</td>'; 
                    echo '</tr>';
                  }else{
                    echo '<tr class="table-success text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';   
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                    echo '<td>Garantizada</td>';
                    echo '</tr>';
                  }
                }else{
                  echo '<tr class="table-secondary text-center">
                  <td>'.$fila['ID'].'</td> 
                  <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                  <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                  if($fila['forzar_tarifa']>0){
                    echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                  }else{
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
      function buscar_reservacion_por_dia($a_buscar,$id){
        $inicio_dia= date("d-m-Y");   
        $inicio_dia= strtotime($inicio_dia);
        
        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar_por_dia(1,$id);
        }else{
          $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
          FROM reservacion
          INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
          INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
          INNER JOIN huesped ON reservacion.id_huesped = huesped.id
          INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || huesped.telefono LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.id DESC";
          $comentario="Mostrar diferentes busquedas en ver reservaciones por dia"; 
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo ' 
            <div class="table-responsive" id="tabla_reservacion">';
            $this->datos_por_dia($inicio_dia);
  
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
                while ($fila = mysqli_fetch_array($consulta))
                {
                  if($fila['edo'] == 1){
                    if($fila['total_pago'] <= 0){
                      echo '<tr class="text-center">
                      <td>'.$fila['ID'].'</td> 
                      <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                      <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                      if($fila['forzar_tarifa']>0){
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                      }else{
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                      }
                      echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                      echo '<td>'.$fila['descripcion'].'</td>';    
                      echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>'; 
                      echo '<td>Abierta</td>'; 
                      echo '</tr>';
                    }else{
                      echo '<tr class="table-success text-center">
                      <td>'.$fila['ID'].'</td> 
                      <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                      <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                      if($fila['forzar_tarifa']>0){
                        echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                      }else{
                        echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                      }
                      echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                      echo '<td>'.$fila['descripcion'].'</td>';   
                      echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                      echo '<td>Garantizada</td>';
                      echo '</tr>';
                    }
                  }else{
                    echo '<tr class="table-secondary text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
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
      function mostrar_reservacion_por_dia($fecha_dia_tiempo,$a_buscar,$combinada,$id){
        date_default_timezone_set('America/Mexico_City');
        $fecha_dia_tiempo= $fecha_dia_tiempo. " 0:00:00";
        $fecha_dia= strtotime($fecha_dia_tiempo);
        
        if($a_buscar != ' ' && strlen ($fecha_dia) == 0){
          $cat_paginas = $this->mostrar_por_dia(1,$id);
        }else{
          if($a_buscar != ' ' || $combinada == 1){
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_dia && reservacion.fecha_entrada <= $fecha_dia && reservacion.fecha_entrada > 0 AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
          }elseif($a_buscar != ' ' && strlen ($fecha_dia) == 0){
            $fecha_dia = date("d-m-Y");   
            $fecha_dia= strtotime($fecha_dia);
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_dia && reservacion.fecha_entrada <= $fecha_dia && reservacion.fecha_entrada > 0 AND (reservacion.id LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%' || huesped.apellido LIKE '%$a_buscar%' || reservacion.nombre_reserva LIKE '%$a_buscar%' || reservacion.suplementos LIKE '%$a_buscar%') AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
          }else{
            $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
            FROM reservacion
            INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
            INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
            INNER JOIN huesped ON reservacion.id_huesped = huesped.id
            INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.fecha_entrada >= $fecha_dia && reservacion.fecha_entrada <= $fecha_dia && reservacion.fecha_entrada > 0 AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
          }
          $comentario="Mostrar por fecha en ver reservaciones por dia";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_reservacion">';
          $this->datos_por_dia($fecha_dia,$a_buscar);

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
              while ($fila = mysqli_fetch_array($consulta)) 
              {
                if($fila['edo'] == 1){
                  if($fila['total_pago'] <= 0){
                    echo '<tr class="text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';    
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>'; 
                    echo '<td>Abierta</td>'; 
                    echo '</tr>';
                  }else{
                    echo '<tr class="table-success text-center">
                    <td>'.$fila['ID'].'</td> 
                    <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                    <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                    if($fila['forzar_tarifa']>0){
                      echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                    }else{
                      echo '<td>$'.number_format($fila['total'], 2).'</td>';  
                    }
                    echo '<td>$'.number_format($fila['total_pago'], 2).'</td>'; 
                    echo '<td>'.$fila['descripcion'].'</td>';   
                    echo '<td>'.$this->mostrar_nombre_pago($fila['limite_pago']).'</td>';  
                    echo '<td>Garantizada</td>';
                    echo '</tr>';
                  }
                }else{
                  echo '<tr class="table-secondary text-center">
                  <td>'.$fila['ID'].'</td> 
                  <td>'.date("d-m-Y",$fila['fecha_entrada']).'</td>
                  <td>'.date("d-m-Y",$fila['fecha_salida']).'</td>
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
                  if($fila['forzar_tarifa']>0){
                    echo '<td>$'.number_format($fila['forzar_tarifa'], 2).'</td>'; 
                  }else{
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
      // Editar una reservacion
      function editar_reservacion($id,$id_huesped,$tipo_hab,$id_cuenta,$fecha_entrada,$fecha_salida,$noches,$numero_hab,$precio_hospedaje,$cantidad_hospedaje,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$nombre_reserva,$acompanante,$forma_pago,$limite_pago,$suplementos,$total_suplementos,$total_hab,$forzar_tarifa,$codigo_descuento,$descuento,$total,$total_pago,$cantidad_cupon,$tipo_descuento){
        $fecha_entrada=strtotime($fecha_entrada);
        $fecha_salida=strtotime($fecha_salida);
        if($forzar_tarifa > 0){
          $total_cargo= $total_suplementos + $forzar_tarifa;
        }
        if($cantidad_cupon > 0){
          $pago_total= $total_pago + $cantidad_cupon;
        }else{
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
        $consulta= $this->realizaConsulta($sentencia,$comentario);

        $sentencia = "UPDATE `cuenta` SET
            `cargo` = '$total_cargo',
            `abono` = '$pago_total'
            WHERE `id` = '$id_cuenta';";
        //echo $sentencia;
        $comentario="Editar una cuenta proveniente de una reservacion dentro de la base de datos";
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
      // Modificar estado de una reservacion
      function modificar_estado($id,$estado){
        // 0=borrada  1=activa  2=cliente en hotel  3=cancelada
        $sentencia = "UPDATE `reservacion` SET
        `estado` = '$estado'
        WHERE `id` = '$id';";
        $comentario="Poner nuevo estado de una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar id_cuenta de una reservacion
      function modificar_id_cuenta($id,$id_cuenta){
        $sentencia = "UPDATE `reservacion` SET
        `id_cuenta` = '$id_cuenta'
        WHERE `id` = '$id';";
        $comentario="Poner nuevo id cuenta de una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Modificar datos por realizar una cancelacion de una reservacion
      function modificar_cancelada($id,$nombre_cancela){
        $fecha_cancelacion= time();
        $sentencia = "UPDATE `reservacion` SET
        `fecha_cancelacion` = '$fecha_cancelacion',
        `nombre_cancela` = '$nombre_cancela'
        WHERE `id` = '$id';";
        $comentario="Poner datos por realizar una cancelacion de una reservacion";
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
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE reservacion.id = $id AND (reservacion.estado = 2 OR reservacion.estado = 1) ORDER BY reservacion.id DESC";
        $comentario="Mostrar los datos de la reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtengo los datos del cargo por noche de la habitacio 
      function datos_reservacion_por_dia($dia){
        $salida= $dia + 86399;
        $sentencia = "SELECT *,reservacion.id AS ID,tipo_hab.nombre AS habitacion,huesped.nombre AS persona,huesped.apellido,usuario.usuario AS usuario,reservacion.estado AS edo,huesped.telefono AS tel
        FROM reservacion
        INNER JOIN tipo_hab ON reservacion.tipo_hab = tipo_hab.id 
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id 
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id WHERE (reservacion.fecha_entrada = $dia || (reservacion.fecha_entrada > $dia && reservacion.fecha_salida <= $salida)) AND (reservacion.estado = 1 || reservacion.estado = 2) ORDER BY reservacion.fecha_entrada DESC;";
        $comentario="Obtengo los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
             
  }
?>