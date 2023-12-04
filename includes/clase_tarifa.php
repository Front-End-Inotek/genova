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
      function guardar_tarifa($nombre,$precio_hospedaje,$cantidad_hospedaje,$cantidad_maxima,$precio_adulto,$precio_infantil,$tipo,$leyenda){
        $sentencia = "INSERT INTO `tarifa_hospedaje` (`nombre`, `precio_hospedaje`, `cantidad_hospedaje`, `cantidad_maxima`, `precio_adulto`, `precio_infantil`, `leyenda`, `tipo`, `estado`)
        VALUES ('$nombre', '$precio_hospedaje', '$cantidad_hospedaje', '$cantidad_maxima', '$precio_adulto', '$precio_infantil', '$leyenda', '$tipo', '1');";
        $comentario="Guardamos la tarifa hospedaje en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo "NO";
        }else{
          echo "error en la consulta";
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
        <div class="inputs_form_container justify-content-start">
          <div class="form-floating input_container_date">
            <button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_tarifas('.$id.')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8m5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0"/>
                <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z"/>
                <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1z"/>
                <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z"/>
              </svg>
              Agregar
            </button>
          </div>
        </div>


        <div class="table-responsive" id="tabla_tipo" >
        <table class="table table-hover" >
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
                  echo '<td><button class="btn btn-danger" onclick="borrar_tarifa('.$fila['ID'].',\'' . addslashes($fila['nom']) . '\',\'' . addslashes($fila['precio_hospedaje']) . '\',\'' . addslashes($fila['cantidad_hospedaje']) . '\',\'' . addslashes($fila['cantidad_maxima']) . '\',\'' . addslashes($fila['precio_adulto']) . '\',\'' . addslashes($fila['precio_junior']) . '\',\'' . addslashes($fila['precio_infantil']) . '\',\'' . addslashes($fila['habitacion']) . '\',\'' . addslashes($fila['leyenda']) . '\')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar una tarifa hospedaje
      function editar_tarifa($id,$nombre,$precio_hospedaje,$cantidad_hospedaje,$cantidad_maxima,$precio_adulto,$precio_infantil,$tipo,$leyenda){
        $sentencia = "UPDATE `tarifa_hospedaje` SET
            `nombre` = '$nombre',
            `precio_hospedaje` = '$precio_hospedaje',
            `cantidad_hospedaje` = '$cantidad_hospedaje',
            `cantidad_maxima` = '$cantidad_maxima',
            `precio_adulto` = '$precio_adulto',
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
          $sentencia = "SELECT th.id,th.nombre,th.tipo FROM tarifa_hospedaje as th INNER JOIN tipo_hab ON th.tipo = tipo_hab.id WHERE th.estado = 1 ORDER BY nombre";
        }else{
          $sentencia = "SELECT th.id,th.nombre,th.tipo FROM tarifa_hospedaje as th INNER JOIN tipo_hab ON th.tipo = tipo_hab.id WHERE th.estado = 1 AND tipo = $hab_tipo ORDER BY nombre";
        }
        $comentario="Mostrar los nombres de las tarifas hospedaje";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<option data-tipo="'.$fila['tipo'].'" value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
        return $consulta;
      }
      // Muestra los nombres de las tarifas hospedaje a editar
      function mostrar_tarifas_editar($id){
        $sentencia = "SELECT id,nombre,precio_hospedaje,tipo FROM tarifa_hospedaje WHERE estado = 1 ORDER BY nombre";
        $comentario="Mostrar los nombres de las tarifas hospedaje a editar";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($id==$fila['id']){
            echo '  <option data-tipo="'.$fila['tipo'].'" value="'.$fila['id'].'" selected>'.$fila['nombre'].'</option>';
          }else{
            echo '  <option data-tipo="'.$fila['tipo'].'" value="'.$fila['id'].'">'.$fila['nombre'].'</option>';  
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