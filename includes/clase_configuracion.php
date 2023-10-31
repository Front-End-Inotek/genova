<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  include_once('clase_validar_usuario.php');
  require_once('sanitize.php');

  class Configuracion extends ConexionMYSql{
    
    /*public $activacion;
    public $nombre;

    function __construct()
    {
      $sentencia = "SELECT * FROM configuracion WHERE id = 1 LIMIT 1 ";
      $comentario="Obtener todos los valores de la configuracion ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           
           $this->activacion= $fila['activacion'];
           $this->nombre= $fila['nombre'];
      }
    }*/
    public $corte;
    public $nombre;
    public $imagen;
    public $pre_ver_corte;
    public $activacion;//
    public $motel;
    public $hospedaje;
    public $placas;
    public $efectivo_caja;
    public $automatizacion;
    public $luz;
    public $credencial_auto;
    public $cortinas;
    public $teclado;
    public $auto_cortinas;
    public $auto_luz;
    public $cancelado;
    public $medio_tiempo;
    public $horas_extra;
    public $canc_antes;
    public $canc_despues;
    public $doble_limpieza;
    public $inventario_corte;
    public $detallado_ticket;
    public $ticket_restaurante;
    public $pantalla_on_off;
    public $puntos;
    public $autocobro;
    public $checkin;
    public $domicilio;

    function __construct(){
      $sentencia = "SELECT * FROM configuracion WHERE id = 1 LIMIT 1";
      $comentario="Obtener todos los valores de la configuracion";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
           $this->corte= $fila['corte'];
           $this->nombre= $fila['nombre'];
           $this->imagen= $fila['imagen'];
           $this->pre_ver_corte= $fila['pre_ver_corte'];
           $this->activacion= $fila['activacion'];
           $this->motel= $fila['motel'];
           $this->hospedaje= $fila['hospedaje'];
           $this->cancelado= $fila['cancelado'];
           $this->placas= $fila['placas'];
           $this->efectivo_caja= $fila['efectivo_caja'];
           $this->automatizacion= $fila['automatizacion'];
           $this->luz= $fila['luz'];
           $this->credencial_auto= $fila['credencial_auto'];
           $this->cortinas= $fila['cortinas'];
           $this->teclado= $fila['teclado'];
           $this->auto_cortinas= $fila['auto_cortinas'];
           $this->auto_luz= $fila['auto_luz'];
           $this->medio_tiempo= $fila['medio_turno'];
           $this->horas_extra= $fila['horas_extras'];
           $this->canc_antes= $fila['canc_antes'];
           $this->canc_despues= $fila['canc_despues'];
           $this->doble_limpieza= $fila['doble_limpieza'];
           $this->inventario_corte= $fila['inventario_corte'];
           $this->detallado_ticket= $fila['detallado_ticket'];
           $this->ticket_restaurante= $fila['ticket_restaurante'];
           $this->pantalla_on_off= $fila['pantalla_on_off'];
           $this->puntos= $fila['puntos'];
           $this->autocobro= $fila['autocobro'];
           $this->checkin= $fila['checkin'];
           $this->domicilio= $fila['domicilio'];
      }
    }
