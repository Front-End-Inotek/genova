<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab = NEW Hab(0);

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Seleccionar cuarto para cambiar cargo $'.number_format($_GET['cargo'], 2).'
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '<div class="row">';
        $hab->cambiar_hab_ocupada($_GET['id'],$_GET['hab_id'],$_GET['estado']); 
      echo '</div>
    <div>     

    <div class="modal-footer" id="boton_abono">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="modificar_herramientas_cargo('.$_GET['ciclo'].','.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>
