<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['hab_id']);
  $nombre= $hab->nombre;

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">';
      echo 'Seleccionar un cuarto para cambiar todas las cuentas de la habitación '.$nombre.':';
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '<div class="row">';
        $hab->cambiar_cuentas_hab_ocupada($_GET['hab_id'],$_GET['estado'],$_GET['mov']); 
      echo '</div>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
