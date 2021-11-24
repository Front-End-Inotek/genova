<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Categoria extends ConexionMYSql{

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
          $sentencia = "SELECT * FROM categoria WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar la categoria
      function guardar_categoria($nombre){
        $sentencia = "INSERT INTO `categoria` (`nombre`, `estado`)
        VALUES ('$nombre', '1');";
        $comentario="Guardamos la categoria en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostramos las categorias
      function mostrar($id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $agregar = $usuario->categoria_editar;
        $editar = $usuario->categoria_editar;
        $borrar = $usuario->categoria_borrar;

        $sentencia = "SELECT * FROM categoria WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar las categorias para el inventario";
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
            echo '<tr <tr class="text-center">
              <td><input type="text" class ="color_black" id="nombre" placeholder="Ingresa el nombre" pattern="[a-z]{1,15}" maxlength="50"></td>';
              if($agregar==1){
                echo '<td><button class="btn btn-success" onclick="guardar_categoria()"> Guardar</button></td>';
              }
              echo '<td></td>       
            </tr>';
            while ($fila = mysqli_fetch_array($consulta))
            {
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_categoria('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_categoria('.$fila['id'].')"> Borrar</button></td>';
                }
                echo '</tr>';
            }  
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar una categoria
      function editar_categoria($id,$nombre){
        $sentencia = "UPDATE `categoria` SET
            `nombre` = '$nombre'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una categoria dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar una categoria
      function borrar_categoria($id){
        $sentencia = "UPDATE `categoria` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una categoria como inactivo";
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
      // Mostramos el nombre de la habitacion
      function mostrar_nombre_hab($id){ 
        $sentencia = "SELECT nombre FROM hab WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $nombre = 0;
        $comentario="Obtengo el nombre de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      } 
      // Nos permite seleccionar una habitacion ocupada 
      function cambiar_hab_ocupada($monto,$id,$hab_id,$estado){
        $sentencia = "SELECT * FROM hab WHERE id != $hab_id AND estado = 1";
        $comentario="Nos permite seleccionar una habitacion ocupada";
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
      // Nos permite seleccionar una habitacion ocupada para cambiar las cuentas
      function cambiar_cuentas_hab_ocupada($hab_id,$estado,$mov){
        $sentencia = "SELECT * FROM hab WHERE id != $hab_id AND estado = 1";
        $comentario="Nos permite seleccionar una habitacion ocupada para cambiar las cuentas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="col-xs-6 col-sm-4 col-md-2 btn-herramientas">';
                echo '<div class="hab_cambiar" onclick="cambiar_hab_cuentas('.$fila['id'].','.$fila['nombre'].','.$fila['mov'].','.$hab_id.','.$estado.','.$mov.')">';
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