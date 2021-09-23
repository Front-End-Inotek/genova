<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Tipo extends ConexionMYSql{

      public $id;
      public $nombre;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM tipo_hab WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de tipo habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar en el tipo habitacion
      function guardar_tipo($nombre){
        $sentencia = "INSERT INTO `tipo_hab` (`nombre`, `estado`)
        VALUES ('$nombre', '1');";
        $comentario="Guardamos el tipo habitacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Obtengo los datos de una herramienta //
       function datos_herramienta(){
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
      } 
             
  }
?>