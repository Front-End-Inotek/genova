<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once("clase_hab.php");
  $usuario = NEW Usuario(0);
  $hab= NEW Hab($_GET['hab_id']);
  $hab_tipo = $hab->tipo;
  echo '
  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-sm-12">
          <h3>Cambiar hab. - Habitación '.$hab->nombre.'</h3>
          </div>
          <div class="col-sm-12">
          Selecciona la habitación a la que se cambiara:
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div><br>
      <div class="modal-body">';
        echo '<div class="row">';
          $hab->select_hab_cambio($_GET['hab_id'],$_GET['estado'],1,$hab_tipo);
        echo '</div>';
      echo '</div>
      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>