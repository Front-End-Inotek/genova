<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_tarifa.php");
  include_once("clase_movimiento.php");
  include_once("clase_reservacion.php");
  include_once("clase_usuario.php");

  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_GET['hab_id']);
  $tarifa= NEW Tarifa(0);
  $movimiento= NEW Movimiento($hab->mov);
  $id_reservacion= $movimiento->saber_id_reservacion($hab->mov);
  $reservacion= NEW Reservacion($id_reservacion);
  $consulta = $reservacion->datos_reservacion($id_reservacion);
  $usuario_id = $_GET['usuario_id'];
  $usuario = new Usuario($usuario_id);

  if($consulta->num_rows==0){
    echo "nada";
    die();
  }

  while ($fila = mysqli_fetch_array($consulta))
  {
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

  $saldo_faltante= 0;
  $total_faltante= 0;
  $mov= $hab->mov;
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
      <div class="container blanco"> 
        <div class="row">
        <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="recargar_pagina()"> ←</button></div>
          <div class="col-sm-6 text-left"><h2 class="text-dark ">Estado de cuenta habitación: '.$hab->nombre.'</h2></div>';
          if($faltante == 0){
            echo '<div class="col-sm-6 text-right"></div>';
          }else{
            if($faltante > 0){
              echo '<div class="col-sm-5 text-right"><h5 class="text-dark ">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }else{
              echo '<div class="col-sm-5 text-right"><h5 class="text-danger ">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }
          }
        echo '</div>
        <div class="row">
          <div class="col">Fecha Entrada: <span>'.$fecha_entrada.'</span></div>
          <div class="col">Fecha Salida: <span>'.$fecha_salida.'</span></div>
          <div class="col">Noches: <span>'.$noches.'</span></div>
          <div class="col">Costo noche: <span>'.$precio_hospedaje.'</span></div>
          <div class="col">Total estancia: <span>$'.number_format($total_tarifa,2).'</span></div>
        </div>
        <div class="row">
          <div class="col">Nombre Huesped: <span>'.$nombre_huesped.'</span></div>
          <div class="col">Plan Alimentos: <span>'.$total_alimentos.'</span></div>
          <div class="col">Tarifa: <span>'.$tarifa.'</span></div>
          <div class="col">Forma Pago: <span>'.$forma_pago.'</span></div>
          </div>
        <div class="d-flex">';
        if(false){
          echo '
          <button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_vehiculo('.$id_reservacion.','.$id_huesped.')" style="margin-left:18px;"><i class="bx bx-car"></i> Agregar datos vehiculo </button>
        ';
        }else{
          echo '
          <div class="btn-group" role="group" aria-label="Basic example"  style="margin-left:18px;">
            <button class="btn btn-primary" href="#caja_herramientas" data-toggle="modal" onclick="agregar_vehiculo('.$id_reservacion.','.$id_huesped.')" > Ver vehiculo </button>
            <button type="button" disabled class="btn btn-danger" data-toggle="tooltip" data-placement="bottom" title="Auto en habitacion"><i class="bx bx-car"></i></button>
          </div>
          ';
        }
        echo'
        </div>
        <div class="row">';
          echo '<div class="col">Pax Extra: <span>'.$pax_extra.'</span></div>';
          if($extra_adulto>0){
            echo '<div class="col">Extra Adulto: <span>'.$extra_adulto.' ('.$precio_adulto.')</span></div>';
          }else{
            echo '';
          }
          if($extra_junior>0){
            echo '<div class="col">Extra Junior: <span>'.$extra_junior.'</span></div>';
          }else{
            echo '';
          }
          if($extra_infantil>0){
            echo '<div class="col">Extra Infantil: <span>'.$extra_infantil.' ('.$precio_infantil.')</span></div>';
          }else{
            echo '';
          }
          if($extra_menor>0){
            echo '<div class="col">Extra Menor: <span>'.$extra_menor.'</span></div>';
          }else{
            echo '';
          }
        echo '</div>

        <div class="row">
          <div class="col-sm-6 altura-rest" id="caja_mostrar_busqueda" >';$total_cargos= $cuenta->mostrar_cargos($mov,$id_reservacion,$_GET['hab_id'],$_GET['estado'],0,$usuario_id);echo '</div>
          <div class="col-sm-6 altura-rest" id="caja_mostrar_totales" >';$total_abonos= $cuenta->mostrar_abonos($mov,$id_reservacion,$_GET['hab_id'],$_GET['estado'],0,$usuario_id);echo '</div>
        </div>';

        if($total_cargos==0){
          $total_faltante=0;
        }else{
          $total_faltante= $total_abonos - $total_cargos;
        }

        echo '<div class="row d-flex justify-content-between"">

          <div class="col-sm-2">Total: <span>$'.number_format($total_cargos, 2).'</span></div>
          <div class="col-sm-4">Saldo Total: <span>$'.number_format($total_faltante, 2).'</span></div>
          <div class="col-sm-2">Total: <span>$'.number_format($total_abonos, 2).'</span></div>
        </div>

        <div class="row d-flex justify-content-between">';
          /*if($total_faltante==0){
            echo '<div class="col-sm-12"></div>';
          }else{*/
            echo '<div class="col-sm-2"><button class="btn btn-danger btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_cargo('.$_GET['hab_id'].','.$_GET['estado'].','.$total_faltante.')"> Cobrar</button></div>';
            echo '<div class="col-sm-2"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="unificar_cuentas('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')"> Unificar</button></div>';
            // echo '<div class="col-sm-2"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="seleccionar_cuentas('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')"> Unificar</button></div>';
            echo '<div class="col-sm-2"><button class="btn btn-success btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_abono('.$_GET['hab_id'].','.$_GET['estado'].','.$total_faltante.')"> Abonar</button></div>';
            if($faltante == 0 && $usuario->nivel<=2){
              echo '<div class="col-sm-3"><button class="btn btn-info btn-block" href="#caja_herramientas" data-toggle="modal" onclick="hab_desocupar_hospedaje('.$_GET['hab_id'].','.$_GET['estado'].')">Desocupar hab.</button></div>';
            }
          //}
        echo '</div>
   
      </div>';
?>
