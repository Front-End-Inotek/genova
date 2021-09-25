<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left "><h2 class="text-dark margen-1">AGREGAR HABITACIONES</h2></div>
        <div class="row">
          <div class="col-sm-2">Fecha entrada:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_entrada" placeholder="Ingresa la fecha de entrada" onchange="calcular_noches()">
          </div>
          </div>
          <div class="col-sm-2">Fecha salida:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_salida" placeholder="Ingresa la fecha de salida" onchange="calcular_noches()">
          </div>
          </div>
          <div class="col-sm-1">Noches:</div>
          <div class="col-sm-1">
          <div class="form-group">
            <input class="form-control" type="number"  id="noches" placeholder="0" disabled/>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">No.Hab.:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="noches" placeholder="0">
          </div>
          </div>
          <div class="col-sm-1">Tarifa:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <select class="form-control" id="tarifa" onchange="cambiar_adultos()">
              <option value="0">Selecciona</option>';
              $tarifa->mostrar_tarifas();
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-2">Adultos:</div>
          <div class="col-sm-2 div_adultos">
          <div class="form-group">
            <input class="form-control" type="number"  id="adultos" placeholder="0">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Adultos Extra:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_adulto" placeholder="0">
          </div>
          </div>
          <div class="col-sm-2">Junior:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_junior" placeholder="0">
          </div>
          </div>
          <div class="col-sm-2">Niños:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_infantil" placeholder="0">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Nombre:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el nombre de la habitacion" maxlength="90">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Tipo de habitacion:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <select class="form-control" id="tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $hab->mostrar_hab();
              echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-3" >Comentario:</div>
          <div class="col-sm-9" >
          <div class="form-group">
            <input class="form-control" type="text"  id="comentario" placeholder="Ingresa el comentario de la habitacion" maxlength="250">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10" ></div>
          <div class="col-sm-2" >
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_hab()">
          </div>
        </div>
      </div>';
?>
