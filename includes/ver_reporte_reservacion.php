<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">RESERVACION '.$_GET['id'].'</h2></div>';
          $consulta= $reservacion->datos_reservacion($_GET['id']);
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
                  $cantidad_hospedaje= $fila['cantidad_hospedaje'];
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
                  if($fila['forzar_tarifa']>0){
                          $total_estancia= $fila['forzar_tarifa']; 
                  }else{
                          $total_estancia= $fila['total']; 
                  }
                  $total_pago= $fila['total_pago'];
                  $forma_pago= $fila['descripcion'];
                  $limite_pago= $reservacion->mostrar_nombre_pago($fila['limite_pago']);
          }
          /*echo '<div class="row">
            <div class="col-sm-6 text-left"><h2 class="text-dark margen-1">ESTADO DE CUENTA - Habitación '.$id_hab.'</h2></div>';
            if($faltante == 0){
              echo '<div class="col-sm-6 text-right"></div>';
            }else{
              echo '<div class="col-sm-6 text-right"><h5 class="text-dark margen-1">Saldo Total '.$faltante_mostrar.'</h5></div>';
            }
          echo '</div>*/
        echo '<div class="row">
          <div class="col-sm-6">Fecha Entrada: '.$fecha_entrada.'</div>
          <div class="col-sm-6">Fecha Salida: '.$fecha_salida.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Usuario que la hizo: '.$usuario_reservacion.'</div>
          <div class="col-sm-6">No. habitaciones: '.$numero_hab.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Noches: '.$noches.'</div>
          <div class="col-sm-6">Tarifa: '.$tarifa.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Nombre Huesped: '.$nombre_huesped.'</div>
          <div class="col-sm-6">Quién Reserva: '.$quien_reserva.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Acompañante: '.$acompanante.'</div>
          <div class="col-sm-6">Cantidad Hospedaje: '.$cantidad_hospedaje.'</div>
        </div>
        <div class="row">';
          if($extra_adulto>0){
            echo '<div class="col-sm-6">Extra Adulto: '.$extra_adulto.'</div>';
          }else{
            echo '<div class="col-sm-6"></div>'; 
          }

          if($extra_junior>0){
            echo '<div class="col-sm-6">Extra Junior: '.$extra_junior.'</div>';
          }else{
            echo '<div class="col-sm-6"></div>'; 
          }
        echo '</div>
        <div class="row">';
          if($extra_infantil>0){
            echo '<div class="col-sm-6">Extra Infantil: '.$extra_infantil.'</div>';
          }else{
            echo '<div class="col-sm-6"></div>'; 
          }

          if($extra_menor>0){
            echo '<div class="col-sm-6">Extra Menor: '.$extra_menor.'</div>';
          }else{
            echo '<div class="col-sm-6"></div>'; 
          }
        echo '</div>
        <div class="row">
          <div class="col-sm-6">Suplementos: '.$suplementos.'</div>
          <div class="col-sm-6">Total suplementos: '.$total_suplementos.'</div>'; 
        echo '</div>
        <div class="row">
          <div class="col-sm-6">Forma Pago: '.$forma_pago.'</div>
          <div class="col-sm-6">Limite Pago: '.$tarifa.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Total Habitacion: '.$noches.'</div>
          <div class="col-sm-6">Descuento: '.$tarifa.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Total Estancia: '.$noches.'</div>
          <div class="col-sm-6">Total Pago: '.$tarifa.'</div>
        </div>
        <div class="row">
          <div class="col-sm-6">Precio Hospedaje: '.$noches.'</div>
          <div class="col-sm-6">T: '.$tarifa.'</div>
        </div>
        '; 
        //  precio hospedaje
  echo '
         </div>';
?>
