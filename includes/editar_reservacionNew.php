<?php
  error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_configuracion.php");
  include_once("clase_forma_pago.php");
  include_once("clase_huesped.php");


  $reservacion = new Reservacion($_GET['id']);
  $tarifa= NEW Tarifa(0);
  $huesped = new Huesped($reservacion->id_huesped);
//   if($reservacion->tarifa!=0){
//     $tarifa= NEW Tarifa($reservacion->tarifa);
//   }
  $id_cuenta = $reservacion->id_cuenta;

  $config= new Configuracion();
  $inputFechaEn="";
  $inputValueFecha="";
  $dia= time();
  $dia_actual= date("Y-m-d",$dia);

  $forma_pago = new Forma_pago(0);

  $titulo_="";
  $clv="";
  
  $require_tarifa="required";

  if($reservacion->forzar_tarifa!=""){
    $require_tarifa="";
  }

  // Checar si hab_id esta vacia o no
  if (empty($_GET['hab_id'])){

    $hab_id= 0;
    $hab_tipo= 0;
    $titulo_="Editar reservación " . $reservacion->id;
    $clv="Clave de reserva";

    $hab = NEW Hab(0);
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
  }else{
    $titulo_="CHECK-IN";
    $clv="Clave check-in";
    $hab_id= $_GET['hab_id'];
    $hab = NEW Hab($hab_id);
    $hab_tipo= $hab->tipo;
    $inputFechaEn="disabled";
    $inputValueFecha=$dia_actual;
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
}
$ultimo_id =$reservacion->id;

$sobreventa="";
if($reservacion->sobrevender){
    $sobreventa="checked";
}

$canales_reserva = array("telefono"=>"Telefono","email"=>"Email","web"=>"Web","agencia"=>"Agencia de viajes");

