<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Hab extends ConexionMYSql{

      public $id;
      public $nombre;
      public $tipo;
      public $mov;
      public $comentario;
      public $estado;
      public $estado_hab;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->tipo= 0;
          $this->mov= 0;
          $this->comentario= 0;
          $this->estado= 0;
          $this->estado_hab= 0;
        }else{
          $sentencia = "SELECT * FROM hab WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->tipo= $fila['tipo'];
              $this->mov= $fila['mov'];
              $this->comentario= $fila['comentario'];
              $this->estado= $fila['estado'];
              $this->estado_hab= $fila['estado_hab'];
          }
        }
      }
      // Guardar la habitacion
      function guardar_hab($nombre,$tipo,$comentario){
        $sentencia = "INSERT INTO `hab` (`nombre`, `tipo`, `mov`, `comentario`, `estado`, `estado_hab`)
        VALUES ('$nombre', '$tipo', '0', '0', '$comentario', '1', '1');";
        $comentario="Guardamos la habitacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostramos las habitaciones
      function mostrar($id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->tarifa_editar;
        $borrar = $usuario->tarifa_borrar;

        $sentencia = "SELECT *,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab 
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado = 1 ORDER BY hab.nombre";
        $comentario="Mostrar las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_tipo">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Tipo de habitacion</th>
            <th>Comentario</th>';
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
                <td>'.$fila['nom'].'</td>
                <td>'.$fila['habitacion'].'</td>
                <td>'.$fila['comentario'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_hab('.$fila['ID'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_hab('.$fila['ID'].')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar una habitacion
      function editar_hab($id,$nombre,$tipo,$comentario){
        $sentencia = "UPDATE `hab` SET
            `nombre` = '$nombre',
            `tipo` = '$tipo',
            `comentario` = '$comentario'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una habitacion dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar una habitacion
      function borrar_hab($id){
        $sentencia = "UPDATE `hab` SET
        `estado_hab` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una habitacion como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo los nombres de las habitaciones
      function mostrar_hab(){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
  
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
  
      }
      // Obtengo los nombres de las habitaciones a editar
      function mostrar_hab_editar($id){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las habitaciones a editar";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($id==$fila['id']){
            echo '  <option value="'.$fila['id'].'" selected>'.$fila['nombre'].'</option>';
          }else{
            echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';  
          }
        }
      }
      // Cambiar estado de la habitacion
      function cambiohab($hab,$mov,$estado){
        $sentencia = "UPDATE `hab` SET
        `mov` = '$mov',
        `estado` = '$estado'
        WHERE `id` = '$hab';";
        $comentario="Cambiar estado de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      } 
      // Nos permite seleccionar una habitacion ocupada 
      function cambiar_hab_ocupada($monto,$id,$hab_id,$estado){
        $sentencia = "SELECT * FROM hab WHERE id != $hab_id AND estado = 1";
        $comentario="Asignación de habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                echo '<div class="hab_cambiar" onclick="cambiar_hab_monto('.$fila['id'].','.$fila['mov'].','.$monto.','.$id.','.$hab_id.','.$estado.')">';
              echo '</br>';
              echo '<div>';
                  //echo '<img src="images/home.png"  class="center-block img-responsive">';
              echo '</div>';
              echo '<div>';
                  echo $fila['nombre'];
              echo '</div>';
              echo '</br>';
            echo '</div>';
          echo '</div>';
        }
      }   
             
  }
?>