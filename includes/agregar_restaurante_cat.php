<?php
  include_once("clase_hab.php");
  include_once("clase_mesa.php");
  include_once("clase_categoria.php");
  include_once("clase_inventario.php");
  $hab=NEW Hab(0);
  $mesa=NEW Mesa(0);
  $inventario=NEW Inventario(0);
  $categoria=NEW Categoria(0);
  $pedido_rest=NEW Pedido_rest(0);
  if($_GET['mesa'] == 0){
    if($_GET['hab_id'] == 0){
      $mov= 0;
    }else{
      $mov= $hab->mostrar_mov_hab($_GET['hab_id']);
    }
  }else{
    if($_GET['hab_id'] == 0){
      $mov= 0;
    }else{
      $mov= $mesa->saber_mov($_GET['hab_id']);
    }
  }
  // <div class="col-sm-2"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black" autofocus="autofocus"/></div>
  // style="background-color:LightSlateGray,aliceblue;"       
  echo '
  <div class="modal-content alinear_centro">
    <h5>Agregar Restaurante</h5>
    <div class="col-sm-12 fondo_rest" style="backdrop-filter: blur(15px); background-color: #ede4ffc5;"><br>  

      <div class="row">
        <div class="col-sm-6" style="background-color:white;">
          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Categorias</h5>
            </div>

            <div class="card-body altura-rest_categorias" id="caja_mostrar_categoria">
              ';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov,$_GET['mesa']);
            echo '</div>
          </div><br>

          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Productos</h5>
            </div>

            <div class="card-body altura-rest_productos" id="caja_mostrar_busqueda">
              ';if($_GET['categoria'] != 0){
                $inventario->mostrar_producto_restaurente($_GET['categoria'],$_GET['hab_id'],$_GET['estado'],$mov,$_GET['mesa']);
              }
            echo '</div>
          </div><br>
 
        </div>

        <div class="col-sm-6" style="background-color:white;">
          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Pedido</h5>
            </div>

            <div class="card-body altura-rest_pedido" id="caja_mostrar_funciones">
              <div class="row">
                <div class="col-sm-4">
                  <input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.','.$_GET['mesa'].')" id="a_buscar" class="form-control color_black">
                </div>
              </div>
              ';$pedido_rest->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov,$_GET['mesa']);
            echo '</div>
          </div>

          <div class="card">
            <div class="card-body " id="caja_mostrar_total">';
              if($_GET['mesa'] == 0){
                $pedido_rest->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov);
              }else{
                $pedido_rest->mostar_pedido_funciones_mesa($_GET['hab_id'],$_GET['estado'],$mov);
              } 
            echo '</div>
          </div><br>
        
        </div>
      </div>

    </div>
  </div>';
?>