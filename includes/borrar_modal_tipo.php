<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  $herramienta= NEW Herramienta($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      $mostrar = $herramienta->nombre_herramienta($_GET['id']);
      echo '¿Borrar Herramienta '.$mostrar.'?';
      echo '
    </div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-outline-danger btn-lg" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-outline-info btn-lg" onclick="borrar_herramienta('.$_GET['id'].')"><span class="glyphicon glyphicon-edit"></span> Aceptar</button>
    </div>
  </div>';
?>
