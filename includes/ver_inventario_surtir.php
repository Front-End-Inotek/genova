<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario(0);
  
  echo ' <div class="main_container"> 
          
          <header class="main_container_title">
            <h2 >INVENTARIO</h2>
          </header>
          
          <div class="inputs_form_container justify-content-start">
            <div class="form-floating input_container">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_surtir_inventario()" class="form-control custom_input"/>
              <label for="a_buscar">Buscar</label>
            </div>

            <div class="form-floating input_container">
                <select class="form-select custom_input" id="categoria" onchange="mostrar_surtir_categoria()" placeholder="Categoria">
                  <option value="-1" disabled selected>Selecciona</option>
                  <option value="0">Todos</option>';
                  $inventario->categoria_surtir();
            echo '</select>
                <label for="categoria" >Categoria</label>
            </div>
          </div><br>';
          $inventario->mostrar_surtir_inventario();
  echo '  
         </div>';
?>
