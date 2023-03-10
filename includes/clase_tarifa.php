<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Tarifa extends ConexionMYSql{

      public $id;
      public $nombre;
      public $precio_hospedaje;
      public $cantidad_hospedaje;
      public $cantidad_maxima;
      public $precio_adulto;
      public $precio_junior;
      public $precio_infantil;
      public $leyenda;
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
          $this->cantidad_maxima= 0;
          $this->precio_adulto= 0;
          $this->precio_junior= 0;
          $this->precio_infantil= 0;
          $this->leyenda= 0;
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
              $this->cantidad_maxima= $fila['cantidad_maxima'];
              $this->precio_adulto= $fila['precio_adulto'];
              $this->precio_junior= $fila['precio_junior'];
              $this->precio_infantil= $fila['precio_infantil'];
              $this->leyenda= $fila['leyenda'];
              $this->tipo= $fila['tipo'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar la tarifa hospedaje
      function guardar_tarifa($nombre,$precio_hospedaje,$cantidad_hospedaje,$cantidad_maxima,$precio_adulto,$precio_junior,$precio_infantil,$tipo,$leyenda){
        $sentencia = "INSERT INTO `tarifa_hospedaje` (`nombre`, `precio_hospedaje`, `cantidad_hospedaje`, `cantidad_maxima`, `precio_adulto`, `precio_junior`, `precio_infantil`, `leyenda`, `tipo`, `estado`)
        VALUES ('$nombre', '$precio_hospedaje', '$cantidad_hospedaje', '$cantidad_maxima', '$precio_adulto', '$precio_junior', '$precio_infantil', '$leyenda', '$tipo', '1');";
        $comentario="Guardamos la tarifa hospedaje en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo ('NO');
        }else{
          echo ('Consulta_no_realizada');
        }
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
        echo '
        <button class="btn btn-success" href="#caja_herramientas" data-toggle="modal" onclick="agregar_tarifas()"> Agregar</button>
        <br>
        <br>

        <div class="table-responsive" id="tabla_tipo">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Nombre</th>
            <th>Precio</th>
            <th>Cantidad habitación</th>
            <th>Cantidad máxima</th>
            <th>Precio adulto</th>
            <th>Precio junior</th>
            <th>Precio infantil</th>
            <th>Tipo de habitación</th>
            <th>Leyenda de habitación</th>';
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
                <td>$'.number_format($fila['precio_hospedaje'], 2).'</td>
                <td>'.$fila['cantidad_hospedaje'].'</td>
                <td>'.$fila['cantidad_maxima'].'</td>
                <td>$'.number_format($fila['precio_adulto'], 2).'</td>
                <td>$'.number_format($fila['precio_junior'], 2).'</td>
                <td>$'.number_format($fila['precio_infantil'], 2).'</td>
                <td>'.$fila['habitacion'].'</td>
                <td>'.$fila['leyenda'].'</td>';
                if($editar==1){
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tarifa('.$fila['ID'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="borrar_tarifa('.$fila['ID'].',\'' . addslashes($fila['nom']) . '\',\'' . addslashes($fila['precio_hospedaje']) . '\',\'' . addslashes($fila['cantidad_hospedaje']) . '\',\'' . addslashes($fila['cantidad_maxima']) . '\',\'' . addslashes($fila['precio_adulto']) . '\',\'' . addslashes($fila['precio_junior']) . '\',\'' . addslashes($fila['precio_infantil']) . '\',\'' . addslashes($fila['habitacion']) . '\',\'' . addslashes($fila['leyenda']) . '\')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar una tarifa hospedaje
      function editar_tarifa($id,$nombre,$precio_hospedaje,$cantidad_hospedaje,$cantidad_maxima,$precio_adulto,$precio_junior,$precio_infantil,$tipo,$leyenda){
        $sentencia = "UPDATE `tarifa_hospedaje` SET
            `nombre` = '$nombre',
            `precio_hospedaje` = '$precio_hospedaje',
            `cantidad_hospedaje` = '$cantidad_hospedaje',
            `cantidad_maxima` = '$cantidad_maxima',
            `precio_adulto` = '$precio_adulto',
            `precio_junior` = '$precio_junior',
            `precio_infantil` = '$precio_infantil',
            `leyenda` = '$leyenda',
            `tipo` = '$tipo'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una tarifa hospedaje dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo ('NO');
        }else{
          echo ('Consulta_no_realizada');
        }
      }
      // Borrar una tarifa hospedaje
      function borrar_tarifa($id){
        $sentencia = "UPDATE `tarifa_hospedaje` SET
        `estado` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una tarifa hospedaje como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo ('NO');
        }else{
          echo ('Consulta_no_realizada');
        }
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
      function mostrar_tarifas($hab_tipo){
        if($hab_tipo == 0){
          $sentencia = "SELECT id,nombre FROM tarifa_hospedaje WHERE estado = 1 ORDER BY nombre";
        }else{
          $sentencia = "SELECT id,nombre FROM tarifa_hospedaje WHERE estado = 1 AND tipo = $hab_tipo ORDER BY nombre";
        }
        $comentario="Mostrar los nombres de las tarifas hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '  <option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
        return $consulta;
      }
      // Muestra los nombres de las tarifas hospedaje a editar
      function mostrar_tarifas_editar($id){
        $sentencia = "SELECT id,nombre,precio_hospedaje FROM tarifa_hospedaje WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las tarifas hospedaje a editar";
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
      // Obtengo los datos de la tarifa hospedaje
      function datos_hospedaje($id){
        $sentencia = "SELECT * FROM tarifa_hospedaje WHERE nombre = $id AND estado = 1";
        $comentario="Mostrar los datos de la tarifa hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtengo el nombre de la tarifa
      function obtengo_nombre($id){
        $sentencia = "SELECT nombre FROM tarifa_hospedaje WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $nombre= '';
        $comentario="Obtengo el nombre de la tarifa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['nombre'];
        }
        return $nombre;
      }
      // Obtengo la tarifa por el dia de hospedaje
      function obtengo_tarifa_dia($id,$extra_adulto,$extra_junior,$extra_infantil,$descuento){
        $sentencia = "SELECT * FROM tarifa_hospedaje WHERE id = $id AND estado = 1 LIMIT 1";
        //echo $sentencia;
        $total_dia= 0;
        $comentario="Obtengo la tarifa por el dia de hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $precio_hospedaje= $fila['precio_hospedaje'];
          $extra_adulto= $extra_adulto * $fila['precio_adulto'];
          $extra_junior= $extra_junior * $fila['precio_junior'];
          $extra_infantil= $extra_infantil * $fila['precio_infantil'];
          $total_dia= $precio_hospedaje + $extra_adulto + $extra_junior + $extra_infantil;
          
          // Se obtine el calculo total considerando si existe o no descuento
          if($descuento>0){
            $descuento= $descuento / 100;
            $descuento= 1 - $descuento;
            $total_dia= $total_dia * $descuento;
          }else{
            // Permanece igual el total dia
          }
        }
        return $total_dia;
      }
             
  }
?>