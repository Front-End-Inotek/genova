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
          <h3>Asignar reservación. - Habitación '.$hab->nombre.'</h3>
          </div>
          <div class="col-sm-12">
          Selecciona la reserva que se asignará a la habitación:
          </div>
        </div>
        <button type="button" class="btn btn-light" data-dismiss="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
      </div>
      <div class="modal-body">';
      echo '<div class="contenedor_botones">';
      $hab->select_hab_reserva($_GET['hab_id'],$_GET['estado'],1,$hab_tipo);
        echo '</div>';
      echo '</div>
      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>