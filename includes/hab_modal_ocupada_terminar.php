<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_movimiento.php");
  $hab= NEW Hab($_GET['hab_id']);
  $movimiento= NEW movimiento(0);
  $estado_interno= $movimiento->mostrar_estado_interno($hab->mov);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
        ¿Terminar estado '.$estado_interno.' de la habitación '.$hab->nombre.'?
    </div><br>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="hab_ocupada_terminar('.$_GET['hab_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>