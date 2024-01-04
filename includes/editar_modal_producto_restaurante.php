<?php
  date_default_timezone_set('America/Mexico_City');
  $id_maestra=0;
  if(isset($_GET['id_maestra'])){
    $id_maestra=$_GET['id_maestra'];
  }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Editar Pedido</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">
        <div class="form-floating input_container">
          <input class="form-control custom_input" type="number"  id="cantidad" value="'.$_GET['cantidad'].'" placeholder="Cantidad">
          <label for="cantidad" >Cantidad</label>
        </div>
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger btn" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary btn" onclick="modificar_producto_restaurante('.$_GET['producto'].','.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['mov'].','.$_GET['mesa'].','.$_GET['cantidad'].','.$id_maestra.')"> Aceptar</button>
    </div>
  </div>';
?>
