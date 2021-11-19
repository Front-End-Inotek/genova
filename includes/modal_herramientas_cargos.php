<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_salida.php");
  $material_salido= NEW Material_salido($_GET['producto']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Agregar Productos Salida
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-12">';
        $material = $material_salido->nombre_producto($_GET['producto']);
        echo '  '.$material; 
        echo '</div>
      </div><br>
        
      <div class="row">
        <div class="col-sm-5">Agregar cantidad:</div>
        <div class="col-sm-7">
        <div class="form-group">
        <input class="form-control" type="number"  id="cantidad" value="1">
        </div>
        </div>
      </div><br>

      <div class="row">
        <div class="col-sm-5">Numero de seguimiento:</div>
        <div class="col-sm-7">
        <div class="form-group">
        <input class="form-control" type="text"  id="numero_seguimiento" placeholder="Ingresa el numero de seguimiento" maxlength="15">
        </div>
        </div>
      </div><br>
    </div>  

    <div class="modal-footer" id="boton_asignar_agregar_producto_salida">
      <button type="button" class="btn btn-outline-danger btn-lg" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-outline-info btn-lg" onclick="asignar_agregar_producto_salida('.$_GET['producto'].','.$_GET['salida_id'].')"><span class="glyphicon glyphicon-edit"></span> Aceptar</button>
    </div>
  </div>';
?>
