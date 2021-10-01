<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_pago.php");
  include_once("clase_reservacion.php");
  include_once("clase_tarifa.php");
  $huesped= NEW Huesped(0);
  $pago= NEW Pago(0);
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
          <div class="col-sm-2">Huésped:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="id_huesped">';
              $huesped->mostrar_huesped_editar($reservacion->id_huesped);
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-2">Quién Reserva:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre_reserva" value="'.$reservacion->nombre_reserva.'"  maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Acompañante:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="text"  id="acompanante" value="'.$reservacion->acompanante.'"  maxlength="70">
          </div>
          </div>
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
          <div class="col-sm-2">Total Estancia:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total" placeholder='.$reservacion->total.' disabled/>
          </div>
          </div>
          <div class="col-sm-2">Forma de Pago:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="forma_pago">';
              if($reservacion->forma_pago == "Efectivo"){echo '
                <option value="Efectivo">'.$reservacion->forma_pago.'</option>
                <option value="Tarjeta">Tarjeta</option>';
              } elseif ($reservacion->forma_pago == "") {echo '
                <option value="Efectivo">Efectivo</option>
                <option value="Tarjeta">Tarjeta</option>';
              }else{ echo '
                <option value="Tarjeta">'.$reservacion->forma_pago.'</option>
                <option value="Efectivo">Efectivo</option>';
              }echo '
            </select>
          </div>
          </div>
          <div class="col-sm-2">Fecha limite de pago:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="limite_pago">';
              $pago->mostrar_pago_editar($reservacion->limite_pago);
              echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-2">
          <div id="boton_tipo">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_reservacion('.$_GET['id'].','.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.','.$adultos.')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_reservacion()"><span class="glyphicon glyphicon-edit"></span> ←</button></div>
        </div>
      </div>';
?>
