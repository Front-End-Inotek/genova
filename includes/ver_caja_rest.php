<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_mesa.php");
  include_once("clase_forma_pago.php");
  include_once("clase_inventario.php");
  include_once("clase_ticket.php");
  $mesa= NEW  Mesa($_GET['mesa_id']);
  $forma_pago= NEW Forma_pago(0);
  $inventario= NEW Inventario(0);
  $concepto= NEW Concepto(0);
  $ticket= NEW Ticket(0);
  $ticket_id= $ticket->saber_id_ticket($mesa->mov);
  $precio= $concepto->saber_total_mesa($ticket_id);
  $total= 0;

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
              $total= $concepto->mostrar_comanda($_GET['mesa_id'],$ticket_id);
              if($total > 0){
                echo '<div class="row">
                  <div class="col-sm-3 fuente_menor_bolder margen_sup_pedir">
                  </div>
                  <div class="col-sm-2 fuente_menor_bolder margen_sup_pedir">
                    <h6 for="sel1">Total: </h6>
                  </div>
                  <div class="col-sm-2 fuente_menor_bolder margen_sup_pedir">
                    <h6 for="sel1"><input class="form-control alinear_centro" type="number" id="total"  placeholder="'.number_format($precio, 2).'" disabled></h6>
                  </div>
                  <div class="col-sm-2 fuente_menor_bolder margen_sup_pedir">';
                    echo '<button type="button" id="boton_cobrar" class="btn btn-danger btn-block" onclick="aplicar_rest_cobro('.$precio.','.$_GET['mesa_id'].','.$_GET['estado'].','.$mesa->mov.',1)"> Cobrar</button>';                                                                                                                                               //('.$total.','.$hab_id.','.$estado.','.$mov.')">Pedir</button></></div>';    
                  echo '</div>
                  <div class="col-sm-2 fuente_menor_bolder margen_sup_pedir">';
                    echo '<button class="btn btn-success btn-block"  href="#caja_herramientas" data-toggle="modal" onclick="modal_cargar_rest_cobro('.$precio.','.$_GET['mesa_id'].','.$_GET['estado'].','.$mesa->mov.')">Cargar</button></>';                                                                                                                                                 //('.$total.','.$hab_id.','.$estado.','.$mov.')">Pedir</button></></div>';    
                  echo '</div>
                  <div class="col-sm-1 fuente_menor_bolder margen_sup_pedir">
                  </div>
                </div><br>';
              }
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
                    <input type="number" class="form-control" id="efectivo" placeholder="Efectivo" onclick="mostrarteclado_rest(2,'.$precio.')" placeholder="Efectivo" onKeyUp="suma_cobro_rest_caja('.$precio.')">
                  </div>
                  <div class="col-sm-4">
                    <input class="form-control" type="number" id="cambio" placeholder="Cambio" disabled>
                  </div>
                  <div class="col-sm-4">
                  </div>
                </div>
                    
                <div class="row margen_inf">
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="monto" placeholder="Monto" onclick="mostrarteclado_rest(3,'.$precio.')">
                  </div>
                  <div class="col-sm-4">
                    <select class="form-control" id="forma_pago">
                      <option value="0">Selecciona</option>';
                      $forma_pago->mostrar_forma_pago_restaurante();
                      echo '
                    </select>
                  </div>
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="folio" placeholder="Folio de autorización" onclick="mostrarteclado_rest(4,'.$precio.')"  maxlength="40">
                  </div>
                </div>
                    
                <div class="row margen_inf">
                  <div class="col-sm-4">
                    <input type="number" class="form-control" id="descuento" placeholder="Descuento" onclick="mostrarteclado_rest(5,'.$precio.')" onKeyUp="cambio_rest_descuento('.$total.')">
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="comentario" placeholder="Comentario del pedido" onclick="mostrarteclado_rest(6,'.$precio.')" maxlength="200">
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
