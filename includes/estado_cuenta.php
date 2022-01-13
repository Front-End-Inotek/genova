<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cuenta.php");
  include_once("clase_hab.php");
  include_once("clase_tarifa.php");
  include_once("clase_movimiento.php");
  include_once("clase_reservacion.php");
  $cuenta= NEW Cuenta(0);
  $hab= NEW Hab($_GET['hab_id']);
  $tarifa= NEW Tarifa(0);
  $movimiento= NEW Movimiento($hab->mov);
  $id_reservacion= $movimiento->saber_id_reservacion($hab->mov);
  $reservacion= NEW Reservacion($id_reservacion);
  $consulta = $reservacion->datos_reservacion($id_reservacion);
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_hab= $fila['ID'];
      $id_usuario= $fila['id_usuario'];
      $usuario_reservacion= $fila['usuario'];
      $fecha_entrada= date("d-m-Y",$fila['fecha_entrada']);
      $fecha_salida= date("d-m-Y",$fila['fecha_salida']);
      $noches= $fila['noches'];
      $numero_hab= $fila['numero_hab'];
      $tarifa= $fila['habitacion'];
      $precio_hospedaje= $fila['precio_hospedaje'];
      $extra_adulto= $fila['extra_adulto'];
      $extra_junior= $fila['extra_junior'];
      $extra_infantil= $fila['extra_infantil'];
      $extra_menor= $fila['extra_menor'];
      $nombre_huesped= $fila['persona'].' '.$fila['apellido'];
      $quien_reserva= $fila['nombre_reserva'];
      $acompanante= $fila['acompanante'];
      // Checar si suplementos esta vacio o no
      if (empty($fila['suplementos'])){
        //echo 'La variable esta vacia';
        $suplementos= 'Ninguno';
      }else{
        $suplementos= $fila['suplementos'];
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
          <div class="col-sm-6 text-left"><h2 class="text-dark margen-1">ESTADO DE CUENTA - Habitación '.$hab->nombre.'</h2></div>';
          if($faltante == 0){
            echo '<div class="col-sm-6 text-right"></div>';
          }else{
            if($faltante > 0){
              echo '<div class="col-sm-6 text-right"><h5 class="text-dark margen-1">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }else{
              echo '<div class="col-sm-6 text-right"><h5 class="text-danger margen-1">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }
          }
        echo '</div>
        <div class="row">
          <div class="col-sm-4">Fecha Entrada: '.$fecha_entrada.'</div>
          <div class="col-sm-4">Fecha Salida: '.$fecha_salida.'</div>
          <div class="col-sm-2">Noches: '.$noches.'</div>
          <div class="col-sm-2">Tarifa: '.$tarifa.'</div>
        </div>
        <div class="row">
          <div class="col-sm-4">Nombre Huesped: '.$nombre_huesped.'</div>
          <div class="col-sm-4">Quién Reserva: '.$quien_reserva.'</div>
          <div class="col-sm-2">Acompañante: '.$acompanante.'</div>
          <div class="col-sm-2">Forma Pago: '.$forma_pago.'</div>
        </div>
        <div class="row">
          <div class="col-sm-4">Suplementos: '.$suplementos.'</div>';
          if($extra_adulto>0){
            echo '<div class="col-sm-2">Extra Adulto: '.$extra_adulto.'</div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }

          if($extra_junior>0){
            echo '<div class="col-sm-2">Extra Junior: '.$extra_junior.'</div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }

          if($extra_infantil>0){
            echo '<div class="col-sm-2">Extra Infantil: '.$extra_infantil.'</div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }

          if($extra_menor>0){
            echo '<div class="col-sm-2">Extra Menor: '.$extra_menor.'></div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }
        echo '</div><br>

        <div class="row">
          <div class="col-sm-6 altura-rest" id="caja_mostrar_busqueda" style="background-color:white;">';$total_cargos= $cuenta->mostrar_cargos($mov,$id_reservacion,$_GET['hab_id'],$_GET['estado']);echo '</div>
          <div class="col-sm-6 altura-rest" id="caja_mostrar_totales" style="background-color:white;">';$total_abonos= $cuenta->mostrar_abonos($mov,$id_reservacion,$_GET['hab_id'],$_GET['estado']);echo '</div>
        </div>'; 

        $total_faltante= $total_abonos - $total_cargos;

        echo '<div class="row">
          <div class="col-sm-4"></div>
          <div class="col-sm-2">Total $'.number_format($total_cargos, 2).'</div>
          <div class="col-sm-4"></div>
          <div class="col-sm-2">Total $'.number_format($total_abonos, 2).'</div>
        </div>

        <div class="row">';
          if($total_faltante==0){
            echo '<div class="col-sm-12"></div>';
          }else{
            echo '<div class="col-sm-4"></div>';
            echo '<div class="col-sm-2"><button class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="unificar_cuentas('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')"> Unificar</button></div>';
            echo '<div class="col-sm-4"></div>';
            echo '<div class="col-sm-2"><button class="btn btn-success btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_abono('.$_GET['hab_id'].','.$_GET['estado'].','.$total_faltante.')"> Abonar</button></div>';
          }
        echo '</div>
   
      </div>';
?>
