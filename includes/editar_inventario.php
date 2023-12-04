<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $categoria= NEW Categoria(0);
  $inventario= NEW Inventario($_GET['id']);
  echo '
      <div class="form_container">

      <form class="formulario_contenedor">
        <div class="form_title_container">
          <h2 class="form_title_text">EDITAR INVENTARIO</h2>
          <button class="btn btn-link" onclick="regresar_editar_inventario()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
              <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"/>
            </svg>
          </button>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="nombre" value="'.$inventario->nombre.'" maxlength="60">
            <label for="nombre">Nombre</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="stock" value="'.$inventario->stock.'">
            <label for="stock" >Stock</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <select class="form-control custom_input" id="categoria" class="form-control">
            ';
              $categoria->mostrar_categoria_editar($inventario->categoria);
              echo '
            </select>
            <label for="categoria" >Categoría</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="inventario" value="'.$inventario->inventario.'">
            <label>Inventario</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="descripcion" value="'.$inventario->descripcion.'" maxlength="200">
            <label for="descripción" >Comentario</label>
          </div>
          
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="bodega_stock" value="'.$inventario->bodega_stock.'">
            <label for="bodega_stock" >Bodega Stock</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="precio" value="'.$inventario->precio.'">
            <label for="precio" >Precio de venta</label>
          </div>
          
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="bodega_inventario" value="'.$inventario->bodega_inventario.'">
            <label for="bodega_inventario" >Bodega inventario</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="precio_compra" value="'.$inventario->precio_compra.'">
            <label for="precio_compra">Precio de compra</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="clave" value="'.$inventario->clave.'">
            <label for="clave">Calve SAT</label>
          </div>
        </div>

        <div class="container_btn">
          
          
          <div id="boton_inventario">
            <button type="submit" class="btn btn-primary" value="Guardar" onclick="modificar_inventario('.$_GET['id'].')">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
              <path d="M11 2H9v3h2z"/>
              <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
            </svg>
            Guardar</button>
          </div>
        </div>  
      </div>
      </form>
      
      ';
?>
