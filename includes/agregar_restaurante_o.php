<?php
  include_once("clase_hab.php");
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $hab=NEW Hab(0);
  $categoria=NEW Categoria(0);
  $pedido_rest=NEW Pedido_rest(0);
  if($_GET['hab_id'] == 0){
    $mov= 0;
  }else{
    $mov= $hab->mostrar_mov_hab($_GET['hab_id']);
  }
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <div class="row">
        <div class="col-sm-10">
        <h4 class="modal-title">Agregar Restaurante 
        <!-- <input type="text" placeholder="Buscar" onkeyup="buscar_libre_producto_cobro(0)" id="a_buscar" class="color_black" autofocus="autofocus"/> -->
        </h4>
        </div>
        <div class="col-sm-2"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black" autofocus="autofocus"/></div>
      </div>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-4 altura-rest_productos" id="caja_mostrar_categoria" style="background-color:aliceblue;">';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
        <div class="col-sm-8 altura-rest_productos" id="caja_mostrar_busqueda" style="background-color:lightcyan;"></div>
      </div>
      <div class="row">
        <div class="col-sm-4 altura-rest_total" id="caja_mostrar_funciones" style="background-color:azure;">';$pedido_rest->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
        <div class="col-sm-8 altura-rest_total" id="caja_mostrar_total" style="background-color:whitesmoke;">';$pedido_rest->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
      </div>
    </div>
      
    <div class="modal-footer">
      <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
    </div>
  </div>';
?>