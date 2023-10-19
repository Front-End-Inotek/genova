<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $entrada = date('Y-m-d',$reservacion->fecha_entrada);
  $salida = date('Y-m-d',$reservacion->fecha_salida);
  $tipo_hab = $_GET['tipo_hab'];
  $numero_hab = $_GET['numero_hab'];
  $multiple="";
  // if($numero_hab>1){
  //   $multiple="multiple";
  // }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Preasignar Reservación: '.$_GET['id']; 
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-4" >Habitaciones disponibles:</div>
        <div id="re"></div>
        <div class="col-sm-9" >
        <div class="form-group">
        <select class="form-control select" id="preasignada" '.$multiple.'>';
        
       echo  $reservacion->comprobarFechaReserva($entrada,$salida,0,0,$tipo_hab)[1];
        echo '
        </select>
        </div>
        </div>
      </div><br>
    </div>
    
    <div class="modal-footer" id="boton_cancelar_reservacion">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button id="boton_cancelar_reservacion" type="button" class="btn btn-success" onclick="guardar_preasignar_reservacion('.$_GET['id'].','.$_GET['opcion'].')"> Aceptar</button>
    </div>
  </div>';
?>
