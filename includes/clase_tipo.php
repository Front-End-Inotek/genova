<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Tipo extends ConexionMYSql{

      public $id;
      public $nombre;
      public $codigo;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->codigo= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM tipo_hab WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de tipo habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->codigo= $fila['codigo'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar en el tipo habitacion
      function guardar_tipo($nombre,$codigo){
        $sentencia = "INSERT INTO `tipo_hab` (`nombre`, `codigo`, `estado`)
        VALUES ('$nombre', '$codigo', '1');";
        $comentario="Guardamos el tipo habitacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Obtengo el total de los tipos de habitaciones
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT *,count(tipo_hab.id) AS cantidad,tipo_hab.id AS ID,tipo_hab.nombre FROM tipo_hab WHERE tipo_hab.estado = 1 ORDER BY tipo_hab.id;";
        //echo $sentencia;
        $comentario="Obtengo el total de los tipos de habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los tipos habitaciones
      function mostrar($id){
        include_once('clase_usuario.php');
        $usuario = NEW Usuario($id);
        $editar = $usuario->tipo_editar;
        $borrar = $usuario->tipo_borrar;

        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los tipos habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_tipo">
        <table class="table table-bordered table-hover mi-tabla">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Código</th>';
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
                <td>'.$fila['codigo'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_tipo('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_tipo('.$fila['id'].')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar un tipo habitacion
      function editar_tipo($id,$nombre,$codigo){
        $sentencia = "UPDATE `tipo_hab` SET
            `nombre` = '$nombre',
            `codigo` = '$codigo'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar un tipo habitacion dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un tipo habitacion
      function borrar_tipo($id){
        $sentencia = "UPDATE `tipo_hab` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de un tipo habitacion como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el nombre de un tipo habitacion
      function obtener_nombre($id){ 
        $sentencia = "SELECT nombre FROM tipo_hab WHERE id = $id AND estado = 1";
        //echo $sentencia;
        $nombre= '';
        $comentario="Obtengo el nombre de un tipo habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      }
             
  }
?>