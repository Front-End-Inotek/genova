<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  include_once("clase_tipo.php");
  $ticket= NEW Ticket(0);
  $tipo= NEW Tipo(0);
  $ticket_inicial= $ticket->ticket_ini();
  $ticket_final= $ticket->ticket_fin();
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

        <div class="col-sm-4">
          <div class="panel panel-success">
            <div class="panel-heading">Detalles</div>
            <div class="panel-body color_black">';
            $cantidad= $tipo->total_elementos();
            
            echo '<p>Hospedaje</p>
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
                for($z =0 ; $z<$cantidad; $z++)
                {
                    echo '<tr class="text-center">';
                      if(($z%2)==0){
                        echo '<tr class="info">';
                      }else{
                          echo '<tr class="active">';
                      }
                      echo '
      
                        <td>'.$inf->hab_tipo_hospedaje[$z].'</td>
                        <td>$'.$inf->hab_precio_hospedaje[$z].'</td>
                        <td>'.$inf->hab_cantidad_hospedaje[$z].'</td>
      
                        <td>$'.$inf->hab_total_hospedaje[$z].'</td>
                      </tr>
                      ';
                      $total_cuartos_hospedaje=$total_cuartos_hospedaje+$inf->hab_total_hospedaje[$z];
                      $suma_cuartos_hospedaje=$suma_cuartos_hospedaje+$inf->hab_cantidad_hospedaje[$z];
                    
                    
                }
                echo '
                      <tr class="warning">
                        <td></td>
                        <td></td>
                        <td>'.$suma_cuartos_hospedaje.'</td>
                        <td>$'.$total_cuartos_hospedaje.'</td>
                      </tr>';
                echo '
              </tbody>
            </table>
            </div>';

          echo '  </div>
        </div>


      </div>';
?>