echo '<div class="container-fluid blanco" style="width: 1200px;">
<div class="row justify-content-center ">
    <div class="col-md-9">
        <form onsubmit="event.preventDefault(); guardarNuevaReservacion('.$hab_id.','.$id_cuenta.','.$reservacion->id.')">
        <div class="div_adultos"></div>
        <h2 class="titulo">'.$titulo_.'</h2> <br>
            <div class="d-flex justify-content-end">
                <div class="form-group col-md-4 mb-3">
                    <label for="clave-reserva" class="text-right">'.$clv.'</label>
                    <input type="text" value="'.$ultimo_id.'" class="form-control" id="clave-reserva" readonly>
                </div>';
                if (empty($_GET['hab_id'])) {
                    echo ' <div class="form-group col-md-4">
                    <label for="tipo-reservacion" class="text-right">Tipo de reservación</label>
                    <select class="form-control" id="tipo-reservacion">
                        <option value="individual">Individual</option>
                        <option value="grupo">Grupo</option>
                        <option value="evento">Evento</option>
                    </select>
                </div>';
                }
                
                echo'
               
                <div class="form-group col-md-4">
                    <label for="total-estancia">Total de la estancia</label>
                    <input type="number" class="form-control" id="total" min="0" step="0.01" value='.$reservacion->total.' readonly>
                    <input type="number" class="form-control" id="aux_total" min="0" value='.$reservacion->total.' step="0.01" readonly hidden>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-4 mb-3">
                    <label for="llegada">Llegada</label>
                    <input required '.$inputFechaEn.' value="'.date("Y-m-d",$reservacion->fecha_entrada).'" class="form-control" type="date"  id="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_noches('.$hab_id.')">
                </div>
                <div class="form-group col-md-4">
                    <label for="salida">Salida</label>
                    <input required class="form-control" type="date"  id="fecha_salida" min='.$dia_actual.' value="'.date("Y-m-d",$reservacion->fecha_salida).'" placeholder="Ingresa la fecha de salida" onchange="calcular_noches('.$hab_id.');">
                </div>
                <div class="form-group col-md-4">
                    <label for="noches">Noches</label>
                    <input class="form-control" type="number" value="'.$reservacion->noches.'"  id="noches" placeholder="0" onchange="cambiar_adultosNew("",'.$hab_id.');" disabled/>
                </div>
                
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    <label for="tarifa">Tarifa por noche</label>
                    <select '.$require_tarifa.' class="form-control" id="tarifa" onchange="cambiar_adultosNew(event,'.$hab_id.')">
                    <option value="">Selecciona</option>';
                    $tarifa->mostrar_tarifas_editar($reservacion->tarifa);
                    echo '
                  </select>
                </div>
            <div class="form-group col-md-4 mb-3">
                    <label for="tipo-habitacion">Forzar tarifa</label>
                    <input type="number" class="form-control" value="'.$reservacion->forzar_tarifa.'" id="forzar-tarifa" min="0" step="0.01" onchange="cambiar_adultosNew(0,'.$hab_id.')">
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="tipo-habitacion">Tipo de habitación</label>
                    <select class="form-control" id="tipo-habitacion" disabled>
                    ';
                    $hab->mostrar_hab_editarTarifa($reservacion->tarifa);
                    echo '
                  </select>
                </div>
                <!---
                <div class="form-group col-md-3">
                    <label for="no-habitaciones">No. de habitaciones</label>
                    <input type="number" class="form-control" id="numero_hab" min="1"  value="'.$reservacion->numero_hab.'" required  onchange="cambiar_adultosNew("",'.$hab_id.')">
                </div>
                -->
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    
            </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="adultos">Adultos</label>
                    <input type="number" class="form-control" id="extra_adulto" min="0"  value="'.$reservacion->extra_adulto.'"  onchange="nuevo_calculo_total()">
                    <input type="number" id="tarifa_adultos" hidden>
                </div>
                <div class="form-group col-md-4">
                    <label for="menores">Menores</label>
                    <input type="number" class="form-control" id="extra_infantil" min="0"  value="'.$reservacion->extra_infantil.'" onchange="nuevo_calculo_total()">
                    <input type="number" id="tarifa_menores" hidden>
                </div>
             
                
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    <label for="no-habitaciones">Número de habitaciones</label>
                    <input type="number" class="form-control" id="numero_hab" min="1" value="'.$reservacion->numero_hab.'" required  onchange="cambiar_adultosNew(0,'.$hab_id.')">
                </div>
                <div class="form-group col-md-4">
                    <label for="pax-extra">Pax extra</label>
                    <input type="number" class="form-control" id="pax-extra" min="0" value="'.$reservacion->pax_.'"  onchange="nuevo_calculo_total()">
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="plan-alimentos">Plan de alimentos</label>
                    <select class="form-control" id="plan-alimentos"  onchange="nuevo_calculo_total(event)">
                    <option value="">Seleccione una opción</option>';
                    $config->mostrar_planes_select($reservacion->plan_alimentos);
                  echo'
                  </select>
                  <input type="number" id="costoplan" hidden>
                </div>
            </div>';
            if (empty($_GET['hab_id'])) {
                echo'
                <div class="d-flex justify-content-between">
                <div class="form-group col-md-4">
                    <label for="hab-preasignada">Habitación preasignada</label>
                    <select class="form-control" id="preasignada">
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="hab-preasignada">Sobrevender</label>
                    <input type="checkbox" id="sobrevender" '.$sobreventa.' disabled class="form-check"/>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="canal-reserva">Canal de reserva</label>
                    <select class="form-control" id="canal-reserva" required>
                        <option value="">Seleccione una opción</option>';
                        foreach ($canales_reserva as $key => $value) {
                            if($key == $reservacion->canal_reserva){
                                echo "<option selected value='$key'>$value</option>";
                            }else{
                                echo "<option value='$key'>$value</option>";
                            }
                        }
                        echo'
                    </select>
                </div>
            </div>';
            }
        echo'
            <br>
            <h2>Datos Personales</h2>
            <button class="btn btn-success btn-block mb-2"  onclick="event.preventDefault(); asignar_huespedNew(0,0,0,0,0)" href="#caja_herramientas" data-toggle="modal"> Buscar Huésped</button>
            <input type="text" id="tomahuespedantes"  hidden value="'.$huesped->id.'">
            <input type="text" id="estadotarjeta" hidden value="'.$huesped->estado_tarjeta.'">
            <input type="text" id="nut" hidden value="'.$huesped->titular_tarjeta.'">
            <input type="text" id="nt" hidden value="'.$huesped->numero_tarjeta.'">
            <input type="text" id="mes" hidden value="'.$huesped->vencimiento_mes.'">
            <input type="text" id="year" hidden value="'.$huesped->vencimiento_ano.'">
            <input type="text" id="ccv" hidden value="'.$huesped->cvv.'">
            <input type="text" id="nombre_tarjeta" hidden value="'.$huesped->nombre_tarjeta.'">
          
           
            <br>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" value="'.$huesped->nombre.'" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido"  value="'.$huesped->apellido.'"required>
                </div>
                <div class="form-group col-md-4">
                    <label for="empresa">Empresa/Agencia</label>
                    <input type="text" class="form-control" id="empresa" value="'.$huesped->empresa.'">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-3">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" required value="'.$huesped->telefono.'">
                </div>
                <div class="form-group col-md-3">
                    <label for="pais">País</label>
                    <input type="text" class="form-control" id="pais" value="'.$huesped->pais.'">
                </div>
                <div class="form-group col-md-3">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" id="estado" value="'.$huesped->estado.'">
                </div>
                <div class="form-group col-md-3">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" required value="'.$huesped->ciudad.'">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-6">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion" value="'.$huesped->direccion.'">
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Correo electrónico </label>
                    <input type="text" class="form-control" id="correo" value="'.$huesped->correo.'">
                </div>
                <div class="form-group col-md-2">
                <label for="confirmacion">Confirmación</label>
                <input type="checkbox" id="confirmacion"  class="form-check"/>
                </select>
            </div>
            </div>
            <div class="d-flex justify-content-between">
                
                <div class="form-group col-md-4">
                    <label for="forma-garantia">Forma de Garantía</label>
                    <select class="form-control" id="forma-garantia" required onchange="obtener_garantia(event)">
                    <option value="">Seleccione una opción </option>
                    ';
                
                    $forma_pago->mostrar_forma_pago($huesped->tipo_tarjeta);
                    echo'
                    </select>
                </div>
               
                <div class="form-group col-md-4">
                <label for="forma-garantia">Forma de Garantía</label>
                <button id="btngarantia" disabled class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">Añadir tarjeta</button>
                </div>';

                if (empty($_GET['hab_id'])) {
                echo ' <div class="form-group col-md-4">
                <label for="persona-reserva">Persona que reserva</label>
                <input type="text" class="form-control" id="persona-reserva" required value="'.$reservacion->nombre_reserva.'">
                </div>';
                }

                echo '
            </div>
            <div class="form-group col-md-6" id="div_voucher" style="display:none">
            <label for="voucher">Voucher</label>
            <textarea id="voucher" class="form-control" rows="1"></textarea>
            </div>
            <div class="form-group col-md-12">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control" id="observaciones" rows="3">'.$huesped->comentarios.'</textarea>
            </div>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" onclick="">Actualizar</button>
            </div>
        </form>
        <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_reservacion()"> ←</button></div>
        <div id="example"></div>
    </div>
    
</div>
</div>
';