<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_ticket.php");
  $ticket = NEW Ticket(0);
  echo '<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title">Herraminetas</h2>
      </div>';
      echo '<div class="container-fluid">';
      echo '</br>';
      $ticket->mostar_info_comanda($_GET['comanda']);

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
      </div>';
  echo '<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>';
?>
