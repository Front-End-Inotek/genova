<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  include_once("clase_forma_pago.php");
  include_once("clase_corte_info.php");
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
      <div class="container-fluid blanco">
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">HACER CORTE</h2></div>
        <div class="row">
          <div class="col-sm-8"></div>
          <div class="col-sm-2">';
            //echo '<h4>Tickets '.$ticket->obtener_etiqueta($ticket_inicial).' - ' .$ticket->obtener_etiqueta($ticket_final);echo '</h4> onclick="aceptar_guardar_corte('. $ticket_inicial.','. $ticket_final.')
          echo '</div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <input type="submit" class="btn btn-danger btn-block" value="Hacer Corte" href="#caja_herramientas" data-toggle="modal" onclick="aceptar_guardar_corte()">
          </div>
          </div>
        </div>
        
        <div class="text-dark margen-1"></div>

        <div class="row">

          <div class="col-sm-12">
            <div  class="card bg-light text-dark">';
              
              echo '<div class="card-header">Cargos</div>
              
              <div class="card-body">
                <div class="table-responsive" style="height:100%" id="tabla_tipo">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr class="table-primary-encabezado text-center">
                    <th>Habitación/Folio Maestra</th>
                    <th>Descripción</th>
                    <th>Cargo</th>
                    <th>Abono</th>
                    
                    </tr>
                  </thead>
                <tbody>';
                echo '<tr class="table-secondary" style="text-align:left">';

                echo '<td>Cargos</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                ';
                echo '<tr class="table-secondary">';

                echo '<td>Habitación 1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>
                ';


                      echo '<tr class="table-primary  text-center">
                        <td></td>
                        <td></td>
                        <td>'.$total_productos.'</td>
                        <td>$'.number_format($total_restaurante, 2).'</td>
                       
                      </tr>';
                    echo '
                  </tbody>
                </table>
                </div>
              </div>
              
            </div>
          </div>


        </div>';

  ;
?>

