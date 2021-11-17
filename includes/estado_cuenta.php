<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_tarifa.php");
  $reservacion= NEW Reservacion($_GET['hab_id']);
  $tarifa= NEW Tarifa(0);
  $consulta = $reservacion->datos_reservacion($_GET['hab_id']);
  while ($fila = mysqli_fetch_array($consulta))
  {
      $id_hab= $fila['ID'];
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
      $nombre_huesped= $fila['persona'];
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
      if($fila['forzar_tarifa']>0){
        $total_estancia= $fila['forzar_tarifa']; 
      }else{
        $total_estancia= $fila['total']; 
      }
      $total_pago= $fila['total_pago'];
      $forma_pago= $fila['descripcion'];
      $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
      //$saldo_pagado= ;
      //$saldo_faltante= ;
      //$abono= ;
  }
  $saldo_faltante= $total_estancia - $total_pago;
  echo '
      <div class="container blanco"> 
        <div class="row">
          <div class="col-sm-9 text-left"><h2 class="text-dark margen-1">ESTADO DE CUENTA - Habitación '.$id_hab.'</h2></div>
          <div class="col-sm-2"><button class="btn btn-success btn-block" href="#caja_herramientas" data-toggle="modal" onclick="agregar_abono('.$_GET['hab_id'].','.$_GET['estado'].','.$saldo_faltante.')"><span class="glyphicon glyphicon-edit"></span>Abonar</button></div>
        </div>
        <div class="row">
          <div class="col-sm-4"><h6>Fecha Entrada: '.$fecha_entrada.'</h6></div>
          <div class="col-sm-4"><h6>Fecha Salida: '.$fecha_salida.'</h6></div>
          <div class="col-sm-2"><h6>Noches: '.$noches.'</h6></div>
          <div class="col-sm-2"><h6>Tarifa: '.$tarifa.'</h6></div>
        </div>
        <div class="row">
          <div class="col-sm-4"><h6>Nombre Huesped: '.$nombre_huesped.'</h6></div>
          <div class="col-sm-4"><h6>Quién Reserva: '.$quien_reserva.'</h6></div>
          <div class="col-sm-4"><h6>Acompañante: '.$acompanante.'</h6></div>
        </div>
        <div class="row">
          <div class="col-sm-4"><h6>Suplementos: '.$suplementos.'</h6></div>';
          if($extra_adulto>0){
            echo '<div class="col-sm-2"><h6>Extra Adulto: '.$extra_adulto.'</h6></div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }

          if($extra_junior>0){
            echo '<div class="col-sm-2"><h6>Extra Junior: '.$extra_junior.'</h6></div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }

          if($extra_infantil>0){
            echo '<div class="col-sm-2"><h6>Extra Infantil: '.$extra_infantil.'</h6></div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }

          if($extra_menor>0){
            echo '<div class="col-sm-2"><h6>Extra Menor: '.$extra_menor.'</h6></div>';
          }else{
            echo '<div class="col-sm-2"></div>'; 
          }
        echo '</div><br>

        <div class="table-responsive" id="tabla_reservacion">
        <table class="table table-bordered table-hover">
          <thead>
            <tr class="table-primary-encabezado text-center">
            <th>Habitación</th>
            <th>Forma Pago</th>
            <th>Limite Pago</th>
            <th>Total Suplementos</th>
            <th>Total Habitacion</th>
            <th>Descuento</th>
            <th>Total Estancia</th>
            <th>Total Pago</th>
            <th>Saldo Pagado</th>
            <th>Saldo Faltante</th>
            </tr>
          </thead>
          <tbody>
            <tr class="text-center">
            <td>'.$id_hab.'</td>  
            <td>'.$forma_pago.'</td>
            <td>'.$limite_pago.'</td>
            <td>$'.number_format($total_suplementos, 2).'</td> 
            <td>$'.number_format($total_habitacion, 2).'</td>
            <td>'.$descuento.'</td>
            <td>$'.number_format($total_estancia, 2).'</td> 
            <td>$'.number_format($total_pago, 2).'</td> 
            <td>$950.00</td> 
            <td>$'.number_format($saldo_faltante, 2).'</td>  
          </tbody>
        </table>
        </div>
       
      </div>';
?>
