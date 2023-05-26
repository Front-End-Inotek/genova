<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Forma_pago extends ConexionMYSql{
    
    public $id;
    public $descripcion;
    public $estado;
    public $garantia;

    // Constructor
    function __construct($id)
    {
      if($id==0){
        $this->id= 0;
        $this->descripcion= 0;
        $this->estado= 0;
        $this->garantia=0;
      }else{  
        $sentencia = "SELECT * FROM forma_pago WHERE id = $id LIMIT 1";
        $comentario="Obtener todos los valores de forma de pago";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
            $this->id= $fila['id'];  
            $this->descripcion= $fila['descripcion']; 
            $this->estado= $fila['estado'];      
            $this->garantia= $fila['garantia'];         
        }
      }
    }
    // Guardar una forma de pago
    function guardar_forma_pago($descripcion,$garantia){
      $sentencia = "INSERT INTO `forma_pago` (`descripcion`, `estado`, `garantia`)
      VALUES ('$descripcion', '1','$garantia');";
      $comentario="Guardamos la forma de pago en la base de datos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);                 
    }
    // Obtengo el total de formas de pago
    function total_elementos(){
      $cantidad=0;
      $sentencia = "SELECT count(id) AS cantidad,descripcion FROM forma_pago WHERE estado = 1  ORDER BY id";
      //echo $sentencia;
      $comentario="Obtengo el total de formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $cantidad= $fila['cantidad'];
      }
      return $cantidad;
    }

    function mostrar_select(){

    }

    // Mostramos las formas de pago
    function mostrar($id){
      include_once('clase_usuario.php');
      $usuario = NEW Usuario($id);
      $agregar = $usuario->categoria_editar;
      $editar = $usuario->forma_pago_editar;
      $borrar = $usuario->forma_pago_borrar;

      $sentencia = "SELECT * FROM forma_pago WHERE estado = 1 ORDER BY descripcion";
      $comentario="Mostrar los tipos formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '<div class="table-responsive" id="tabla_forma">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Descripción</th>
          <th>Garantía</th>
          ';
          
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
            <td><input type="text" class ="color_black" id="descripcion" placeholder="Ingresa la descripción" pattern="[a-z]{1,15}" maxlength="50"></td>
            <td><input type="checkbox" class ="color_black" id="garantia"></td>'
            ;
            
            if($agregar==1){
              echo '<td><button class="btn btn-success" onclick="guardar_forma_pago()"> Guardar</button></td>';
            }
            echo '<td></td>       
          </tr>';
          while ($fila = mysqli_fetch_array($consulta))
          {
              echo '<tr class="text-center">
              <td>'.$fila['descripcion'].'</td>';
              if($editar==1){
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_forma_pago('.$fila['id'].')"> Editar</button></td>';
              }
              if($borrar==1){
                echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_forma_pago('.$fila['id'].')"> Borrar</button></td>';
              }
              echo '</tr>';
          }
          echo '
        </tbody>
      </table>
      </div>';
    }
    // Editar una forma de pago
    function editar_forma_pago($id,$descripcion,$garantia){
      $sentencia = "UPDATE `forma_pago` SET
          `descripcion` = '$descripcion'
          ,`garantia` = $garantia
          WHERE `id` = '$id';";
      echo $sentencia ;
      $comentario="Editar una forma de pago dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    // Borrar una forma de pago
    function borrar_forma_pago($id){
      $sentencia = "UPDATE `forma_pago` SET
      `estado` = '0'
      WHERE `id` = '$id';";
      $comentario="Poner estado de una forma de pago como inactivo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
    }
    // Muestra las formas de pago
    function mostrar_forma_pago(){
      $sentencia = "SELECT * FROM forma_pago WHERE estado = 1 ORDER BY id";
      $comentario="Mostrar las formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<option data-garantia="'.$fila['garantia'].'" value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
      }
      return $consulta;
    }
    // Muestra las formas de pago a editar
    function mostrar_forma_pago_editar($id){
      $sentencia = "SELECT * FROM forma_pago WHERE estado = 1 ORDER BY id";
      $comentario="Mostrar las formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        if($id==$fila['id']){
          echo '<option value="'.$fila['id'].'" selected>'.$fila['descripcion'].'</option>';
        }else{
          echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';  
        }
      }
    }
    // Muestra las formas de pago
    function mostrar_forma_pago_restaurante(){
      $sentencia = "SELECT * FROM forma_pago WHERE estado = 1 AND id != 1 ORDER BY id";
      $comentario="Mostrar las formas de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<option value="'.$fila['id'].'">'.$fila['descripcion'].'</option>';
      }
      return $consulta;
    }
    // Obtengo el descripcion de una forma de pago
    function obtener_descripcion($id){
      $descripcion= '';
      $sentencia = "SELECT descripcion FROM forma_pago WHERE id = $id AND estado = 1";
      //echo $sentencia;
      $comentario="Obtengo el descripcion de una forma de pago";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        $descripcion= $fila['descripcion'];
      }
      return $descripcion;
    }
    
  }
?>
