<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Surtir extends ConexionMYSql{

      public $id;
      public $id_reporte;
      public $fecha;
      public $producto;
      public $cantidad;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_reporte= 0;
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
              $this->id_reporte= $fila['id_reporte'];
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
        $sentencia = "INSERT INTO `surtir` (`id_reporte`, `fecha`, `producto`, `cantidad`, `estado`)
        VALUES ('0', '$fecha', '$producto', '$cantidad', '1');";
        $comentario="Guardamos el surtir en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostrar productos que seran en el inventario surtidos
      function mostrar_a_surtir(){
        $contador= 0;
        $sentencia = "SELECT *,surtir.id AS ID,inventario.nombre AS nom
        FROM surtir
        INNER JOIN inventario ON surtir.producto = inventario.id WHERE surtir.estado = 1 ORDER BY surtir.producto DESC";
        $comentario="Mostrar productos que seran en el inventario surtidos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_surtir">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Producto</th>
            <th>Cantidad</th>
            <th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>
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
              <td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_editar_surtir_inventario('.$fila['ID'].')"> Editar</button></td>
              <td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_surtir_inventario('.$fila['ID'].')"> Borrar</button></td>
              </tr>';
            }
            echo '
            </tbody>
          </table>
          </div>';
          if($contador>0){
            echo '<div class="row">
            <div class="col-sm-9"></div>
            <div class="col-sm-3"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_aplicar_surtir_inventario()"> Surtir</button></div>';
            echo '</div>';
          }
      }
      // Editar el surtir
      function editar_surtir($id,$cantidad){
        $sentencia = "UPDATE `surtir` SET
            `cantidad` = '$cantidad'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar el surtir dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar el surtir
      function borrar_surtir($id){
        $sentencia = "UPDATE `surtir` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de surtir como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Poner numero de reporte de surtir y estado inativo
      function ajustes_surtir($id,$id_reporte){
        $fecha_surtido= time();
        $sentencia = "UPDATE `surtir` SET
        `id_reporte` = '$id_reporte',
        `fecha_surtido` = '$fecha_surtido',
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner numero de reporte de surtir y estado inativo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo los datos de surtir inventario para realizar el ajuste de inventario
      function datos_surtir_inventario(){
        $sentencia = "SELECT * ,surtir.id AS ID FROM surtir LEFT JOIN inventario ON surtir.producto = inventario.id  WHERE surtir.estado = 1 ORDER BY surtir.producto";
        $comentario="Mostrar los productos a surtir";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtengo los datos de surtir inventario para realizar su reporte
      function datos_surtir_inventario_reporte($id_reporte){
        $sentencia = "SELECT * ,surtir.id AS ID FROM surtir LEFT JOIN inventario ON surtir.producto = inventario.id  WHERE surtir.id_reporte = $id_reporte ORDER BY surtir.producto";
        $comentario="Mostrar los productos a surtir";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtener el ultimo reporte surtir ingresado 
      function ultima_insercion(){
        $sentencia= "SELECT id,id_reporte FROM surtir WHERE estado = 0 ORDER BY id DESC LIMIT 1";
        $id_reporte= 0;
        $comentario="Obtener el ultimo reporte surtir ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id_reporte= $fila['id_reporte'];
        }
        return $id_reporte;
      }
      // Obtener el ultimo id ingresado 
      function ultima_insercion_reporte(){
        $sentencia= "SELECT id,id_reporte FROM surtir ORDER BY id DESC LIMIT 1";
        $id_reporte= 0;
        $comentario="Obtener el ultimo reporte surtir ingresado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id_reporte= $fila['id_reporte'];
        }
        return $id_reporte;
      }
              
  }
?>