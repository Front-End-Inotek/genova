<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $categoria= NEW Categoria(0);
  $inventario= NEW Inventario($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR INVENTARIO</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" value="'.$inventario->nombre.'" maxlength="90">
          </div>
          </div>
          <div class="col-sm-2">Stock:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="stock" value="'.$inventario->stock.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Categoria:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="form-control" id="categoria" class="form-control">';
              $categoria->mostrar_categoria_editar($inventario->categoria);
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-2">Inventario:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="inventario" value="'.$inventario->inventario.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Descripcion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="descripcion" value="'.$inventario->descripcion.'" maxlength="200">
          </div>
          </div>
          <div class="col-sm-2">Bodega Stock:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="bodega_stock" value="'.$inventario->bodega_stock.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Precio de Venta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="precio" value="'.$inventario->precio.'">
          </div>
          </div>
          <div class="col-sm-2">Bodega Inventario:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="bodega_inventario" value="'.$inventario->bodega_inventario.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Precio de Compra:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="precio_compra" value="'.$inventario->precio_compra.'">
          </div>
          </div>
          <div class="col-sm-2">Clave SAT:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="clave" value="'.$inventario->clave.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-2">
          <div id="boton_inventario">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_inventario('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_inventario()"> ←</button></div>
        </div>  
      </div>';
?>
