<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_categoria.php");
  $categoria= NEW Categoria($_GET['id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Editar Categoría
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">
      <div class="row">
        <div class="col-sm-2">Nombre:</div>
        <div class="col-sm-9">
        <div class="form-group">
          <input class="form-control" type="text" id="nombre_categoria" value="'.$categoria->nombre.'" maxlength="50">
        </div>
        </div>
        <div class="col-sm-1"></div>
      </div>
    </div>
    
    <div class="modal-footer" id="boton_categoria">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="modificar_categoria('.$_GET['id'].')"> Aceptar</button>
    </div>
  </div>';
?>

