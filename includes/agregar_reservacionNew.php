

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
    $no_hab_estado="";

  // Checar si hab_id esta vacia o no
    if (empty($_GET['hab_id'])){
        $hab_id= 0;
        $hab_tipo= 0;
        $titulo_="Reservación de habitación";
        $clv="Clave de reserva";
        $hab = NEW Hab(0);
        $dia_actual = date("Y-m-d",strtotime($dia_actual));
    }else{
        $titulo_="CHECK-IN";
        $clv="Clave check-in";
        $hab_id= $_GET['hab_id'];
        $hab = NEW Hab($hab_id);
        $hab_tipo= $hab->tipo;
        $inputFechaEn="disabled";
        $inputValueFecha=$dia_actual;
        $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
        $no_hab_estado = "disabled";
    }



  //obtener el ultimo id de reserva.
$ultimo_id = $reservacion->obtener_ultimo_id() /*+ 1*/;
echo '

<div class="form_container">
    <form onsubmit="event.preventDefault();" id="form-reserva" class="formulario_contenedor">
        <div class="div_adultos"></div>
        <div class="form_title_container">
            <h2 class="titulo">'.$titulo_.'</h2> <br>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input type="text" value="'.$ultimo_id.'" class="form-control custom_input" id="clave-reserva" readonly placeholder="Clave de reserva">
                <label for="clave-reserva" class="text-right">'.$clv.'</label>
            </div>';

if (empty($_GET['hab_id'])) {
    echo ' <div class="form-floating input_container">
                <select class="form-select custom_input " id="tipo-reservacion">
                    <option value="individual">Individual</option>
                    <option value="grupo">Grupo</option>
                    <option value="evento">Evento</option>
                </select>
                <label for="tipo-reservacion">Tipo de reservación</label>
            </div>';
}else{
    echo ' <div class="form-floating input_container">
                <input type="text" value="'.$hab->nombre.'" class="form-control custom_input"  readonly placeholder="Habitacion">
                <label for="clave-reserva">Habitación</label>
            </div>';
}
    echo'
            <div class="form-floating input_container">
                <input type="number" class="form-control custom_input" id="total" min="0" step="0.01" readonly>
                <input type="number" class="form-control" id="tarifa_base" min="0" step="0.01" readonly hidden >
                <label for="total-estancia">Total de la estancia</label>
            </div>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input aria-required="true" required '.$inputFechaEn.' value="'.$inputValueFecha.'" class="form-control custom_input" type="date"  id="fecha_entrada" name="fecha_entrada"  placeholder="Ingresa la fecha de entrada" onchange="calcular_noches('.$hab_id.')"/>
                <label class="asterisco" for="fecha_entrada">Llegada</label>
            </div>

            <div class="form-floating input_container">
                <input required class="form-control custom_input" type="date"  id="fecha_salida" name="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_noches('.$hab_id.');" >
                <label class="asterisco" for="salida">Salida</label>
            </div>

            <div class="form-floating input_container">
                <input  class="form-control custom_input" type="number"  id="noches" placeholder="0" onchange="cambiar_adultosNew("",'.$hab_id.');" disabled/>
                <label for="noches">Noches</label>
            </div>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <select required class="form-control custom_input" id="tarifa" onchange="cambiar_adultosNew(event,'.$hab_id.')">
                <option selected disabled>Seleccionar</option>';
                $tarifa->mostrar_tarifas($hab_tipo);
                echo '
                </select>
                <label class="asterisco" for="tarifa">Tarifa por noche</label>
            </div>

            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="forzar-tarifa" min="0" step="0.01" maxlength="10"   onkeypress="validarNumero(event)" onchange="cambiar_adultosNew(0,'.$hab_id.')" placeholder="tipo de habitacion">
                <label for="tipo-habitacion">Forzar tarifa</label>
            </div>

            <div class="form-floating input_container">
                <select class="form-control custom_input " id="tipo-habitacion" disabled>';
                    $hab->mostrar_tipo();
                echo '
                </select>
                <label for="tipo-habitacion">Tipo de habitación</label>
            </div>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input type="number" class="form-control custom_input" id="precio_hospedaje" min="0" disabled>
                <label for="adultos">Precio noche</label>
            </div>

            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="extra_adulto" maxlength="2" onkeypress="validarNumero(event)"  onchange="editarTotalEstancia(); mostrarAcordeonCompleto()" placeholder="Adultos">
                <input type="number" id="tarifa_adultos" hidden>
                <input type="number" id="cantidad_hospedaje" hidden>
                <input type="number" id="cantidad_maxima" hidden >
                <label for="extra_adulto">Adultos</label>
            </div>

            <div class="form-floating input_container">
                <input type="text" class="form-control custom_input" id="extra_infantil" maxlength="2" placeholder="Menores"  onkeypress="validarNumero(event)"  onchange="editarTotalEstancia()">
                <input type="number" id="tarifa_menores" hidden>
                <label for="extra_infantil">Menores</label>
            </div>
        </div>

        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <input maxlength="2" '.$no_hab_estado.' type="text" class="form-control custom_input" id="numero_hab" minlength="1" value="1" required onkeypress="validarNumero(event)" onchange="editarTotalEstancia()" placeholder="Numero de habitacion">
                <label class="asterisco" for="numero_hab">Número de habitaciones</label>
            </div>

            <div class="form-floating input_container">
                <input type="text"  class="form-control custom_input" placeholder="Pax extra" id="pax-extra" maxlength="10"   onkeypress="validarNumero(event)"  onchange="editarTotalEstancia()">
                <label for="pax-extra">Pax extra</label>
            </div>

            <div class="form-floating input_container">
                <select class="form-control custom_input" id="plan-alimentos"  onchange="editarTotalEstancia(event)">
                <option data-costoplan="0"  disabled value="0" selected>Seleccione una opción</option>';
                $config->mostrar_planes_select();
                echo'
                </select>
                <input type="number" id="costoplan" hidden>
                <label for="plan-alimentos">Plan de alimentos</label>
            </div>
        </div>';

