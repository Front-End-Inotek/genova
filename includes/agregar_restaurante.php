<?php
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $categoria=NEW Categoria(0);
  $pedido=NEW Pedido_rest(0);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title">Agregar Restaurante 
      <!-- <input type="text" placeholder="Buscar" onkeyup="buscar_libre_producto_cobro(0)" id="a_buscar" class="color_black" autofocus="autofocus"/> -->
      </h4>
    </div>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-4 altura-rest_productos" id="caja_mostrar_categoria" style="background-color:aliceblue;">';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado']);echo '</div>
        <div class="col-sm-8 altura-rest_productos" id="caja_mostrar_busqueda" style="background-color:lightcyan;"></div>
      </div>
      <div class="row">
        <div class="col-sm-4 altura-rest_total" id="caja_mostrar_funciones" style="background-color:azure;">';$pedido->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado']);echo '</div>
        <div class="col-sm-8 altura-rest_total" id="caja_mostrar_total" style="background-color:whitesmoke;">';$pedido->mostar_pedido($_GET['hab_id'],$_GET['estado']);echo '</div>
      </div>
    </div>
      
    <div class="modal-footer">
      <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
    </div>
  </div>';
?>