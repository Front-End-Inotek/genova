<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container">
        <br>
        <div class="col-sm-12 text-left"><h2 class="text-dark">AGREGAR TIPO DE HABITACION</h2></div></br><br><br>
        <div class="row">
          <div class="col-sm-2" >Nombre:</div>
          <div class="col-sm-7" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el nombre del tipo de habitacion" maxlength="90">
          </div>
          </div>
          <div class="col-sm-1" ></div>
          <div class="col-sm-2" >
          <div id="boton_tipo">
          <input type="submit" class="btn btn-success btn-lg btn-block" value="Guardar" onclick="guardar_tipo()">
          </div>
        </div>
        </div><br>
      </div>';
?>
