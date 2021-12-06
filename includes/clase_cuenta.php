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
      // Editar el cargo de una cuenta
      function editar_cargo($id,$cargo){
        $sentencia = "UPDATE `cuenta` SET
            `cargo` = '$cargo'
            WHERE `id` = '$id';";
        //echo $sentencia ;
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
      // Borrar una cuenta
      function borrar_cuenta($id,$descripcion,$monto){
        $descripcion= substr($descripcion, 0, 17);
        if($descripcion == 'Total reservacion'){
          $sentencia = "SELECT * FROM cuenta WHERE id = $id AND estado = 1";
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
          $suma_abonos= $suma_abonos + ($abono= $fila['abono']);
        }
        return $suma_abonos;
      }
      // Mostrar los cargos que tenemos por movimiento en una habitacion
      function mostrar_cargos($mov,$id_reservacion,$hab_id,$estado){
        $total_cargos= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo    
        FROM cuenta 
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id 
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo 
        echo '<div class="table-responsive" id="tabla_cargos">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Cargo</th>
              <th>Forma Pago</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              </tr>
            </thead>
            <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                $descripcion= substr($fila['concepto'], 0, 17);
                $largo= strlen($fila['concepto']);
                if($fila['edo'] == 1){
                  $total_cargos= $total_cargos + $fila['cargo'];
                  if($descripcion == 'Total reservacion'){
                    echo '<tr class="fuente_menor text-center">';
                    if($largo > 17){
                      echo '<td>Total suplementos*</td>';
                    }else{
                      echo '<td>Total suplementos</td>';
                    }
                    echo '<td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['cargo'], 2).'</td> 
                    <td>'.$fila['descripcion'].'</td>
                    <td><button class="btn btn-outline-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['cargo'].')"> 🔧</button></td>
                    </tr>';
                  }else{
                    echo '<tr class="fuente_menor text-center">
                    <td>'.$fila['concepto'].'</td>
                    <td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['cargo'], 2).'</td> 
                    <td>'.$fila['descripcion'].'</td>
                    <td><button class="btn btn-outline-primary" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_cargos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['cargo'].')"> 🛠️</button></td>
                    </tr>';
                  }
                }else{
                  if($descripcion != 'Total reservacion'){
                    echo '<tr class="fuente_menor table-secondary text-center">
                    <td>'.$fila['concepto'].'</td>
                    <td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['cargo'], 2).'</td> 
                    <td>'.$fila['descripcion'].'</td>
                    <td></td>
                    </tr>';
                  }
                }
              }
              echo '
            </tbody>
          </table>
        </div>';
        return $total_cargos;
      }
      // Mostramos los abonos que tenemos por movimiento en una habitacion
      function mostrar_abonos($mov,$id_reservacion,$hab_id,$estado){
        $total_abonos= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo   
        FROM cuenta 
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id 
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
        //echo $sentencia;
        //echo $id;
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        echo '<div class="table-responsive" id="tabla_abonos">
          <table class="table table-bordered table-hover">
            <thead>
              <tr class="table-info-encabezado text-center">
              <th>Descripción</th>
              <th>Fecha</th>
              <th>Abono</th>
              <th>Forma Pago</th>
              <th><span class=" glyphicon glyphicon-cog"></span> Herramientas</th>
              </tr>
            </thead>
            <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                $descripcion= substr($fila['concepto'], 0, 17);
                $largo= strlen($fila['concepto']);
                if($fila['edo'] == 1){
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
                    <td><button class="btn btn-outline-success" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_abonos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['abono'].')"> ⚙️</button></td>
                    </tr>';
                  }else{
                    echo '<tr class="fuente_menor text-center">
                    <td>'.$fila['concepto'].'</td>
                    <td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['abono'], 2).'</td> 
                    <td>'.$fila['descripcion'].'</td>
                    <td><button class="btn btn-outline-success" href="#caja_herramientas" data-toggle="modal" onclick="herramientas_abonos('.$fila['ID'].','.$hab_id.','.$estado.','.$fila['id_usuario'].','.$fila['abono'].')"> 🛠️</button></td>
                    </tr>';
                  }
                }else{
                  if($descripcion != 'Total reservacion'){
                    echo '<tr class="fuente_menor table-secondary text-center">
                    <td>'.$fila['concepto'].'</td>
                    <td>'.date("d-m-Y",$fila['fecha']).'</td>
                    <td>$'.number_format($fila['abono'], 2).'</td> 
                    <td>'.$fila['descripcion'].'</td>
                    <td></td>
                    </tr>';
                  }
                }
              }
              echo '
            </tbody>
          </table>
        </div>';
        return $total_abonos;
      }
      // Mostrar la diferencia existente entre los cargos y los abonos que tenemos por movimiento en una habitacion
      function mostrar_faltante($mov){
        $total_cargos= 0;
        $total_abonos= 0;
        $total_faltante= 0;
        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo    
        FROM cuenta 
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id 
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.cargo > 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los cargos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila['edo'] == 1){
            $total_cargos= $total_cargos + $fila['cargo'];
          }
        }

        $sentencia = "SELECT *,usuario.usuario,cuenta.descripcion AS concepto,cuenta.id AS ID,cuenta.estado AS edo   
        FROM cuenta 
        INNER JOIN usuario ON cuenta.id_usuario = usuario.id 
        INNER JOIN forma_pago ON cuenta.forma_pago = forma_pago.id WHERE cuenta.mov = $mov AND cuenta.abono > 0 ORDER BY cuenta.fecha";
        $comentario="Mostrar los abonos que tenemos por movimiento en una habitacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          if($fila['edo'] == 1){
            $total_abonos= $total_abonos + $fila['abono'];
          }
        }

        // Obtenemos la diferencia existente entre los cargos y los abonos
        //$total_faltante= $total_cargos - $total_abonos;
        $total_faltante= $total_abonos - $total_cargos;
        return $total_faltante;
      }
      // Cambiar de habitacion el monto en estado de cuenta
      function cambiar_hab_monto($mov,$id){
        $sentencia = "SELECT * FROM cuenta WHERE id = $id AND estado = 1";
        //echo $sentencia;
        $id_usuario= 0;
        $descripcion= '';
        $fecha= 0;
        $forma_pago= 0;
        $cargo= 0;
        $abono= 0;
        $comentario="Obtenemos los datos de la correspondiente cuenta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
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
      function cambiar_hab_cuentas($mov_hab,$mov){
        $sentencia = "SELECT * FROM cuenta WHERE mov = $mov AND estado = 1 ORDER BY fecha";
        //echo $sentencia;
        $id= 0;
        $descripcion= '';
        $comentario="Obtenemos los datos de la correspondiente cuenta";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
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
             
  }
?>