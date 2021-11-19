<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  $tipo= NEW Tipo($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      $mostrar = $tipo->nombre;
      echo '¿Borrar tipo de habitacion '.$mostrar.'?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="borrar_tipo('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>
