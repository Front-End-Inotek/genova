<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('consulta.php');
  class Huesped extends ConexionMYSql{
      public $id;
      public $nombre;
      public $apellido;
      public $direccion;
      public $ciudad;
      public $estado;
      public $codigo_postal;
      public $telefono;
      public $correo;
      public $contrato;
      public $cupon;
      public $preferencias;
      public $comentarios;
      public $titular_tarjeta;
      public $tipo_tarjeta;
      public $numero_tarjeta;
      public $vencimiento_mes;
      public $vencimiento_ano;
      public $cvv;
      public $visitas;
      public $estado_huesped;
      public $estado_tarjeta;
      public $nombre_tarjeta;
      public $empresa;
      public $voucher;
      public $estado_credito;
      public $limite_credito;
      public $indole_tarjeta;
      // Constructor
      function __construct($id)
      {
        if($id==0){
          $this->id= 0;
          $this->nombre= 0;
          $this->apellido= 0;
          $this->direccion= 0;
          $this->ciudad= 0;
          $this->estado= 0;
          $this->codigo_postal= 0;
          $this->telefono= 0;
          $this->correo= 0;
          $this->contrato= 0;
          $this->cupon= 0;
          $this->preferencias= 0;
          $this->comentarios= 0;
          $this->titular_tarjeta= "";
          $this->tipo_tarjeta= 0;
          $this->numero_tarjeta= "";
          $this->vencimiento_mes= "";
          $this->vencimiento_ano= "";
          $this->cvv= "";
          $this->visitas= 0;
          $this->estado_huesped= 0;
          $this->estado_tarjeta=0;
          $this->nombre_tarjeta="";
          $this->empresa="";
          $this->voucher="";
          $this->estado_credito="";
          $this->limite_credito=0;
          $this->indole_tarjeta="";
        }else{
          $sentencia = "SELECT * FROM huesped WHERE id = $id LIMIT 1 ";
          $comentario="Obtener todos los valores de un huesped";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta)){
              $this->id= $fila['id'];
              $this->nombre= $fila['nombre'];
              $this->apellido= $fila['apellido'];
              $this->direccion= $fila['direccion'];
              $this->ciudad= $fila['ciudad'];
              $this->estado= $fila['estado'];
              $this->codigo_postal= $fila['codigo_postal'];
              $this->telefono= $fila['telefono'];
              $this->correo= $fila['correo'];
              $this->contrato= $fila['contrato'];
              $this->cupon= $fila['cupon'];
              $this->preferencias= $fila['preferencias'];
              $this->comentarios= $fila['comentarios'];
              $this->titular_tarjeta= $fila['titular_tarjeta'];
              $this->tipo_tarjeta= $fila['tipo_tarjeta'];
              $this->numero_tarjeta= $fila['numero_tarjeta'];
              $this->vencimiento_mes= $fila['vencimiento_mes'];
              $this->vencimiento_ano= $fila['vencimiento_ano'];
              $this->cvv= $fila['cvv'];
              $this->visitas= $fila['visitas'];
              $this->estado_huesped= $fila['estado_huesped'];
              $this->estado_tarjeta = $fila['estado_tarjeta'];
              $this->nombre_tarjeta=$fila['nombre_tarjeta'];
              $this->empresa=$fila['empresa'];
              $this->voucher=$fila['voucher'];
              $this->estado_credito=$fila['estado_credito'];
              $this->limite_credito=$fila['limite_credito'];
              $this->indole_tarjeta=$fila['indole_tarjeta'];
          }
        }
      }
      public function mostrar_garantia($estado_tarjeta){
        echo '
        <!--<p id="choosen-paymenttype"></p> -->
          <div class="container-fluid" >
              <form  id="form-garantia">
                <picture class="credit_card_container">
                  <img class="credit_card_svg" src="./assets/credit_card.svg" />
                </picture>
                          ';
                            if(!empty($this->numero_tarjeta)){
                              echo '
                                <div class="form-floating input_container">
                                  <input disabled class="form-control custom_input" type="text" id="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"  value="**************" maxlength="16">
                                  <input id="check_tarjeta" onchange="mostrar_tarjeta('.$this->id.')" class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                                  <label class="asterisco" for"numero_tarjeta">Numero de tarjeta</label>
                                </div>
                              ';
                              }else{
                                echo '
                                <div class="form-floating input_container">
                                  <input onchange="" type="number" name="número de tarjeta" class="form-control custom_input" id="numero_tarjeta" maxlength="20" value="'.$this->numero_tarjeta.'" required placeholder="Numero de tarjeta">
                                  <label class="asterisco" for="numero_tarjeta">Numero de tarjeta</label>
                                </div>';
                              }
                              echo '

                            <div class="inputs_form_container">
                              <div class="form-floating input_container">
                                <input  type="text" class="form-control custom_input" name="nombre en tarjeta" id="cardholder" maxlength="25" autocorrect="off" spellcheck="false" value="'.$this->titular_tarjeta.'" required placeholder="Nombre en Tarjeta">
                                <label class="asterisco" for="cardholder">Nombre en Tarjeta</label>
                              </div>
                            </div>

                            <div class="inputs_form_container">
                              <div class="form-floating input_container">
                                <input onchange="" name="tipo de tarjeta" placeholder="Mastercard, Visa, American Express, etc..." type="text" class="form-control custom_input" id="tipo" maxlength="20" value="'.$this->nombre_tarjeta.'" required>
                                <label class="asterisco" for="tipo">Tipo de tarjeta</label>
                              </div>
                            </div>

                            <div class="inputs_form_container">
                              <div class="col-12 row g-2">
                                <div class="col-md">
                                  <div class="form-floating input_container">
                                    <input type="tel" name="expira (mes)" class="form-control custom_input" id="expires-month" placeholder="MM" allowed-pattern="[0-9]" maxlength="2" value="'.$this->vencimiento_mes.'" required>
                                    <label class="asterisco" for="expires-month">Mes de expiracion</label>
                                  </div>
                                </div>
                                <div class="col-md">
                                  <div class="form-floating input_container">
                                    <input type="tel" name="expira (año)" class="form-control custom_input" id="expires-year" placeholder="YY" allowed-pattern="[0-9]" maxlength="2" value="'.$this->vencimiento_ano.'" required>
                                    <label class="asterisco" for="expires-year">Año de expiracion</label>
                                  </div>
                                </div>
                                <div class="col-md">
                                  <div class="form-floating input_container">
                                    <input type="tel" name="expira (año)" class="form-control custom_input" id="tcccv" placeholder="CCV" allowed-pattern="[0-9]" maxlength="3" value="'.$this->cvv.'" required>
                                    <label class="asterisco" for="expires-year">CCV</label>
                                  </div>
                                </div>
                              </div>
                            </div>


                            <div class="mb-2">
                              <div class="form-check">
                                <input class="form-check-input" type="radio" name="estado" value="1" id="check1">
                                <label class="form-check-label" for="check1">Pendiente de preautorizar</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="estado" value="2" id="check2">
                                  <label class="form-check-label" for="check2">Garantizada</label>
                              </div>
                              <div class="form-check">
                                  <input class="form-check-input" type="radio" name="estado" value="3" id="check3">
                                  <label class="form-check-label" for="check3">Sin garantía</label>
                              </div>
                            </div>
                            <hr/>
                            <div class="mb-2">
                              <div class="form-check">
                                <input class="form-check-input" type="radio"  id="c_abierto" value="abierto" name="credit">
                                <label class="form-check-label" for="c_abierto">Crédito abierto</label>
                              </div>
                              <div class="form-check">
                                <input class="form-check-input" type="radio"  id="c_cerrado" value="cerrado" name="credit">
                                <label class="form-check-label" for="c_cerrado">Crédito cerrado</label>
                              </div>
                            </div>

                            <div class="inputs_form_container">
                              <div class="form-floating input_container">
                                <input value="'.$this->limite_credito.'" type="number" id="limite_credito" name="limite_credito"  class="form-control custom_input"  autocomplete="off" >
                                <label for="limite_credito" class="asterisco">Límite de crédito</label>
                              </div>
                            </div>

              </form>
          </div>
      ';
      }
      function existe_vehiculo($id_huesped,$id_reserva){
        $sentencia="SELECT* FROM datos_vehiculo WHERE id_huesped=$id_huesped AND id_reserva=$id_reserva";
        $comentario="Obtenemos datos de un vehiculo";
        $comentario="Actualizando info del vehiculo huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        $datos=[];
        while ($fila = mysqli_fetch_array($consulta))
        {
          $datos= $fila;
        }
        return $datos;
      }
      function mostrar_historial_cuenta($id_huesped,$inicial,$final,$a_buscar){
        $filtro_fecha="";
        $filtro_buscar="";
        if(!empty($a_buscar)){
          $filtro_buscar=" AND (hab.nombre LIKE '%$a_buscar%' || cuenta.descripcion LIKE '%$a_buscar%')";
        }
        if(!empty($inicial) && !empty($final)){
          $inicial = strtotime($inicial);
          $final = strtotime($final);
          $filtro_fecha="AND cuenta.fecha BETWEEN $inicial AND $final";
        }
        $sentencia="SELECT *, hab.nombre as hab_nombre, reservacion.total as tarifa, cuenta.estado as estado_cuenta
        FROM
        cuenta
        INNER JOIN hab  ON hab.mov = cuenta.mov
        INNER JOIN movimiento as mov ON hab.mov = mov.id
        INNER JOIN reservacion ON mov.id_reservacion = reservacion.id
        INNER JOIN huesped on mov.id_huesped  = huesped.id
        AND (cuenta.abono>0 OR cuenta.cargo>0)
        AND huesped.id = $id_huesped
        AND cuenta.estado!=0
        ".$filtro_fecha."
        ".$filtro_buscar."
        order by cuenta.fecha desc";
        //echo $sentencia;
        $comentario="Obtenemos cargos/habonos de una habitacion en casa";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        return $consulta;
      }
      function actualizar_estado_vehiculo($id_huesped,$estado){
        $sentencia = "UPDATE `datos_vehiculo` SET
        `estado`='$estado'
        WHERE `id_huesped`='$id_huesped'";
        $comentario="Actualizando info del vehiculo huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      function actualizar_datos_vehiculo($datos){
        $id_huesped = $datos['id_huesped'];
        $usuario_id =$datos['usuario_id'];
        $matricula =$datos['matricula'];
        $marca=$datos['marca'];
        $modelo=$datos['modelo'];
        $year =$datos['year'];
        $color =$datos['color'];
        $propietario =$datos['propietario'];
        $fecha_ingreso =0;
        $fecha_salida =0;
        $observaciones =$datos['observaciones'];
        $id_reserva=$datos['id_reserva'];
        $sentencia = "UPDATE `datos_vehiculo` SET
        `id_usuario`='$usuario_id',
        `matricula`='$matricula',
        `marca`='$marca',
        `modelo`='$modelo',
        `year`='$year',
        `color`='$color',
        `propietario`='$propietario',
        `fecha_ingreso`='$fecha_ingreso',
        `fecha_salida`='$fecha_salida',
        `observaciones`='$observaciones'
        WHERE `id_huesped`='$id_huesped'";
        $comentario="Actualizando info del vehiculo huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if(!$consulta){
          echo "NO_VALIDO";
        }else{
          $logs = new Log(0);
          $logs->guardar_log($_POST['usuario_id'], "Actualizando datos vehiculo". $_POST['id_huesped']);
          echo "OK";
        }
      }
      function optener_estado_vehiculo($id_huesped){
        $estado=0;
        $sentencia = "SELECT estado FROM datos_vehiculo WHERE id_huesped = $id_huesped";
        //echo $sentencia;
        $comentario="Actualizando info del vehiculo huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta))
        {
          $estado= $fila['estado'];
        }
        return $estado;
      }
      function guardar_datos_vehiculo($datos){
        $id_huesped = $datos['id_huesped'];
        $id_reserva=$datos['id_reserva'];
        $usuario_id =$datos['usuario_id'];
        $matricula =$datos['matricula'];
        $marca=$datos['marca'];
        $modelo=$datos['modelo'];
        $year =$datos['year'];
        $color =$datos['color'];
        $propietario =$datos['propietario'];
        $fecha_ingreso =0;
        $fecha_salida =0;
        $observaciones =$datos['observaciones'];
        $sentencia="INSERT INTO `datos_vehiculo`(`id_huesped`, `id_usuario`, `id_reserva`, `matricula`, `marca`, `modelo`, `year`, `color`, `propietario`, `fecha_ingreso`, `fecha_salida`, `observaciones`) 
        VALUES ('$id_huesped','$usuario_id','$id_reserva','$matricula','$marca','$modelo','$year','$color','$propietario','$fecha_ingreso','$fecha_salida','$observaciones')";
        $comentario="Guardando info del vehiculo huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if(!$consulta){
          echo "NO_VALIDO";
        }else{
          $logs = new Log(0);
          $logs->guardar_log($_POST['usuario_id'], "Guardando datos vehiculo". $_POST['id_huesped']);
          echo "OK";
        }
      }
      function guardar_tarjeta($huesped_id,$datos_tarjeta){
        print_r($datos_tarjeta);
        $titular_tarjeta=$datos_tarjeta['nombre_tarjeta'];
        $nombre_tarjeta=$datos_tarjeta['tipo_tarjeta'];
        $tipo_tarjeta=$datos_tarjeta['forma_garantia'];
        $numero_tarjeta=$datos_tarjeta['numero_tarjeta'];
        $vencimiento_mes=$datos_tarjeta['mes_tarjeta'];
        $vencimiento_ano=$datos_tarjeta['year_tarjeta'];
        $sentencia = "UPDATE  `huesped`
        SET  titular_tarjeta = '$titular_tarjeta', estado_tarjeta = 2, nombre_tarjeta = '$nombre_tarjeta'
        , tipo_tarjeta = '$tipo_tarjeta' , numero_tarjeta = IF('$numero_tarjeta' ='', numero_tarjeta, '$numero_tarjeta'), vencimiento_mes = '$vencimiento_mes', vencimiento_ano = '$vencimiento_ano'
        WHERE id='$huesped_id'";
        $comentario="actualizamos el huesped en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if(!$consulta){
          echo "NO_VALIDO";
          exit();
        }
      }
      // Guardar el huesped
      function guardar_huesped($nombre,$apellido,$direccion,$ciudad,$estado,$codigo_postal,$telefono,$correo,$contrato,$cupon,$preferencias,$comentarios,$titular_tarjeta,$tipo_tarjeta,$numero_tarjeta,$vencimiento_mes,$vencimiento_ano,$cvv,
      $usuario_id,$pais,$empresa,$nombre_tarjeta,$estado_tarjeta,$voucher,$estado_credito,$limite_credito,$indole_tarjeta,$nombre_huesped_sin_editar,$apellido_huesped_sin_editar){
        //validaciones del huesped.
        if(empty($nombre)){
          echo "NO_DATA";
          exit();
        }
        //Revisar si el tipo de pago/tipo_tarjeta/garantia es realmente una garantía.
        if($tipo_tarjeta!=""){
          include_once('clase_forma_pago.php');
          $forma_pago = new Forma_pago($tipo_tarjeta);
          if($forma_pago!=null && $forma_pago->garantia == 1){
            $estado_tarjeta = 2; //Garantizada.
          }
        }
        if($nombre_huesped_sin_editar=="" && $apellido_huesped_sin_editar==""){
          $nombre_huesped_sin_editar=$nombre;
          $apellido_huesped_sin_editar=$apellido;
        }
        //verififca si el cliente/huesped ya existe.
        $existe = "SELECT id FROM huesped WHERE nombre = '$nombre_huesped_sin_editar' and apellido='$apellido_huesped_sin_editar'";
        $comentario = "Verificar si existe el nombre del huesped";
        $consulta_existe = $this->realizaConsulta($existe,$comentario);
        if(mysqli_num_rows($consulta_existe)==0){
          //no existe.
          $sentencia = "INSERT INTO `huesped` (`nombre`, `apellido`, `direccion`, `ciudad`, `estado`, `codigo_postal`, `telefono`, `correo`, `contrato`, `cupon`, `preferencias`, `comentarios`, `titular_tarjeta`,`tipo_tarjeta`, `numero_tarjeta`, `vencimiento_mes`, `vencimiento_ano`, `cvv`, `visitas`, 
          `estado_huesped`,`pais`,`empresa`,`nombre_tarjeta`,`estado_tarjeta`,`voucher`,`estado_credito`,`limite_credito`,`indole_tarjeta`)
          VALUES ('$nombre', '$apellido', '$direccion', '$ciudad', '$estado','$codigo_postal', '$telefono', '$correo', '$contrato', '$cupon', '$preferencias', '$comentarios', '$titular_tarjeta', '$tipo_tarjeta', '$numero_tarjeta', '$vencimiento_mes', '$vencimiento_ano', 
          '$cvv', '0', '1','$pais','$empresa','$nombre_tarjeta','$estado_tarjeta','$voucher','$estado_credito',$limite_credito,'$indole_tarjeta');";
          $comentario="Guardamos el huesped en la base de datos";
          //echo $sentencia ;
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          if(!$consulta){
            echo "NO_VALIDO";
            exit();
          }
          include_once("clase_log.php");
          $logs = NEW Log(0);
          $sentencia = "SELECT id FROM huesped ORDER BY id DESC LIMIT 1";
          $comentario="Obtengo el id del huesped agregado";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          while ($fila = mysqli_fetch_array($consulta)){
            $id= $fila['id'];
          }
          //retornamos el id del nuevo husped para usarlo en la reservación.
          echo $id;
          $logs->guardar_log($usuario_id,"Agregar huesped: ". $id);
        }else{
          //actualizar el cliente existente con los datos 'nuevos' del formulario.
          while ($fila = mysqli_fetch_array($consulta_existe)){
          $huesped_id= $fila['id'];
        }
        $sentencia = "UPDATE  `huesped`
        SET nombre ='$nombre', apellido='$apellido', empresa = '$empresa',telefono='$telefono',pais='$pais',estado='$estado',ciudad='$ciudad',direccion='$direccion'
        ,comentarios ='$comentarios'
        , codigo_postal = '$codigo_postal', correo = '$correo', titular_tarjeta = '$titular_tarjeta', estado_tarjeta = '$estado_tarjeta', nombre_tarjeta = '$nombre_tarjeta'
        , tipo_tarjeta = '$tipo_tarjeta' , numero_tarjeta = IF('$numero_tarjeta' ='', numero_tarjeta, '$numero_tarjeta'), vencimiento_mes = '$vencimiento_mes', vencimiento_ano = '$vencimiento_ano'
        , cvv = '$cvv', voucher = '$voucher', estado_credito='$estado_credito',limite_credito='$limite_credito' , indole_tarjeta = IF('$indole_tarjeta' ='', indole_tarjeta, '$indole_tarjeta')
        WHERE id='$huesped_id'";
        //echo $sentencia;
        $comentario="actualizamos el huesped en la base de datos";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        if(!$consulta){
          echo "NO_VALIDO";
          exit();
        }
        echo $huesped_id;
        }
      }
      // Obtengo el total de huespedes
      function total_elementos(){
        $cantidad=0;
        $sentencia = "SELECT count(id) AS cantidad FROM huesped WHERE estado_huesped = 1 ORDER BY nombre";
        //echo $sentencia;
        $comentario="Obtengo el total de huespedes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $cantidad= $fila['cantidad'];
        }
        return $cantidad;
      }
      // Mostramos los huespedes
      function mostrar($posicion,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->huesped_editar;
        $borrar = $usuario->huesped_borrar;
        $cont = 1;
        //echo $posicion;
        $final = $posicion+20;
        $cat_paginas=($this->total_elementos()/20);
        $extra=($this->total_elementos()%20);
        $cat_paginas=intval($cat_paginas);
        if($extra>0){
          $cat_paginas++;
        }
        $ultimoid=0;
        $sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY nombre";
        $comentario="Mostrar los huespedes";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '
        <button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_huespedes()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
                <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"></path>
                <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"></path>
            </svg>
          Agregar huesped
        </button>

        <div class="table-responsive" id="tabla_huesped">
        <table class="table table_expansion">
          <thead>
            <tr class="text-center">
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Dirección</th>
            <th>Ciudad</th>
            <th>Estado</th>
            <th>Código Postal</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Comentarios</th>
            <th>Ajustes</th>';
            '</tr>
          </thead>
        <tbody>';
            while ($fila = mysqli_fetch_array($consulta)){
              if($cont>=$posicion & $cont<$final){
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['comentarios'].'</td>
                <td>
                <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="tools" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Ver mas
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
                  if($editar==1){
                    echo ' <a class="dropdown-item" onclick="editar_huesped('.$fila['id'].')">Editar</a>';
                  }
                  if($borrar==1){
                    echo ' <a class="dropdown-item" onclick="ver_historial_huesped('.$fila['id'].')">Ver historial</a>';
                  }
                  if($borrar==1){
                    echo ' <div class="dropdown-divider"></div> ';
                    echo ' <a class="dropdown-item text-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_huesped('.$fila['id'].')">Borrar</a>';
                  }'
                  </div>
                </div>
                </td>';
                //if($editar==1){
                //  echo '<td><button class="btn btn-warning" onclick="editar_huesped('.$fila['id'].')"> Editar</button></td>';
                //}
                //if($borrar==1){
                //  echo '<td><button class="btn btn-danger" > Borrar</button></td>';
                //}
                echo '</tr>';
              }
              $cont++;
            }
            echo '
            </tbody>
          </table>
          </div>';
          return $cat_paginas;
      }
      // Barra de diferentes busquedas en ver huespedes
      function buscar_huesped($a_buscar,$id){
        include_once('clase_usuario.php');
        $usuario =  NEW Usuario($id);
        $editar = $usuario->huesped_editar;
        $borrar = $usuario->huesped_borrar;
        if(strlen ($a_buscar) == 0){
          $cat_paginas = $this->mostrar(1,$id);
          }else{
          $sentencia = "SELECT * FROM huesped WHERE (nombre LIKE '%$a_buscar%' || apellido LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%' || telefono LIKE '%$a_buscar%') && estado_huesped = 1 ORDER BY nombre;";
          $comentario="Mostrar diferentes busquedas en ver huespedes";
          $consulta= $this->realizaConsulta($sentencia,$comentario);
          //se recibe la consulta y se convierte a arreglo
          echo '<div class="table-responsive" id="tabla_huesped" >
          <table class="table table_expansion">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Dirección</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Código Postal</th>
              <th>Teléfono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              <th>Ajustes</th>';
              /* if($editar==1){
                echo '<th><span class=" glyphicon glyphicon-cog"></span> Ajustes</th>';
              }
              if($borrar==1){
                echo '<th><span class="glyphicon glyphicon-cog"></span> Borrar</th>';
              } */
              echo '</tr>
            </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)){
                echo '<tr class="text-center">
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Ver mas
                    </button>
                    <div class="dropdown-menu" aria-labelledby="options">';
                    echo ' <a class="dropdown-item" href="#" onclick="editar_huesped('.$fila['id'].')" >Editar</a> ';
                    echo ' <a class="dropdown-item" href="#" onclick="editar_huesped('.$fila['id'].')" >Ver historial</a> ';
                    echo '<div class="dropdown-divider"></div>';
                    echo ' <a class="dropdown-item text-danger" href="#" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_huesped('.$fila['id'].')">Borrar</a> ';
                echo ' </div>
                </td>';
                /* if($editar==1){
                  echo '<td><button class="btn btn-warning" onclick="editar_huesped('.$fila['id'].')"> Editar</button></td>';
                }
                if($borrar==1){
                  echo '<td><button class="btn btn-danger" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_borrar_huesped('.$fila['id'].')"> Borrar</button></td>';
                }
                echo  */'</tr>';
              }
        }
            echo '
          </tbody>
        </table>
        </div>';
      }
      // Editar un huesped
      function editar_huesped($id,$nombre,$apellido,$direccion,$ciudad,$estado,$codigo_postal,$telefono,$correo,$contrato,$cupon,$preferencias,$comentarios,$titular_tarjeta,$tipo_tarjeta,$numero_tarjeta,$vencimiento_mes,$vencimiento_ano,$cvv){
        // echo $numero_tarjeta;
        $sentencia = "UPDATE `huesped` SET
            `nombre` = '$nombre',
            `apellido` = '$apellido',
            `direccion` = '$direccion',
            `ciudad` = '$ciudad',
            `estado` = '$estado',
            `codigo_postal` = '$codigo_postal',
            `telefono` = '$telefono',
            `correo` = '$correo',
            `contrato` = '$contrato',
            `cupon` = '$cupon',
            `preferencias` = '$preferencias',
            `comentarios` = '$comentarios',
            `titular_tarjeta` = '$titular_tarjeta',
            `indole_tarjeta` = '$tipo_tarjeta',
            numero_tarjeta = IF('$numero_tarjeta' ='', numero_tarjeta, '$numero_tarjeta'),
            `vencimiento_mes` = '$vencimiento_mes',
            `vencimiento_ano` = '$vencimiento_ano',
            `cvv` = '$cvv'
            WHERE `id` = '$id';";
        //echo $sentencia ;
        $comentario="Editar huesped dentro de la base de datos ";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Borrar un huesped
      function borrar_huesped($id){
        $sentencia = "UPDATE `huesped` SET
        `estado_huesped` = '0'
        WHERE `id` = '$id';";
        $comentario="Poner estado de huesped como inactivo";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
      // Obtengo el nombre del huesped
      function obtengo_nombre($id){
        $sentencia = "SELECT nombre FROM huesped WHERE id = $id AND estado_huesped = 1 LIMIT 1";
        //echo $sentencia;
        $nombre= '';
        $comentario="Obtengo el nombre del huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $nombre= $fila['nombre'];
        }
        return $nombre;
      }
      // Obtengo el nombre completo del huesped
      function obtengo_nombre_completo($id){
        $sentencia = "SELECT nombre,apellido FROM huesped WHERE id = $id AND estado_huesped = 1 LIMIT 1";
        //echo $sentencia;
        $nombre_completo= '';
        $comentario="Obtengo el nombre completo del huesped";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        while ($fila = mysqli_fetch_array($consulta)){
          $nombre= $fila['nombre'];
          $apellido= $fila['apellido'];
          $nombre_completo= $nombre.' '.$apellido;
        }
        return $nombre_completo;
      }
      // Mostrar las huespedes para asignar en una reservacion
      function mostrar_asignar_huesped_maestra($id_maestra,$mov){
        echo '
        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" placeholder="Buscar" onkeyup="buscar_asignar_huespedNew(0,0,0,0,0,'.$id_maestra.','.$mov.')" id="a_buscar" />
            <label for="a_buscar">Buscar huesped</label>
          </div>
        </div> 
        ';
        $sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC,id DESC LIMIT 30";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY id DESC LIMIT 15";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC LIMIT 15";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_huesped">
          <table class="table ">
            <thead>
              <tr class="table-primary-encabezado text-center">
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)){
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-primary" onclick="aceptar_asignar_huesped_maestra('.$fila['id'] .','.$id_maestra .','.$mov.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
       // Mostrar las huespedes para asignar en una reservacion
      function mostrar_asignar_huespedNew($funcion,$precio_hospedaje,$total_adulto,$total_junior,$total_infantil){
        echo '
          
          <div class="inputs_form_container">
            <div class="form-floating input_container">
              <input type="text" placeholder="Buscar" onkeyup="buscar_asignar_huespedNew('.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')" id="a_buscar" class="form-control custom_input" />
              <label for="a_buscar">Buscar</label>
            </div>
            <button type="button" class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_huespedes()">Agregar huesped</button>
          </div>
        ';
        $sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC,id DESC LIMIT 30";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY id DESC LIMIT 15";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC LIMIT 15";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '
        <div class="table-responsive text-center" id="tabla_huesped" ">
          <table class="table">
            <thead>
              <tr>
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)){
                $numero_tarjeta="**************";
                echo '
                <tr >
                  <td><button type="button" class="btn btn-primary" onclick="aceptar_asignar_huespedNew(' . $fila['id'] . ', \'' . $fila['nombre'] . '\', \'' . $fila['apellido'] . '\', \'' . $fila['empresa'] . '\', \'' . $fila['telefono'] . '\', \'' . $fila['pais'] . '\', \'' . $fila['estado'] . '\', \'' . $fila['ciudad'] . '\', \'' . $fila['direccion'] . '\', \'' . $fila['estado_tarjeta'] . '\', \'' . $fila['tipo_tarjeta'] . '\', \'' . $fila['titular_tarjeta'] . '\', \'' . $numero_tarjeta . '\', \'' . $fila['vencimiento_mes'] . '\', \'' . $fila['vencimiento_ano'] . '\',\'' . $fila['cvv'] . '\',\'' . $fila['correo'] . '\',\'' . $fila['voucher'] . '\',\'' . $fila['estado_credito'] . '\',\'' . $fila['limite_credito'] . '\',\'' . $fila['nombre_tarjeta'] . '\')"> Agregar</button></td>
                  <td>'.$fila['nombre'].'</td>
                  <td>'.$fila['apellido'].'</td>
                  <td>'.$fila['direccion'].'</td>
                  <td>'.$fila['ciudad'].'</td>
                  <td>'.$fila['estado'].'</td>
                  <td>'.$fila['codigo_postal'].'</td>
                  <td>'.$fila['telefono'].'</td>
                  <td>'.$fila['correo'].'</td>
                  <td>'.$fila['contrato'].'</td>
                  <td>'.$fila['cupon'].'</td>
                  <td>'.$fila['preferencias'].'</td>
                  <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Mostrar las huespedes para asignar en una reservacion
      function mostrar_asignar_huesped($funcion,$precio_hospedaje,$total_adulto,$total_junior,$total_infantil){
        echo '<div class="row">
              <div class="col-sm-12"><input type="text" placeholder="Buscar" onkeyup="buscar_asignar_huesped('.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')" id="a_buscar" class="color_black form-control-lg" /></div> 
        </div><br>';
        $sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC,id DESC LIMIT 30";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY id DESC LIMIT 15";
        //$sentencia = "SELECT * FROM huesped WHERE estado_huesped = 1 ORDER BY visitas DESC LIMIT 15";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '
        <div class="table-responsive" id="tabla_huesped" >
          <table class="table ">
            <thead>
              <tr >
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta))
              {
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-primary" onclick="aceptar_asignar_huesped('.$fila['id'].','.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Busqueda de los huespedes para asignar en una reservacion
      function buscar_asignar_huesped($funcion,$precio_hospedaje,$total_adulto,$total_junior,$total_infantil,$a_buscar){
        $sentencia = "SELECT * FROM huesped WHERE (nombre LIKE '%$a_buscar%' || apellido LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%' || telefono LIKE '%$a_buscar%') && estado_huesped = 1 ORDER BY nombre;";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_huesped" >
          <table class="table ">
            <thead>
              <tr >
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)){
                echo '<tr class="text-center">
                <td><button type="button" class="btn btn-success" onclick="aceptar_asignar_huesped('.$fila['id'].','.$funcion.','.$precio_hospedaje.','.$total_adulto.','.$total_junior.','.$total_infantil.')"> Agregar</button></td>
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Busqueda de los huespedes para asignar en una reservacion
      function buscar_asignar_huespedNew($funcion,$precio_hospedaje,$total_adulto,$total_junior,$total_infantil,$a_buscar,$id_maestra=0,$mov=0){
        $sentencia = "SELECT * FROM huesped WHERE (nombre LIKE '%$a_buscar%' || apellido LIKE '%$a_buscar%' || direccion LIKE '%$a_buscar%' || telefono LIKE '%$a_buscar%') && estado_huesped = 1 ORDER BY nombre;";
        $comentario="Mostrar los huespedes para asignar en una reservacion";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
        //se recibe la consulta y se convierte a arreglo
        echo '<div class="table-responsive" id="tabla_huesped">
          <table class="table" >
            <thead>
              <tr >
              <th><span class=" glyphicon glyphicon-cog"></span> Productos</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Direccion</th>
              <th>Ciudad</th>
              <th>Estado</th>
              <th>Codigo Postal</th>
              <th>Telefono</th>
              <th>Correo</th>
              <th>Contrato Socio</th>
              <th>Cupón</th>
              <th>Preferencias</th>
              <th>Comentarios</th>
              </tr>
          </thead>
          <tbody>';
              while ($fila = mysqli_fetch_array($consulta)){
                $numero_tarjeta="**************";
                echo '<tr class="text-center">
                <td>';
                //here
                if($id_maestra==0){
                  echo '<button type="button" class="btn btn-primary" onclick="aceptar_asignar_huespedNew(' . $fila['id'] . ', \'' . $fila['nombre'] . '\', \'' . $fila['apellido'] . '\', \'' . $fila['empresa'] . '\', \'' . $fila['telefono'] . '\', \'' . $fila['pais'] . '\', \'' . $fila['estado'] . '\', \'' . $fila['ciudad'] . '\', \'' . $fila['direccion'] . '\', \'' . $fila['estado_tarjeta'] . '\', \'' . $fila['tipo_tarjeta'] . '\', \'' . $fila['titular_tarjeta'] . '\', \'' . $numero_tarjeta . '\', \'' . $fila['vencimiento_mes'] . '\', \'' . $fila['vencimiento_ano'] . '\',\'' . $fila['cvv'] . '\',\'' . $fila['correo'] . '\',\'' . $fila['voucher'] . '\',\'' . $fila['estado_credito'] . '\',\'' . $fila['limite_credito'] . '\',\'' . $fila['nombre_tarjeta'] . '\')"> Agregar</button>';
                }else{
                  echo '<button type="button" class="btn btn-primary" onclick="aceptar_asignar_huesped_maestra('.$fila['id'] .','.$id_maestra .','.$mov.')"> Agregar</button>';
                }
                echo'
                </td>
                <td>'.$fila['nombre'].'</td>
                <td>'.$fila['apellido'].'</td>
                <td>'.$fila['direccion'].'</td>
                <td>'.$fila['ciudad'].'</td>
                <td>'.$fila['estado'].'</td>
                <td>'.$fila['codigo_postal'].'</td>
                <td>'.$fila['telefono'].'</td>
                <td>'.$fila['correo'].'</td>
                <td>'.$fila['contrato'].'</td>
                <td>'.$fila['cupon'].'</td>
                <td>'.$fila['preferencias'].'</td>
                <td>'.$fila['comentarios'].'</td>
                </tr>';
              }
              echo '
            </tbody>
          </table>
        </div>';
      }
      // Agregamos las visitas correspondientes al check-in realizado
      function modificar_visitas($id,$cantidad_visitas){
        $sentencia = "UPDATE `huesped` SET
        `visitas` = '$cantidad_visitas'
        WHERE `id` = '$id';";
        $comentario="Agregamos las visitas correspondientes al check-in realizado";
        $consulta= $this->realizaConsulta($sentencia,$comentario);
      }
  }
?>