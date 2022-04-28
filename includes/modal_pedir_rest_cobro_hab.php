<?php
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['hab_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Pago del Restaurante
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      //$mostrar = $huesped->obtengo_nombre($_GET['id']);
      echo '¿Realizar el cargo de $'.number_format($_GET['total'], 2).' a la habitación '.$hab->nombre.'?';
      echo '
    </div><br>   

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="aplicar_rest_cobro('.$_GET['total'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].',0)"> Aceptar</button>
    </div>
  </div>';
?>