<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $preasignada = 0;

  if(isset($_GET['preasignada']) && $_GET['preasignada']!=0){
    $preasignada=$_GET['preasignada'];
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Cancelar Reservación: '.$_GET['id']; 
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-3" >Quién Cancela:</div>
        <div class="col-sm-9" >
        <div class="form-group">
          <input class="form-control" type="text"  id="nombre_cancela" placeholder="Ingresa el nombre de quién cancela" maxlength="60">
        </div>
        </div>
      </div><br>
    </div>
    
    <div class="modal-footer" id="boton_cancelar_reservacion">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="cancelar_reservacion('.$_GET['id'].','.$preasignada.')"> Aceptar</button>
    </div>
  </div>';
?>