function tipos_abonos($id=0){
    $sentencia = "SELECT* from tipos_abonos WHERE estado= 1";
    $comentario = "Consulta todos los planes de alimentos disponibles";
    $consulta = $this->realizaConsulta($sentencia, $comentario);
    while ($fila = mysqli_fetch_array($consulta)) {
        if($id==$fila['id']) {
            echo '<option selected value="'.$fila['nombre'].'">'.$fila['nombre'].'</option>';
        } else {
            echo '<option value="'.$fila['nombre'].'">'.$fila['nombre'].'</option>';
        }
    }
}
    function borrar_tipo_abono($id){
      $sentencia = "UPDATE `tipos_abonos` SET
      `estado` = '0'
      WHERE `id` = '$id';";
      $comentario="Poner tipo de abono como inactivo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      // echo $sentencia;
      if($consulta){
        echo "NO";
      }else{
        echo "error en la consulta";
      }
    }
    function borrar_plan_alimentacion($id){
      $sentencia = "UPDATE `planes_alimentos` SET
      `estado_plan` = '0'
      WHERE `id` = '$id';";
      $comentario="Poner plan de alimentacion como inactivo";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      if($consulta){
        echo "NO";
      }else{
        echo "error en la consulta";
      }
    }
    function editar_plan($plan_id,$nombre,$costo,$descripcion,$costo_menores){
      $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
      $sentencia = "UPDATE `planes_alimentos` SET
      `nombre_plan` = '$nombre',
      `costo_plan` = '$costo',
      `costo_menores` = '$costo_menores',
      `descripcion` = '$descripcion'
      WHERE `id` = '$plan_id'";
      //echo $sentencia ;
      $comentario="Editar un plan dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      if($consulta){
        echo ("NO");
      }else{
        echo ("error en la consulta");
      }
    }
    function mostrar_planes_select($id=0){
      $sentencia = "SELECT* from planes_alimentos WHERE estado_plan= 1";
      $comentario = "Consulta todos los planes de alimentos disponibles";
      $consulta = $this->realizaConsulta($sentencia, $comentario);
      while ($fila = mysqli_fetch_array($consulta))
      {
        if($id==$fila['id']){
          echo '<option selected data-costoplan='.$fila['costo_plan'].' value="'.$fila['id'].'">'.$fila['nombre_plan'].' $'.$fila['costo_plan'].'</option>';
        }else{
          echo '<option data-costoplan='.$fila['costo_plan'].' value="'.$fila['id'].'">'.$fila['nombre_plan'].' $'.$fila['costo_plan'].'</option>';
        }
      }
    }
  function guardar_plan_alimentos($nombre,$costo,$descripcion){
      $nombre = htmlspecialchars($nombre, ENT_QUOTES, 'UTF-8');
      $sentencia = "INSERT INTO `planes_alimentos` (`nombre_plan`, `costo_plan`, `estado_plan`, `descripcion`)
      VALUES ('$nombre', '$costo', '1','$descripcion');";
      $comentario="Guardamos el plan de alimentos en la base de datos";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      if($consulta){
        echo ('NO');
      }else{
        echo ("error en la consulta");
      }
    }
    function editar_tipo_abono($tipo_id,$nombre,$descripcion){
      $nombre = sanitize($nombre);
      $descripcion = sanitize($descripcion);
      $sentencia = "UPDATE `tipos_abonos` SET
      `nombre` = '$nombre',
      `descripcion` = '$descripcion'
      WHERE `id` = '$tipo_id';";
      // echo $sentencia ;
      $comentario="Editar un tipo de abono dentro de la base de datos ";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      if($consulta){
        echo ("NO");
      }else{
        echo ("error en la consulta");
      }
    }

    public function guardar_tipo_abono($nombre,$descripcion){
        $nombre = sanitize($nombre);
        $descripcion = sanitize($descripcion);
        $sentencia = "INSERT INTO `tipos_abonos` (`nombre`,`descripcion`,`estado`)
        VALUES ('$nombre','$descripcion',1);";
        $comentario="Guardamos el tipo de abono en la base de datos";
        $consulta= $this->realizaConsulta($sentencia, $comentario);
        if($consulta) {
            echo('NO');
        } else {
            echo("error en la consulta");
        }
    }
    public function mostrar_tipos_abonos($id){
      include_once('clase_usuario.php');
      $usuario = NEW Usuario($id);
      $editar = $usuario->tipo_editar;
      $borrar = $usuario->tipo_borrar;
      $sentencia = "SELECT* from tipos_abonos WHERE estado= 1";
      $comentario = "Consulta todos los planes de alimentos disponibles";
      $consulta = $this->realizaConsulta($sentencia, $comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <button class="btn btn-success" href="#caja_herramientas"  data-toggle="modal" onclick="agregar_tipos_abonos('.$id.')"> Agregar </button>
      <br>
      <br>
      <div class="table-responsive" id="tabla_tipo"  style="max-height:860px; overflow-x: scroll; ">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Nombre</th>
          <th>Descripción</th>';
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
              <td>'.$fila['nombre'].'</td>
              <td>'.$fila['descripcion'].'</td>
              ';
              if($editar==1){
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_tipo_abono(' . $fila['id'] . ', \'' . addslashes($fila['nombre']) . '\', \'' . addslashes($fila['descripcion']) . '\')"> Editar</button></td>';
              }
              if($borrar==1){
                echo '<td><button class="btn btn-danger" onclick="borrar_tipo_abono(' . $fila['id'] . ', \'' . addslashes($fila['nombre']) . '\', \'' . addslashes($fila['descripcion']) . '\')">Borrar</button></td>';
              }
              echo '</tr>';
          }
          echo '
        </tbody>
      </table>
      </div>';
  }
  public function mostrar_planes_alimentos($id){
      include_once('clase_usuario.php');
      $usuario = NEW Usuario($id);
      $editar = $usuario->tipo_editar;
      $borrar = $usuario->tipo_borrar;
      $sentencia = "SELECT* from planes_alimentos WHERE estado_plan= 1";
      $comentario = "Consulta todos los planes de alimentos disponibles";
      $consulta = $this->realizaConsulta($sentencia, $comentario);
      //se recibe la consulta y se convierte a arreglo
      echo '
      <button class="btn btn-success" href="#caja_herramientas"  data-toggle="modal" onclick="agregar_planes_alimentos('.$id.')"> Agregar </button>
      <br>
      <br>
      <div class="table-responsive" id="tabla_tipo"  style="max-height:860px; overflow-x: scroll; ">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-primary-encabezado text-center">
          <th>Nombre</th>
          <th>Costo</th>';
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
              <td>'.$fila['nombre_plan'].'</td>
              <td>'.$fila['costo_plan'].'</td>
              ';
              $descripcion=$fila['descripcion'];
              if($editar==1){
                //var_dump($fila);
                echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_plan_alimentos('.$fila['id']. ',  \'' . $fila['nombre_plan'] . '\', '.$fila['costo_plan'].', \'' . $descripcion . '\', '.$fila['costo_menores'].')"> Editar</button></td>';
              }
              if($borrar==1){
                echo '<td><button class="btn btn-danger" onclick="borrar_plan_alimentacion(' . $fila['id'] . ', \'' . addslashes($fila['nombre_plan']) . '\', \'' . addslashes($fila['costo_plan']) . '\')">Borrar</button></td>';
              }
              echo '</tr>';
          }
          echo '
        </tbody>
      </table>
      </div>';
  }
    // Guardar la foto de inicio
    function guardar_foto($nombre){
      $sentencia = "UPDATE `configuracion` SET
      `imagen` = '$nombre'
      WHERE `id` = '1';";
      $comentario="Modificar la foto de inicio";
      $this->realizaConsulta($sentencia,$comentario);
    }
    // Guardar el nombre del sistema
    function guardar_nombre($nombre){
      $sentencia = "UPDATE `configuracion` SET
      `nombre` = '$nombre'
      WHERE `id` = '1';";
      $comentario="Modificar el nombre del sistema";
      $this->realizaConsulta($sentencia,$comentario);
    }
    // Obtener el nombre del sistema
    function obtener_nombre(){
      $sentencia = "SELECT nombre FROM configuracion LIMIT 1";
      $nombre= "";
      $comentario="Obtener el nombre del sistema";
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      while ($fila = mysqli_fetch_array($consulta))
      {
        $nombre=$fila["nombre"];
      }
      return $nombre;
    }
  }
?>
