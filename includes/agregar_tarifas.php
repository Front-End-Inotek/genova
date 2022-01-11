<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  $leyenda= '1 menor de 9 años por habitación, excepto en SUITE, aplican restricciones';
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR TARIFA HOSPEDAJE</h2></div>
        <div class="row">
          <div class="col-sm-3" >Nombre:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el nombre de la tarifa de la habitación" maxlength="90">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Precio hospedaje:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="number"  id="precio_hospedaje" placeholder="Ingresa el precio del hospedaje">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Cantidad por habitación:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="number"  id="cantidad_hospedaje" placeholder="Ingresa la cantidad de personas en la habitación">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Cantidad máxima ocupación:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="number"  id="cantidad_maxima" placeholder="Ingresa la cantidad máxima de personas permitida">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Precio por adulto:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="number"  id="precio_adulto" placeholder="Ingresa el precio por adulto">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Precio por junior:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="number"  id="precio_junior" placeholder="Ingresa el precio por junior(13-17 años)">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Precio por niño:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="number"  id="precio_infantil" placeholder="Ingresa el precio por niño(6-12 años)">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3">Tipo de habitación:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <select class="form-control" id="tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $tarifa->mostrar_tipo();
              echo '
            </select>
          </div>
          </div>
        </div>
      <div class="row">
        <div class="col-sm-3" >Leyenda de habitación:</div>
        <div class="col-sm-9" >
        <div class="form-group">
          <input class="form-control" type="text"  id="leyenda" value="'.$leyenda.'" placeholder="Ingresa la leyenda correspondiente por la tarifa" maxlength="90">
        </div>
        </div>
      </div><br>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_tarifa()">
          </div>
          </div>
        </div>
      </div>';
?>
