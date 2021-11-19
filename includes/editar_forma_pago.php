<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_forma_pago.php");
  $forma_pago= NEW Forma_pago($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR FORMA DE PAGO</h2></div>
        <div class="row">
          <div class="col-sm-2">Descripcion:</div>
          <div class="col-sm-7">
          <div class="form-group">
            <input class="form-control" type="text"  id="descripcion" value="'.$forma_pago->descripcion.'" maxlength="50">
          </div>
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_forma_pago('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-11"></div>
        </div>
        <div class="row">
          <div class="col-sm-11"></div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_forma_pago()"> ←</button></div>
        </div>
      </div>';
?>
