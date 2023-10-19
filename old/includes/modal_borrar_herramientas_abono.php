<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['hab_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Borrar abono
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      $nombre= $hab->nombre;
      if($_GET['id_maestra']==0){
        echo '¿Borrar abono $'.number_format($_GET['abono'], 2).' de habitacion '.$nombre.'?';
      }else{
        require_once('clase_cuenta_maestra.php');
        $cm = new CuentaMaestra($_GET['id_maestra']);
        echo '¿Borrar abono $'.number_format($_GET['abono'], 2).' de cuenta maestra '.$cm->nombre.'?';
      }
     
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="borrar_herramientas_abono('.$_GET['id'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].','.$_GET['id_maestra'].')"> Aceptar</button>
    </div>
  </div>';
?>
