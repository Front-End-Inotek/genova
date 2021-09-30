<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Huesped extends ConexionMYSql{

      public $id;
      public $nombre;
      public $apellido;
      public $direccion;
      public $ciudad;
      public $estado;
      public $codigo_postal;
      public $telefono;
      public $correo;
      public $preferencias;
      public $comentarios;
      public $estado_huesped;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->apellido= 0;
          $this->direccion= 0;
          $this->ciudad= 0;
          $this->estado= 0;
          $this->codigo_postal= 0;
          $this->telefono= 0;
          $this->correo= 0;
          $this->preferencias= 0;
          $this->comentarios= 0;
          $this->estado_huesped= 0; 
        }else{
          $sentencia = "SELECT * FROM huesped WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de un huesped";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->apellido= $fila['apellido'];
              $this->direccion= $fila['direccion'];
              $this->ciudad= $fila['ciudad'];
              $this->estado= $fila['estado'];
              $this->codigo_postal= $fila['codigo_postal'];
              $this->telefono= $fila['telefono'];
              $this->correo= $fila['correo'];
              $this->preferencias= $fila['preferencias'];
              $this->comentarios= $fila['comentarios'];
              $this->estado_huesped= $fila['estado_huesped'];
          }
        }
      }
      // Guardar el huesped
      function guardar_huesped($nombre,$apellido,$direccion,$ciudad,$estado,$codigo_postal,$telefono,$correo,$preferencias,$comentarios){
        $sentencia = "INSERT INTO `huesped` (`nombre`, `apellido`, `direccion`, `ciudad`, `estado`, `codigo_postal`, `telefono`, `correo`, `preferencias`, `comentarios`, `estado_huesped`)
        VALUES ('$nombre', '$apellido', '$direccion', '$ciudad', '$estado','$codigo_postal', '$telefono', '$correo', '$preferencias', '$comentarios', '1');";
        $comentario="Guardamos el huesped en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);    
        
        include_once("clase_log.php");
        $logs = NEW Log(0);
        $sentencia = "SELECT id FROM huesped ORDER BY id DESC LIMIT 1";
        $comentario="Obtengo el id del huesped agregado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        $logs->guardar_log($usuario_id,"Agregar huesped: ". $id);
      }
      // Obtengo el total de huespedes
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM huesped WHERE estado_huesped = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de huespedes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los huespedes
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->huesped_editar;
        $borrar = $usuario->huesped_borrar;
    
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

        $sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY nombre";
        $comentario="Mostrar los huespedes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_huesped">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Direccion</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Codigo Postal</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Preferencias</th>
            <th>Comentarios</th>';
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
                <td>'.$fila['nombre'].'</td>  
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_huesped('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_huesped('.$fila['id'].')"> Borrar</button></td>';
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
      // Barra de diferentes busquedas en ver huespedes
      function buscar_huesped($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->huesped_editar;
        $borrar = $usuario->huesped_borrar;

        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
        }else{
          $sentencia = "SELECT * FROM huesped WHERE (nombre LIKE '%$a_buscar%' || apellido LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%') && estado_huesped = 1 ORDER BY nombre;";
          $comentario="Mostrar diferentes busquedas en ver huespedes";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_huesped">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Preferencias</th>
              <th>Comentarios</th>';
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
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_huesped('.$fila['id'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_huesped('.$fila['id'].')"> Borrar</button></td>';
                }
                echo '</tr>';
              }
        }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar un huesped
      function editar_huesped($id,$nombre,$apellido,$direccion,$ciudad,$estado,$codigo_postal,$telefono,$correo,$preferencias,$comentarios){
        $sentencia = "UPDATE `huesped` SET
            `nombre` = '$nombre',
            `apellido` = '$apellido',
            `direccion` = '$direccion',
            `ciudad` = '$ciudad',
            `estado` = '$estado',
            `codigo_postal` = '$codigo_postal',
            `telefono` = '$telefono',
            `correo` = '$correo',
            `preferencias` = '$preferencias',
            `comentarios` = '$comentarios'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar huesped dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un huesped
      function borrar_huesped($id){
        $sentencia = "UPDATE `huesped` SET
        `estado_huesped` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de huesped como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
             
  }
?>