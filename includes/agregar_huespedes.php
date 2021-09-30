<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR HUÉSPEDES</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" placeholder="Ingresa el nombre del huesped" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Apellido:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="apellido" placeholder="Ingresa el apellido del huesped" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Direccion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" placeholder="Ingresa la direccion del huesped" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Ciudad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="ciudad" placeholder="Ingresa la ciudad del huesped" maxlength="30">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Estado:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="estado" placeholder="Ingresa el estado del huesped" maxlength="30">
          </div>
          </div>
          <div class="col-sm-2">Codigo postal:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="codigo_postal" placeholder="Ingresa el codigo postal del huesped" maxlength="20">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Telefono:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="telefono" placeholder="Ingresa el telefono del huesped" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Correo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="correo" placeholder="Ingresa el correo del huesped" maxlength="200">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Preferencias del huésped:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="preferencias" placeholder="Ingresa las preferencias del huesped">
          </div>
          </div>
          <div class="col-sm-2">Comentarios adicionales:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="comentarios" placeholder="Ingresa los comentarios adicionales">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
          <div id="boton_huesped">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_huesped()">
          </div>
        </div>
      </div>';
?>
