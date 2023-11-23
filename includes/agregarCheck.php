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
echo '

<div class="form_container">
    <form onsubmit="event.preventDefault();" id="form-reserva" class="formulario_contenedor">
        <div class="div_adultos"></div>

        <div class="form_title_container">
            <h2 class="form_title_text">'.$titulo_.'</h2>
        </div>

            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input type="text" value="'.$ultimo_id.'" class="form-control custom_input" id="clave-reserva" readonly placeholder="'.$clv.'">
                    <label for="clave-reserva">'.$clv.'</label>
                </div>';

        echo'   <div class="form-floating input_container">
                    <select class="form-select custom_input" id="habitacion_checkin" name="habitacion_check" onchange="habSeleccionada(event); calcular_nochesChek()" required>
                        <option selected disabled>Seleccionar una habitación</option>
                        ';
                        $hab->mostrar_hab_option();
        echo'
                    </select>
                    <label for="clave-reserva asterisco">Habitación</label>
                </div>';
        echo'
                <div class="form-floating input_container">
                    <input type="number" class="form-control custom_input" id="total" min="0" step="0.01" readonly placeholder="Total de la estancia">
                    <input type="number" class="d-none" id="tarifa_base" min="0" step="0.01" readonly hidden>
                    <label for="total">Total de la estancia</label>
                </div>
            </div>

            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input required '.$inputFechaEn.' value="'.$inputValueFecha.'" class="form-control custom_input" type="date"  id="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_nochesChek()">
                    <label for="llegada">Llegada</label>
                </div>
                <div class="form-floating input_container">
                    <input required class="form-control custom_input" type="date"  id="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_nochesChek();">
                    <label class="asterisco" for="salida">Salida</label>
                </div>
                <div class="form-floating input_container">
                    <input class="form-control custom_input" type="number"  id="noches" placeholder="0" onchange="cambiar_adultosNew("",'.$hab_id.');" disabled/>
                    <label for="noches">Noches</label>
                </div>
            </div>

            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <select required class="form-control custom_input" id="tarifa" onchange="cambiar_adultosNew(event,'.$hab_id.')" aria-label="Floating label select example">
                    <option selected disabled>Selecciona una opción</option>
                    ';
                echo '
                    </select>
                    <label class="asterisco" for="tarifa">Tarifa por noche</label>
                </div>
                <div class="form-floating input_container">
                    <input class="form-control custom_input" autocomplete="off" id="forzar-tarifa" minlength="0" step="0.01" type="text" maxlength="10"  onkeypress="validarNumero(event)"onchange="cambiar_adultosNew(0,'.$hab_id.')" placeholder="Forzar tarifa">
                    <label for="forzar-tarifa">Forzar tarifa</label>
                </div>
                <div class="form-floating input_container">
                    <select class="form-control custom_input" id="tipo-habitacion" disabled>
                    ';
                    $hab->mostrar_tipo();
                echo '
                    </select>
                    <label for="tipo-habitacion">Tipo de habitación</label>
                </div>
                <!---
                <div class="form-group col-md-3">
                    <label class="asterisco" for="no-habitaciones">No. de habitaciones</label>
                    <input disabled type="number" class="form-control" id="numero_hab" min="1" value="" required  onchange="cambiar_adultosNew("",'.$hab_id.')">
                </div>
                -->
            </div>
            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input type="number" class="form-control custom_input" id="precio_hospedaje" min="0" disabled placeholder="Preio noche">
                    <label for="precio_hospedaje">Precio noche</label>
                </div>
                <div class="form-floating input_container">
                    <input class="form-control custom_input" id="extra_adulto" type="text" maxlength="2"  onkeypress="validarNumero(event)" onchange="editarTotalEstancia(); mostrarAcordeonCompleto()" placeholder="Adultos">
                    <input type="number" id="cantidad_hospedaje" hidden>
                    <input type="number" id="tarifa_adultos" hidden>
                    <label for="extra_adulto">Adultos</label>
                </div>
                <div class="form-floating input_container">
                    <input class="form-control custom_input" id="extra_infantil" type="text" maxlength="2"  onkeypress="validarNumero(event)" onchange="editarTotalEstancia()" placeholder="Menores">
                    <input type="number" id="tarifa_menores" hidden>
                    <label for="extra_infantil">Menores</label>
                </div>
            </div>
            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input disabled class="form-control custom_input" id="numero_hab" minlength="1" value="1" required type="text" maxlength="2"  onkeypress="validarNumero(event)" onchange="editarTotalEstancia()" placeholder="Número de habitaciones">
                    <label class="asterisco" for="numero_hab">Número de habitaciones</label>
                </div>
                <div class="form-floating input_container">
                    <input  class="form-control custom_input" id="pax-extra" type="text" maxlength="10"  onkeypress="validarNumero(event)" onchange="editarTotalEstancia()" placeholder="Pax extra">
                    <label for="pax-extra">Pax extra</label>
                </div>
                <div class="form-floating input_container">
                    <select class="form-select custom_input" id="plan-alimentos"  onchange="editarTotalEstancia(event)">
                        <option selected disabled>Seleccione una opción</option>';
                        $config->mostrar_planes_select();
                echo'
                    </select>
                    <input type="number" id="costoplan" hidden>
                    <label for="plan-alimentos">Plan de alimentos</label>
                </div>
            </div>';

        echo'
            <div class="form_title_container">
                <h2 class="form_title_text">Datos Personales</h2>
                <button class="btn btn-primary"  onclick="event.preventDefault(); asignar_huespedNew(0,0,0,0,0)" href="#caja_herramientas" data-toggle="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                        <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
                    </svg>
                    Buscar Huésped
                </button>
            </div>
            <input type="text" id="tomahuespedantes" hidden>
            <input type="text" id="estadotarjeta" hidden>
            <input type="text" id="nut" hidden>
            <input type="text" id="nt" hidden>
            <input type="text" id="mes" hidden>
            <input type="text" id="year" hidden>
            <input type="text" id="ccv" hidden>
            <input type="text" id="nombre_tarjeta"hidden >
            <input type="text" id="estadocredito" hidden>
            <input type="text" id="limitecredito" hidden>

            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="nombre" required placeholder="Nombre">
                    <label class="asterisco" for="nombre">Nombre</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="apellido" required placeholder="Apellido">
                    <label class="asterisco" for="apellido">Apellido</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="empresa" placeholder="Empresa / Agencia">
                    <label for="empresa">Empresa / Agencia</label>
                </div>
            </div>
            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input type="tel" class="form-control custom_input" id="telefono" required placeholder="Teléfono">
                    <label class="asterisco" for="telefono">Teléfono</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="pais" placeholder="País">
                    <label for="pais">País</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="estado" placeholder="Estado">
                    <label for="estado">Estado</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="ciudad" required placeholder="Ciudad">
                    <label class="asterisco" for="ciudad">Ciudad</label>
                </div>
            </div>
            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="direccion" placeholder="Dirección">
                    <label for="direccion">Dirección</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="correo" placeholder="Correo electrónico">
                    <label for="email">Correo electrónico </label>
                </div>
                <!-- 
                <div class="form-floating">
                    <label for="confirmacion">Confirmación</label>
                    <div class="checkbox-container">
                        <input class="yesornot" type="radio" name="rdo" id="yes" checked/>
                        <input class="yesornot" type="radio" name="rdo" id="no" />
                    <div class="switch">
                        <label for="yes">Si</label>
                        <label for="no">No</label>
                        <span></span>
                        </div>
                        <input type="checkbox" id="confirmacion"  class="form-check" hidden/>
                        </div>
                    </select>
                
                </div>
                -->
            </div>
            <div class="inputs_form_container">
                <div class="accordionCustom" id="acordeonchido">
                    <div class="accordion-itemCustom">
                        <div id="acordeonIcon" onclick="mostrarAcorderon()" class="accordionItemHeaderCustom">
                            <label>Acompañantes</label>
                        </div>
                        <div id="acordeon" class="accordionItemBodyCustom">
                        </div>
                    </div>
                </div>
            </div>
            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <select class="form-select custom_input" id="forma-garantia" required onchange="obtener_garantia(event)" >
                    <option selected disable>Seleccione una opción </option>
                    ';
                    $forma_pago->mostrar_forma_pago();
                echo'
                    </select>
                    <label class="asterisco" for="forma-garantia">Forma de Garantía</label>
                </div>
                <div class="form-group input_container">
                <label class="col-12" for="forma-garantia">Forma de Garantía</label>
                <button id="btngarantia" class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                        <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                    </svg>
                    Añadir tarjeta
                </button>
                </div>
            </div>
            <div class="form-floating input_container" id="div_voucher" style="display:none">
                <input id="voucher" type="text" class="form-control custom_input" rows="1"></input>
                <label for="voucher">Voucher</label>
            </div>
        <div class="inputs_form_container">
                <div class="form-floating input_container" id="div_voucher" >
                    <input disabled id="voucher" type="text" class="form-control custom_input" rows="1"></input>
                    <label for="voucher">Voucher</label>
                </div>

                <div class="form-floating input_container" id="div_garantia" >
                    <input disabled class="form-control custom_input" id="garantia_monto" type="text" maxlength="10"  onkeypress="validarNumero(event)">
                    <label for="garantia_monto">Monto garantía</label>
                </div>
            </div>
            <div class="form-floating input_container">
                <textarea class="form-control custom_input" id="observaciones" placeholder="Deja una observacion" style="height: 100px"></textarea>
                <label for="observaciones">Observaciones</label>
            </div>
            <div class="container_btn">
                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="guardarCheck()">Enviar</button>
            </div>
    </form>
        <div id="example"></div>
</div>
';