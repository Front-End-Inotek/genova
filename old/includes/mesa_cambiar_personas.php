<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_mesa.php");
  include_once("clase_movimiento.php");
  $mesa= NEW Mesa($_GET['mesa_id']);
  $movimiento= NEW Movimiento(0);
  $personas= $movimiento->saber_personas($mesa->mov);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Comensales en Mesa '.$mesa->nombre.'
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
      echo '<div class="row">
        <div class="col-sm-3">Cantidad personas:</div>
        <div class="col-sm-8">
        <div class="form-group">
        <input class="form-control" type="number"  id="personas" value="'.$personas.'"/>
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="cambiar_personas('.$_GET['mesa_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>