<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  $adultos= $tarifa->mostrar_cantidad_hospedaje($_GET['tarifa']);
  $precio_hospedaje= 2;
  $precio_adulto= 2;
  $precio_junior= 2;
  $precio_infantil= 2;
  $consulta = $tarifa->datos_hospedaje($_GET['tarifa']);
  //$precio_hospedaje= $tarifa->mostrar_precio_hospedaje($id_tarifa);
  while ($fila = mysqli_fetch_array($consulta))
  {
    $precio_hospedaje = $fila['precio_hospedaje'];
    $precio_adulto = $fila['precio_adulto'];
    $precio_junior = $fila['precio_junior'];
    $precio_infantil = $fila['precio_infantil'];
  }
  echo '
      <div class="container blanco"> 
        <div class="row div_adultos">
          <div class="col-sm-2">Adultos:</div>
          <div class="col-sm-2 div_adultos">
          <div class="form-group">
            <input class="form-control" type="number"  id="adultos" placeholder='.$adultos.' disabled/>
          </div>
          </div>
          <div class="col-sm-2">Adultos Extra:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_adulto" placeholder="0" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Junior:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_junior" placeholder="[13-17 años]" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Niños:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_infantil" placeholder="[6-12 años]" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Niños Gratis:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_menor" placeholder="[0-5 años]">
          </div>
          </div>
          <div class="col-sm-4">1 menor de 9 años por habitación, excepto en SUITE, aplican restricciones</div>
        </div>
        <div class="row">
          <div class="col-sm-2">Suplementos:</div>
          <div class="col-sm-6">
          <div class="form-group">
            <input class="form-control" type="text"  id="suplementos" placeholder="Ingresa los suplementos de la reservacion" maxlength="90">
          </div>
          </div>
          <div class="col-sm-2">Total suplementos:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total_suplementos" placeholder="0" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Total Habitación:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total_hab" placeholder="0" disabled/>
          </div>
          </div>
          <div class="col-sm-2">Forzar Tarifa:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="forzar_tarifa" placeholder="0">
          </div>
          </div>
          <div class="col-sm-2">Total Estancia:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total" placeholder="0" disabled/>
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
