<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_mesa.php");
  $mesa= NEW Mesa($_GET['mesa_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      $mostrar = $mesa->nombre;
      echo '¿Imprimir ticket de la mesa '.$mostrar.'?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="imprimir_ticket('.$_GET['mesa_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>