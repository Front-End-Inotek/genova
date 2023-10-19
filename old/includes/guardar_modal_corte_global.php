<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_corte.php");
  $corte= NEW Corte(0);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '¿Realizar corte?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="guardar_corte_global()"> Aceptar</button>
    </div>
  </div>';
?>
