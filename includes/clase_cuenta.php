<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  include_once('clase_ticket.php');
 

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

      function mostrar_cuenta_maestra(){
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
        echo '
        <button class="btn btn-success" href="#caja_herramientas" data-toggle="modal" onclick="agregar_hab('.$id.')"> Agregar </button>
        <br>
        <br>
        <div class="table-responsive" id="tabla_tipo" style="max-height:860px; overflow-y: scroll;">
        <table class="table table-bordered table-hover" >
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
                  echo '<td><button class="btn btn-warning" href="#caja_herramientas" data-toggle="modal" onclick="editar_hab('.$fila['ID'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" onclick="borrar_hab('.$fila['ID'].', \'' . addslashes($fila['nom']) . '\', \'' . addslashes($fila['habitacion']) . '\', \'' . addslashes($fila['comentario']) . '\')"> Borrar</button></td>';
                }
                echo '</tr>';
            }
            echo '
          </tbody>
        </table>
        </div>';
      }


      // Guardar la cuenta
      function guardar_cuenta($usuario_id,$mov,$descripcion,$forma_pago,$cargo,$abono,$id_ticket=1){
        if (isset($_SESSION['observaciones'])) {
          $observacion=$_SESSION['observaciones'];
          unset($_SESSION['observaciones']);
        }else{
          $observacion="";
        }
        $fecha=time();
        $descripcion = htmlspecialchars($descripcion, ENT_QUOTES, 'UTF-8');
        $sentencia = "INSERT INTO `cuenta` (`id_usuario`,`id_ticket`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`,`observacion`)
        VALUES ('$usuario_id','$id_ticket' ,'$mov', '$descripcion', '$fecha', '$forma_pago', '$cargo', '$abono', '1', '$observacion');";
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
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado != 0 ORDER BY hab.nombre";
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
      // Editar una cuenta proveniente de una reservacion
      function editar_cuenta_reservacion($id,$total_suplementos,$total_pago){
        $sentencia = "UPDATE `cuenta` SET
            `cargo` = '$total_suplementos',
            `abono` = '$total_pago'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar una cuenta proveniente de una reservacion dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }

      // Editar multiples cargos de cuentas
      function editar_cargos($cargos){
        $cargos = json_decode($cargos);
        // print_r($cargos);
        // die();
        foreach ($cargos as $key => $cargo) {
          $sentencia = "UPDATE `cuenta` SET
          `cargo` = '$cargo->valor'
          WHERE `id` = '$cargo->cuenta_id';";
          // echo $sentencia ;
          $comentario="Editar el cargo de una cuenta dentro de la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }
      }

      // Editar el cargo de una cuenta
      function editar_cargo($id,$cargo){
        $sentencia = "UPDATE `cuenta` SET
            `cargo` = '$cargo'
            WHERE `id` = '$id';";
        // echo $sentencia ;
        $comentario="Editar el cargo de una cuenta dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Editar el abono de una cuenta
      function editar_abono($id,$abono){
        $sentencia = "UPDATE `cuenta` SET
            `abono` = '$abono'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar el abono de una cuenta dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Editar el estado de una cuenta luego de un corte
      function editar_estadoGlobal($id_usuario){
        $hoy = date('Y-m-d');
        $sentencia = "UPDATE `cuenta` SET
            `estado` = '2'
            where from_unixtime(cuenta.fecha + 3600,'%Y-%m-%d') = '$hoy' AND `estado` = '1'
            AND `id_usuario` = '$id_usuario'
            ";
        //echo $sentencia ;
        $comentario="Editar el estado de una cuenta luego de un corte dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }

      // Editar el estado de una cuenta luego de un corte
      function editar_estado($id_usuario){
        $sentencia = "UPDATE `cuenta` SET
            `estado` = '2'
            WHERE `id_usuario` = '$id_usuario' AND `estado` = '1';";
        //echo $sentencia ;
        $comentario="Editar el estado de una cuenta luego de un corte dentro de la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }

      // Borrar una cuenta
      function borrar_cuenta($id,$descripcion,$monto){
        $descripcion= substr($descripcion, 0, 17);
        if($descripcion == 'Total reservacion'){
          $sentencia = "SELECT * FROM cuenta WHERE id = $id AND estado != 0";
          //echo $sentencia;
          $id_usuario= 0;
          $mov= 0;
          $fecha= 0;
          $forma_pago= 0;
          $cargo= 0;
          $abono= 0;
          $comentario="Obtenemos los datos de la correspondiente cuenta";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta))
          {
            $id_usuario= $fila['id_usuario'];
            $mov= $fila['mov'];
            $fecha= $fila['fecha'];
            $forma_pago= $fila['forma_pago'];
            $cargo= $fila['cargo'];
            $abono= $fila['abono'];
          }

          if($monto == 1){
             // Para poder borrar el cargo o abono de una reservacion se divide en dos
            $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
            VALUES ('$id_usuario', '$mov', 'Total suplementos', '$fecha', '$forma_pago', '$cargo', '0', '0');";
            $comentario="Guardamos la cuenta en la base de datos";
            $consulta= $this->realizaConsulta($sentencia,$comentario);

            $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
            VALUES ('$id_usuario', '$mov', 'Pago al reservar', '$fecha', '$forma_pago', '0', '$abono', '1');";
            $comentario="Guardamos la cuenta en la base de datos";
            $consulta= $this->realizaConsulta($sentencia,$comentario);
          }else{
             // Para poder borrar el cargo o abono de una reservacion se divide en dos
            $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
            VALUES ('$id_usuario', '$mov', 'Total suplementos', '$fecha', '$forma_pago', '$cargo', '0', '1');";
            $comentario="Guardamos la cuenta en la base de datos";
            $consulta= $this->realizaConsulta($sentencia,$comentario);
            $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
            VALUES ('$id_usuario', '$mov', 'Pago al reservar', '$fecha', '$forma_pago', '0', '$abono', '0');";
            $comentario="Guardamos la cuenta en la base de datos";
            $consulta= $this->realizaConsulta($sentencia,$comentario);
          }
          // Despues de dividir la cuenta se inactiva
          $sentencia = "UPDATE `cuenta` SET
            `estado` = '0'
            WHERE `id` = '$id';";
          //echo $sentencia ;
          $comentario="Poner estado de una cuenta como inactivo";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }else{
          $sentencia = "UPDATE `cuenta` SET
          `estado` = '0'
          WHERE `id` = '$id';";
          $comentario="Poner estado de una cuenta como inactivo";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }
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
        `estado` = '$estado',
        ultimo_mov = UNIX_TIMESTAMP()
        WHERE `id` = '$hab';";
        $comentario="Cambiar estado de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtenemos la suma de los abonos que tenemos por movimiento en una habitacion
      function obtner_abonos($mov){
        $sentencia = "SELECT * FROM cuenta WHERE mov = $mov AND estado != 0";
        //echo $sentencia;
        $suma_abonos = 0;
        $comentario="Obtenemos la suma de los abonos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $suma_abonos= $suma_abonos + ($abono= $fila['abono']);
        }
        return $suma_abonos;
      }
      //Obtener el limite de credito de husped en base a un movimiento.
      function mostrarLimiteCredito($mov){
        $sentencia="SELECT huesped.estado_credito as estado_credito , huesped.limite_credito
        FROM hab
        INNER JOIN movimiento as mov ON hab.mov = mov.id
        LEFT JOIN huesped on mov.id_huesped = huesped.id
        where hab.estado !=0
        and hab.mov = $mov
        ";
        $comentario="Obtener el limite de credito de husped en base a un movimiento";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $estado_credito="";
        $limite_credito =0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $estado_credito= $fila['estado_credito'];
          $limite_credito = $fila['limite_credito'];
        }
        return [$estado_credito,$limite_credito];
      }
      function estadoCargosHabs($editable){
        $filtro="";
        if(!$editable){
          $filtro ="and
          (from_unixtime(reservacion.fecha_auditoria,'%Y-%m-%d') != CURRENT_DATE()
        or reservacion.fecha_auditoria is null
        )";
        }
        $sentencia="SELECT hab.nombre as hab_nombre, reservacion.precio_hospedaje as tarifa, reservacion.id as reserva_id, reservacion.forzar_tarifa
        ,reservacion.fecha_auditoria
        FROM
        hab
        INNER JOIN movimiento as mov ON hab.mov = mov.id
        INNER JOIN reservacion ON mov.id_reservacion = reservacion.id
        where hab.estado = 1
        ".$filtro."
        order by hab.id";
        $comentario="Obtenemos cargos/habonos de una habitacion en casa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      //Saldo huespedes en casa
      function hab_ocupadas(){
        $sentencia="SELECT hab.id ,hab.nombre as hab_nombre,hab.tipo,hab.mov as mov,hab.estado,reservacion.precio_hospedaje as tarifa, reservacion.precio_hospedaje,
        huesped.nombre, huesped.apellido, reservacion.estado_credito, reservacion.limite_credito
        FROM hab INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id
        INNER JOIN movimiento as mov ON hab.mov = mov.id
        INNER JOIN reservacion ON mov.id_reservacion = reservacion.id
        INNER JOIN huesped on mov.id_huesped = huesped.id
        WHERE hab.estado = 1
        ORDER BY id";
        $comentario="Obtenemos habitaciones en casa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrar_historial_cuentas($inicial,$final,$a_buscar){
        $filtro_fecha="";
        $filtro_buscar="";
        if(!empty($a_buscar)){
          $filtro_buscar=" AND (hab.nombre LIKE '%$a_buscar%' || cuenta.descripcion LIKE '%$a_buscar%' || huesped.nombre LIKE '%$a_buscar%'
          || huesped.apellido LIKE '%$a_buscar%'|| cuenta.estado LIKE '%$a_buscar%')";
        }
        if(!empty($inicial) && !empty($final)){
          $inicial = strtotime($inicial);
          $final = strtotime($final);
          if($inicial == $final){
            $filtro_fecha="AND FROM_UNIXTIME(cuenta.fecha  + 3600,'%Y-%m-%d') = FROM_UNIXTIME($inicial + 3600,'%Y-%m-%d')";
          }else{
            $filtro_fecha="AND FROM_UNIXTIME(cuenta.fecha  + 3600,'%Y-%m-%d') >=  FROM_UNIXTIME($inicial + 3600,'%Y-%m-%d') AND FROM_UNIXTIME(cuenta.fecha  + 3600,'%Y-%m-%d') <=  FROM_UNIXTIME($final + 3600,'%Y-%m-%d')";
          }
        }
        $sentencia="SELECT *, hab.nombre as hab_nombre, reservacion.total as tarifa, cuenta.estado as estado_cuenta
        ,huesped.nombre as huesped_nombre, huesped.apellido as huesped_apellido, cuenta.id as id_cuenta
        FROM
        cuenta
        INNER JOIN movimiento as mov ON cuenta.mov = mov.id
        LEFT JOIN hab ON hab.mov = cuenta.mov
        INNER JOIN reservacion ON mov.id_reservacion = reservacion.id
        LEFT JOIN huesped on mov.id_huesped = huesped.id
        WHERE (cuenta.abono>0 OR cuenta.cargo>0)
        AND cuenta.estado!=0
        ".$filtro_fecha."
        ".$filtro_buscar."
        order by cuenta.fecha desc";
        // echo $sentencia;
        $comentario="Obtenemos cargos/habonos de una habitacion en casa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }

      function estadoCuentaHabs(){
        $sentencia="SELECT *, hab.nombre as hab_nombre, reservacion.total as tarifa
        FROM
        cuenta
        INNER JOIN hab  ON hab.mov = cuenta.mov
        INNER JOIN movimiento as mov ON hab.mov = mov.id
        INNER JOIN reservacion ON mov.id_reservacion = reservacion.id
        where hab.estado = 1
        AND cuenta.estado =1
        AND (cuenta.abono>0 OR cuenta.cargo>0)
        order by hab.id";
        $comentario="Obtenemos cargos/habonos de una habitacion en casa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrarCuentaUsuario($id_usuario,$forma_pago){
        $sentencia="SELECT  cuenta.fecha, reservacion.id as fcasa,hab.nombre as hab_nombre, cuenta.descripcion, cuenta.cargo, cuenta.abono, usuario.usuario,
        cm.nombre as cm_nombre
        from cuenta
        inner join movimiento on cuenta.mov = movimiento.id
        left join reservacion on movimiento.id_reservacion = reservacion.id
        left join hab on movimiento.id_hab = hab.id
        inner join usuario on cuenta.id_usuario = usuario.id
        left join cuenta_maestra as cm on cuenta.mov = cm.mov
        where cuenta.id_usuario= $id_usuario
        and cuenta.forma_pago = $forma_pago
        and cuenta.estado =1
        and (cuenta.abono >0) 
        and (from_unixtime(cuenta.fecha + 3600,'%Y-%m-%d') = CURRENT_DATE())
        order by cuenta.forma_pago , cuenta.fecha asc" ;
        $comentario="Mostrar los cargos de todas las habitaciones por usuario";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      /*RESUMEN DE TRANSACCIONES*/
      function mostrarCargos($id_usuario){
        $sentencia="SELECT *, hab.id as hab_id ,hab.nombre as hab_nombre from cuenta
        LEFT join hab on hab.mov = cuenta.mov
        where cuenta.estado =1
        AND cuenta.id_usuario= $id_usuario
        AND hab.estado = 1
        AND cuenta.estado = 1
        AND cuenta.cargo > 0
        order by hab.id , cuenta.fecha asc";
        $comentario="Mostrar los cargos de todas las habitaciones por usuario";
        // echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrarCargosMaestra($id_usuario){
        $sentencia="SELECT cuenta.descripcion as concepto, cm.id as maestra_id, cm.nombre as maestra_nombre, cuenta.cargo, cuenta.descripcion, cuenta.fecha
        from cuenta
        INNER join cuenta_maestra as cm on cm.mov = cuenta.mov
        -- where id_usuario =$id_usuario
        and cm.estado = 1 and cuenta.estado =1
        and cuenta.cargo>0
        order by cm.id , cuenta.fecha asc" ;
        $comentario="Mostrar los cargos de todas las habitaciones por usuario";
        // echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrarAbonos($id_usuario){
        $sentencia="SELECT *, hab.id as hab_id ,hab.nombre as hab_nombre from cuenta
        LEFT JOIN movimiento ON cuenta.mov = movimiento.id
        LEFT JOIN hab ON  movimiento.id_hab = hab.id
        WHERE movimiento.motivo !='maestra'
        AND cuenta.estado=1
        AND cuenta.id_usuario= $id_usuario
        AND cuenta.abono > 0
        order by hab.id , cuenta.fecha asc";
        $comentario="Mostrar los cargos de todas las habitaciones por usuario";
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrarAbonosMaestra($id_usuario){
        $sentencia="SELECT *, cuenta.descripcion as concepto, cm.id as maestra_id, cm.nombre as maestra_nombre, cuenta.descripcion, cuenta.abono, cuenta.fecha
        from cuenta
        INNER join cuenta_maestra as cm on cm.mov = cuenta.mov
        -- where id_usuario =$id_usuario
        and cm.estado = 1 and cuenta.estado=1
        and cuenta.abono>0
        order by cm.id , cuenta.fecha asc";
        $comentario="Mostrar los cargos de todas las habitaciones por usuario";
        // echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrar_abonosPDF($mov){
        $total_abonos= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo
        FROM cuenta
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
        // echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function mostrar_cargosPDF($mov){
        $limite="";
        // if($init!=0 && $base!=0){
        //   $limite="LIMIT $init, $base";
        // }
        $total_cargos= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo,cuenta.forma_pago AS forma
        FROM cuenta
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha
        ".$limite."
        ";
        $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
        // echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }

// Mostrar los cargos que tenemos por movimiento en una habitacion, para seleccionar
function mostrar_cargos_seleccion($mov,$id_reservacion,$hab_id,$estado,$id_maestra=0,$id_usuario){
  include_once('clase_usuario.php');
  $fecha_atras="";
  $total_cargos= 0;
  $usuario = new Usuario($id_usuario);
  $auditoria_editar = $usuario->auditoria_editar;
  // echo $id_usuario;
  $sentencia = "SELECT  usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo,cuenta.forma_pago AS forma, cuenta.fecha, cuenta.cargo
  FROM cuenta
  INNER JOIN usuario ON cuenta.id_usuario = usuario.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
  $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
  $consulta= $this->realizaConsulta($sentencia,$comentario);
  //se recibe la consulta y se convierte a arreglo
  echo '<div class="table-responsive" id="tabla_cargos">
    <table class="table table-bordered table-hover">
      <thead>
        <tr class="table-primary-encabezado text-center">
        <th></th>
        <th>Fecha</th>
        <th>Cargo</th>
        <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
        </tr>
      </thead>
      <tbody>';
      $c=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $descripcion= substr($fila['concepto'], 0, 17);
          $largo= strlen($fila['concepto']);
          if($fecha_atras!= date('Y-m-d',$fila['fecha'])) {
            if($c!=0) {
              echo '<tr>
              <td colspan="5" style="height: 2px; padding: 0; background-color: #CBE3F9;"></td>
              </tr>';
            }
        }
        $campo = "campo".$c;
        echo '<tr class="fuente_menor text-center">
        <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos"  id="'.$campo.'" </td>
        <td>'.$fila['concepto'].'</td>
        <td>'.date("d-m-Y",$fila['fecha']).'</td>
        <td>$'.number_format($fila['cargo'], 2).'</td>
        </tr>';
          $fecha_atras = date('Y-m-d',$fila['fecha']);
          $c++;
        }
        echo '
      </tbody>
    </table>
  </div>';
  return $total_cargos;
}

 // Mostramos los abonos que tenemos por movimiento en una habitacion
function mostrar_abonos_seleccion($mov,$id_reservacion,$hab_id,$estado,$id_maestra=0){
  $fecha_atras="";
  $total_abonos= 0;
  $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo
  FROM cuenta
  INNER JOIN usuario ON cuenta.id_usuario = usuario.id
  INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
  $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
  //echo $sentencia;
  //echo $id;
  $consulta= $this->realizaConsulta($sentencia,$comentario);
  echo '<div class="table-responsive" id="tabla_abonos">
    <table class="table table-bordered table-hover">
      <thead>
        <tr class="table-primary-encabezado text-center">
        <th></th>
        <th>Descripción</th>
        <th>Fecha</th>
        <th>Abono</th>
        <th>Forma Pago</th>
        </tr>
      </thead>
      <tbody>';
        $c=0;
        while ($fila = mysqli_fetch_array($consulta))
        {
          $descripcion= substr($fila['concepto'], 0, 17);
          $largo= strlen($fila['concepto']);
          if($fecha_atras!= date('Y-m-d',$fila['fecha'])) {
            if($c!=0) {
              echo '<tr>
              <td colspan="5" style="height: 2px; padding: 0; background-color: #CBE3F9;"></td>
              </tr>';
            }
        }
          echo '<tr class="fuente_menor table text-center">
          <td><input type="checkbox"> </td>
          <td>'.$fila['concepto'].'</td>
          <td>'.date("d-m-Y",$fila['fecha']).'</td>
          <td>$'.number_format($fila['abono'], 2).'</td>
          <td>'.$fila['descripcion'].'</td>
          </tr>';
          $fecha_atras = date('Y-m-d',$fila['fecha']);
          $c++;
        }
        echo '
      </tbody>
    </table>
  </div>';
  return $total_abonos;
}
      // Mostrar los cargos que tenemos por movimiento en una habitacion
      function mostrar_cargos($mov,$id_reservacion,$hab_id,$estado,$id_maestra=0,$id_usuario){
        include_once('clase_usuario.php');
        $fecha_atras="";
        $total_cargos= 0;
        $usuario = new Usuario($id_usuario);
        $auditoria_editar = $usuario->auditoria_editar;
        // echo $id_usuario;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo,cuenta.forma_pago AS forma
        FROM cuenta
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_cargos">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th></th>
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Cargo</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              </tr>
            </thead>
            <tbody>';
            $c=0;
              while ($fila = mysqli_fetch_array($consulta))
              {
                $descripcion= substr($fila['concepto'], 0, 17);
                $largo= strlen($fila['concepto']);

                if($fecha_atras!= date('Y-m-d',$fila['fecha'])) {
                  if($c!=0) {
                    echo '<tr>
                    <td colspan="5" style="height: 2px; padding: 0; background-color: #CBE3F9;"></td>
                    </tr>';
                  }
              }
                if($fila['edo'] == 1){
                  $total_cargos= $total_cargos + $fila['cargo'];
                  if($descripcion == 'Total reservacion'){
                    echo '<tr class="fuente_menor text-center">
                    <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos"> </td>
                    ';
                    if($largo > 17){
                      echo '<td>Total suplementos*</td>';
                    }else{
                      echo '<td>Total suplementos</td>';
                    }
                    echo '<td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['cargo'], 2).'</td>
                    <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['cargo'].','.$id_maestra.','.$mov.')" style="font-size: 12px;"> 
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>
                      Editar
                    </button></td>
                    </tr>';
                  }else{
                    if($descripcion=="Cargo por noche" && $auditoria_editar>0){
                      echo '<tr class="fuente_menor text-center">
                      <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos"> </td>
                      <td>'.$fila['concepto'].'</td>
                      <td>'.date("d-m-Y",$fila['fecha']).'</td>
                      <td>$'.number_format($fila['cargo'], 2).'</td>
                      <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['cargo'].','.$id_maestra.','.$mov.')" style="font-size: 12px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                            Editar
                        </button></td>
                      </tr>';
                      echo '';
                    }elseif($descripcion!="Cargo por noche"){
                      echo '<tr class="fuente_menor text-center">
                      <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos"> </td>
                      <td>'.$fila['concepto'].'</td>
                      <td>'.date("d-m-Y",$fila['fecha']).'</td>
                      <td>$'.number_format($fila['cargo'], 2).'</td>
                      <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['cargo'].','.$id_maestra.','.$mov.')" style="font-size: 12px;"> 
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                      </svg>
                      Editar
                      </button>
                      </td>
                      </tr>';
                      echo '';
                    }else{
                      echo '<tr class="fuente_menor table text-center">
                      <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos"> </td>
                      <td>'.$fila['concepto'].'</td>
                      <td>'.date("d-m-Y",$fila['fecha']).'</td>
                      <td>$'.number_format($fila['cargo'], 2).'</td>
                      <td></td>
                      </tr>';
                    }
                  }
                }else{
                  if($auditoria_editar>0){
                    echo '<tr class="fuente_menor text-center">
                    <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos"> </td>
                    <td>'.$fila['concepto'].'</td>
                    <td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['cargo'], 2).'</td>
                    <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['cargo'].','.$id_maestra.','.$mov.')" style="font-size: 12px;"> 
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                          </svg>
                          Editar
                    </button></td>
                    </tr>';
                    echo '';
                  }else{
                    echo '<tr class="fuente_menor table text-center">
                    <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_cargos" </td>
                    <td>'.$fila['concepto'].'</td>
                    <td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['cargo'], 2).'</td>
                    <td></td>
                    </tr>';
                  }
                }
                $fecha_atras = date('Y-m-d',$fila['fecha']);
                $c++;
              }
              echo '
            </tbody>
          </table>
        </div>';
        return $total_cargos;
      }
      // Mostramos los abonos que tenemos por movimiento en una habitacion
      function mostrar_abonos($mov,$id_reservacion,$hab_id,$estado,$id_maestra=0){
        $fecha_atras="";
        $total_abonos= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo
        FROM cuenta
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
        //echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        echo '<div class="table-responsive" id="tabla_abonos">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>
                <span data-toggle="tooltip" data-placement="top" title="Por favor, selecciona los abonos que deseas incluir en la factura.">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                  <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
              </span>
              </th>
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Abono</th>
              <th>Forma Pago</th>
              <th>Observaciones</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              </tr>
            </thead>
            <tbody>';
              $c=0;
              while ($fila = mysqli_fetch_array($consulta))
              {
                $descripcion= substr($fila['concepto'], 0, 17);
                $largo= strlen($fila['concepto']);
                if($fecha_atras!= date('Y-m-d',$fila['fecha'])) {
                  if($c!=0) {
                    echo '<tr>
                    <td colspan="6" style="height: 2px; padding: 0; background-color: #CBE3F9;"></td>
                    </tr>';
                  }
              }
              include_once('clase_ticket.php');
              //var_dump($fila);
                  $total_abonos= $total_abonos + $fila['abono'];
                  if($descripcion == 'Total reservacion'){
                    echo '<tr class="fuente_menor text-center">';
                    if($largo > 17){
                      echo '<td>Pago al reservar*</td>';
                    }else{
                      echo '<td>Pago al reservar</td>';
                    }
                    echo '<td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['abono'], 2).'</td>
                    <td>'.$fila['descripcion'].'</td>
                    <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_abonos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['abono'].','.$id_maestra.','.$mov.')" style="font-size: 12px;"> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg> 
                          Editar
                        </button></td>
                    </tr>';
                  }else{
                    $Tickets= NEW Ticket(0);
                    //echo $fila['id_ticket'];
                    $estado_facturacion=$Tickets->saber_estado_facturados($fila['id_ticket']);
                    //$estado_facturacion=$estado_facturacion->fetch_assoc();
                    //echo($estado_facturacion);
                    if($estado_facturacion==0){
                      echo '<tr class="fuente_menor text-center">
                      <td><input type="checkbox"  data-cuentaid='.$fila['ID'].' class="color_black campos_abonos " id="leer_check_'.+$c.'"> 
                          <input class="d-none" type="number" id="leer_id_'.+$c.'" value='.$fila['id_ticket'].'>
                          <input class="d-none" type="number" id="leer_mov_'.+$c.'" value='.$fila['mov'].'>
                          <p class="ticket_info_p ticket_info_n"><input class="d-none" type="number" id="leer_tipo_'.+$c.'" value="1"/></p>
                      </td>
                      <td>'.$fila['concepto'].'</td>
                      <td>'.date("d-m-Y",$fila['fecha']).'</td>
                      <td>$'.number_format($fila['abono'], 2).'
                          <input class="d-none" type="number" id="leer_total_'.+$c.'" value='.$fila['abono'].' >
                      </td>
                      <td>'.$fila['descripcion'].'</td>
                      <td>'.$fila['observacion'].'</td>
                      <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_abonos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['abono'].','.$id_maestra.','.$mov.')" style="font-size: 12px;"> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                            Editar
                      </button></td>
                      </tr>';
                    }else{
                      echo '<tr class="fuente_menor text-center">
                      <td><input type="checkbox" disabled  data-cuentaid='.$fila['ID'].' class="color_black campos_abonos " id="leer_check_'.+$c.'"> 
                          <input class="d-none" type="number" id="leer_id_'.+$c.'" value='.$fila['id_ticket'].'>
                      </td>
                      <td>'.$fila['concepto'].'</td>
                      <td>'.date("d-m-Y",$fila['fecha']).'</td>
                      <td>$'.number_format($fila['abono'], 2).'
                          <input class="d-none" type="number" id="leer_total_'.+$c.'" value='.$fila['abono'].' >
                      </td>
                      <td>'.$fila['descripcion'].'</td>
                      <td>'.$fila['observacion'].'</td>
                      <td><button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_abonos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['abono'].','.$id_maestra.','.$mov.')" style="font-size: 12px;"> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                              <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                              <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                            </svg>
                            Editar
                          </button>
                        </td>
                      </tr>';
                    }
                  }
                
                $fecha_atras = date('Y-m-d',$fila['fecha']);
                $c++;
              }
              echo '
            </tbody>
            <input class="d-none" type="number" id="leer_iteraciones" value='.$c.' readonly>
            <input class="d-none" type="number" id="leer_facturacion" value="0" readonly>
          </table>
        </div>
        ';
        return $total_abonos;
      }
      // Mostrar la diferencia existente entre los cargos y los abonos que tenemos por movimiento en una habitacion
      function mostrar_faltante($mov){
        $total_abonos= 0;
        $total_faltante= 0;
        $total_cargos= $this->mostrar_total_cargos($mov);
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo
        FROM cuenta
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          //if($fila['edo'] == 1){
            $total_abonos= $total_abonos + $fila['abono'];
          //}
        }
        //echo $sentencia;
        // Obtenemos la diferencia existente entre los cargos y los abonos
        //$total_faltante= $total_cargos - $total_abonos;
        $total_faltante= $total_abonos - $total_cargos;
        return $total_faltante;
      }
      // Mostrar la cantidad total de cargos que tenemos por movimiento en una habitacion
      function mostrar_total_cargos($mov){
        $total_cargos= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo,cuenta.forma_pago AS forma
        FROM cuenta
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 AND cuenta.estado != 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          //if($fila['edo'] == 1){
            $total_cargos= $total_cargos + $fila['cargo'];
          //}
        }
       // echo $sentencia;
        return $total_cargos;
      }
      // Cambiar de habitacion el monto en estado de cuenta
      function cambiar_hab_monto($mov,$id){
        $sentencia = "SELECT * FROM cuenta WHERE id = $id AND cuenta.estado != 0 ";
        //echo $sentencia;
        $id_usuario= 0;
        $descripcion= '';
        $fecha= 0;
        $forma_pago= 0;
        $cargo= 0;
        $abono= 0;
        $comentario="Obtenemos los datos de la correspondiente cuenta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $id_usuario= $fila['id_usuario'];
          $descripcion= $fila['descripcion'];
          $fecha= $fila['fecha'];
          $forma_pago= $fila['forma_pago'];
          $cargo= $fila['cargo'];
          $abono= $fila['abono'];
        }
        $descripcion= substr($descripcion, 0, 17);
        if($descripcion == 'Total reservacion'){
          // Para poder cambiar de lugar el cargo o abono de una reservacion se divide en dos
          $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
          VALUES ('$id_usuario', '$mov', 'Total suplementos', '$fecha', '$forma_pago', '$cargo', '0', '1');";
          $comentario="Guardamos la cuenta en la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
          VALUES ('$id_usuario', '$mov', 'Pago al reservar', '$fecha', '$forma_pago', '0', '$abono', '1');";
          $comentario="Guardamos la cuenta en la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          // Despues de dividir la cuenta se inactiva
          $sentencia = "UPDATE `cuenta` SET
            `estado` = '0'
            WHERE `id` = '$id';";
          //echo $sentencia ;
          $comentario="Poner estado de una cuenta como inactivo";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }else{
          $sentencia = "UPDATE `cuenta` SET
            `mov` = '$mov'
            WHERE `id` = '$id';";
          //echo $sentencia ;
          $comentario="Cambiar de habitacion el monto en estado de cuenta dentro de la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        }
      }
      // Cambiar de habitacion el monto en estado de cuenta
      function cambiar_hab_cuentas_seleccionadas($mov_hab,$id_cuenta){
        $sentencia = "SELECT * FROM cuenta WHERE id = $id_cuenta AND cuenta.estado != 0  ORDER BY fecha";
        //echo $sentencia;
        $id= 0;
        $descripcion= '';
        $comentario="Obtenemos los datos de la correspondiente cuenta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $id= $fila['id'];
          $descripcion= $fila['descripcion'].'*';// Total reservacion
          $this->cambiar_cuentas($id,$mov_hab,$descripcion);
        }
      }
      // Cambiar de habitacion el monto en estado de cuenta
      function cambiar_hab_cuentas($mov_hab,$mov){
        $sentencia = "SELECT * FROM cuenta WHERE mov = $mov AND cuenta.estado != 0  ORDER BY fecha";
        //echo $sentencia;
        $id= 0;
        $descripcion= '';
        $comentario="Obtenemos los datos de la correspondiente cuenta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $id= $fila['id'];
          $descripcion= $fila['descripcion'].'*';// Total reservacion
          $this->cambiar_cuentas($id,$mov_hab,$descripcion);
        }
      }
      // Editar una cuenta proveniente de una reservacion
      function cambiar_cuentas($id,$mov_hab,$descripcion){
        $sentencia = "UPDATE `cuenta` SET
            `mov` = '$mov_hab',
            `descripcion` = '$descripcion'
            WHERE `id` = '$id';";
          //echo $sentencia ;
          $comentario="Cambiar de habitacion el monto en estado de cuenta dentro de la base de datos";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Resumen del dia actual
      function resumen_actual($ocupadas,$disponibles,$salidas,$usuario_id,$preasignadas){
        // $preasignadas= 0;
        $total_adultos= 4;
        $total_niños= 0;
        $total_cargos= $this->saber_total_cargos($usuario_id);
        $total_abonos= $this->saber_total_abonos($usuario_id);
        $total_cargos= number_format($total_cargos, 2);
        $total_abonos= number_format($total_abonos, 2);
        echo '
          <p class="footerContainerText">
            <strong>Total Ocupadas:</strong> '.$ocupadas.'
          </p>
          <div class="footerDividor"></div>
          <p class="footerContainerText">
          <strong>Total Disponibles:</strong> '.$disponibles.'
          </p>
          <div class="footerDividor"></div>
          <p class="footerContainerText">
          <strong>Total Preasignadas:</strong> '.$preasignadas.'
          </p>
          <div class="footerDividor"></div>
          <p class="footerContainerText">
          <strong>Total Salidas:</strong> '.$salidas.'
          </p>
          <div class="footerDividor"></div>
          <p class="footerContainerText">
          <strong>Total Cargos:</strong> $'.$total_cargos.'
          </p>
          <div class="footerDividor"></div>
          <p class="footerContainerText">
            <strong>Total Abonos:</strong> $'.$total_abonos.'
          </p>
        ';
      }
      //Obtener el total de reservaciones preasignadas.
      // Obtener el total de cargos del dia actual
      function saber_total_cargos($usuario_id){
        $cargos=0;
        $fecha_actual= time();
        $dia_actual= date("d-m-Y",$fecha_actual);
        $dia_actual= strtotime($dia_actual);
        $sentencia = "SELECT * FROM cuenta WHERE fecha >= $dia_actual AND id_usuario = $usuario_id AND estado = 1 AND estado!=2";
        // echo $sentencia;
        $comentario="Obtener el total de cargos del dia actual";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $cargos= $cargos + $fila['cargo'];
        }
        return $cargos;
      }
      // Obtener el total de abonos del dia actual
      function saber_total_abonos($usuario_id){
        $abonos=0;
        $fecha_actual= time();
        $dia_actual= date("d-m-Y",$fecha_actual);
        $dia_actual= strtotime($dia_actual);
        $sentencia = "SELECT * FROM cuenta WHERE fecha >= $dia_actual AND id_usuario = $usuario_id AND estado = 1";
        $comentario="Obtener el total de abonos del dia actual";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $abonos= $abonos + $fila['abono'];
        }
        return $abonos;
      }
      function reservacion_garantia($usuario_id,$id_movimiento,$forma_pago,$total_pago){
        $fecha=time();
        $id_cuenta= 0;
        //Se guarda como cuenta el cargo del total suplementos y como abono del total pago de la reservacion
        $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
        VALUES ('$usuario_id', '$id_movimiento', 'Pago al reservar', '$fecha', '$forma_pago', 0, '$total_pago', '1');";
        $comentario="Se guarda como cuenta el cargo del total suplementos y como abono del total pago en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id_cuenta= $this->ultima_insercion();
        return $id_cuenta;
      }
      function reservacion_cuenta($usuario_id,$id_movimiento,$forma_pago,$total_suplementos,$total_pago){
        $fecha=time();
        $id_cuenta= 0;
        //Se guarda como cuenta el cargo del total suplementos y como abono del total pago de la reservacion
        $sentencia = "INSERT INTO `cuenta` (`id_usuario`, `mov`, `descripcion`, `fecha`, `forma_pago`, `cargo`, `abono`, `estado`)
        VALUES ('$usuario_id', '$id_movimiento', 'Total reservacion', '$fecha', '$forma_pago', '$total_suplementos', '$total_pago', '1');";
        $comentario="Se guarda como cuenta el cargo del total suplementos y como abono del total pago en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $id_cuenta= $this->ultima_insercion();
        return $id_cuenta;
      }
      // Obtener la ultima cuenta ingresada
      function ultima_insercion(){
        $sentencia= "SELECT id FROM cuenta ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener la ultima cuenta ingresada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $id= $fila['id'];
        }
        return $id;
      }
      function obtener_id_pago(){
        $sentencia= "SELECT id FROM forma_pago WHERE descripcion LIKE '%efectivo%'   ORDER BY id DESC LIMIT 1";
        $id= 0;
        $comentario="Obtener la ultima cuenta ingresada";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $id= $fila['id'];
        }
        return $id;
      }
  }
?>