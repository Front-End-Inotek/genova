<?php
  date_default_timezone_set('America/Mexico_City');
  //$_GET['id'] reservacion
  //$_GET['usuario_id']
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_usuario.php");
  include_once('clase_log.php');
  $hab= NEW Hab($_GET['hab_id']);
  $reservaciones = NEW Reservacion($_GET['id']);
  $usuario = NEW Usuario(0);
  $logs = NEW Log(0);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-sm-12">
          <h3>LIMPIEZA - Habitación '.$hab->nombre.'</h3>
          </div>
          <div class="col-sm-12">
          Selecciona la recamarera que hara la limpieza:
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div><br>

      <div class="modal-body">';
        echo '<div class="row">';
          $usuario->select_reca($_GET['hab_id'],$_GET['estado'],1);
        echo '</div>';
      echo '</div>

      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';

  $logs->guardar_log($_POST['usuario_id'],"Checkin en habitacion: ". $hab->nombre);
?>