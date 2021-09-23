<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR TARIFA HOSPEDAJE</h2></div>
        <div class="row">
          <div class="col-sm-3" >Nombre:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" value="'.$tarifa->nombre.'" maxlength="90">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Precio hospedaje:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="number"  id="precio_hospedaje" value="'.$tarifa->precio_hospedaje.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Cantidad por hospedaje:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="number"  id="cantidad_hospedaje" value="'.$tarifa->cantidad_hospedaje.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Precio por persona:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="number"  id="precio_persona" value="'.$tarifa->precio_persona.'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Tipo de habitacion:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <select class="form-control" id="tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $tarifa->mostrar_tipo_editar($tarifa->tipo);
              echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9" ></div>
          <div class="col-sm-2" >
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_tarifa('.$_GET['id'].')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_tarifa()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
        </div>
      </div>';
?>
