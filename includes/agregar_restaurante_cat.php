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
  $id_maestra=0;
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
  if(isset($_GET['mov'])){
    if($_GET['mov']!=0){
      $mov = $_GET['mov'];
    }
  }
  if(isset($_GET['id_maestra'])){
    $id_maestra=$_GET['id_maestra'];
  }
  // echo $id_maestra;
  // <div class="col-sm-2"><input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.')" id="a_buscar" class="color_black" autofocus="autofocus"/></div>
  // style="background-color:LightSlateGray,aliceblue;"
  echo '

  <div class="main_container">
  
    <div class="main_container_title">
      <h2>Agregar Restaurante</h2>
    </div>

    <main class="restaurante_contenedor">
      <section class="restaurante_section">
        <div class="restaurante_section_body">
          <h4>Categorias</h4>
          <div class="restaurante_section_buttons" id="caja_mostrar_categoria">
          ';$categoria->mostrar_categoria_restaurente($_GET['hab_id'],$_GET['estado'],$mov,$_GET['mesa'],$id_maestra);
          echo '
          </div>
        </div>

          <div class="restaurante_section_body">
            <h4>Productos</h4>
            <div id="caja_mostrar_busqueda" class="contenedor_botones_restaurante">
            ';if($_GET['categoria'] != 0){
              $inventario->mostrar_producto_restaurente($_GET['categoria'],$_GET['hab_id'],$_GET['estado'],$mov,$_GET['mesa'],$id_maestra);
            }
          echo '
            </div>
        </div>
      </section>

      <section class="restaurante_section">
        <h4>Pedido</h4>
        <div class="form-floating">
          <input type="text" placeholder="Buscar" onkeyup="buscar_producto_restaurante('.$_GET['hab_id'].','.$_GET['estado'].','.$mov.','.$_GET['mesa'].','.$id_maestra.')" id="a_buscar" class="form-control color_black">
          <label>Buscar</label>
        </div>

        <div class="table-restaurante" id="caja_mostrar_funciones">
          ';$pedido_rest->mostar_pedido($_GET['hab_id'],$_GET['estado'],$mov,$_GET['mesa'],$id_maestra);
        echo '
        </div>

        <div class="footer_restaurante_tabla" id="caja_mostrar_total">';
            if($_GET['mesa'] == 0){
              $pedido_rest->mostar_pedido_funciones($_GET['hab_id'],$_GET['estado'],$mov,$id_maestra);
            }else{
              $pedido_rest->mostar_pedido_funciones_mesa($_GET['hab_id'],$_GET['estado'],$mov,$id_maestra);
            }
        echo '
        </div>
            
      </section>
    </main>
  ';
?>