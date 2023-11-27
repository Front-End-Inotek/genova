<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria(0);
  echo '
      <div class="form_container">
        <div class="form_title_container">
          <h2 class="form_title_text">AGREGAR INVENTARIO</h2>
        </div>
        <div class="inputs_form_container">
           <div class="form-floating input_container">
              <input class="form-control custom_input" type="text" id="nombre" placeholder="Ingresa el nombre del producto" maxlength="60">
              <label for="nombre">Nombre</label>
           </div>
           <div class="form-group col-md-4 col-12">
           <div class="inputs_form_container">         
           <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="stock" placeholder="Ingresa la cantidad en stock" >
            <label for="stock">Stock</label>
          </div>
          <div class="form-floating input_container">
          <select class="form-select custom_input" id="categoria">
              <option selected disabled>Seleccione una opción</option>';
              $categoria->mostrar_categoria();
              echo '
          </select>
          <label for="categoria">Categoria</label>
          </div>
          </div>
        </div>
        <div class="form-group col-md-2">
        <div class="inputs_form_container">
        <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="inventario" placeholder="Ingresa la cantidad en el inventario">
            <label for="inventario ">Inventario</label>
            </div>
          </div>
        </div>
        <div class="form-group col-md-4">
        <div class="inputs_form_container">
        <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="descripcion" placeholder="Ingresa una descripción del producto" maxlength="200">
            <label for="descripcion">Descripción</label>
        </div>
          <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="bodega_stock" placeholder="Ingresa la cantidad en bodega stock">
            <label for="Bodega stock">Bodega stock</label>
        </div>
        </div>
        <div class="inputs_form_container">
        <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="precio" placeholder="Ingresa el precio de venta">
            <label for="precio de venta">Precio de venta</label>
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
            <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_inventario()">Guardar</button>
          </div>
          </div>
        </div>
      </div>';
?>
