<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container">
        <br>
        <div class="col-sm-12 text-center"><h1 class="text-primary">Agregar Herramienta</h1></div></br>
        <div class="row">
          <div class="col-sm-2" >Nombre:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el nombre de la herramienta" maxlength="50">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Marca:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="text"  id="marca" placeholder="Ingresa la marca de la herramienta" maxlength="30">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Modelo:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="text"  id="modelo" placeholder="Ingresa el modelo de la herramienta" maxlength="50">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Descripcion:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="text"  id="descripcion" placeholder="Ingresa la descripcion de la herramienta">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Cantidad en almacen:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="number"  id="cantidad_almacen" placeholder="Ingresa la cantidad de la herramienta en almacen">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Cantidad prestadas:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="number"  id="cantidad_prestadas" placeholder="Ingresa la cantidad de la herramienta prestada">
          </div>
          </div>
        </div><br>
        <div id="boton_herramienta">
        <input type="submit" class="btn btn-outline-info btn-lg btn-block" value="Guardar" onclick="guardar_herramienta()">
        </div>
      </div>';
?>
