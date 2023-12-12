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


  // Checar si hab_id esta vacia o no
if (empty($_GET['hab_id'])){

    $hab_id= 0;
    $hab_tipo= 0;
    $titulo_="Reservación de habitación";
    $clv="Clave de reserva";

    $hab = NEW Hab(0);
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
}else{
    $titulo_="CHECK-IN";
    $clv="Clave uso casa";
    $hab_id= $_GET['hab_id'];
    $hab = NEW Hab($hab_id);
    $hab_tipo= $hab->tipo;
    $inputFechaEn="disabled";
    $inputValueFecha=$dia_actual;
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
}



  //obtener el ultimo id de reserva.
$ultimo_id = $reservacion->obtener_ultimo_id() /*+ 1*/;
echo '
<div class="form_container">
    <form onsubmit="event.preventDefault();" id="form-reserva" class="formulario_contenedor">
        <form onsubmit="event.preventDefault();" id="form-reserva">
        <div class="div_adultos"></div>
        <div class="form_title_container">
        <h2 class="titulo">USO CASA</h2> <br>
        </div>

          <div class="inputs_form_container">
              <div class="form-floating input_container">
              <input type="text" value="'.$ultimo_id.'" class="form-control custom_input" id="clave-reserva" readonly placeholder="'.$clv.'">
              <label for="clave-reserva" >'.$clv.'</label>
                </div>';

                if (empty($_GET['hab_id'])) {
                    echo '   <div class="form-floating input_container">
                    <label for="tipo-reservacion" class="text-right">Tipo de reservación</label>
                    <select class="form-control" id="tipo-reservacion">
                        <option value="individual">Individual</option>
                        <option value="grupo">Grupo</option>
                        <option value="evento">Evento</option>
                    </select>
                </div>';
                }else{
                    echo ' <div class="form-floating input_container">
                    <input type="text" value="'.$hab->nombre.'" class="form-control custom_input"  readonly>
                    <label for="clave-reserva" class="text-right">Habitación</label>
                    </div>';
                }
                echo'
                <div class="form-floating input_container">
                <label for="total-estancia">Total de la estancia</label>
                <input type="number" class="form-control custom_input" id="total" min="0" step="0.01" readonly>
                <input type="number" class="form-controlcustom_input" id="tarifa_base" min="0" step="0.01" readonly hidden >
                </div>
            </div>

            <div class="inputs_form_container">
              <div class="form-floating input_container">
              <input aria-required="true" required '.$inputFechaEn.' value="'.$inputValueFecha.'" class="form-control custom_input" type="date"  id="fecha_entrada" name="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_noches('.$hab_id.',0,1)"/>
              <label class="asterisco" for="llegada">Llegada</label>
                <span> </span>

                </div>
                <div class="form-floating input_container">
                <input required class="form-control custom_input" type="date"  id="fecha_salida" name="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_noches('.$hab_id.',0,1);" />
                <label class="asterisco" for="salida">Salida</label>
                </div>
                <div class="form-floating input_container">
                <input class="form-control custom_input" type="number"  id="noches" placeholder="0" onchange="cambiar_adultosNew("",'.$hab_id.');" disabled/>
                <label for="noches">Noches</label>
                </div>
              </div>

              <div class="inputs_form_container">
               <div class="form-floating input_container">
                    <label for="tarifa">Tarifa por noche</label>
                    <select disabled class="form-control custom_input" id="tarifa" onchange="cambiar_adultosNew(event,'.$hab_id.')">
                   '; echo '
                  </select>
                </div>

               <div class="form-floating input_container">
               <label for="tipo-habitacion">Forzar tarifa</label>
               <input disabled type="number" class="form-control custom_input" id="forzar-tarifa" min="0" step="0.01" onchange="cambiar_adultosNew(0,'.$hab_id.')">
                </div>
                <div class="form-floating input_container">
                <label for="tipo-habitacion">Tipo de habitación</label>
                <select class="form-control custom_input" id="tipo-habitacion" disabled>
                    ';
                    
                    echo '
                  </select>
                </div>
                </div>

              <div class="inputs_form_container">
               <div class="form-floating input_container">      
                    <label for="adultos">Adultos</label>
                    <input disabled  type="number" class="form-control custom_input" id="extra_adulto" min="0"   onchange="editarTotalEstancia()">
                    <input type="number" id="tarifa_adultos" hidden>
                </div>       
                <div class="form-floating input_container">
                    <label for="menores">Menores</label>
                    <input disabled type="number" class="form-control custom_input" id="extra_infantil" min="0"  onchange="editarTotalEstancia()">
                    <input type="number" id="tarifa_menores" hidden>
                </div> 
              </div>

              <div class="inputs_form_container">
              <div class="form-floating input_container">     
              <input disabled type="number" class="form-control custom_input" id="numero_hab" min="1" value="1" required  onchange="editarTotalEstancia()">
              <label class="asterisco" for="no-habitaciones">Número de habitaciones</label>
                </div>

                 <div class="form-floating input_container"> 
                 <label for="pax-extra">Pax extra</label>
                 <input disabled type="number" class="form-control custom_input" id="pax-extra" min="0"   onchange="editarTotalEstancia()">
                </div>
                 <div class="form-floating input_container"> 
                 <label for="plan-alimentos">Plan de alimentos</label>
                  <select disabled class="form-control custom_input" id="plan-alimentos"  onchange="editarTotalEstancia(event)">
                    ';
                  
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
                <div class="form-group col-md-4 sobrevender">
                    <label for="hab-preasignada">Sobrevender</label>
                    
                    <div class="checkbox-container">
                    
                        <input type="checkbox" id="sobrevender" disabled class="form-check" onchange="sobreVenderHab(event)"/>
                        
                    </div>
                    
                </div>
                <div class="form-group col-md-4">
                    <label class="asterisco" for="canal-reserva">Canal de reserva</label>
                    <select class="form-control" id="canal-reserva" required>
                        <option value="">Seleccione una opción</option>
                        <option value="telefono">Teléfono</option>
                        <option value="email">Email</option>
                        <option value="web">Web</option>
                        <option value="agencia">Agencia de viajes</option>
                    </select>
                </div>
            </div>';
            }
        echo'
        <div class="form_title_container">
            <h2>Datos Personales</h2>
            </div>
            <input type="text" id="tomahuespedantes" hidden>
            <input type="text" id="estadotarjeta" hidden>
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
                <input type="text" class="form-control custom_input" id="nombre" required placeholder="Nombre">
                <label class="asterisco" for="nombre">Nombre</label>
                </div>

                <div class="form-floating input_container">
                 <input type="text" class="form-control custom_input" id="apellido" required placeholder="Apellido">
                 <label class="asterisco" for="apellido">Apellido</label>
                </div>

                <div class="form-floating input_container">
                <input disabled type="text" class="form-control custom_input" id="empresa" placeholder="Empresa / Agencia">
                <label for="empresa">Empresa / Agencia</label>
                </div>
            </div>

              <div class="inputs_form_container">
                <div class="form-floating input_container">
                <input disabled type="tel" class="form-control custom_input" id="telefono" placeholder="Telefono" >
                <label for="telefono">Teléfono</label>
                </div>

                <div class="form-floating input_container">
                 <input disabled type="text" class="form-control custom_input" id="pais"  placeholder="País">
                 <label for="pais">País</label>
                </div>

                <div class="form-floating input_container">
                 <input disabled type="text" class="form-control custom_input" id="estado" placeholder="Estado">
                 <label for="estado">Estado</label>
                </div>

                 <div class="form-floating input_container">
                  <input disabled type="text" class="form-control custom_input" id="ciudad" placeholder="Ciudad">
                  <label for="ciudad">Ciudad</label>
                </div>
                </div>

                <div class="inputs_form_container">
                 <div class="form-floating input_container">
                 <input disabled type="text" class="form-control custom_input" id="direccion" placeholder="Dirección">
                 <label for="direccion">Dirección</label>
                </div>

                <div class="form-floating input_container">
                 <input disabled type="email" class="form-control custom_input" id="correo" onblur="comprobarEmail()" placeholder="Correo electrónico">
                 <label for="email">Correo electrónico </label>
                </div>
                </div>
                <div class="form-group col-md-2">';
                if (empty($_GET['hab_id'])) {
                    echo '<label for="confirmacion">Confirmación</label>
                    <div class="checkbox-container">
                    <input type="radio" name="rdo" id="yes" checked/>
                    <input type="radio" name="rdo" id="no" />
                    <div class="switch">
                        <label for="yes">Si</label>
                        <label for="no">No</label>
                        <span></span>
                    </div>
                    <input type="checkbox" id="confirmacion"  class="form-check" hidden/>
                    </div>';
                }

                echo '
            </div>
               <div class="inputs_form_container">
                <div class="form-floating input_container">
                <label class="col-12" for="forma-garantia">Forma de Garantía</label>
                <select disabled class="form-control custom_input" id="forma-garantia" placeholder="Forma de garantía">
                    ';
                    echo'
                    </select>
                </div>
              
                <!--<div class="form-floating input_container">
                <button disabled type="button" id="btngarantia" class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"/>
                        <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"/>
                    </svg>
                Añadir tarjeta
                </button>
                </div> -->
                </div>
                ';
                if (empty($_GET['hab_id'])) {
                    echo ' <div class="form-group col-md-4">
                    <label class="asterisco" for="persona-reserva">Persona que reserva</label>
                    <input type="text" class="form-control" id="persona-reserva" required>
                    </div>';
                }else{
                    echo ' <div class="form-group col-md-4">
                    </div>';
                }

                echo '
            
            <div class="form-group col-md-6" id="div_voucher" style="display:none">
            <label for="voucher">Voucher</label>
            <input id="voucher" type="text" class="form-control" rows="1"></input>
            </div>

            <div class="form-floating input_container">
            <textarea class="form-control custom_input" id="observaciones" placeholder="Observacion" style="height: 100px"></textarea>
                <label for="observaciones">Observaciones</label>
            </div>
        
            <div class="container_btn">
                <button type="submit" class="btn btn-primary btn-lg btn-block" onclick="event.preventDefault(); guardarUsoCasa('.$_GET['hab_id'].',8)">Enviar</button>
            </div>
        </form>

        <div id="example"></div>
    </div>

';