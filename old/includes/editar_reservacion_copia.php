<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_tarifa.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $id_tarifa= $reservacion->tarifa;
  $noches= $reservacion->noches;
  $numero_hab= $reservacion->numero_hab;
  $tarifa= NEW Tarifa($id_tarifa);
  $adultos= $tarifa->mostrar_cantidad_hospedaje($id_tarifa);
  $precio_hospedaje= 0;
  $precio_adulto= 0;
  $precio_junior= 0;
  $precio_infantil= 0;
  $precio_hospedaje= $tarifa->precio_hospedaje;
  $precio_adulto= $tarifa->precio_adulto;
  $precio_junior= $tarifa->precio_junior;
  $precio_infantil= $tarifa->precio_infantil;
  $precio_hab= $precio_hospedaje * $noches * $numero_hab;
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR RESERVACION</h2></div>
          <div class="row">
          <div class="col-sm-2">Fecha entrada:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_entrada" value="'.date("Y-m-d",$reservacion->fecha_entrada).'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Fecha salida:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_salida" value="'.date("Y-m-d",$reservacion->fecha_salida).'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-1">Noches:</div>
          <div class="col-sm-1">
          <div class="form-group">
            <input class="form-control" type="number"  id="noches" value='.$noches.' disabled/>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">No.Hab.:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="numero_hab" value="'.$reservacion->numero_hab.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-1">Tarifa:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <select class="form-control" id="tarifa" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">';
              $tarifa->mostrar_tarifas_editar();
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-8"></div>
        </div>
        <div class="row">';
          // Div adultos donde van resto de los datos para agregar una reservacion
          echo '
          <div class="col-sm-2">Adultos:</div>
          <div class="col-sm-2 div_adultos">
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
          <div class="col-sm-2">Total Estancia:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total" value="'.$reservacion->total.'" disabled/>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_reservacion('.$_GET['id'].')">Guardar</button>
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_reservacion()"> ←</button></div>
        </div>
      </div>';
?>
