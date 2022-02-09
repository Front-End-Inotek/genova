<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  include_once("clase_surtir.php");
  $inventario = NEW Inventario(0);
  $surtir = NEW Surtir(0);
  
  echo ' <div class="container-fluid blanco"> 
          <br>
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">SURTIR INVENTARIO</h2></div>

          <div class="row">
            <div class="col-sm-2">
              <input type="text" id="a_buscar" placeholder="Buscar" onkeyup="buscar_surtir_inventario()" class="color_black form-control form-control" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">
              <div class="form-group">
                <select class="form-control-lg" id="categoria" onchange="mostrar_surtir_categoria()">
                  <option value="0">Todos</option>';
                  $inventario->categoria_surtir();
                echo '</select>
              </div>
            </div>
            <div class="col-sm-8"></div>
          </div><br>
          
          <div class="row">
            <div class="col-sm-8">';
              $inventario->mostrar_surtir_inventario();
            echo  '</div>
            <div class="col-sm-4 " id="a_surtir">';
              $surtir->mostrar_a_surtir();
            echo  '</div>
          </div>
         </div>';
          
?>
