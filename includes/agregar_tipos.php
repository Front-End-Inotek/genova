<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR TIPO DE HABITACION</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-7">
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el nombre del tipo de habitación" maxlength="90">
          </div>
          </div>
          <div class="col-sm-3"></div>
        </div>
        <div class="row">
          <div class="col-sm-2">Código:</div>
          <div class="col-sm-7">
          <div class="form-group">
            <input class="form-control" type="text"  id="codigo" placeholder="Ingresa el código del tipo de habitación" maxlength="20">
          </div>
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_tipo()">
          </div>
          </div>
        </div>
      </div>';
?>
