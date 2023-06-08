<?php
  error_reporting(0);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_configuracion.php");
  include_once("clase_forma_pago.php");
  $tarifa= NEW Tarifa(0);
  $reservacion = new Reservacion(0);
  $config= new Configuracion();
  $inputFechaEn="";
  $inputValueFecha="";
  $dia= time();
  $dia_actual= date("Y-m-d",$dia);
  $forma_pago = new Forma_pago(0);
  $titulo_="";
  $clv="";
  $titulo_="CHECK-IN";
  $clv="Clave check-in";
  $hab_id=0;
  $hab = new Hab(0);
  $inputFechaEn="disabled";
  $inputValueFecha=$dia_actual;
  $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));


  //obtener el ultimo id de reserva.
$ultimo_id = $reservacion->obtener_ultimo_id() /*+ 1*/;
echo '<div class="container-fluid blanco" style="width: 1200px;">
<div class="row justify-content-center ">
    <div class="col-md-9">
        <form onsubmit="event.preventDefault(); guardarCheck()">
        <div class="div_adultos"></div>
        <h2 class="titulo">'.$titulo_.'</h2> <br>
            <div class="d-flex justify-content-end">
                <div class="form-group col-md-4 mb-3">
              
                    <label for="clave-reserva" class="text-right">'.$clv.'</label>
                    <input type="text" value="'.$ultimo_id.'" class="form-control" id="clave-reserva" readonly>
                </div>';
              
                    echo ' <div class="form-group col-md-4">
                    <label for="clave-reserva" class="text-right">Habitación</label>
                    <select class="form-control" id="habitacion_check" onchange="habSeleccionada(event)" required>
                    <option value="">Seleccionar una habitación</option>
                    ';
                    
                    $hab->mostrar_hab_option();

                    echo '
                    </select>
                    </div>';
                echo'
                <div class="form-group col-md-4">
                    <label for="total-estancia">Total de la estancia</label>
                    <input type="number" class="form-control" id="total" min="0" step="0.01" readonly>
                    <input type="number" class="form-control" id="aux_total" min="0" step="0.01" readonly hidden>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-4 mb-3">
                    <label for="llegada">Llegada</label>
                    <input required '.$inputFechaEn.' value="'.$inputValueFecha.'" class="form-control" type="date"  id="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_nochesChek()">
                </div>
                <div class="form-group col-md-4">
                    <label for="salida">Salida</label>
                    <input required class="form-control" type="date"  id="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_nochesChek();">
                </div>
                <div class="form-group col-md-4">
                    <label for="noches">Noches</label>
                    <input class="form-control" type="number"  id="noches" placeholder="0" onchange="cambiar_adultosNew("",'.$hab_id.');" disabled/>
                </div>
                
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    <label for="tarifa">Tarifa por noche</label>
                    <select required class="form-control" id="tarifa" onchange="cambiar_adultosNew(event,'.$hab_id.')">
                   
                    ';
                    echo '
                    </select>
                </div>
            <div class="form-group col-md-4 mb-3">
                    <label for="tipo-habitacion">Forzar tarifa</label>
                    <input type="number" class="form-control" id="forzar-tarifa" min="0" step="0.01" onchange="cambiar_adultosNew(0,'.$hab_id.')">
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="tipo-habitacion">Tipo de habitación</label>
                    <select class="form-control" id="tipo-habitacion" disabled>
                    ';
                    $hab->mostrar_tipo();
                    echo '
                  </select>
                </div>
                <!---
                <div class="form-group col-md-3">
                    <label for="no-habitaciones">No. de habitaciones</label>
                    <input type="number" class="form-control" id="numero_hab" min="1" value="" required  onchange="cambiar_adultosNew("",'.$hab_id.')">
                </div>
                -->
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    
            </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="adultos">Adultos</label>
                    <input type="number" class="form-control" id="extra_adulto" min="0"   onchange="nuevo_calculo_total()">
                    <input type="number" id="tarifa_adultos" hidden>
                </div>
                <div class="form-group col-md-4">
                    <label for="menores">Menores</label>
                    <input type="number" class="form-control" id="extra_infantil" min="0"  onchange="nuevo_calculo_total()">
                    <input type="number" id="tarifa_menores" hidden>
                </div>
             
                
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    <label for="no-habitaciones">Número de habitaciones</label>
                    <input type="number" class="form-control" id="numero_hab" min="1" value="1" required  onchange="cambiar_adultosNew(0,'.$hab_id.')">
                </div>
                <div class="form-group col-md-4">
                    <label for="pax-extra">Pax extra</label>
                    <input type="number" class="form-control" id="pax-extra" min="0"   onchange="nuevo_calculo_total()">
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="plan-alimentos">Plan de alimentos</label>
                    <select class="form-control" id="plan-alimentos"  onchange="nuevo_calculo_total(event)">
                    <option value="">Seleccione una opción</option>';
                    $config->mostrar_planes_select();
                  echo'
                  </select>
                  <input type="number" id="costoplan" hidden>
                </div>
            </div>';
          
          
        echo'
            <br>
            <h2>Datos Personales</h2>
            <button class="btn btn-success btn-block mb-2"  onclick="event.preventDefault(); asignar_huespedNew(0,0,0,0,0)" href="#caja_herramientas" data-toggle="modal"> Buscar Huésped</button>
            <input type="text" id="tomahuespedantes" hidden>
            <input type="text" id="estadotarjeta" hidden>
            <input type="text" id="nut" hidden>
            <input type="text" id="nt" hidden>
            <input type="text" id="mes" hidden>
            <input type="text" id="year" hidden>
            <input type="text" id="ccv" hidden>
            <input type="text" id="nombre_tarjeta" hidden>
          
           
            <br>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-4">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="empresa">Empresa/Agencia</label>
                    <input type="text" class="form-control" id="empresa">
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-3">
                    <label for="telefono">Teléfono</label>
                    <input type="tel" class="form-control" id="telefono" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="pais">País</label>
                    <input type="text" class="form-control" id="pais">
                </div>
                <div class="form-group col-md-3">
                    <label for="estado">Estado</label>
                    <input type="text" class="form-control" id="estado">
                </div>
                <div class="form-group col-md-3">
                    <label for="ciudad">Ciudad</label>
                    <input type="text" class="form-control" id="ciudad" required>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-6">
                    <label for="direccion">Dirección</label>
                    <input type="text" class="form-control" id="direccion">
                </div>
                <div class="form-group col-md-4">
                    <label for="email">Correo electrónico </label>
                    <input type="text" class="form-control" id="correo">
                </div>
                <div class="form-group col-md-2">
                <label for="confirmacion">Confirmación</label>
                <div class="checkbox-container">
                <input type="radio" name="rdo" id="yes" checked/>
                <input type="radio" name="rdo" id="no" />
                <div class="switch">
                    <label for="yes">Si</label>
                    <label for="no">No</label>
                    <span></span>
                </div>
                <input type="checkbox" id="confirmacion"  class="form-check"/>
                </div>
                </select>
            </div>
            </div>
            <div class="d-flex justify-content-between">
                
                <div class="form-group col-md-4">
                    <label for="forma-garantia">Forma de Garantía</label>
                    <select class="form-control" id="forma-garantia" required onchange="obtener_garantia(event)">
                    <option value="">Seleccione una opción </option>
                    ';
                
                    $forma_pago->mostrar_forma_pago();
                    echo'
                    </select>
                </div>
              
                <div class="form-group col-md-4">
                <label for="forma-garantia">Forma de Garantía</label>
                <button id="btngarantia" disabled class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">Añadir tarjeta</button>
                </div>';
                echo '
            </div>
            <div class="form-group col-md-6" id="div_voucher" style="display:none">
            <label for="voucher">Voucher</label>
            <textarea id="voucher" class="form-control" rows="1"></textarea>
        </div>
            <div class="form-group col-md-12">
                <label for="observaciones">Observaciones</label>
                <textarea class="form-control" id="observaciones" rows="3"></textarea>
            </div>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" onclick="">Enviar</button>
            </div>
        </form>

        <div id="example"></div>
    </div>
</div>
</div>
';