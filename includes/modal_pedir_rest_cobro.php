<?php
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  include_once("clase_forma_pago.php");
  $categoria=NEW Categoria(0);
  $pedido=NEW Pedido_rest(0);
  $forma_pago= NEW Forma_pago(0);
  $total= $_GET['total'];
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Pago del Restaurante
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-2">Efectivo:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="number" id="efectivo" placeholder="Dinero en efectivo" onKeyUp="cambio_rest_cobro('.$total.')">
        </div>
        </div>
        <div class="col-sm-2">Cambio:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="number" id="cambio"  placeholder="0" disabled>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2">Monto:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="number" id="monto" placeholder="Otro metodo de pago">
        </div>
        </div>
        <div class="col-sm-2">Forma de Pago:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <select class="form-control" id="forma_pago">
            <option value="0">Selecciona</option>';
            $forma_pago->mostrar_forma_pago_restaurante();
            echo '
          </select>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-2">Folio de Autorización:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="number" id="folio" placeholder="Folio autorización tarjeta">
        </div>
        </div>
        <div class="col-sm-2">Descuento:</div>
        <div class="col-sm-4">
        <div class="form-group">
          <input class="form-control" type="number" id="descuento" placeholder="Ingresa el descuento">
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-10"></div>
        <div class="col-sm-2">Total: $'.number_format($total, 2).'</div>
      </div>
      <br>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="aplicar_rest_cobro('.$_GET['comentario'].')"> Cobrar</button>
    </div>
  </div>';
?>