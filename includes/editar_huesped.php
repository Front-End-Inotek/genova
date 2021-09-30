<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR HUESPED</h2></div>
        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" value="'.$huesped->nombre.'" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Apellido:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="apellido" value="'.$huesped->apellido.'" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Direccion:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" value="'.$huesped->direccion.'" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Ciudad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="ciudad" value="'.$huesped->ciudad.'" maxlength="30">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Estado:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="estado" value="'.$huesped->estado.'" maxlength="30">
          </div>
          </div>
          <div class="col-sm-2">Codigo postal:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="codigo_postal" value="'.$huesped->codigo_postal.'" maxlength="20">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Telefono:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="telefono" value="'.$huesped->telefono.'" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Correo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="correo" value="'.$huesped->correo.'" maxlength="200">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Preferencias del huésped:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="preferencias" value="'.$huesped->preferencias.'">
          </div>
          </div>
          <div class="col-sm-2">Comentarios adicionales:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="comentarios" value="'.$huesped->comentarios.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-2">
          <div id="boton_huesped">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_huesped('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_huesped()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
        </div>  
      </div>';
?>
