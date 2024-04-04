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
      function mostrar_tipoHab(){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY id";
        $comentario="Mostrar los nombres de las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        $nombres = [];
        while ($fila = mysqli_fetch_array($consulta))
        {
          array_push($nombres,$fila['nombre']);
        }
        return $nombres;
      }
      // Guardar la habitacion
      function guardar_hab($nombre,$tipo,$comentario){
        $sentencia = "INSERT INTO `hab` (`nombre`, `tipo`, `mov`, `comentario`, `estado`, `cargo_noche`, `estado_hab`)
        VALUES ('$nombre', '$tipo', '0', '$comentario', '0', '0', '1');";
        $comentario="Guardamos la habitacion en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo ('NO');
        }else{
          echo ('consulta_no_realizada');
        }
      }
      function obtener_habitaciones(){
        $sentencia = "SELECT * FROM `hab` WHERE 1;";
        $comentario="sacamos todas las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function obtener_tipo_habitaciones($id){
        $sentencia = "SELECT estado FROM `estados_hab_colores` WHERE id='$id';";
        $comentario="sacamos todas las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $estado=$fila['estado'];
        }
        return $estado;
      }
      function obtener_estado_interno($mov){
        $sentencia = "SELECT * FROM `movimiento` WHERE id =$mov LIMIT 1;";
        $comentario="sacamos el estado interno";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $estado=$fila['estado_interno'];
        }
        return $estado;
      }
      function obtener_fecha_entrada_salida($mov){
        $sentencia = "SELECT * FROM `movimiento` WHERE id ='$mov' LIMIT 1;";
        $comentario="sacamos fecha de entrad y salida";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function obtener_estado_reservacion($id){
        $id_reservacion="";
        $tiempoInicioDia = strtotime('today midnight');

        $sentencia = "SELECT * FROM `movimiento` WHERE `id_hab` ='$id' AND `inicio_hospedaje`='$tiempoInicioDia'  LIMIT 1;";
        $comentario="sacamos el estado interno";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila){
            $id_reservacion=$fila['id_reservacion'];
          }
        }
        return $id_reservacion;
      }
      function obtener_garantia_reservacion($id){
        $sentencia = "SELECT * FROM `reservacion` WHERE `id`='$id'  LIMIT 1;";
        $comentario="sacamos el estado interno";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function obtener_huesped($mov){
        $nombre="";
        $huesped="";
        $tiempoMedianoche = strtotime('today midnight');
        $sentencia = "SELECT `id_huesped` FROM `movimiento` WHERE id =$mov AND '$tiempoMedianoche'>`fin_hospedaje` LIMIT 1;";
        $comentario="sacamos el id del huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $huesped=$fila['id_huesped'];
        }
        if ($huesped!=""){
          $sentencia = "SELECT `nombre`, `apellido` FROM `huesped` WHERE `id`='$huesped' LIMIT 1;";
          $comentario="sacamos el nombre y apellido del huesped";
          $consulta2= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta2))
          {
            $nombre=$fila['nombre']." ".$fila['apellido'];
          }
        }
        return $nombre;
      }
      function mostrar_tipo(){
        $sentencia = "SELECT *
        FROM tipo_hab
        WHERE estado = 1 ORDER BY id";// nombre
        $comentario="Mostrar los tipos de habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        echo '<option value="">Seleccionar</option>';
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
      }
      function mostrar_hab_option($hab_id=0){
        $where="AND hab.estado = 0";
        if($hab_id!=0){
          $where="AND hab.estado = 1";
        }
        $where="";
        $sentencia = "SELECT *,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado_hab  = 1 ".$where." ORDER BY hab.id";// nombre
        $comentario="Mostrar las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($hab_id == $fila['ID']){
            echo '<option selected data-habid="'.$fila['ID'].'" data-habtipo="'.$fila['tipo'].'" value="'.$fila['nom'].'">'.$fila['nom'].'</option>';
          }else{
            echo '<option data-habid="'.$fila['ID'].'" data-habtipo="'.$fila['tipo'].'" value="'.$fila['nom'].'">'.$fila['nom'].'</option>';
          }
        }
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
        echo '
        <div class="inputs_form_container justify-content-start">
          <div class="form-floating">
            <button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_hab('.$id.')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-add" viewBox="0 0 16 16">
                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h4a.5.5 0 1 0 0-1h-4a.5.5 0 0 1-.5-.5V7.207l5-5 6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293z"/>
                <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0m-3.5-2a.5.5 0 0 0-.5.5v1h-1a.5.5 0 0 0 0 1h1v1a.5.5 0 1 0 1 0v-1h1a.5.5 0 1 0 0-1h-1v-1a.5.5 0 0 0-.5-.5"/>
              </svg>
              Agregar
            </button>
          </div>
        </div>
 
        <div class="table-responsive" id="tabla_tipo">
        <table class="table  table-hover" >
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
        if($consulta){
          echo ('NO');
        }else{
          echo ('consulta_no_realizada');
        }
      }
      // Borrar una habitacion
      function borrar_hab($id){
        $sentencia = "UPDATE `hab` SET
        `estado_hab` = '0',
        ultimo_mov = UNIX_TIMESTAMP()
        WHERE `id` = '$id';";
        $comentario="Poner estado de una habitacion como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if($consulta){
          echo ('NO');
        }else{
          echo ('consulta_no_realizada');
        }
      }
      // Obtengo los nombres de las habitaciones
      function mostrar_hab(){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY id";
        $comentario="Mostrar los nombres de las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
        }
      }
      // Obtengo los nombres de las habitaciones a editar en base a una tarifa
      function mostrar_hab_editarTarifa($tarifa){
        $tipo_hab=0;
        $sentencia = "SELECT tipo FROM tarifa_hospedaje
        WHERE id=$tarifa
        AND estado = 1 ORDER BY id";
        $comentario="Mostrar los nombres de las habitaciones a editar";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $tipo_hab = $fila['tipo'];
        }
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY id";
        $comentario="Mostrar los nombres de las habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($tipo_hab == $fila['id']){
            echo '<option selected value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
          }else{
            echo '<option value="'.$fila['id'].'">'.$fila['nombre'].'</option>';
          }
        }
      }
      // Obtengo los nombres de las habitaciones a editar
      function mostrar_hab_editar($id){
        $sentencia = "SELECT * FROM tipo_hab WHERE estado = 1 ORDER BY id";
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
      //Mostrar las reservas disponibles para asignar a la habitación seleccionada.
      function select_hab_reserva($hab_id,$estado,$nuevo_estado,$hab_tipo){
        // Seleccionar recamarera
      if($nuevo_estado == 1){
        $nivel= 3;
      }else{
        $nivel= $nuevo_estado;
      }
      // echo $hab_id . "|" . $estado ."|".$nuevo_estado;
      if($nuevo_estado == 2){
        $nivel = 3;
      }
      $hoy=date('Y-m-d');
      $sentencia = "SELECT reservacion.id, movimiento.id_hab,movimiento.id as mov
      FROM reservacion
      INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion
      WHERE tipo_hab = '$hab_tipo' AND from_unixtime(fecha_entrada + 3600,'%Y-%m-%d') = '$hoy' AND reservacion.estado_interno='garantizada' AND estado=1";
      $comentario="Asignación de usuarios a la clase usuario funcion constructor";
      // echo $sentencia . "|" . $nuevo_estado;
      $consulta= $this->realizaConsulta($sentencia,$comentario);
      //se recibe la consulta y se convierte a arreglo
      $contador_row = mysqli_num_rows($consulta);
      if($contador_row==0){
        echo '¡No existe ninguna reservación disponible para asignar a la habitación!';
      }
      while ($fila = mysqli_fetch_array($consulta))
      {
        echo '<div class="btn_modal_herramientas btn_reservar" onclick="select_asignar_checkin('.$fila['id'].',1,'.$hab_id.','.$fila['mov'].')">';
        echo '<img  class="btn_modal_img" src="./assets/iconos_btn/btn_reservar.svg"/>';        
          echo 'Reservación: '.$fila['id'];
        echo '</div>';
     
      }
    }
      function select_hab_cambio($hab_id,$estado,$nuevo_estado,$hab_tipo){
          // Seleccionar recamarera
        if($nuevo_estado == 1){
          $nivel= 3;
        }else{
          $nivel= $nuevo_estado;
        }
        // echo $hab_id . "|" . $estado ."|".$nuevo_estado;
        if($nuevo_estado == 2){
          $nivel = 3;
        }
        $sentencia = "SELECT * FROM hab WHERE estado = 0 AND tipo = '$hab_tipo' AND estado_hab=1 ORDER BY hab.id";
        $comentario="Asignación de usuarios a la clase usuario funcion constructor";
        // echo $sentencia . "|" . $nuevo_estado;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        $contador_row = mysqli_num_rows($consulta);
        if($contador_row==0){
          echo '¡No existe ninguna habitación disponible para hacer el cambio de habitación!';
        }
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="btn_modal_herramientas btn_cambiar_hab " onclick="hab_cambio('.$hab_id.','.$estado.','.$fila['id'].')">';
          echo '<img  class="btn_modal_img" src="./assets/iconos_btn/house-user-solid.svg"/>';        
            echo $fila['nombre'];
        echo '</div>';
        }
      }
      //Cambiar el ultimo movimiento (Fecha)  de una habitacion (Reserva)
      function cambiohabUltimo($hab){
        $sentencia = "UPDATE `hab` SET
        ultimo_mov = UNIX_TIMESTAMP()
        WHERE `id` = '$hab';";
        $comentario="Cambiar estado de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Cambiar estado de la habitacion
      function cambiohab($hab,$mov,$estado){
        $habitaciones=[43,44,45];
        // foreach ($habitaciones as $key => $habitacion) {
          $sentencia = "UPDATE `hab` SET
          `mov` = '$mov',
          `estado` = '$estado',
          ultimo_mov = UNIX_TIMESTAMP()
          WHERE `id` = '$hab';";
          $comentario="Cambiar estado de la habitacion";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
        // }
      }
      function reactivarHab ($hab) {
        $sentencia = "UPDATE `hab` SET
        `estado` = 1
        WHERE `id` = '$hab';";
        $comentario = "Reactivar habitacion";
        $consulta = $this->realizaConsulta($sentencia,$comentario);
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
          echo '<div class="btn_modal_herramientas btn_desocupar" onclick="cambiar_hab_monto('.$fila['id'].','.$fila['mov'].','.$monto.','.$id.','.$hab_id.','.$estado.')">';
            echo '<img class="btn_modal_img" src="./assets/iconos_btn/desocupar.svg">';
            echo $fila['nombre'];
          echo '</div>';
        }
      }
      // Nos permite seleccionar una habitacion ocupada para cambiar las cuentas
      function cambiar_cuentas_hab_ocupada($hab_id,$estado,$mov,$fa){
        $sentencia = "SELECT * FROM hab WHERE id != $hab_id AND estado = 1";
        $comentario="Nos permite seleccionar una habitacion ocupada para cambiar las cuentas";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          echo '<div class="btn_modal_herramientas btn_desocupar" onclick="cambiar_hab_cuentas_seleccionadas('.$fila['id'].',\''.$fila['nombre'].'\','.$fila['mov'].','.$hab_id.','.$estado.','.$mov.')" >';
              echo '<img class="btn_modal_img" src="./assets/iconos_btn/desocupar.svg">';
              echo $fila['nombre'];
          echo '</div>';
        }
        echo '<div class="btn_modal_herramientas btn_editar" onclick="unificar_con_folio_casa('.$hab_id.','.$fa.')" >';
              echo '<img class="btn_modal_img" src="./assets/iconos_btn/list.svg">';
              echo "Unificar por folio casa";
          echo '</div>';
          
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
        $sentencia = "SELECT count(hab.id) AS cantidad,hab.estado,hab.estado_hab FROM hab WHERE hab.estado = 0 AND hab.estado_hab = 1 AND hab.tipo > 0";
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
      // Consultar disponibilidad de un tipo de habitacion para hacer check-in
      function consultar_disponibilidad($tipo_hab){
        //consultar el el tipo de habitación en base a la tarifa dada.
        $cantidad=0;
        $sentencia = "SELECT *,count(hab.id) AS cantidad,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado = 0 AND hab.tipo = $tipo_hab ORDER BY hab.id";
        $comentario="Consultar disponibilidad de un tipo de habitacion para hacer check-in";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Seleccionar habitacion a asignar reservacion para check-in
      function select_asignar_reservacion($tipo_hab,$id_reservacion,$habitaciones,$multiple,$mov=0){
        $sentencia = "SELECT *,hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab 
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.estado = 0 AND hab.estado_hab = 1 AND hab.tipo = $tipo_hab ORDER BY hab.id";
        $comentario="Seleccionar habitacion a asignar reservacion para check-in";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
            if($multiple == 0){
              echo '<div class="btn_modal_herramientas btn_limpieza " onclick="asignar_reservacion('.$fila['ID'].','.$id_reservacion.','.$habitaciones.','.$mov.')">';
            }else{
              echo '<div class="btn_modal_herramientas btn_limpieza " onclick="asignar_reservacion_multiple('.$fila['ID'].','.$id_reservacion.','.$habitaciones.')">';
            }
            echo '<img class="btn_modal_img" src="./assets/iconos_btn/bnt_ocupado.svg">';
            echo '<p>Hab: '.$fila['nom'].'</p>';
            echo '</div>';
        }
      }
      function datos_auditoria(){
        $sentencia="SELECT *,hab.id AS ID
        FROM hab
        INNER JOIN movimiento ON hab.mov = movimiento.id
        INNER JOIN reservacion ON movimiento.id_reservacion = reservacion.id WHERE hab.estado_hab = 1
        and (from_unixtime(reservacion.fecha_auditoria,'%Y-%m-%d') = CURRENT_DATE())";
        $comentario="Obtengo los datos del cargo por noche de la habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
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
                <button type="submit" class="btn btn-success btn-block margen-1" value="Aplicar" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_cargo_noche()">Aplicar</button>
              </div>
              </div>
        </div>';
        $total_final= 0;
        include_once("clase_huesped.php");
        include_once('clase_tarifa.php');
        $huesped= NEW Huesped(0);
        $tarifa= NEW Tarifa(0);
        $sentencia = "SELECT *,hab.id AS ID,hab.cargo_noche AS cargo
        FROM hab
        INNER JOIN movimiento ON hab.mov = movimiento.id
        INNER JOIN reservacion ON movimiento.id_reservacion = reservacion.id WHERE reservacion.forzar_tarifa = 0 AND hab.estado = 1 AND hab.estado_hab = 1";
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
                //$cargo_noche = $fila['cargo'];
                $cargo_noche = $this->consultar_cargo($hab_id);
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
                    $cargo= 0;
                    echo '<input class="form-check-input" type="checkbox" id="cargo_noche" onclick="cambiar_cargo_noche('.$hab_id.','.$cargo.')">';
                  }else{
                    $cargo= 1;
                    echo '<input class="form-check-input" type="checkbox" id="cargo_noche" onclick="cambiar_cargo_noche('.$hab_id.','.$cargo.')" checked>';
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
      // Consultar cargo noche de una habitacion
      function consultar_cargo($hab_id){
        $cargo_noche= 0;
        $sentencia = "SELECT cargo_noche FROM hab WHERE id = $hab_id LIMIT 1";
        $comentario="Consultar cargo noche de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $cargo_noche= $fila['cargo_noche'];
        }
        return $cargo_noche;
      }
      // Consultar el nombre del tipo de una habitacion
      function consultar_tipo($hab_id){
        $nombre= '';
        $sentencia = "SELECT hab.id AS ID,hab.nombre AS nom,tipo_hab.nombre AS habitacion
        FROM hab
        INNER JOIN tipo_hab ON hab.tipo = tipo_hab.id WHERE hab.id = $hab_id AND hab.estado_hab = 1 ORDER BY hab.id";
        $comentario="Consultar el nombre del tipo de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        while ($fila = mysqli_fetch_array($consulta))
        {
          $nombre= $fila['habitacion'];
        }
        return $nombre;
      }
      function consultar_tipos(){
        $sentencia = "SELECT `id` FROM `tipo_hab`";
        $comentario="Consultar el nombre del tipo de una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        return $consulta;
      }
      function id_tipos_habitacion($id){
        $contador=0;
        $sentencia = "SELECT id FROM `hab` WHERE `tipo`='$id'";
        $comentario="Consultar el tipo de habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $contador= $contador+1;
        }
        return $contador;
      }
      function habitaciones_ocupadas_checkin($inicio,$id){
        $checkin="checkin";
        $sentencia = "SELECT * FROM `reservacion` WHERE `tipo_hab`='$id' AND `nombre_reserva`='$checkin'";
        //echo $sentencia;
        $comentario="Consultar checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function habitaciones_reservadas($id){
        $checkin="checkin";
        $web="web";
        $sentencia = "SELECT * FROM `reservacion` WHERE `tipo_hab`='$id' AND `nombre_reserva`!='$checkin' AND `canal_reserva`!='$web' AND estado =1";
        //echo $sentencia;
        $comentario="Consultar checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function habitaciones_reservadas_web($id){
        $checkin="checkin";
        $web="web";
        $sentencia = "SELECT * FROM `reservacion` WHERE `tipo_hab`='$id' AND `nombre_reserva`!='$checkin' AND `canal_reserva`='$web' AND estado =1";
        //echo $sentencia;
        $comentario="Consultar checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function llegadas_huespedes_dia($entrada){
        $sentencia = "SELECT * FROM `reservacion` WHERE `fecha_entrada`='$entrada' AND estado =1";
        //echo $sentencia;
        $comentario="Consultar checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function salidas_huespedes_dia($salida){
        $sentencia = "SELECT * FROM `reservacion` WHERE `fecha_salida`='$salida' AND estado =1";
        //echo $sentencia;
        $comentario="Consultar checkin";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      /** Pronosticos */
       // Obtengo el total de habitaciones ocupadas
        function obtener_todas(){
        $sentencia = "SELECT * FROM hab WHERE  hab.estado_hab = 1";
        //echo $sentencia;
        $cantidad=0;
        $comentario="Obtengo el total de habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        // while ($fila = mysqli_fetch_array($consulta))
        // {
        //   $cantidad= $fila['cantidad'];
        // }
        return $consulta;
        // return $cantidad;
      }
      function fuera_servicio($actual){
        $actual = date('Y-m-d',$actual);
        $sentencia="SELECT  mov.*  FROM `hab`
        INNER JOIN movimiento as mov  on hab.mov = mov.id
        WHERE hab.estado not in (0,1,6,7,8)
        AND (from_unixtime(mov.detalle_inicio + 3600 , '%Y-%m-%d' ) >= '$actual' OR
        from_unixtime(mov.inicio_limpieza + 3600 , '%Y-%m-%d' ) >= '$actual')
        ;";
        $comentario="Obtengo el total de habitaciones";
        $cantidad=0;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      //   $cantidad=0;
      //   while ($fila = mysqli_fetch_array($consulta))
      //  {
      //    $cantidad= $fila['cantidad'];
      //  }
      //  return $cantidad;
      }
      function en_libros($actual){
        $actual = date('Y-m-d',$actual);
        $sentencia="SELECT reservacion.*  FROM reservacion LEFT JOIN tarifa_hospedaje ON reservacion.tarifa = tarifa_hospedaje.id
        INNER JOIN movimiento ON reservacion.id = movimiento.id_reservacion
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
        LEFT JOIN hab ON movimiento.id_hab = hab.id
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id
        WHERE (reservacion.estado = 1 || reservacion.estado = 2)
        AND (from_unixtime(reservacion.fecha_salida + 3600 , '%Y-%m-%d' ) >= '$actual') ORDER BY reservacion.id DESC;
        ";
        $comentario="Obtener todo en libros que sea mayor al dia actual";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
        // $cantidad=0;
        //  while ($fila = mysqli_fetch_array($consulta))
        // {
        //   $cantidad= $fila['cantidad'];
        // }
        // return $cantidad;
      }
      function llegadas_dia($actual){
        $actual = date('Y-m-d',$actual);
        $sentencia="SELECT reservacion.*
        FROM reservacion
        LEFT JOIN tarifa_hospedaje  ON reservacion.tarifa = tarifa_hospedaje.id
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id
        INNER JOIN movimiento on reservacion.id = movimiento.id_reservacion
        LEFT JOIN hab on movimiento.id_hab = hab.id
        WHERE (reservacion.estado = 1)
        AND from_unixtime(reservacion.fecha_entrada + 3600 , '%Y-%m-%d' ) >= '$actual'
        ORDER BY reservacion.id DESC;";
        $comentario="";
        //echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
        // $cantidad=0;
        // while ($fila = mysqli_fetch_array($consulta))
        // {
        //   $cantidad= $fila['cantidad'];
        // }
        // return $cantidad;
      }
      function salidas_dia($actual){
        $actual = date('Y-m-d',$actual);
        $sentencia="SELECT reservacion.*
        FROM reservacion
        LEFT JOIN tarifa_hospedaje  ON reservacion.tarifa = tarifa_hospedaje.id
        LEFT JOIN tipo_hab ON tarifa_hospedaje.tipo = tipo_hab.id
        INNER JOIN usuario ON reservacion.id_usuario = usuario.id
        INNER JOIN huesped ON reservacion.id_huesped = huesped.id
        INNER JOIN forma_pago ON reservacion.forma_pago = forma_pago.id
        INNER JOIN movimiento on reservacion.id = movimiento.id_reservacion
        LEFT JOIN hab on movimiento.id_hab = hab.id
        WHERE (reservacion.estado = 1 || reservacion.estado=2)
        AND movimiento.finalizado  = 0
        AND from_unixtime(reservacion.fecha_salida + 3600 , '%Y-%m-%d' ) >= '$actual'
        ORDER BY reservacion.id DESC;";
        $comentario="";
        // echo $sentencia;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
        // $cantidad=0;
        // while ($fila = mysqli_fetch_array($consulta))
        // {
        //   $cantidad= $fila['cantidad'];
        // }
        // return $cantidad;
      }
      function numero_de_hab(){
        $sentencia = "SELECT hab.id, hab.nombre, tipo_hab.color  FROM hab LEFT JOIN tipo_hab ON hab.tipo= tipo_hab.id WHERE  estado_hab = '1'";
        $comentario="Obtengo el total de habitaciones";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
  }
?>