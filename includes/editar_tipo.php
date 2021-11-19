<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tipo.php");
  $tipo= NEW Tipo($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR TIPO DE HABITACION</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-7">
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" value="'.$tipo->nombre.'" maxlength="90">
          </div>
          </div>
          <div class="col-sm-3"></div>
        </div>
        <div class="row">
          <div class="col-sm-2">Codigo:</div>
          <div class="col-sm-7">
          <div class="form-group">
            <input class="form-control" type="text"  id="codigo" value="'.$tipo->codigo.'" maxlength="20">
          </div>
          </div>
          <div class="col-sm-1"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_tipo('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-11"></div>
        </div>
        <div class="row">
          <div class="col-sm-11"></div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_tipo()"> ←</button></div>
        </div>
      </div>';
?>
