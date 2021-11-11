<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_forma_pago.php");
  include_once("clase_pago.php");
  include_once("clase_tarifa.php");
  $huesped= NEW Huesped(0);
  $forma_pago= NEW Forma_pago(0);
  $pago= NEW Pago(0);
  $tarifa= NEW Tarifa($_GET['tarifa']);
  $adultos= $tarifa->mostrar_cantidad_hospedaje($_GET['tarifa']);
  $agregar= 1;
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
        <div class="row div_adultos">
          <div class="col-sm-2">Adultos:</div>
          <div class="col-sm-2 div_adultos">
          <div class="form-group">
            <input class="form-control" type="number"  id="cantidad_hospedaje" placeholder='.$adultos.' disabled/>
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
            <input class="form-control" type="number"  id="extra_menor" placeholder="[0-5 años]" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-4">1 menor de 9 años por habitación, excepto en SUITE, aplican restricciones</div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <button class="btn btn-success btn-block" href="#caja_herramientas" data-toggle="modal" onclick="asignar_huesped('.$agregar.','.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')"><span class="glyphicon glyphicon-edit"></span> Asignar Huésped</button>
          </div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="id_huesped" value="" disabled/>
          </div>
          </div>
          <div class="col-sm-2">Quién Reserva:</div>
          <div class="col-sm-2"> 
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre_reserva" placeholder="Ingresa nombre    reservacion"  maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Acompañante:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="text"  id="acompanante" placeholder="Ingresa nombre    acompañante"  maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-8 div_datos">Presiona este botón si deseas ver los datos del huésped previamente asignado:</div>
          <div class="col-sm-3">
            <button type="button" class="btn btn-primary btn-block boton_datos" onclick="mostrar_datos()">Ver Datos</button>
          </div>
          <div class="col-sm-1"></div>
        </div>
        <div class="row div_oculto">';
          // Div oculto donde van los datos de el huésped asignado para agregar una reservacion, pudiendose editar
          echo '
        </div><hr> 
        <div class="row">
          <div class="col-sm-12 text-left"><h3 class="text-dark margen-1">DATOS PAGO:</h3></div>
          <div class="col-sm-2">Suplementos:</div>
          <div class="col-sm-6">
          <div class="form-group">
            <input class="form-control" type="text"  id="suplementos" placeholder="Ingresa los suplementos de la reservacion" maxlength="90" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-2">Total Suplementos:</div>
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
            <input class="form-control" type="number"  id="total_hab" placeholder='.$precio_hab.' disabled/>
          </div>
          </div>
          <div class="col-sm-2">Forzar Tarifa:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="forzar_tarifa" placeholder="0">
          </div>
          </div>
          <div class="col-sm-2">Descuento:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="descuento" placeholder="0" onchange="calcular_total('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Total Estancia:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="total" placeholder='.$precio_hab.' disabled/>
          </div>
          </div>
          <div class="col-sm-2">Forma de Pago:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="forma_pago">
              <option value="0">Selecciona</option>';
              $forma_pago->mostrar_forma_pago();
              echo '
            </select>
          </div>
          </div>
          <div class="col-sm-2">Fecha limite de pago:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="limite_pago">
              <option value="0">Selecciona</option>';
              $pago->mostrar_pago();
              echo '
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
          <div id="boton_reservacion">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_reservacion('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.','.$adultos.','.$_GET['hab_id'].')">
          </div>
          </div>
        </div>
      </div>';
?>
