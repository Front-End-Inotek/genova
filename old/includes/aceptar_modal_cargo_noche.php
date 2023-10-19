<?php
  date_default_timezone_set('America/Mexico_City');
  include_once('clase_cargo_noche.php');
  include_once("clase_hab.php");
  $cargo_noche = NEW Cargo_noche(0);
  $hab= NEW Hab(0);
  $numero_actual= $cargo_noche->ultima_insercion();
  $numero_actual++;//'.$numero_actual.'
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '¿Aplicar cargo por noche en las habitaciones seleccionadas?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="cargo_noche()"> Aceptar</button>
    </div>
  </div>';
?>