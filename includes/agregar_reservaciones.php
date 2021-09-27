<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion(0);
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  $precio_hospedaje= 0;
  $precio_adulto= 0;
  $precio_junior= 0;
  $precio_infantil= 0;
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
            <input class="form-control" type="number"  id="numero_hab" placeholder="0">
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
          <div class="col-sm-8"></div>
        </div>
        <div class="row div_adultos"></div>';
          /*$consulta = $tarifa->datos_hospedaje($id_tarifa);
          //$precio_hospedaje= $tarifa->mostrar_precio_hospedaje($id_tarifa);
          while ($fila = mysqli_fetch_array($consulta))
          {
              $precio_hospedaje = $fila['precio_hospedaje'];
              $precio_adulto = $fila['precio_adulto'];
              $precio_junior = $fila['precio_junior'];
              $precio_infantil = $fila['precio_infantil'];
          }*/
          echo '
        </div>
      </div>';
?>
