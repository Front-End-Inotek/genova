<?php
  include_once("clase_hab.php");
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $hab=NEW Hab(0);
  $categoria=NEW Categoria(0);
  $pedido=NEW Pedido_rest(0);
  if($_GET['hab_id'] == 0){
    $mov= 0;
  }else{
    $mov= $hab->mostrar_mov_hab($_GET['hab_id']);
  }
  // <div class="col-sm-2"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black" autofocus="autofocus"/></div>
         
  echo '
  
  <div class="modal-content">
    <div class="col-sm-12 fondo_rest" >
       
          <h5 class="alinear_centro">Agregar Restaurante </h5>
        

          <div class="row">
            <div class="col-sm-6 altura-rest_total" id="caja_mostrar_funciones" style="background-color:white;"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black margen_sup">';$pedido->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
            <div class="col-sm-6 altura-rest_total" id="caja_mostrar_categoria" style="background-color:aliceblue;"><h6 class="alinear_centro_categorias"> Categorias</h6>';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
          </div>
          <div class="row">
            <div class="col-sm-6 altura-rest_productos" id="caja_mostrar_total" style="background-color:white;">';$pedido->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
            <div class="col-sm-6 altura-rest_productos" id="caja_mostrar_busqueda" style="background-color:aliceblue;"></div>
          </div>
 
  
    </div>
  </div>';
          /*
          <div class="row">
            <div class="col-sm-6 altura-rest_productos" id="caja_mostrar_categoria" style="background-color:aliceblue;">';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
            <div class="col-sm-6 altura-rest_productos" id="caja_mostrar_busqueda" style="background-color:lightcyan;"></div>
          </div>
          <div class="row">
            <div class="col-sm-6 altura-rest_total" id="caja_mostrar_funciones" style="background-color:azure;">';$pedido->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
            <div class="col-sm-6 altura-rest_total" id="caja_mostrar_total" style="background-color:whitesmoke;">';$pedido->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
          </div>
          */
?>