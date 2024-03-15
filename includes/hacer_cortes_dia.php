<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte_info_dia.php");
  include_once("clase_hab.php");
  include_once("clase_cuenta.php");
  include_once("clase_usuario.php");
  $usuario=NEW Usuario(0);
  $cuenta=NEW Cuenta(0);
  $hab= NEW Hab(0);
  $ticket= NEW Ticket(0);
  $tipo= NEW Tipo(0);
  $forma_pago= NEW Forma_pago(0);
  /*$ticket_inicial= $ticket->ticket_ini();
  $ticket_final= $ticket->ticket_fin();
  $inf= NEW Corte_info($ticket_inicial,$ticket_final);*/
  $inf= NEW Corte_info($_GET['usuario_id']);
  $total_cuartos_hospedaje= 0;
  $suma_cuartos_hospedaje= 0;
  $total_cuartos= 0;
  $total_productos= 0;
  $total_restaurante= 0;
  $total_productos_hab= 0;
  $total_productos_rest= 0;
  echo '
      <div class="main_container">
        <header class="main_container_title">
          <h2 >HACER CORTE DIARIO</h2>
          <div id="boton_usuario">
          <button disabled="true" class="btn btn-primary btn-block" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_guardar_corte_global()" id="btn_hacer_corte">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-receipt-cutoff" viewBox="0 0 16 16">
              <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5M11.5 4a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1zm0 2a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
              <path d="M2.354.646a.5.5 0 0 0-.801.13l-.5 1A.5.5 0 0 0 1 2v13H.5a.5.5 0 0 0 0 1h15a.5.5 0 0 0 0-1H15V2a.5.5 0 0 0-.053-.224l-.5-1a.5.5 0 0 0-.8-.13L13 1.293l-.646-.647a.5.5 0 0 0-.708 0L11 1.293l-.646-.647a.5.5 0 0 0-.708 0L9 1.293 8.354.646a.5.5 0 0 0-.708 0L7 1.293 6.354.646a.5.5 0 0 0-.708 0L5 1.293 4.354.646a.5.5 0 0 0-.708 0L3 1.293zm-.217 1.198.51.51a.5.5 0 0 0 .707 0L4 1.707l.646.647a.5.5 0 0 0 .708 0L6 1.707l.646.647a.5.5 0 0 0 .708 0L8 1.707l.646.647a.5.5 0 0 0 .708 0L10 1.707l.646.647a.5.5 0 0 0 .708 0L12 1.707l.646.647a.5.5 0 0 0 .708 0l.509-.51.137.274V15H2V2.118l.137-.274z"/>
            </svg>
            Hacer Corte
          </button>
          </div>
        </header>
          ';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          /* echo '

        <div class="text-dark margen-1"></div>

        <div class="row">

          <div class="col">
            <h5> Ventas Restaurante </h5> 
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Venta</th>
                    <th>Total</th>
                    <th>En Hab.</th>
                    <th>En Rest.</th>
                    </tr>
                  </thead>
                <tbody>';
                    $cantidad= count($inf->producto_nombre);
                    for($z=0 ; $z<$cantidad; $z++)
                    {
                      if(($z%2) == 0){
                        echo '<tr class="table-white text-center">';
                      }else{
                        echo '<tr class="table text-center">';
                      }
                        echo '<td>'.$inf->producto_nombre[$z].'</td>
                        <td class="total_corte">$'.number_format($inf->producto_precio[$z], 2).'</td>
                        <td>'.$inf->producto_venta[$z].'</td>
                        <td class="total_corte">$'.number_format(($inf->producto_venta[$z] * $inf->producto_precio[$z]), 2).'</td>
                        <td>'.$inf->producto_tipo_hab[$z].'</td>
                        <td>'.$inf->producto_tipo_rest[$z].'</td>';
                        $total_restaurante= $total_restaurante + ($inf->producto_venta[$z] * $inf->producto_precio[$z]);
                        $total_productos= $total_productos + $inf->producto_venta[$z];
                        $total_productos_hab= $total_productos_hab + $inf->producto_tipo_hab[$z];
                        $total_productos_rest= $total_productos_rest + $inf->producto_tipo_rest[$z];
                    }
                      echo '<tr class="table  text-center">
                        <td></td>
                        <td></td>
                        <td>'.$total_productos.'</td>
                        <td class="total_corte">$'.number_format($total_restaurante, 2).'</td>
                        <td>'.$total_productos_hab.'</td>
                        <td>'.$total_productos_rest.'</td>
                      </tr>';
                    echo '
                  </tbody>
                </table>
                </div>

                <h5>Totales</h5>
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Concepto</th>
                    <th>Total</th>
                    </tr>
                  </thead>
                <tbody>';
                    $concepto= array();
                    $concepto[0]= 'Habitaciones';
                    $concepto[1]= 'Restaurante';
                    $concepto[2]= 'Reservaciones';
                    $concepto[3]= 'Cuentas Maestras';
                    $concepto[4]= 'Total';
                    $total= array();
                    $total[0]= $inf->total_hab;
                    $total[1]= $inf->total_restaurante_entrada;
                    $total[2]= $inf->total_reservas;
                    $total[3]= $inf->total_cuenta_maestra;
                    $total[4]= $inf->total_global;
                    $cantidad= 4;
                    for($z=0 ; $z<$cantidad; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table text-center">';
                        }
                          echo '<td>'.$concepto[$z].'</td>
                          <td class="total_corte">$'.number_format($total[$z], 2).'</td>
                        </tr>';
                    }
                    echo '<tr class="table  text-center">
                      <td>Total</td>
                      <td class="total_corte">$'.number_format($total[4], 2).'</td>
                    </tr>';
                    echo '
                  </tbody>
                </table>
                </div>
          </div>

          <div class="col">
            <h5>Hospedaje</h5>
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Tipo</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    </tr>
                  </thead>
                <tbody>';
                    $cantidad= $tipo->total_elementos();
                    $c = sizeof($inf->hab_tipo_hospedaje);
                    $c = $c;
                    for($z=0 ; $z<$c; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table text-center">';
                        }
                          echo '<td>'.$inf->hab_tipo_hospedaje[$z].'</td>';
                          //<td>$'.number_format($inf->hab_precio_hospedaje[$z], 2).'</td>
                          echo '<td>'.$inf->hab_cantidad_hospedaje[$z].'</td>
                          <td class="total_corte">$'.number_format($inf->hab_total_hospedaje[$z], 2).'</td>
                        </tr>';
                        $total_cuartos_hospedaje= $total_cuartos_hospedaje + $inf->hab_total_hospedaje[$z];
                        $suma_cuartos_hospedaje= $suma_cuartos_hospedaje + $inf->hab_cantidad_hospedaje[$z];
                    }
                    echo '<tr class="table  text-center">
                      <td></td>
                      <td>'.$suma_cuartos_hospedaje.'</td>
                      <td class="total_corte">$'.number_format($total_cuartos_hospedaje, 2).'</td>
                    </tr>';
                    echo '
                  </tbody>
                </table>
                </div>
          </div>

          <div class="col">';
              $ids= $forma_pago->total_elementos();
              echo '
              <h5>Desglose en Sistema</h5>
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Forma de Pago</th>
                    <th>Total</th>
                    </tr>
                  </thead>
                <tbody>';
                    $cantidad= count($ids);
                    for($z=0 ; $z<$cantidad; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table text-center">';
                        }
                          echo '<td>'.$forma_pago->obtener_descripcion($ids[$z]).'</td>
                          <td class="total_corte">$'.number_format($inf->total_pago[$ids[$z]], 2).'</td>
                        </tr>';
                    }
                    echo '
                  </tbody>
                </table>
                </div>
          </div>
        </div>';
        //<div class="text-dark margen-1"></div> */
  $consulta_abono=$ticket->tipo_abonos();
  $bandera = 0;
  while ($fila = mysqli_fetch_array($consulta_abono))
  {
      $abonos[$fila['id']]=$fila['descripcion'];
  }
  
  foreach ($abonos as $clave => $valor){
    $listas=array();
    $consulta=$ticket->sacar_tickets_corte($_GET['usuario_id'],$clave);
    $total_cargo=0;
    $total_abono=0;
    if ($consulta->num_rows > 0) {
      while ($fila = mysqli_fetch_array($consulta))
      {
        $listas[$fila['mov']]['fecha']=$fila['fecha'];
        $listas[$fila['mov']]['folio_casa']=$fila['mov'];
        $listas[$fila['mov']]['cuarto']='Habitacion '.$hab->mostrar_nombre_hab($fila['id_hab']);
        if (isset($listas[$fila['mov']]['folio'])){
          $listas[$fila['mov']]['folio']=$listas[$fila['mov']]['folio'].", ".$fila['id'];
        }else{
          $listas[$fila['mov']]['folio']=$fila['id'];
        }
        $listas[$fila['mov']]['observaciones']=$fila['comentario'];

        $fila_cuenta=$cuenta->sacar_cargo_abono($fila['id']);
        if (!isset($listas[$fila['mov']]['cargo'])){
          $fila_cargo=$cuenta->sacar_cargo($fila['mov']);
          $listas[$fila['mov']]['cargo']=$fila_cargo;
          $total_cargo+=$fila_cargo;
        }
        if (isset($listas[$fila['mov']]['abono'])){
          $listas[$fila['mov']]['abono']=$listas[$fila['mov']]['abono']+$fila_cuenta['abono'];
          $total_abono+=$fila_cuenta['abono'];
        }else{
          $listas[$fila['mov']]['abono']=$fila_cuenta['abono'];
          $total_abono+=$fila_cuenta['abono'];
        }
        
        $listas[$fila['mov']]['usuario']=$usuario->obtengo_nombre_completo($_GET['usuario_id']);
      }
      echo '<h3>'.$valor.'</h3>';
      //var_dump($listas);
      echo '
        <div class="col">
          <div class="table-responsive" id="tabla_tipo">
            <table class="table table-bordered table-hover">
              <thead>
                <tr class="table-primary-encabezado text-center">
                <th>Fecha</th>
                <th>Folio casa</th>
                <th>Cuarto</th>
                <th>FPosteo</th>
                <th>Obsevaciones</th>
                <th>Usuario</th>
                <th>Cargo</th>
                <th>Abono</th>
                </tr>
              </thead>
              <tbody>';
                foreach ($listas as $item) {
                  echo'
                  <tr class="text-center">
                    <td>'.$item['fecha'].'</td>
                    <td>'.$item['folio_casa'].'</td>
                    <td>'.$item['cuarto'].'</td>
                    <td>'.$item['folio'].'</td>
                    <td>'.$item['observaciones'].'</td>
                    <td>'.$item['usuario'].'</td>
                    <td>$'.number_format($item['cargo'],2).'</td>
                    <td>$'.number_format($item['abono'],2).'</td>
                  </tr>';
                }
              echo'
                <tr class="text-center">
                  <td colspan="5"></td>
                  <th>Total:</th>
                  <th class="total_corte">$'.number_format($total_cargo,2).'</th>
                  <th class="total_corte">$'.number_format($total_abono,2).'</th>
                  <td></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      ';
      $bandera = $bandera + 1;
    }
    echo '';
  }
  if($bandera <= 0) {
    echo '
    <div class="alert alert-warning" role="alert">
      Sin info que mostrar
    </div>
    ';
  }
  
  //var_dump($consulta);
  echo '
    
  </div>

  <script>handle_btn_corte_diario()</script>
';
?>

