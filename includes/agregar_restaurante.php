<?php
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $categoria=NEW Categoria(0);
  $inventario=NEW Inventario(0);
  echo '<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Agregar Restaurante 
        <!-- <input type="text" placeholder="Buscar" onkeyup="buscar_libre_producto_cobro(0)" id="a_buscar" class="color_black" autofocus="autofocus"/> -->
        </h4>';

        echo '</br><div class="row mostrarresta" >';
          //$inv->catgoria_restaurente_cobrar_direto();
        echo '</div>';
        echo '
      </div>

      <div class="modal-body">';
        echo '<div class="row">
          <div class="col-sm-3 altura-rest" id="caja_mostrar_categoria" style="background-color:azure;">';$categoria->mostrar_categoria_restaurente();echo '</div>
          <div class="col-sm-6 altura-rest" id="caja_mostrar_busqueda" style="background-color:lavender;">';//$inventario->mo();echo '</div>';
            //$inv->mostar_pedido_mov_cobro_directo(0,0);
            //azure o white
            echo '
          <div class="col-sm-3 altura-rest" id="caja_mostrar_totales" style="background-color:lavenderblush;">';//$inventario->mo();echo '</div>';
          echo '
        </div>
      </div>
      
      <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button> -->
      </div>
    </div>';
?>