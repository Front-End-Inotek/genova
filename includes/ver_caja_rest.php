<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_mesa.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  $mesa= NEW  Mesa($_GET['mesa_id']);
  $inventario= NEW Inventario(0);
  $concepto= NEW Concepto(0);
  $ticket= NEW Ticket(0);
  $ticket_id= $ticket->saber_id_ticket($mesa->mov);
  $precio= $concepto->saber_total_mesa($ticket_id);
  echo '
  <div class="modal-content alinear_centro">
    <h5>Caja</h5>
    <div class="col-sm-12 fondo_rest" style="background-color:white;"><br>  

      <div class="row">
        <div class="col-sm-6" style="background-color:white;">
          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Pedido</h5>
            </div>

            <div class="card-body alinear_izq" style="background-color:white;">';
              $concepto->mostrar_comanda($_GET['mesa_id'],$ticket_id);
            echo '</div>
          </div>
        </div>
        
        <div class="col-sm-6" style="background-color:white;">
          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Pagos</h5>
            </div>

            <div class="card-body alinear_centro" style="background-color:white;">';
             
              echo '<div class="col-sm-12">
              
                <div class="row margen_inf">
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="efectivo" placeholder="Efectivo" onclick="mostrarteclado_rest(8,'.$precio.')" placeholder="Efectivo" onKeyUp="suma_cobro_rest_caja('.$precio.')">
                  </div>
                  <div class="col-sm-4">
                    <input class="form-control" type="number" id="cambio" placeholder="Cambio" disabled>
                  </div>
                  <div class="col-sm-4">
                  </div>
                </div>
                    
                <div class="row margen_inf">
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="tarjeta" placeholder="Tarjeta" onclick="mostrarteclado_rest(17,'.$precio.')">
                  </div>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="autoriza" placeholder="Folio de autorización" onclick="mostrarteclado_rest(18,'.$precio.')">
                  </div>
                  <div class="col-sm-4">
                  </div>
                </div>
                    
                <div class="row margen_inf">
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="cortesia" placeholder="Cortesia" onclick="mostrarteclado_rest(9,'.$precio.')">
                  </div>
                  <div class="col-sm-8">
                  </div>
                </div>  
                
              </div>';

            echo '</div>
          </div><br>
          
          <div class="row" id="tecaldo">
          </div>

        </div>

      </div><br>

    </div>
  </div>';
?>
