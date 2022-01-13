<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  include_once("clase_forma_pago.php");
  include_once("clase_pago.php");
  include_once("clase_reservacion.php");
  include_once("clase_tarifa.php");
  $huesped= NEW Huesped(0);
  $forma_pago= NEW Forma_pago(0);
  $pago= NEW Pago(0);
  $reservacion= NEW Reservacion($_GET['id']);
  $tarifa= NEW Tarifa($_GET['tarifa']);
  $adultos= $tarifa->mostrar_cantidad_hospedaje($_GET['tarifa']);
  $editar= 1;
  $id_cuenta= $reservacion->id_cuenta;
  $precio_hospedaje= 0;
  $precio_adulto= 0;
  $precio_junior= 0;
  $precio_infantil= 0;

   // Checar si forzar tarifa esta vacia o no
   if (empty($_GET['forzar_tarifa'])){
    //echo 'La variable esta vacia';
    $forzar_tarifa= 0;
  }else{
    $forzar_tarifa= $_GET['forzar_tarifa'];
  }
  // Checar si forzar extra esta vacia o no
  if (empty($_GET['forzar_extra'])){
    //echo 'La variable esta vacia';
    $forzar_extra= 0;
  }else{
    $forzar_extra= $_GET['forzar_extra'];
  }

  // Reajuste al forzar tarifa
  if($forzar_tarifa <= 0){
    $precio_hospedaje= $tarifa->precio_hospedaje;
  }else{
    $precio_hospedaje= $forzar_tarifa;
  }
  // Reajuste al forzar extra
  if($forzar_extra <= 0){
    $precio_adulto= $tarifa->precio_adulto;
    $precio_junior= $tarifa->precio_junior;
    $precio_infantil= $tarifa->precio_infantil;
  }else{
    $precio_adulto= $forzar_extra;
    $precio_junior= $forzar_extra;
    $precio_infantil= $forzar_extra;
  }

  $precio_adulto= $precio_adulto * $_GET['noches'];
  $precio_junior= $precio_junior * $_GET['noches'];
  $precio_infantil= $precio_infantil * $_GET['noches'];
  $precio_hab= $precio_hospedaje * $_GET['noches'] * $_GET['numero_hab'];
  $cantidad_maxima= $tarifa->cantidad_maxima;
  $leyenda= $tarifa->leyenda;
  $tipo_hab= $_GET['tarifa'];
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
          <div class="col-sm-4">'.$leyenda.'</div>
        </div>
        <div class="row">
          <div class="col-sm-2">
            <button class="btn btn-success btn-block" href="#caja_herramientas" data-toggle="modal" onclick="asignar_huesped('.$editar.','.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')"> Asignar Huésped</button>
          </div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="id_huesped" value="'.$reservacion->id_huesped.'" disabled/>
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
          <div class="col-sm-8 div_datos">Presiona este botón si deseas ver los datos del huésped previamente asignado:</div>
          <div class="col-sm-3">
            <button type="button" class="btn btn-primary btn-block boton_datos" onclick="mostrar_datos(-1)">Ver Datos</button>
          </div>
          <div class="col-sm-1"></div>
        </div>
        <div class="row div_oculto">';
          // Div oculto donde van los datos de el huésped asignado para agregar una reservacion, pudiendose editar
          echo '
        </div><hr> 
        <div class="row">
          <div class="col-sm-2">Suplementos:</div>
          <div class="col-sm-2">
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
          <div class="col-sm-2">Abono al reservar:</div>
          <div class="col-sm-2">
          <div class="form-group">
          <input class="form-control" type="number"  id="total_pago" value="'.$reservacion->total_pago.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
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
          <div class="col-sm-2">Descuento:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="number"  id="descuento" value="'.$reservacion->descuento.'" onchange="calcular_total_editar('.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.')">
          </div>
          </div>
          <div class="col-sm-4"></div>
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
              $forma_pago->mostrar_forma_pago_editar($reservacion->forma_pago);
              echo '
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
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_reservacion('.$_GET['id'].','.$precio_hospedaje.','.$precio_adulto.','.$precio_junior.','.$precio_infantil.','.$adultos.','.$id_cuenta.','.$cantidad_maxima.','.$tipo_hab.')">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_reservacion()"> ←</button></div>
        </div>
      </div>';
?>
