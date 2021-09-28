<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Reservacion extends ConexionMYSql{

      public $id;
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
      public $suplementos;
      public $total_suplementos;
      public $total_hab;
      public $forzar_tarifa;
      public $total;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
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
          $this->suplementos= 0;
          $this->total_suplementos= 0;
          $this->total_hab= 0;
          $this->forzar_tarifa= 0;
          $this->total= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM reservacion WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de una reservacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
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
              $this->suplementos= $fila['suplementos'];
              $this->total_suplementos= $fila['total_suplementos'];
              $this->total_hab= $fila['total_hab'];
              $this->forzar_tarifa= $fila['forzar_tarifa'];
              $this->total= $fila['total'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar la reservacion
      function guardar_reservacion($fecha_entrada,$fecha_salida,$noches,$numero_hab,$precio_hospedaje,$cantidad_hospedaje,$extra_adulto,$extra_junior,$extra_infantil,$extra_menor,$tarifa,$suplementos,$total_suplementos,$total_hab,$forzar_tarifa,$total,$usuario_id){
        // Checar si la variable esta vacia o no
        if(empty($extra_adulto)){
          //echo 'La variable esta vacia';
        }else{
          $extra_adulto= 0;
        }

        if(empty($extra_junior)){
          //echo 'La variable esta vacia';
        }else{
          $extra_junior= 0;
        }

        if(empty($extra_infantil)){
          //echo 'La variable esta vacia';
        }else{
          $extra_infantil= 0;
        }

        if(empty($extra_menor)){
          //echo 'La variable esta vacia';
        }else{
          $extra_menor= 0;
        }

        if(empty($suplementos)){
          //echo 'La variable esta vacia';
        }else{
          $suplementos= '';
        }

        if(empty($total_suplementos)){
          //echo 'La variable esta vacia';
        }else{
          $total_suplementos= 0;
        }
        
        $fecha_entrada=strtotime($fecha_entrada);
        $fecha_salida=strtotime($fecha_salida);
        $sentencia = "INSERT INTO `reservacion` (`fecha_entrada`, `fecha_salida`, `noches`, `numero_hab`, `precio_hospedaje`, `cantidad_hospedaje`, `extra_adulto`, `extra_junior`, `extra_infantil`, `extra_menor`, `tarifa`, `suplementos`, `total_suplementos`, `total_hab`, `forzar_tarifa`, `total`, `estado`)
        VALUES ('$fecha_entrada', '$fecha_salida', '$noches', '$numero_hab', '$precio_hospedaje', '$cantidad_hospedaje', '$extra_adulto', '$extra_junior', '$extra_infantil', '$extra_menor', '$tarifa',  '$suplementos', '$total_suplementos', '$total_hab', '$forzar_tarifa', '$total', '1');";
        $comentario="Guardamos la reservacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);  
        
        include_once('clase_log.php');
        $logs = NEW Log(0);
        $sentencia = "SELECT id FROM reservacion ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id de la reservacion agregada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id,"Agregar reservacion: ". $id);
      }
      // Obtengo los datos de una herramienta //
      /* function datos_herramienta(){
        $sentencia = "SELECT * FROM herramienta WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los datos de tipos habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtengo el total de tipos habitaciones
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad  FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de tipos habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los tipos habitaciones
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->tipo_editar;
        $borrar = $usuario->tipo_borrar;

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

        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar las herramientas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_tipo">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>';
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
                <td>'.$fila['nombre'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_tipo('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_tipo('.$fila['id'].')"> Borrar</button></td>';
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
      // Barra de busqueda en ver los tipos habitaciones//
      function buscar($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->herramienta_editar;
        $borrar = $usuario->herramienta_borrar;
        
        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM herramienta WHERE (nombre LIKE '%$a_buscar%' || marca LIKE '%$a_buscar%' || modelo LIKE '%$a_buscar%' || descripcion LIKE '%$a_buscar%') AND estado = 1 ORDER BY nombre";
          $comentario="Mostrar diferentes busquedas en ver clientes"; 
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo ' 
            <div class="table-responsive" id="tabla_inventario">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="table-primary-encabezado text-center">
                <th>Nombre</th> 
                <th>Marca</th>
                <th>Modelo</th>
                <th>Descripcion</th>
                <th>Cantidad en Almacen</th>
                <th>Cantidad Prestadas</th>';
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
                  <td>'.$fila['nombre'].'</td>  
                  <td>'.$fila['marca'].'</td>
                  <td>'.$fila['modelo'].'</td>
                  <td>'.$fila['descripcion'].'</td>  
                  <td>'.$fila['cantidad_almacen'].'</td>
                  <td>'.$fila['cantidad_prestadas'].'</td>';
                  if($editar==1){
                    echo '<td><button class="btn btn-outline-info btn-lg" onclick="editar_herramienta('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                  }
                  if($borrar==1){
                    echo '<td><button class="btn btn-outline-danger btn-lg" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_herramienta('.$fila['id'].')"> Borrar</button></td>';
                  }
                echo '</tr>';
                }
        }
              echo '
              </tbody>
            </table>
            </div>';
      }
      // Editar los tipos habitaciones
      function editar_tipo($id,$nombre){
        $sentencia = "UPDATE `tipo_hab` SET
            `nombre` = '$nombre'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar los tipos de habitaciones dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar los tipos habitaciones
      function borrar_tipo($id){
        $sentencia = "UPDATE `tipo_hab` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de tipos de habitaciones como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el nombre de la herramienta//
      function nombre_herramienta($id){
        $sentencia = "SELECT nombre FROM herramienta WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $comentario="Obtengo el nombre de la herramienta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      } */
             
  }
?>