<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_inventario.php");
  $inventario= NEW Inventario($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Borrar producto</h5>
      <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
          <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
    </div>

    <div class="modal-body">';
      $mostrar = $inventario->obtengo_nombre($_GET['id']);
      echo '<h4>¿Borrar Producto '.$mostrar.'?</h4>';
      echo '
    </div>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-primary" onclick="borrar_inventario('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>
