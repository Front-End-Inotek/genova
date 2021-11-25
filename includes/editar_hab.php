<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR HABITACION</h2></div>
        <div class="row">
          <div class="col-sm-3">Nombre:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" value="'.$hab->nombre.'" maxlength="90">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Tipo de habitacion:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <select class="form-control" id="tipo" class="form-control">';
              $hab->mostrar_hab_editar($hab->tipo);
              echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Comentario:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="text"  id="comentario" value="'.$hab->comentario.'" maxlength="250">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_hab('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_hab()"> ←</button></div>
        </div>
      </div>';
?>
