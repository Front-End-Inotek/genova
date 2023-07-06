<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte_info2.php");
  $ticket= NEW Ticket(0);
  $tipo= NEW Tipo(0);
  $forma_pago= NEW Forma_pago(0);
  /*$ticket_inicial= $ticket->ticket_ini();
  $ticket_final= $ticket->ticket_fin();
  $inf= NEW Corte_info($ticket_inicial,$ticket_final);*/
  $inf= NEW Corte_info();
  $total_cuartos_hospedaje= 0;
  $suma_cuartos_hospedaje= 0; 
  $total_cuartos= 0;
  $total_productos= 0;
  $total_restaurante= 0;
  $total_productos_hab= 0;
  $total_productos_rest= 0;
  echo '
      <div class="container-fluid blanco">
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">HACER CORTE DIARIO</h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          echo '</div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <input type="submit" class="btn btn-danger btn-block" value="Hacer Corte" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_guardar_corte_global()">
          </div>
          </div>
        </div>
        
        <div class="text-dark margen-1"></div>

        <div class="row">

          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              
              echo '<div class="card-header"><h5> Ventas Restaurante </h5> </div>
              
              <div class="card-body">
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
                        echo '<tr class="table-secondary text-center">';
                      }
                        echo '<td>'.$inf->producto_nombre[$z].'</td>
                        <td>$'.number_format($inf->producto_precio[$z], 2).'</td>
                        <td>'.$inf->producto_venta[$z].'</td>
                        <td>$'.number_format(($inf->producto_venta[$z] * $inf->producto_precio[$z]), 2).'</td>
                        <td>'.$inf->producto_tipo_hab[$z].'</td>
                        <td>'.$inf->producto_tipo_rest[$z].'</td>';
                        $total_restaurante= $total_restaurante + ($inf->producto_venta[$z] * $inf->producto_precio[$z]);
                        $total_productos= $total_productos + $inf->producto_venta[$z];
                        $total_productos_hab= $total_productos_hab + $inf->producto_tipo_hab[$z];
                        $total_productos_rest= $total_productos_rest + $inf->producto_tipo_rest[$z];
                    }
                      echo '<tr class="table-primary  text-center">
                        <td></td>
                        <td></td>
                        <td>'.$total_productos.'</td>
                        <td>$'.number_format($total_restaurante, 2).'</td>
                        <td>'.$total_productos_hab.'</td>
                        <td>'.$total_productos_rest.'</td>
                      </tr>';
                    echo '
                  </tbody>
                </table>
                </div>
              </div>
              
            </div>
          </div>

          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              
              echo '<div class="card-header"><h5>Hospedaje</h5></div>
              
              <div class="card-body">
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Tipo</th>';
                    //<th>Precio</th>
                    echo '<th>Cantidad</th>
                    <th>Total</th>
                    </tr>
                  </thead>
                <tbody>';
                    $cantidad= $tipo->total_elementos();
                    $c = sizeof($inf->hab_tipo_hospedaje);
                    for($z=0 ; $z<$c; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table-secondary text-center">';
                        }
                          echo '<td>'.$inf->hab_tipo_hospedaje[$z].'</td>';
                          //<td>$'.number_format($inf->hab_precio_hospedaje[$z], 2).'</td> 
                          echo '<td>'.$inf->hab_cantidad_hospedaje[$z].'</td> 
                          <td>$'.number_format($inf->hab_total_hospedaje[$z], 2).'</td> 
                        </tr>';
                        $total_cuartos_hospedaje= $total_cuartos_hospedaje + $inf->hab_total_hospedaje[$z];
                        $suma_cuartos_hospedaje= $suma_cuartos_hospedaje + $inf->hab_cantidad_hospedaje[$z];
                    }
                    echo '<tr class="table-primary  text-center">
                      <td></td>
                      <td>'.$suma_cuartos_hospedaje.'</td>
                      <td>$'.number_format($total_cuartos_hospedaje, 2).'</td>
                    </tr>';
                    echo '
                  </tbody>
                </table>
                </div>
              </div>
              
            </div>
          </div>

          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              //$cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header"><h5>Totales</h5></div>
              
              <div class="card-body">
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
                    //$concepto[2]= 'Personas Extras';
                    $concepto[2]= 'Total';
                    $total= array();
                    $total[0]= $inf->total_hab;
                    $total[1]= $inf->total_restaurante_entrada;
                    //$total[2]= 0;
                    $total[2]= $inf->total_global;
                    $cantidad= 2;
                    for($z=0 ; $z<$cantidad; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table-secondary text-center">';
                        }
                          echo '<td>'.$concepto[$z].'</td>
                          <td>$'.number_format($total[$z], 2).'</td>
                        </tr>';
                    }
                    echo '<tr class="table-primary  text-center">
                      <td>Total</td>
                      <td>$'.number_format($total[2], 2).'</td>
                    </tr>';
                    echo '
                  </tbody>
                </table>
                </div>
              </div>
              
            </div>

            <div class="text-dark margen-1"></div>

            <div  class="card bg-light text-dark">';
              $cantidad= $forma_pago->total_elementos();
              
              echo '<div class="card-header"><h5>Desgloce en Sistema</h5></div>
              
              <div class="card-body">
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Forma de Pago</th>
                    <th>Total</th>
                    </tr>
                  </thead>
                <tbody>';
                    $cantidad= $cantidad + 1;
                    for($z=1 ; $z<$cantidad; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table-secondary text-center">';
                        }
                          echo '<td>'.$forma_pago->obtener_descripcion($z).'</td>
                          <td>$'.number_format($inf->total_pago[$z-1], 2).'</td>
                        </tr>';
                    }
                    echo '
                  </tbody>
                </table>
                </div>
              </div>
              
            </div>

          </div>

        </div>';

        //<div class="text-dark margen-1"></div>

        echo '<div class="row">
             
          <div class="col-sm-4">';
            /*<div  class="card bg-light text-dark">';
              $cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header">Extras</div>
              
              <div class="card-body">
              </div>
              
            </div>*/
          echo '</div>

          <div class="col-sm-4">';
            /*<div  class="card bg-light text-dark">';
              $cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header">Totales</div>
              
              <div class="card-body">
              </div>
              
            </div>*/
          echo '</div>

          <div class="col-sm-4">';
            /*<div  class="card bg-light text-dark">';
              $cantidad= $forma_pago->total_elementos();
              
              echo '<div class="card-header">Desgloce en Sistema</div>
              
              <div class="card-body">
              </div>
              
            </div>*/
          echo '</div>

        </div>


      </div>';
?>

