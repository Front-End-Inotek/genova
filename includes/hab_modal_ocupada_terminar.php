<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_movimiento.php");
  $hab= NEW Hab($_GET['hab_id']);
  $movimiento= NEW movimiento(0);
  $estado_interno= $movimiento->mostrar_estado_interno($hab->mov);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div><br>

    <div class="modal-body">
        ¿Terminar estado '.$estado_interno.' de la habitación '.$hab->nombre.'?
    </div><br>
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="hab_ocupada_terminar('.$_GET['hab_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>