if (empty($_GET['hab_id'])) { echo'
        <div class="inputs_form_container">
            <div class="form-floating input_container">
                <select class="form-control custom_input" id="preasignada">
                    <option selected disabled>Seleccione una opción</option>
                </select>
                <label for="hab-preasignada">Habitación preasignada</label>
            </div>

        <div class="form-floating input_container">
            <select class="form-control custom_input" id="canal-reserva" required>
                <option selected disabled>Seleccione una opción</option>
                <option value="telefono">Teléfono</option>
                <option value="email">Email</option>
                <option value="web">Web</option>
                <option value="agencia">Agencia de viajes</option>
            </select>
            <label class="asterisco" for="canal-reserva">Canal de reserva</label>
        </div>

        <div class="form-check form-switch input_container">
            <input class="form-check-input" type="checkbox" role="switch" id="sobrevender" onchange="sobreVenderHab(event)">
            <label class="form-check-label" for="sobrevender">Sobrevender</label>
        </div>

        </div>
';}
echo'
    <div class="form_title_container">
        <h2 class="form_title_text">Datos Personales</h2>
        <button type="button" class="btn btn-primary"  onclick="event.preventDefault(); asignar_huespedNew(0,0,0,0,0)" href="#caja_herramientas" data-toggle="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z"/>
            </svg>
            Buscar Huésped
        </button>
    </div>

            <input type="text" id="tomahuespedantes" hidden>
            <input type="text" id="estadotarjeta" hidden >
            <input type="text" id="nut" hidden>
            <input type="text" id="nt" hidden>
            <input type="text" id="mes" hidden>
            <input type="text" id="year" hidden>
            <input type="text" id="ccv" hidden>
            <input type="text" id="nombre_tarjeta" hidden>
            <input type="text" id="estadocredito" hidden >
            <input type="text" id="limitecredito" hidden>

        <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" id="nombre" required name="nombre" placeholder="Nombre">
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
                    <input type="tel" class="form-control custom_input" placeholder="Telefono" id="telefono" required>
                    <label class="asterisco" for="telefono">Teléfono</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" placeholder="Pais" id="pais">
                    <label for="pais">País</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" placeholder="Estado" id="estado">
                    <label for="estado">Estado</label>
                </div>
                <div class="form-floating input_container">
                    <input type="text" class="form-control custom_input" placeholder="Ciudad" id="ciudad" required>
                    <label class="asterisco" for="ciudad">Ciudad</label>
                </div>
        </div>

         <div class="inputs_form_container">
                <div class="form-floating inputs_container">
                    <input type="text" class="form-control custom_input" id="direccion" placeholder="Direccion">
                    <label for="direccion">Dirección</label>
                </div>
                <div class="form-floating inputs_container">
                    <input type="email" class="form-control custom_input" id="correo" onblur="comprobarEmail()" placeholder="Correo electronico">
                    <label for="email">Correo electrónico </label>
                </div>';
                if (empty($_GET['hab_id'])) {
                    echo'
                        <div class="form-check form-switch input_container">
                            <input class="form-check-input" type="checkbox" role="switch" id="confirmacion" checked onchange="sobreVenderHab(event)">
                            <label class="form-check-label" for="confirmacion">Confirmacion</label>
                        <!--
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
                        -->
                        </div>
                    ';
                }else {
                    echo '
                    <div class="form-check form-switch input_container d-none">
                            <input class="form-check-input" type="checkbox" role="switch" id="confirmacion" checked onchange="sobreVenderHab(event)">
                            <label class="form-check-label" for="confirmacion">Confirmacion</label>
                        <!--
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
                        -->
                        </div>';
                }
                echo '
            </div>

            <div class="d-flex justify-content-between flex-wrap">
                <div class="accordionCustom" id="acordeonchido">
                    <div class="accordion-itemCustom">
                    <div id="acordeonIcon" onclick="mostrarAcorderon()" class="accordionItemHeaderCustom">
                                    <label>Acompañantes</label>
                                </div>
                                <div id="acordeon" class="accordionItemBodyCustom acordeon">
                                </div>
                            </div>
                        </div>
            </div>

            <div class="inputs_form_container">
                <div class="form-floating input_container">
                    <select class="form-select custom_input" id="forma-garantia" required onchange="obtener_garantia(event)">
                    <option selected disabled>Seleccione una opción </option>
                    ';
                    $forma_pago->mostrar_forma_pago(0);
                    echo'
                    </select>
                    <label class="asterisco" for="forma-garantia">Forma de Garantía</label>
                </div>
                ';
                if (empty($_GET['hab_id'])) {
                    echo '
                        <div class="form-floating input_container">
                            <input type="text" class="form-control custom_input" id="persona-reserva" required placeholder="Persona que reserva">
                            <label class="asterisco" for="persona-reserva">Persona que reserva</label>
                        </div>
                    ';
                }else{
                    echo ' <div class="form-floating input_container">
                    </div>';
                }
                echo '
                <!--<div class="form-floating input_container">
                    <button type="button" id="btngarantia" class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                        </svg>
                        Añadir tarjeta
                    </button>
                </div>
                -->
            </div>

            <div class="inputs_form_container">
                <div class="form-floating input_container" id="div_voucher" >
                    <input disabled id="voucher" type="text" class="form-control custom_input" placeholder="Voucher">
                    <label for="voucher">Voucher</label>
                </div>
                <div class="form-floating input_container" id="div_garantia" >
                    <input disabled type="text" class="form-control custom_input" id="garantia_monto"  maxlength="10"  onkeypress="validarNumero(event)" placeholder="Monto garantia">
                    <label for="garantia_monto">Monto garantía</label>
                </div>
            </div>

            <div class="form-floating input_container">
                <textarea class="form-control custom_input" id="observaciones" placeholder="Deja una observacion" style="height: 100px;" ></textarea>
                <label for="observaciones">Observaciones</label>
            </div>

            <div class="container_btn">
                <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="event.preventDefault(); guardarNuevaReservacion('.$_GET['hab_id'].')">Enviar</button>
            </div>

            </form>
        </div>

        <div id="example"></div>
</div>
';
?>

