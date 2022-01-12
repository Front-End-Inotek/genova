<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  $hab= NEW Hab(0);
  $reservaciones = NEW Reservacion($_GET['id']);
  $tipo_hab= $reservaciones->tipo_hab;
  echo '
  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-sm-12">
          <h3>HACER CHECKIN</h3>
          </div>
          <div class="col-sm-12">
          Selecciona la habitación disponible para asignar la reservación '.$_GET['id'].':
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div><br>

      <div class="modal-body">';
        echo '<div class="row">';
          $hab->select_asignar_reservacion($tipo_hab);
        echo '</div>';
      echo '</div>

      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>