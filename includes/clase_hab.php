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
            <th>Número</th>
            <th>Tipo de habitación</th>
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
      // Mostramos el movimiento de la habitacion
      function mostrar_mov_hab($id){ 
        $sentencia = "SELECT mov FROM hab WHERE id = $id LIMIT 1";
        //echo $sentencia;
        $mov = 0;
        $comentario="Obtengo el movimiento de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $mov= $fila['mov'];
        }
        return $mov;
      } 
      // Obtengo el total de habitaciones ocupadas
      function obtener_ocupadas(){ 
        $sentencia = "SELECT count(hab.id) AS cantidad,hab.estado,hab.estado_hab FROM hab WHERE hab.estado = 1 AND hab.estado_hab = 1";
        //echo $sentencia;
        $cantidad=0;
        $comentario="Obtengo el total de habitaciones ocupadas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Obtengo el total de habitaciones disponibles
      function obtener_disponibles(){ 
        $sentencia = "SELECT count(hab.id) AS cantidad,hab.estado,hab.estado_hab FROM hab WHERE hab.estado = 0 AND hab.estado_hab = 1";
        //echo $sentencia;
        $cantidad=0;
        $comentario="Obtengo el total de habitaciones disponibles";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Seleccionar habitacion a asignar reservacion para checkin
      function select_asignar_reservacion($tipo_hab){
        $disponible= 0;
        $sentencia = "SELECT *,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab 
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado = 0 AND hab.tipo = $tipo_hab ORDER BY hab.nombre";
        $comentario="Seleccionar habitacion a asignar reservacion para checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="col-xs-6 col-sm-4 col-md-3 btn-herramientas estado estado" onclick="asignar_reservacion('.$tipo_hab.')">';//col-xs-4 col-sm-2 col-md-1
            echo '<div class="estado estado0" onclick="asignar_reservacion('.$tipo_hab.')">';
              echo '<div class="row">
                <div class="col-sm-6">
                  <div class="titulo_hab">';
                    echo "Disponible";
                  echo '</div>
                </div>

                <div class="col-sm-6">
                  <div class="imagen_hab">';
                   echo '<span class="badge tama_num_hab">'.$fila['nom'].'</span>';
                  echo '</div>
                </div>
              </div>';

              echo '<div class="timepo_hab">';
                echo '&nbsp';
              echo '</div>';

              echo '<div class="timepo_hab">';
                echo '&nbsp';
              echo '</div>';

              echo '<div class="icono_hab">';
                echo '<div><br></div>';    
              echo '</div>';
              
            echo '</div>';
          echo '</div>';
          $disponible= 1;
        }
        if($disponible== 0){
          echo '<div class="col-xs-12 col-sm-12 col-md-12 margen-1">';
            echo "¡No existe disponibilidad en ese tipo de habitación!";
          echo '</div>';
        }
      }
              
  }
?>