<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark ">INVENTARIO</h2></div>
          
          <div class="row">
            <div class="col-sm-2">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_surtir_inventario()" class="color_black form-control form-control"/>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <select class="form-control-lg" id="categoria" onchange="mostrar_surtir_categoria()">
                  <option value="-1">Selecciona</option>
                  <option value="0">Todos</option>';
                  $inventario->categoria_surtir();
                echo '</select>
              </div>
            </div>
            <div class="col-sm-8"></div>
          </div><br>';
          $inventario->mostrar_surtir_inventario();
  echo '  
         </div>';
?>
