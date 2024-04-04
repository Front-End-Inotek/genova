<?php
  date_default_timezone_set('America/Mexico_City');
  session_start();
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_tarifa.php");
  include_once("clase_movimiento.php");
  include_once("clase_reservacion.php");
  include_once("clase_usuario.php");
  include_once("clase_huesped.php");

  //Aqui se obtiene del folio casa 🐓
  $folio_casa = $_GET["fcasa"];


  $cuenta= NEW Cuenta(0);
  //$hab= NEW Hab($_GET['hab_id']);
  $tarifa= NEW Tarifa(0);
  $huesped= NEW Huesped(0);
  $movimiento= NEW Movimiento($folio_casa);
  $consulta=$movimiento->sacar_movimiento($folio_casa);
  while ($fila = mysqli_fetch_array($consulta)){
    $id_habitacion=$fila['id_hab'];
  }
  $id_reservacion= $movimiento->saber_id_reservacion($folio_casa);
  $reservacion= NEW Reservacion($id_reservacion);
  //echo $id_reservacion;
  $consulta = $reservacion->datos_reservacion($id_reservacion);
  $usuario_id = 1;
  $usuario = new Usuario($usuario_id);
  $id_huesped=0;
  if($consulta->num_rows==0){
    //var_dump($consulta);
    echo '
    <div class="alert alert-warning mt-3" role="alert">
      <h4 class="alert-heading">¡Atención!</h4>
      <p>No se encontraron resultados para el folio de casa buscado. Por favor, revisa el folio e inténtalo de nuevo.</p>
      <hr>
      <p class="mb-0">¡Vuelve a intentarlo con un folio casa correcto!</p>
    </div>
    ';
    die();
  }
  while ($fila = mysqli_fetch_array($consulta)) {
      $id_huesped = $fila['id_huesped'];
      $id_hab= $fila['ID'];
      $id_usuario= $fila['id_usuario'];
      $usuario_reservacion= $fila['usuario'];
      $fecha_entrada= date("d-m-Y",$fila['fecha_entrada']);
      $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
      $noches= $fila['noches'];
      $numero_hab= $fila['numero_hab'];
      $tarifa= $fila['habitacion'];
      $precio_hospedaje="$".number_format($fila['reserva_precio_hospedaje'],2);
      $extra_adulto= $fila['extra_adulto'];
      $extra_junior= $fila['extra_junior'];
      $extra_infantil= $fila['extra_infantil'];
      $extra_menor= $fila['extra_menor'];
      $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
      $quien_reserva= $fila['nombre_reserva'];
      $acompanante= $fila['acompanante'];
      // Checar si suplementos esta vacio o no
      if (empty($fila['nombre_plan'])){
        //echo 'La variable esta vacia';
        $suplementos= 'Ninguno';
      }else{
        $suplementos= $fila['nombre_plan'];
      }
      $total_suplementos= $fila['total_suplementos'];
      $total_habitacion= $fila['total_hab'];
      if($fila['descuento']>0){
        $descuento= $fila['descuento'].'%';
      }else{
        $descuento= 'Ninguno';
      }
      // Total provisional
      $total_estancia= $fila['total'];
      $total_pago= $fila['total_pago'];
      $forma_pago= $fila['descripcion'];
      $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
      $total_tarifa = $fila['total'];
      if(!empty($fila['forzar_tarifa'])){
        $tarifa="Forzada";
      }
      $precio_adulto =  '$'.number_format($fila['precio_adulto'], 2);
      $pax_extra ='$'.number_format($fila['pax_extra'],2);
      $precio_infantil =  '$'.number_format($fila['precio_infantil'], 2);
      $total_alimentos= '$'.number_format($fila['costo_plan'], 2);
  }
  $estado_veiculo=$huesped->optener_estado_vehiculo($id_huesped);
  $saldo_faltante= 0;
  $total_faltante= 0;
  $mov= $folio_casa;
  $suma_abonos= $cuenta->obtner_abonos($mov);
  $saldo_pagado= $total_pago + $suma_abonos;
  $saldo_faltante= $total_estancia - $saldo_pagado;
  $total_cargos= 0;
  $total_abonos= 0;
  $faltante= 0;
  $faltante= $cuenta->mostrar_faltante($mov);
  if($faltante >= 0){
    $faltante_mostrar= '$'.number_format($faltante, 2);
  }else{
    $faltante_mostrar= substr($faltante, 1);
    $faltante_mostrar= '-$'.number_format($faltante_mostrar, 2);
  }
  echo '
      <div class="main_container">
        <header class="main_container_title">
          <div>
          <h2>Estado de cuenta habitación folio casa: '.$folio_casa.'</h2>
          <input class="d-none" type="number" id="leer_mov" value='.$folio_casa.'>
          <input class="d-none" type="number" id="leer_hab" value=nombre>
            </div>
          ';
          $_SESSION['nombre_usuario']="nombre";
          
        echo '
        </header>
        
        <div class="estado_cuenta_botones">
          <div class="btn-group" role="group" aria-label="Basic example" >
            <button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_vehiculo('.$id_reservacion.','.$id_huesped.')" > Ver vehiculo </button>
            <div id="coche_estado">';
            if($estado_veiculo==0){
              echo '
              <button type="button"  class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Auto en habitacion" onclick="cambiar_estado_vehiculo('.$id_huesped.',1)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front-fill" viewBox="0 0 16 16">
                  <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM3 10a1 1 0 1 0 0-2 1 1 0 0 0 0 2m10 0a1 1 0 1 0 0-2 1 1 0 0 0 0 2M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM2.906 5.189a.51.51 0 0 0 .497.731c.91-.073 3.35-.17 4.597-.17 1.247 0 3.688.097 4.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 11.691 3H4.309a.5.5 0 0 0-.447.276L2.906 5.19Z"/>
                </svg>
              </button>';
            }else{
              echo '
              <button type="button"  class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" title="Auto en habitacion" onclick="cambiar_estado_vehiculo('.$id_huesped.',0)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-car-front" viewBox="0 0 16 16">
                  <path d="M4 9a1 1 0 1 1-2 0 1 1 0 0 1 2 0m10 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M6 8a1 1 0 0 0 0 2h4a1 1 0 1 0 0-2zM4.862 4.276 3.906 6.19a.51.51 0 0 0 .497.731c.91-.073 2.35-.17 3.597-.17 1.247 0 2.688.097 3.597.17a.51.51 0 0 0 .497-.731l-.956-1.913A.5.5 0 0 0 10.691 4H5.309a.5.5 0 0 0-.447.276"/>
                  <path d="M2.52 3.515A2.5 2.5 0 0 1 4.82 2h6.362c1 0 1.904.596 2.298 1.515l.792 1.848c.075.175.21.319.38.404.5.25.855.715.965 1.262l.335 1.679c.033.161.049.325.049.49v.413c0 .814-.39 1.543-1 1.997V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.338c-1.292.048-2.745.088-4 .088s-2.708-.04-4-.088V13.5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1.892c-.61-.454-1-1.183-1-1.997v-.413a2.5 2.5 0 0 1 .049-.49l.335-1.68c.11-.546.465-1.012.964-1.261a.807.807 0 0 0 .381-.404l.792-1.848ZM4.82 3a1.5 1.5 0 0 0-1.379.91l-.792 1.847a1.8 1.8 0 0 1-.853.904.807.807 0 0 0-.43.564L1.03 8.904a1.5 1.5 0 0 0-.03.294v.413c0 .796.62 1.448 1.408 1.484 1.555.07 3.786.155 5.592.155 1.806 0 4.037-.084 5.592-.155A1.479 1.479 0 0 0 15 9.611v-.413c0-.099-.01-.197-.03-.294l-.335-1.68a.807.807 0 0 0-.43-.563 1.807 1.807 0 0 1-.853-.904l-.792-1.848A1.5 1.5 0 0 0 11.18 3z"/>
                </svg>
              </button>';
            }
          echo '</div></div>
          <div>
            <button class="btn btn-primary" onclick="generar_facturas_global_cargos()" disabled id="btn_generador_factura_cargos">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
              </svg>
              Fac. Cargos
            </button>
          </div>
          <div>
            <button class="btn btn-primary" onclick="generar_facturas_global()" disabled id="btn_generar_factura">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2M9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5z"/>
                <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
              </svg>
              Fac. Abonos
            </button>
          </div>';
          if($total_faltante == 0){
            //echo'
            //  <button class="btn btn-info btn-block" href="#caja_herramientas" data-toggle="modal" onclick="unificar_cuentas('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')"> ';
              echo '
              <button class="btn btn-info btn-block" href="#caja_herramientas" data-toggle="modal" onclick="unificar_cuentas( 0 , 1 ,'.$mov.', '.$folio_casa.')"> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-collapse-vertical" viewBox="0 0 16 16">
                  <path d="M8 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M0 8a.5.5 0 0 1 .5-.5h3.793L3.146 6.354a.5.5 0 1 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8.5H.5A.5.5 0 0 1 0 8m11.707.5 1.147 1.146a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2a.5.5 0 0 1 .708.708L11.707 7.5H15.5a.5.5 0 0 1 0 1z"/>
                </svg>
                Unificar
              </button>
            ';
          } else {
            echo '<div></div>';
          }
          echo'
        </div>
        <input class="d-none" type="number" id="tipo_factura" value="0" disabled/>
        <section class="estado_cuenta_resumen">
          <ul class="list-group list_group_perzonalizado ">
            <li class="list-group-item">Huesped: <span>'.$nombre_huesped.'</span></li>
            <li class="list-group-item">Costo noche: <span>'.$precio_hospedaje.'</span></li>
            <li class="list-group-item">Total estancia: <span>$'.number_format($total_tarifa,2).'</span></li>
          </ul>

          <ul class="list-group list_group_perzonalizado ">
            <li class="list-group-item">Fecha Entrada: <span>'.$fecha_entrada.'</span></li>
            <li class="list-group-item">Fecha Salida: <span>'.$fecha_salida.'</span></li>
            <li class="list-group-item">Noches: <span>'.$noches.'</span></li>
          </ul>

          <ul class="list-group list_group_perzonalizado ">
            <li class="list-group-item">Tarifa: <span>'.$tarifa.'</span></li>
            <li class="list-group-item">Forma Pago: <span>'.$forma_pago.'</span></li>
            <li class="list-group-item">Plan Alimentos: <span>'.$total_alimentos.'</span></li>
          </ul>

          <ul class="list-group list_group_perzonalizado ">';
            echo '
              <ul class="list-group-item">Pax Extra: <span>'.$pax_extra.'</span></ul>';
            if($extra_adulto>0){
              echo '
              <ul class="list-group-item">Extra Adulto: <span>'.$extra_adulto.' ('.$precio_adulto.')</span></ul>';
              $_SESSION['extra_adulto']=$extra_adulto;
            }else{
              echo '
              <ul class="list-group-item">Extra Adulto: </ul>';
              $_SESSION['extra_adulto']=0;
            }
            if($extra_junior>0){
              echo '
              <ul class="list-group-item">Extra Junior: <span>'.$extra_junior.'</span></ul>';
              $_SESSION['extra_junior']=$extra_junior;
            }else{
              echo '
              <ul class="list-group-item">Extra Junior: </ul>';
              $_SESSION['extra_junior']=$extra_junior;
            }
            if($extra_infantil>0){
              echo '<ul class="list-group-item">Extra Infantil: <span>'.$extra_infantil.' ('.$precio_infantil.')</span></ul>';
            }else{
              echo '';
            }
            if($extra_menor>0){
              echo '<ul class="list-group-item">Extra Menor: <span>'.$extra_menor.'</span></ul>';
            }else{
              echo '';
            }
        echo '</ul>

        </section>

        

        <div class="estado_cuenta_container">
          <div class="estado_cuenta_tabla" id="caja_mostrar_busqueda" >';
            $total_cargos= $cuenta->mostrar_cargos($mov,$id_reservacion,$id_habitacion,1,0,$usuario_id);
            echo '
            <div class="btn_estado_cuenta"><button class="btn btn-danger btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_cargo(0,0,'.$total_faltante.','.$folio_casa.')"> Cobrar</button></div>
          </div>
          <div class="estado_cuenta_tabla" id="caja_mostrar_totales" >';
            $total_abonos= $cuenta->mostrar_abonos($mov,$id_reservacion,$id_habitacion,1,0,$usuario_id);
            echo '
            <div class="btn_estado_cuenta"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_abono(0,0,'.$total_faltante.','.$folio_casa.')"> Abonar</button></div>
          </div>
        </div>';
        if($total_cargos==0){
          $total_faltante=0;
        }else{
          $total_faltante= $total_abonos - $total_cargos;
        }
        echo '
        <div class="estado_cuenta_cantidades">
          <div>Total cargos: <span>$'.number_format($total_cargos, 2).'</span></div>
          <div>Saldo Total: <span>$'.number_format($total_faltante, 2).'</span></div>
          <div>Total abonos: <span>$'.number_format($total_abonos, 2).'</span></div>
        </div>

        
        <div class="">';
          /*if($total_faltante==0){
            echo '<div class="col-sm-12"></div>';
          }else{*/
            echo '<!-- <div class="col-sm-2"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="unificar_cuentas('.$id_habitacion.',1,'.$mov.', '.$folio_casa.')"> 
                    Unificar
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrows-collapse-vertical" viewBox="0 0 16 16">
                        <path d="M8 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M0 8a.5.5 0 0 1 .5-.5h3.793L3.146 6.354a.5.5 0 1 1 .708-.708l2 2a.5.5 0 0 1 0 .708l-2 2a.5.5 0 0 1-.708-.708L4.293 8.5H.5A.5.5 0 0 1 0 8m11.707.5 1.147 1.146a.5.5 0 0 1-.708.708l-2-2a.5.5 0 0 1 0-.708l2-2a.5.5 0 0 1 .708.708L11.707 7.5H15.5a.5.5 0 0 1 0 1z"/>
                      </svg>
                  </button> --> </div>';
            // echo '<div class="col-sm-2"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="seleccionar_cuentas('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')"> Unificar</button></div>';
            
          //}
        echo '</div>
      </div>';
      
?>