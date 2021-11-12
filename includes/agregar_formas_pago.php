<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR FORMA DE PAGO</h2></div>
        <div class="row">
          <div class="col-sm-2">Descripcion:</div>
          <div class="col-sm-7">
          <div class="form-group">
            <input class="form-control" type="text"  id="descripcion" placeholder="Ingresa la descripcion de la forma de pago" maxlength="20">
          </div>
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-2">
          <div id="boton_forma">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_forma_pago()">
          </div>
          </div>
        </div>
      </div>';
?>
