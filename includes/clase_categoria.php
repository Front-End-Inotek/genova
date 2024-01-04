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
        <table class="table  table-hover">
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
              <td>
                <div class="form-floating">
                  <input type="text" class ="form-control custom_input" id="nombre" placeholder="Ingresa el nombre" pattern="[a-z]{1,15}" maxlength="50">
                  <label for="nombre" >Ingresa el nombre</label>
                </div>
              </td>';
              if($agregar==1){
                echo '<td><button class="btn btn-primary" onclick="guardar_categoria()"> Guardar</button></td>';
              }
              echo '<td></td>
            </tr>';
            while ($fila = mysqli_fetch_array($consulta))
            {
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_categoria('.$fila['id'].')">
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>
                      Editar
                    </button>
                  </td>';
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
      // Obtengo los nombres de las categorias
      function mostrar_categoria(){
        $sentencia = "SELECT * FROM categoria WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las categorias";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
  
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
  
      }
      // Obtengo los nombres de las categorias a editar
      function mostrar_categoria_editar($id){
        $sentencia = "SELECT * FROM categoria WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las categorias a editar";
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
      // Mostrar categorias existentes en el inventario
      function mostrar_categoria_restaurente($hab_id,$estado,$mov,$mesa,$maestra=0){
        $sentencia = "SELECT * FROM categoria WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar las categorias en el restaurente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $cont=0;
       
        while ($fila = mysqli_fetch_array($consulta))
        {
          //if($cont%2==0){
            echo '
              <button type="button" class="btn btn-primary " onclick="buscar_categoria_restaurente('.$fila['id'].','.$hab_id.','.$estado.','.$mov.','.$mesa.','.$maestra.')">
                 '.$fila['nombre'].'
              </button>
            ';
          /*}else{
            echo '<div class="col-sm-2 margen_inf">
              <button type="button" class="btn btn-dark btn-square-md" onclick="buscar_categoria_restaurente('.$fila['id'].','.$hab_id.','.$estado.','.$mov.','.$mesa.')"> 🍽️<br>'.$fila['nombre'].'</button>
            </div>';
          }
          $cont++;*/
        }
      }

      function mostrarCategoriaRestaurante($hab_id,$estado,$mov,$mesa){
        $sentencia = "SELECT * FROM categoria WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar las categorias en el restaurente";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;

      }
              
  }
?>