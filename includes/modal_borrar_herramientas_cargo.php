<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['hab_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h3>Borrar cargo</h3>
      <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">';
      $nombre= $hab->nombre;
      if($_GET['id_maestra']==0){
        echo '¿Borrar cargo $'.number_format($_GET['cargo'], 2).' de habitacion '.$nombre.'?';
      }else{
        include_once('clase_cuenta_maestra.php');
        $cm = new CuentaMaestra($_GET['id_maestra']);
        echo '¿Borrar cargo $'.number_format($_GET['cargo'], 2).' de cuenta maestra '.$cm->nombre.'?';
      }
      echo '
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="borrar_herramientas_cargo('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['id_maestra'].','.$_GET['mov'].')"> Aceptar</button>
    </div>
  </div>';
?>
