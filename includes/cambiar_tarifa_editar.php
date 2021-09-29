<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_tarifa.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $tarifa= NEW Tarifa($_GET['tarifa']);
  $adultos= $tarifa->mostrar_cantidad_hospedaje($_GET['tarifa']);
  $precio_hospedaje= 0;
  $precio_adulto= 0;
  $precio_junior= 0;
  $precio_infantil= 0;
  $precio_hospedaje= $tarifa->precio_hospedaje;
  $precio_adulto= $tarifa->precio_adulto;
  $precio_junior= $tarifa->precio_junior;
  $precio_infantil= $tarifa->precio_infantil;
  $precio_hab= $precio_hospedaje * $_GET['noches'] * $_GET['numero_hab'];
  echo '
      <div class="container blanco"> 
        <div class="row div_adultos_editar">
          <div class="col-sm-2">Adultos:</div>
          <div class="col-sm-2 div_adultos_editar">
          <div class="form-group">
            <input class="form-control" type="number"  id="cantidad_hospedaje" value='.$adultos.' disabled/>
          </div>
          </div>
          <div class="col-sm-2">Adultos Extra:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_adulto" value="'.$reservacion->extra_adulto.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Junior:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_junior" value="'.$reservacion->extra_junior.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Niños:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_infantil" value="'.$reservacion->extra_infantil.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Niños Gratis:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="extra_menor" value="'.$reservacion->extra_menor.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-4">1 menor de 9 años por habitación, excepto en SUITE, aplican restricciones</div>
        </div>
        <div class="row">
          <div class="col-sm-2">Suplementos:</div>
          <div class="col-sm-6">
          <div class="form-group">
            <input class="form-control" type="text"  id="suplementos" value="'.$reservacion->suplementos.'" maxlength="90" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Total suplementos:</div>
          <div class="col-sm-2">
          <div class="form-group">
          <input class="form-control" type="number"  id="total_suplementos" value="'.$reservacion->total_suplementos.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Total Habitación:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total_hab" value="'.$reservacion->total_hab.'" disabled/>
          </div>
          </div>
          <div class="col-sm-2">Forzar Tarifa:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="forzar_tarifa" value="'.$reservacion->forzar_tarifa.'">
          </div>
          </div>
          <div class="col-sm-2">Descuento:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="descuento" value="'.$reservacion->descuento.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-5"></div>
          <div class="col-sm-2">Total Estancia:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total" placeholder='.$reservacion->total.' disabled/>
          </div>
          </div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_reservacion('.$_GET['id'].','.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.','.$adultos.')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_reservacion()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
        </div>
      </div>';
?>
