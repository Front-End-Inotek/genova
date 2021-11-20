<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab = NEW Hab(0);

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">';
      if($_GET['monto'] == 1){
        echo 'Seleccionar cuarto para cambiar cargo $'.number_format($_GET['monto'], 2).'';
      }else{
        echo 'Seleccionar cuarto para cambiar abono $'.number_format($_GET['monto'], 2).'';
      }
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '<div class="row">';
        $hab->cambiar_hab_ocupada($_GET['monto'],$_GET['id'],$_GET['hab_id'],$_GET['estado']); 
      echo '</div>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
    </div>
  </div>';
?>
