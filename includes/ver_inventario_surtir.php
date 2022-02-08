<?php
	date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">INVENTARIO</h2></div>
          
          <div class="row">
            <div class="col-sm-2">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_surtir_inventario()" class="color_black form-control form-control" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">
              <select class="color_black" onchange="mostrar_surtir_categoria()" id="categoria">';
              echo '<option value="0">Todos</option>';
                $inventario->categoria_surtir();
              echo '</select>
            </div>
            <div class="col-sm-8"></div>
          </div><br>';
          $inventario->mostrar_surtir_inventario();
  echo '  
         </div>';
        /*echo '<input type="text" id="busqueda" onkeyup="buscar_surtir()" class="color_black"><span class="color_black">----</span>';
        echo '<select class="color_black" onchange="mostrar_surtir_categoria()" id="categoria_inv">';
        echo '<option value="0">Todos</option>';
        //$this->categoria_surtir();
        echo '</select>';*/
?>
