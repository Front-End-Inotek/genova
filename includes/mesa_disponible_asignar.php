<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_mesa.php");
  $mesa= NEW Mesa($_GET['mesa_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Asignar la mesa '.$mesa->nombre.'
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '<div class="row">
        <div class="col-sm-2">Personas:</div>
        <div class="col-sm-8">
        <div class="form-group">
        <input class="form-control" type="number"  id="personas" placeholder="Ingresa la cantidad de personas en la mesa" value="2"/>
        </div>
        </div>
        <div class="col-sm-2"></div>
      </div>
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="disponible_asignar_mesa('.$_GET['mesa_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>