<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['hab_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Borrar cargo
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      $nombre= $hab->nombre;
      echo '¿Borrar cargo $'.number_format($_GET['cargo'], 2).' de habitacion '.$nombre.'?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="borrar_herramientas_cargo('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>
