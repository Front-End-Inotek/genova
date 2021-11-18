<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');

  class Cuenta extends ConexionMYSql{

      public $id;
      public $id_usuario;
      public $mov;
      public $descripcion;
      public $fecha;
      public $forma_pago;
      public $cargo;
      public $abono;
      public $estado;
      
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->id_usuario= 0;
          $this->mov= 0;
          $this->descripcion= 0;
          $this->fecha= 0;
          $this->forma_pago= 0;
          $this->cargo= 0;
          $this->abono= 0;
          $this->estado= 0;
        }else{
          $sentencia = "SELECT * FROM cuenta WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de cuenta";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $this->id= $fila['id'];
              $this->id_usuario= $fila['id_usuario'];
              $this->mov= $fila['mov'];
              $this->descripcion= $fila['descripcion'];
              $this->fecha= $fila['fecha'];
              $this->forma_pago= $fila['forma_pago'];
              $this->cargo= $fila['cargo'];
              $this->abono= $fila['abono'];
              $this->estado= $fila['estado'];
          }
        }
      }
      // Guardar la cuenta
      function guardar_cuenta($usuario_id,$mov,$descripcion,$forma_pago,$cargo,$abono){
        $fecha=time();
        $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
        VALUES ('$usuario_id', '$mov', '$descripcion', '$fecha', '$forma_pago', '$cargo', '$abono', '1');";
        $comentario="Guardamos la cuenta en la base de datos";
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
            <th>Nombre</th>
            <th>Tipo de habitacion</th>
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
                  echo '<td><button class="btn btn-warning" onclick="editar_hab('.$fila['ID'].')"><span class="glyphicon glyphicon-edit"></span> Editar</button></td>';
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
      // Editar una habitacion**
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
      // Borrar una habitacion**
      function borrar_hab($id){
        $sentencia = "UPDATE `hab` SET
        `estado_hab` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de una habitacion como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo los nombres de las habitaciones**
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
      // Obtengo los nombres de las habitaciones a editar**
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
      // Cambiar estado de la habitacion**
      function cambiohab($hab,$mov,$estado){
        $sentencia = "UPDATE `hab` SET
        `mov` = '$mov',
        `estado` = '$estado'
        WHERE `id` = '$hab';";
        $comentario="Cambiar estado de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }     
      // Obtenemos la suma de los abonos que tenemos por movimiento en una habitacion
      function obtner_abonos($mov){ 
        $sentencia = "SELECT * FROM cuenta WHERE mov = $mov AND estado = 1";
        //echo $sentencia;
        $suma_abonos = 0;
        $comentario="Obtenemos la suma de los abonos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $suma_abonos= $suma_abonos + $abono= $fila['abono'];
        }
        return $suma_abonos;
      }
      // Mostrar los cargos que tenemos por movimiento en una habitacion
      function mostrar_cargos($mov){
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion concepto  
        FROM cuenta 
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id 
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 AND cuenta.estado = 1 ORDER BY cuenta.fecha";
        $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo --id="tabla_material_ver"
        echo '<div class="table-responsive" id="tabla_cargos">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Usuario</th>
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Cargo</th>
              <th>Forma Pago</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Información</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td>'.$fila['usuario'].'</td>  
                <td>'.$fila['concepto'].'</td>
                <td>'.date("d-m-Y",$fila['fecha']).'</td>
                <td>'.$fila['cargo'].'</td>
                <td>'.$fila['descripcion'].'</td>
                <td><button type="button" class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_agregar_producto_salida('.$fila['id'].')"> Detalles</button></td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Mostramos los abonos que tenemos por movimiento en una habitacion
      function mostrar_abonos($mov){
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion concepto  
        FROM cuenta 
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id 
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 AND cuenta.estado = 1 ORDER BY cuenta.fecha";
        $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
        //echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $total=0;
        echo '<div class="table-responsive" id="tabla_abonos">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-info-encabezado text-center">
              <th>Usuario</th>
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Abono</th>
              <th>Forma Pago</th>
              </tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td>'.$fila['usuario'].'</td>  
                <td>'.$fila['concepto'].'</td>
                <td>'.date("d-m-Y",$fila['fecha']).'</td>
                <td>'.$fila['abono'].'</td>
                <td>'.$fila['descripcion'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
             
  }
?>