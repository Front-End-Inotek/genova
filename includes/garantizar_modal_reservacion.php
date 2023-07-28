<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_forma_pago.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $forma_pago = new Forma_pago(0);
  $preasignada = 0;

  $correo = $_GET['correo'];
  $garantizada = $_GET['garantizada'];

  if(isset($_GET['preasignada']) && $_GET['preasignada']!=0){
    $preasignada=$_GET['preasignada'];
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Garantizar Reservación: '.$_GET['id']; 
      echo '<button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-3" >Estado:</div>
        <div class="col-sm-9" >
        <div class="form-group">
        <select class="form-control" id="estado"  onchange="editarTotalEstancia(event)">
        <option value="">Seleccione una opción</option>
        <option value="garantizada">Garantizada</option>
        <option value="pendiente">Sin garantía</option>
        </select>
        </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3 asterisco" >Método de garantía:</div>
        <div class="col-sm-9" >
        <div class="form-group">
        <select class="form-control" id="forma-garantia" required onchange="obtener_garantia(event)" >
        <option value="">Seleccione una opción </option>
        ';
    
        $forma_pago->mostrar_forma_pago();
        echo'
        </select>
        </div>
        </div>
      </div>
      <div class="row">
      <div class="col-sm-3" >Monto:</div>
      <div class="col-sm-9" >
      <div class="form-group">
      <input class="form-control" type="text"  id="monto" placeholder="Ingresa el monto con el que garantizas la reservación" maxlength="60">
      </div>
      </div>
    </div>
      <br>
    </div>
    
    <div class="modal-footer" id="boton_cancelar_reservacion">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="garantizar_reservacion('.$_GET['id'].','.$preasignada.',\''.$correo.'\','.$garantizada.')"> Aceptar</button>
    </div>
  </div>';
?>
