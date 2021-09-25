<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Tarifa extends ConexionMYSql{

      public $id;
      public $nombre;
      public $precio_hospedaje;
      public $cantidad_hospedaje;
      public $precio_adulto;
      public $precio_junior;
      public $precio_infantil;
      public $tipo;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->precio_hospedaje= 0;
          $this->cantidad_hospedaje= 0;
          $this->precio_adulto= 0;
          $this->precio_junior= 0;
          $this->precio_infantil= 0;
          $this->tipo= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM tarifa_hospedaje WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de tarifa hospedaje";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->precio_hospedaje= $fila['precio_hospedaje'];
              $this->cantidad_hospedaje= $fila['cantidad_hospedaje'];
              $this->precio_adulto= $fila['precio_adulto'];
              $this->precio_junior= $fila['precio_junior'];
              $this->precio_infantil= $fila['precio_infantil'];
              $this->tipo= $fila['tipo'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar la tarifa hospedaje
      function guardar_tarifa($nombre,$precio_hospedaje,$cantidad_hospedaje,$precio_adulto,$precio_junior,$precio_infantil,$tipo){
        $sentencia = "INSERT INTO `tarifa_hospedaje` (`nombre`, `precio_hospedaje`, `cantidad_hospedaje`, `precio_adulto`, `precio_junior`, `precio_infantil`, `tipo`, `estado`)
        VALUES ('$nombre', '$precio_hospedaje', '$cantidad_hospedaje', '$precio_adulto', '$precio_junior', '$precio_infantil', '$tipo', '1');";
        $comentario="Guardamos la tarifa hospedaje en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);                 
      }
      // Mostramos las tarifas hospedaje
      function mostrar($id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->tarifa_editar;
        $borrar = $usuario->tarifa_borrar;

        $sentencia = "SELECT *,tarifa_hospedaje.id AS ID,tarifa_hospedaje.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM tarifa_hospedaje 
        INNER JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id WHERE tarifa_hospedaje.estado = 1 ORDER BY tarifa_hospedaje.nombre";
        $comentario="Mostrar las tarifas hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_tipo">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad por hospedaje</th>
            <th>Precio adulto</th>
            <th>Precio junior</th>
            <th>Precio infantil</th>
            <th>Tipo de habitacion</th>';
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
                <td>$'.$fila['precio_hospedaje'].'</td>
                <td>'.$fila['cantidad_hospedaje'].'</td>
                <td>$'.$fila['precio_adulto'].'</td>
                <td>$'.$fila['precio_junior'].'</td>
                <td>$'.$fila['precio_infantil'].'</td>
                <td>'.$fila['habitacion'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_tarifa('.$fila['ID'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_tarifa('.$fila['ID'].')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar las tarifas hospedaje
      function editar_tarifa($id,$nombre,$precio_hospedaje,$cantidad_hospedaje,$precio_adulto,$precio_junior,$precio_infantil,$tipo){
        $sentencia = "UPDATE `tarifa_hospedaje` SET
            `nombre` = '$nombre',
            `precio_hospedaje` = '$precio_hospedaje',
            `cantidad_hospedaje` = '$cantidad_hospedaje',
            `precio_adulto` = '$precio_adulto',
            `precio_junior` = '$precio_junior',
            `precio_infantil` = '$precio_infantil',
            `tipo` = '$tipo'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar las tarifas hospedaje dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar las tarifas hospedaje
      function borrar_tarifa($id){
        $sentencia = "UPDATE `tarifa_hospedaje` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una tarifa hospedaje como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo los nombres de los tipos de habitaciones de tarifas hospedaje
      function mostrar_tipo(){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de tipos de habitaciones de tarifas hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
  
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
  
      }
      // Obtengo los nombres de los tipos de habitaciones de tarifas hospedaje a editar
      function mostrar_tipo_editar($id){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de tipos de habitaciones de tarifas hospedaje a editar";
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
      // Muestra los nombres de las tarifas hospedaje
      function mostrar_tarifas(){
        $sentencia = "SELECT * FROM tarifa_hospedaje WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las tarifas hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
        return $consulta;
      }
      // Muestra la cantidad hospedaje de la tarifa hospedaje
      function mostrar_cantidad_hospedaje($id){
        $sentencia = "SELECT * FROM tarifa_hospedaje WHERE id = $id AND estado = 1";
        $cantidad_hospedaje= 0;
        $comentario="Mostrar los nombres de las tarifas hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad_hospedaje= $fila['cantidad_hospedaje'];
        }
        return $cantidad_hospedaje;
      }
             
  }
?>