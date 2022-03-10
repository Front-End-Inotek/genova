<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_corte_info.php");
  $ticket= NEW Ticket(0);
  $tipo= NEW Tipo(0);
  $ticket_inicial= $ticket->ticket_ini();
  $ticket_final= $ticket->ticket_fin();
  $inf= NEW Corte_info($ticket_inicial,$ticket_final);
  $total_cuartos_hospedaje=0;
  $suma_cuartos_hospedaje=0; 
  echo '
      <div class="container-fluid blanco">
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">HACER CORTE</h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4>
          </div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <input type="submit" class="btn btn-danger btn-block" value="Hacer Corte" onclick="realiza_corte_sin_caja('. $ticket_inicial.','. $ticket_final.')">
          </div>
          </div>
        </div>
        
        <div class="text-dark margen-1"></div>

        <div class="row">
          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              
              echo '<div class="card-header">Hospedaje</div>
              
              <div class="card-body">
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Tipo</th>
                    <th>Precio</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    </tr>
                  </thead>
                <tbody>';
                    $cantidad= $tipo->total_elementos();
                    for($z=0 ; $z<$cantidad; $z++)
                    {
                        if(($z%2) == 0){
                          echo '<tr class="table-white text-center">';
                        }else{
                          echo '<tr class="table-secondary text-center">';
                        }
                          echo '<td>'.$inf->hab_tipo_hospedaje[$z].'</td>
                          <td>$'.$inf->hab_precio_hospedaje[$z].'</td> 
                          <td>'.$inf->hab_cantidad_hospedaje[$z].'</td> 
                          <td>$'.$inf->hab_total_hospedaje[$z].'</td> 
                        </tr>';
                        $total_cuartos_hospedaje= $total_cuartos_hospedaje+$inf->hab_total_hospedaje[$z];
                        $suma_cuartos_hospedaje= $suma_cuartos_hospedaje+$inf->hab_cantidad_hospedaje[$z];
                    }
                    echo '<tr class="warning">
                      <td></td>
                      <td></td>
                      <td>'.$suma_cuartos_hospedaje.'</td>
                      <td>$'.$total_cuartos_hospedaje.'</td>
                    </tr>';
                    echo '
                  </tbody>
                </table>
              </div>
              
            </div>
          </div>

          <div class="col-sm-4"></div>
          </div>
          
          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              $cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header">Extras</div>
              
              <div class="card-body">
              </div>
              
            </div>
          </div>

          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              $cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header">Totales</div>
              
              <div class="card-body">
              </div>
              
            </div>
          </div>

        </div>
        <div class="text-dark margen-1"></div>

        <div class="row">
          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              
              echo '<div class="card-header">Ventas Restaurante</div>
              
              <div class="card-body">
                <div class="table-responsive" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Producto</th>
                    <th>Venta</th>
                    <th>Precio</th>
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
                          <td>'.$inf->producto_venta[$z].'</td>
                          <td>$'.$inf->producto_precio[$z].'</td>
                          <td>$'.($inf->producto_venta[$z] * $inf->producto_precio[$z]).'</td>
                          <td>'.$inf->producto_tipo_venta[$z].'</td>
                          <td>'.($inf->producto_venta[$z] - $inf->producto_tipo_venta[$z]).'</td>
                        </tr>';
                    }
                    echo '
                  </tbody>
                </table>
              </div>
              
            </div>
          </div>

          <div class="col-sm-4"></div>
          </div>
          
          <div class="col-sm-4">';
            /*<div  class="card bg-light text-dark">';
              $cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header">Totales</div>
              
              <div class="card-body">
              </div>
              
            </div>*/
          echo '</div>

          <div class="col-sm-4">
            <div  class="card bg-light text-dark">';
              $cantidad= $tipo->total_elementos();
              
              echo '<div class="card-header">Desgloce en Sistema</div>
              
              <div class="card-body">
              </div>
              
            </div>
          </div>

        </div>


      </div>';
?>

