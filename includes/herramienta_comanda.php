<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  $concepto = NEW Concepto(0);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Herramientas
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div></br>
      
    <div class="modal-body">';
      $concepto->mostar_info_comanda($_GET['comanda']);
      echo '</br>
      <div class="row">
        <div class="col-sm-1"></div>
        <div class="col-sm-5">
          <a href="#" class="btn btn-warning btn-block" onclick="editar_modal_producto_mesa('.$_GET['mesa_id'].','.$_GET['comanda'].','.$_GET['cantidad'].','.$_GET['precio'].','.$_GET['producto'].')">Editar</a>
        </div>
        <div class="col-sm-5">
          <a href="#" class="btn btn-danger btn-block" onclick="borrar_modal_producto_mesa('.$_GET['mesa_id'].','.$_GET['comanda'].','.$_GET['producto'].')">Borrar</a>
        </div>
        <div class="col-sm-1"></div>
      </div>
    </div></br>';

    echo ' <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
