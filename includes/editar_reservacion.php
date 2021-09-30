<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  include_once("clase_tarifa.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $tarifa= NEW Tarifa(0);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR RESERVACION</h2></div>
        <div class="row">
          <div class="col-sm-2">Fecha entrada:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_entrada" value="'.date("Y-m-d",$reservacion->fecha_entrada).'" onchange="calcular_noches()">
          </div>
          </div>
          <div class="col-sm-2">Fecha salida:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <input class="form-control" type="date"  id="fecha_salida" value="'.date("Y-m-d",$reservacion->fecha_salida).'" onchange="calcular_noches()">
          </div>
          </div>
          <div class="col-sm-1">Noches:</div>
          <div class="col-sm-1">
          <div class="form-group">
            <input class="form-control" type="number"  id="noches" value="'.$reservacion->noches.'" disabled/>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">No.Hab.:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="numero_hab" value="'.$reservacion->numero_hab.'" onchange="cambiar_adultos_editar()">
          </div>
          </div>
          <div class="col-sm-1">Tarifa:</div>
          <div class="col-sm-3">
          <div class="form-group">
            <select class="form-control" id="tarifa" onchange="cambiar_adultos_editar('.$_GET['id'].')">';
              $tarifa->mostrar_tarifas_editar($reservacion->tarifa);
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-8"></div>
        </div>
        <div class="row div_adultos_editar"></div>';
          // Div adultos donde van resto de los datos para agregar una reservacion
          echo '
        </div>
      </div>';
?>
