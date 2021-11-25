<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria(0);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR INVENTARIO</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" placeholder="Ingresa el nombre del producto" maxlength="90">
          </div>
          </div>
          <div class="col-sm-2">Stock:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="stock" placeholder="Ingresa la cantidad en stock">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Categoria:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="form-control" id="categoria" class="form-control">
              <option value="0">Selecciona</option>';
              $categoria->mostrar_categoria();
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-2">Inventario:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="inventario" placeholder="Ingresa la cantidad en el inventario">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Descripcion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="descripcion" placeholder="Ingresa una descripcion del producto" maxlength="200">
          </div>
          </div>
          <div class="col-sm-2">Bodega Stock:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="bodega_stock" placeholder="Ingresa la cantidad en bodega stock">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Precio de Venta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="precio" placeholder="Ingresa el precio de venta">
          </div>
          </div>
          <div class="col-sm-2">Bodega Inventario:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="bodega_inventario" placeholder="Ingresa la cantidad en bodega inventario">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Precio de Compra:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="precio_compra" placeholder="Ingresa el precio de compra">
          </div>
          </div>
          <div class="col-sm-2">Clave SAT:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="clave" placeholder="Ingresa la clave SAT">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
          <div id="boton_inventario">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_inventario()">
          </div>
          </div>
        </div>
      </div>';
?>
