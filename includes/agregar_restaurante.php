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
  if(isset($_GET['mov'])){
    if($_GET['mov']!=0){
      $mov = $_GET['mov'];
    }
  }
  $id_maestra=0;
  if(isset($_GET['maestra'])){
    if($_GET['maestra']!=0){
      $id_maestra = $_GET['maestra'];
    }
  }
  
  $mesa= 0;
  // <div class="col-sm-2"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black" autofocus="autofocus"/></div>
  // style="background-color:LightSlateGray,aliceblue;"       
  echo '
  <div class="modal-content alinear_centro" style="background-color:#b5b2f957 !important;">
    <h5 style="padding-bottom: 25px;">Agregar Restaurante </h5>
    <div class="col-sm-12 fondo_rest"><br>  

      <div class="row">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Categorias</h5>
            </div>

            <div class="card-body altura-rest_categorias" id="caja_mostrar_categoria">
              ';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov,$mesa,$id_maestra);
            echo '</div>
          </div><br>

          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Productos</h5>
            </div>
            <div class="card-body altura-rest_productos" id="caja_mostrar_busqueda">
            </div>
          </div><br>
 
        </div>

        <div class="col-sm-6" ">
          <div class="card">
            <div class="card-header alinear_centro">
              <h5>Pedido</h5>
            </div>

            <div class="card-body altura-rest_pedido" id="caja_mostrar_funciones">
              <div class="row">
                <div class="col-sm-4">
                  <input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.','.$mesa.','.$id_maestra.')" id="a_buscar" class="form-control color_black">
                </div>
                <div class="col-sm-8"></div>
              </div>
              ';$pedido_rest->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov,$mesa,$id_maestra);
            echo '</div>
          </div>

          <div class="card">
            <div class="card-body " id="caja_mostrar_total">
              ';$pedido_rest->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov,$id_maestra);
            echo '</div>
          </div><br>
        
        </div>
      </div>

    </div>
  </div>';

  /*
  <div class="modal-content">
    <div class="col-sm-12 fondo_rest" >
       
          <h5 class="alinear_centro">Agregar Restaurante </h5>
        

          <div class="row">
            <div class="col-sm-6 altura-rest_total" id="caja_mostrar_funciones" style="background-color:white;"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black margen_sup">';$pedido_rest->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
            <div class="col-sm-6 altura-rest_total" id="caja_mostrar_categoria" style="background-color:aliceblue;"><h6 class="alinear_centro_categorias"> Categorias</h6>';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
          </div>
          <div class="row">
            <div class="col-sm-6 altura-rest_productos" id="caja_mostrar_total" style="background-color:white;">';$pedido_rest->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov);echo '</div>
            <div class="col-sm-6 altura-rest_productos" id="caja_mostrar_busqueda" style="background-color:aliceblue;"></div>
          </div>
 
    </div>
  </div>';
  */
?>