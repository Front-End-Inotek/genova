<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria(0);
  echo '
      <div class="main_container">
      <div class="form_container">
      <form class="formulario_contenedor">
        <header class="main_container_title">
          <h2>AGREGAR MESA</h2>
        </header>


        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="nombre" placeholder="Ingresa el nombre de la mesa" maxlength="60">
            <label for="nombre">Nombre</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="number" id="capacidad" placeholder="Ingresa la capacidad de la mesa">
            <label for="capacidad">Capacidad de la mesa</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="comentario" placeholder="Ingresa un comentario para la mesa">
            <label for="comentario">Comentario para la mesa</label>
          </div>
        </div>

      <div id="boton_inventario">
            <button type="submit" class="btn btn-primary" value="Guardar" onclick="guardar_mesa()">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                <path d="M11 2H9v3h2z"/>
                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
              </svg>
              Guardar
            </button>
          </div>
          </form>
      </div>
      ';
?>
