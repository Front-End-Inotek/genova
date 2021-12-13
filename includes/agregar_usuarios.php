<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR USUARIO</h2></div>
        <div class="row">
          <div class="col-sm-2">Usuario:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="usuario" placeholder="Ingresa el nombre para el usuario" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Nombre completo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre_completo" placeholder="Ingresa el nombre completo del usuario" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Contraseña:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="password" id="contrasena" placeholder="Ingresa la contraseña del usuario" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Categoria:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="form-control" id="nivel">
              <option value="0">Selecciona</option>
              <option value="1">Administrador</option>
              <option value="2">Cajera</option>
              <option value="3">Recamarera</option>
              <option value="4">Mantenimiento</option>
              <option value="5">Supervision</option>
              <option value="6">Restaurante</option>
              <option value="7">Reservaciones</option>
              <option value="8">Ama Llaves</option>
              <option value="9">Indefinido</option>
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Contraseña:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="password" id="recontrasena" placeholder="Ingresa nuevamente la contraseña del usuario" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Puesto:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="puesto" placeholder="Ingresa el puesto del usuario" maxlength="40">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Celular:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="celular" placeholder="Ingresa el celular del usuario" maxlength="20">
          </div>
          </div>
          <div class="col-sm-2">Correo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="correo" placeholder="Ingresa el correo del usuario" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Direccion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" placeholder="Ingresa la direccion del usuario">
          </div>
          </div>
          <div class="col-sm-4"></div>
          <div class="col-sm-2">
          <div id="boton_usuario">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_usuario()">
          </div>
          </div>
        </div>
      </div>';
?>

