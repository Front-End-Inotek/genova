<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab(0);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left "><h2 class="text-dark margen-1">AGREGAR HABITACIONES</h2></div>
        <div class="row">
          <div class="col-sm-3" >Nombre:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el nombre de la habitacion" maxlength="90">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Tipo de habitacion:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <select class="form-control" id="tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $hab->mostrar_hab();
              echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Comentario:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="comentario" placeholder="Ingresa el comentario de la habitacion" maxlength="250">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10" ></div>
          <div class="col-sm-2" >
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_hab()">
          </div>
        </div>
      </div>';
?>
