<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Surtir extends ConexionMYSql{

      public $id;
      public $fecha;
      public $producto;
      public $cantidad;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->fecha= 0;
          $this->producto= 0;
          $this->cantidad= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM surtir WHERE id = $id LIMIT 1";
          $comentario="Obtener todos los valores de habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->fecha= $fila['fecha'];
              $this->producto= $fila['producto'];
              $this->cantidad= $fila['cantidad'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar el surtir
      function guardar_surtir($producto,$cantidad){
        $fecha=time();
        $sentencia = "INSERT INTO `surtir` (`fecha`, `producto`, `cantidad`, `estado`)
        VALUES ('$fecha', '$producto', '$cantidad', '1');";
        $comentario="Guardamos el cargo noche en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostrar productos que seran en el inventario surtidos
      function mostrar_a_surtir(){
        $contador= 0;
        $sentencia = "SELECT *,surtir.id AS ID,inventario.nombre AS nom
        FROM surtir
        INNER JOIN inventario ON surtir.producto = inventario.id WHERE surtir.estado = 1 ORDER BY surtir.producto";
        $comentario="Mostrar productos que seran en el inventario surtidos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_surtir">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Producto</th>
            <th>Cantidad</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Borrar</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
              $contador++;
              echo '<tr class="text-center">
              <td>'.$fila['nombre'].'</td>
              <td>'.$fila['cantidad'].'</td>
              <td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_surtir_inventario('.$fila['ID'].')"> Borrar</button></td>
              </tr>';
            }
            if($contador>0){
              echo '<tr class="text-center">
              <td></td>
              <td></td>
              <td><button class="btn btn-primary btn-lg" onclick="aplicar_inventario_surtir()"> Surtir</button></td>
            </tr>';
            }
            echo '
            </tbody>
          </table>
          </div>';
      }
      // Editar una surtir
      function editar_surtir($id,$nombre){
        $sentencia = "UPDATE `surtir` SET
            `nombre` = '$nombre'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una surtir dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar una surtir
      function borrar_surtir($id){
        $sentencia = "UPDATE `surtir` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una surtir como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtener el ultimo surtir ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id FROM surtir ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener el ultimo surtir ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      }
              
  }
?>