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
      public $cargo_noche;
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
          $this->cargo_noche= 0;
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
              $this->cargo_noche= $fila['cargo_noche'];
              $this->estado_hab= $fila['estado_hab'];
          }
        }
      }
      // Guardar la habitacion
      function guardar_hab($nombre,$tipo,$comentario){
        $sentencia = "INSERT INTO `hab` (`nombre`, `tipo`, `mov`, `comentario`, `estado`, `cargo_noche`, `estado_hab`)
        VALUES ('$nombre', '$tipo', '0', '$comentario', '0', '0', '1');";
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
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado_hab = 1 ORDER BY hab.id";// nombre
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
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY id";
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
        $sentencia = "SELECT * FROM tipo_hab WHERE estad = 1 ORDER BY id";
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
      // Mostramos el id de la habitacion
      function mostrar_id_hab($nombre){ 
        $sentencia = "SELECT id FROM hab WHERE id = $nombre LIMIT 1";
        //echo $sentencia;
        $id = 0;
        $comentario="Obtengo el id de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $id= $fila['id'];
        }
        return $id;
      } 
      // Mostramos el movimiento de la habitacion por medio del nombre
      function mostrar_movimiento_hab($nombre){ 
        $sentencia = "SELECT mov FROM hab WHERE nombre LIKE '%$nombre%' LIMIT 1";
        //echo $sentencia;
        $mov = 0;
        $comentario="Obtengo el movimiento de la habitacion por medio del nombre";
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
      // Consultar disponibilidad de un tipo de habitacion para hacer checkin
      function consultar_disponibilidad($tipo_hab){
        $cantidad=0;
        $sentencia = "SELECT *,count(hab.id) AS cantidad,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab 
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado = 0 AND hab.tipo = $tipo_hab ORDER BY hab.id";
        $comentario="Consultar disponibilidad de un tipo de habitacion para hacer checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Seleccionar habitacion a asignar reservacion para checkin
      function select_asignar_reservacion($tipo_hab,$id_reservacion,$habitaciones,$multiple){
        $sentencia = "SELECT *,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab 
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado = 0 AND hab.tipo = $tipo_hab ORDER BY hab.id";
        $comentario="Seleccionar habitacion a asignar reservacion para checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="col-xs-6 col-sm-4 col-md-3 btn-herramientas estado estado">';
            if($multiple == 0){
              echo '<div class="estado estado0" onclick="asignar_reservacion('.$fila['ID'].','.$id_reservacion.','.$habitaciones.')">';
            }else{
              echo '<div class="estado estado0" onclick="asignar_reservacion_multiple('.$fila['ID'].','.$id_reservacion.','.$habitaciones.')">';
            }
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
        }
      }
      // Obtengo los datos del cargo por noche de la habitacion para realizar su reporte
      function datos_cargo_noche(){
        $sentencia = "SELECT *,hab.id AS ID 
        FROM hab
        INNER JOIN movimiento ON hab.mov = movimiento.id 
        INNER JOIN reservacion ON movimiento.id_reservacion = reservacion.id WHERE hab.cargo_noche = 1 AND reservacion.forzar_tarifa = 0 AND hab.estado_hab = 1";
        $comentario="Obtengo los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      // Obtengo los datos del cargo por noche de la habitacion 
      function mostrar_cargo_noche(){
        //<div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CARGO POR NOCHE</h2></div>';
        echo '<div class="row">
              <div class="col-sm-4"></div>
              <div class="col-sm-4"><h2 class="text-dark">CARGO POR NOCHE</h2></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2">
              <div id="boton_reservacion">
                <input type="submit" class="btn btn-success btn-block margen-1" value="Aplicar" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cargo_noche()">
              </div>
              </div>
        </div>';

        $total_final= 0;
        include_once("clase_huesped.php");
        include_once('clase_tarifa.php');
        $huesped= NEW Huesped(0);
        $tarifa= NEW Tarifa(0);

        $sentencia = "SELECT *,hab.id AS ID 
        FROM hab
        INNER JOIN movimiento ON hab.mov = movimiento.id 
        INNER JOIN reservacion ON movimiento.id_reservacion = reservacion.id WHERE reservacion.forzar_tarifa = 0 AND hab.estado_hab = 1";
        $comentario="Mostrar los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_cargo_noche">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Seleccionar</th>
            <th>Hab</th>
            <th>Tarifa</th>
            <th>Extra Adulto</th>
            <th>Extra Junior</th>
            <th>Extra Infantil</th>
            <th>Extra Menor</th>
            <th>Nombre Huésped</th>
            <th>Quien Reserva</th>
            <th>Descuento</th>
            <th>Total</th>
            </tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta))
            {
                $hab_id = $fila['ID'];
                $hab_nombre = $fila['nombre'];  
                $extra_adulto = $fila['extra_adulto'];
                $extra_junior = $fila['extra_junior'];
                $extra_infantil = $fila['extra_infantil'];
                $extra_menor = $fila['extra_menor'];
                $id_tarifa = $fila['tarifa'];
                $id_huesped = $fila['id_huesped'];
                $quien_reserva	= $fila['nombre_reserva'];
                $descuento = $fila['descuento'];
                $cargo_noche = $fila['cargo_noche'];

                $nombre_huesped= $huesped->obtengo_nombre_completo($id_huesped);
                $nombre_tarifa= $tarifa->obtengo_nombre($id_tarifa);
                $total_tarifa= $tarifa->obtengo_tarifa_dia($id_tarifa,$extra_adulto,$extra_junior,$extra_infantil,$descuento);
                if($cargo_noche == 1){
                  $total_tarifa_seleccionada= $total_tarifa;
                }else{
                  $total_tarifa_seleccionada= 0;
                }
                $total_final= $total_final + $total_tarifa_seleccionada;
                echo '<tr class="text-center">
                <td><div class="form-check">';
                  if($cargo_noche == 0){
                    echo '<input class="form-check-input" type="checkbox" id="cargo_noche" onchange="cambiar_cargo_noche('.$hab_id.')">';
                  }else{
                    echo '<input class="form-check-input" type="checkbox" id="cargo_noche" onchange="cambiar_cargo_noche('.$hab_id.')" checked>';
                  }
                echo '</div></td>
                <td>'.$hab_nombre.'</td>
                <td>'.$nombre_tarifa.'</td>
                <td>'.$extra_adulto.'</td>
                <td>'.$extra_junior.'</td>
                <td>'.$extra_infantil.'</td>
                <td>'.$extra_menor.'</td>
                <td>'.$nombre_huesped.'</td>
                <td>'.$quien_reserva.'</td>
                <td>'.$descuento.'%</td>
                <td>$'.number_format($total_tarifa, 2).'</td>';
                //echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_tipo('.$fila['id'].')"> Borrar</button></td>';
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
        return $total_final;
      }
      // Cambiar el estado cargo noche de una habitacion
      function cambiar_cargo_noche($id,$cargo_noche){
        $sentencia = "UPDATE `hab` SET
        `cargo_noche` = '$cargo_noche'
        WHERE `id` = '$id';";
        $comentario="Cambiar el estado cargo noche de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Cambiar estado cargo noche en todas las habitaciones
      function estado_cargo_noche($estado){
        $sentencia = "UPDATE `hab` SET
        `cargo_noche` = '$estado';";
        $comentario="Cambiar estado cargo noche en todas las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      } 
              
  }
?>