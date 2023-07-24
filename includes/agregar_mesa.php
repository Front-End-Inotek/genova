<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria(0);
  echo '
      <div class="container blanco">
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR MESA</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" placeholder="Ingresa el nombre de la mesa" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Capacidad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="capacidad" placeholder="Ingresa la capacidad de la mesa">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Comentario:</div>
          <div class="col-sm-4">
          <div class="form-group">
          <input class="form-control" type="number" id="comentario" placeholder="Ingresa un comentario para la mesa">
          </div>
          </div>
         
        </div>
      
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
          <div id="boton_inventario">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_mesa()">
          </div>
          </div>
        </div>
      </div>';
?>
