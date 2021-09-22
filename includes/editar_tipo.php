<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_herramienta.php");
  $herramienta= NEW Herramienta($_GET['id']);
  echo '
      <div class="container">
        <br>
        <div class="col-sm-12 text-center"><h1 class="text-primary">Editar Herramienta</h1></div></br>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2"><button class="btn btn-outline-info btn-lg btn-block" onclick="regresar_editar_herramienta()"><span class="glyphicon glyphicon-edit"></span> Regresar</button></div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Nombre:</div>
          <div class="col-sm-10" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" value="'.$herramienta->nombre.'" maxlength="50">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Marca:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="text"  id="marca" value="'.$herramienta->marca.'" maxlength="30">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Modelo:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="text"  id="modelo" value="'.$herramienta->modelo.'" maxlength="50">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Descripcion:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="text"  id="descripcion" value="'.$herramienta->descripcion.'"/>
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Cantidad en almacen:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="number"  id="cantidad_almacen" value="'.$herramienta->cantidad_almacen.'"/>
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-2" >Cantidad prestadas:</div>
          <div class="col-sm-10" >
          <div class="form-group">
          <input class="form-control" type="number"  id="cantidad_prestadas" value="'.$herramienta->cantidad_prestadas.'"/>
          </div>
          </div>
        </div><br>
        <div id="boton_herramienta">
          <input type="submit" class="btn btn-outline-info btn-lg btn-block" value="Guardar" onclick="modificar_herramienta('.$_GET['id'].')">
          </div>
      </div>';
?>
