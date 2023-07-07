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
    $clv="Clave check-in";
    $hab_id= $_GET['hab_id'];
    $hab = NEW Hab($hab_id);
    $hab_tipo= $hab->tipo;
    $inputFechaEn="disabled";
    $inputValueFecha=$dia_actual;
    $dia_actual = date("Y-m-d",strtotime($dia_actual . "+ 1 days"));
  }

echo '<style>

.side-navbar{
    transition: transform 300ms linear !important;
    
    
    }

</style>';


  //obtener el ultimo id de reserva.
$ultimo_id = $reservacion->obtener_ultimo_id() /*+ 1*/;
echo '<div class="container-fluid blanco" style="width: 1200px;">
<div class="row justify-content-center ">
    <div class="col-md-9">
        <form onsubmit="event.preventDefault();" id="form-reserva">
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
                }else{
                    echo ' <div class="form-group col-md-4">
                    <label for="clave-reserva" class="text-right">Habitación</label>
                    <input type="text" value="'.$hab->nombre.'" class="form-control"  readonly>
                    </div>';
                }
                echo'
                <div class="form-group col-md-4">
                    <label for="total-estancia">Total de la estancia</label>
                    <input type="number" class="form-control" id="total" min="0" step="0.01" readonly>
                    <input type="number" class="form-control" id="tarifa_base" min="0" step="0.01" readonly hidden>
                </div>
            </div>
            <div class="d-flex justify-content-between">
                <div class="form-group col-md-4 mb-3">
                    <label for="llegada">Llegada</label>
                    <input aria-required="true" required '.$inputFechaEn.' value="'.$inputValueFecha.'" class="form-control" type="date"  id="fecha_entrada" name="fecha_entrada" min='.$dia_actual.' placeholder="Ingresa la fecha de entrada" onchange="calcular_noches('.$hab_id.')"/>
                    <span> </span>
                </div>
                <div class="form-group col-md-4">
                    <label for="salida">Salida</label>
                    <input required class="form-control" type="date"  id="fecha_salida" name="fecha_salida" min='.$dia_actual.' placeholder="Ingresa la fecha de salida" onchange="calcular_noches('.$hab_id.');" />
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
                    <option value="">Selecciona</option>';
                    $tarifa->mostrar_tarifas($hab_tipo);
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
               
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                
            </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="adultos">Adultos</label>
                    <input type="number" class="form-control" id="extra_adulto" min="0"   onchange="editarTotalEstancia()">
                    <input type="number" id="tarifa_adultos" hidden>
                </div>
                <div class="form-group col-md-4">
                    <label for="menores">Menores</label>
                    <input type="number" class="form-control" id="extra_infantil" min="0"  onchange="editarTotalEstancia()">
                    <input type="number" id="tarifa_menores" hidden>
                </div>
             
                
            </div>
            <div class="d-flex justify-content-between">
            <div class="form-group col-md-4">
                    <label for="no-habitaciones">Número de habitaciones</label>
                    <input type="number" class="form-control" id="numero_hab" min="1" value="1" required  onchange="editarTotalEstancia()">
                </div>
                <div class="form-group col-md-4">
                    <label for="pax-extra">Pax extra</label>
                    <input type="number" class="form-control" id="pax-extra" min="0"   onchange="editarTotalEstancia()">
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="plan-alimentos">Plan de alimentos</label>
                    <select class="form-control" id="plan-alimentos"  onchange="editarTotalEstancia(event)">
                    <option value="">Seleccione una opción</option>';
                    $config->mostrar_planes_select();
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
                    <label for="canal-reserva">Canal de reserva</label>
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
            <br>
            <h2>Datos Personales</h2>
            <button type="button" class="btn btn-success btn-block mb-2"  onclick="event.preventDefault(); asignar_huespedNew(0,0,0,0,0)" href="#caja_herramientas" data-toggle="modal"> Buscar Huésped</button>
            <input type="text" id="tomahuespedantes" hidden>
            <input type="text" id="estadotarjeta" hidden>
            <input type="text" id="nut" hidden>
            <input type="text" id="nt" hidden>
            <input type="text" id="mes" hidden>
            <input type="text" id="year" hidden>
            <input type="text" id="ccv" hidden>
            <input type="text" id="nombre_tarjeta" hidden>
          
            <input type="text" id="estadocredito" hidden>
            <input type="text" id="limitecredito" hidden>
           
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
                    <input type="email" class="form-control" id="correo" onblur="comprobarEmail()">
                </div>
                <div class="form-group col-md-2">';
                if (empty($_GET['hab_id'])) {
                    echo '<label for="confirmacion">Confirmación</label>
                    <div class="checkbox-container">
                    <input class="yesornot" type="radio" name="rdo" id="yes" checked/>
                    <input class="yesornot" type="radio" name="rdo" id="no" />
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
            </div>
            <div class="d-flex justify-content-between">
                
                <div class="form-group col-md-4">
                    <label for="forma-garantia">Forma de Garantía</label>
                    <select class="form-control" id="forma-garantia" required">
                    <option value="">Seleccione una opción </option>
                    ';
                
                    $forma_pago->mostrar_forma_pago(0);
                    echo'
                    </select>
                </div>
              
                <div class="form-group col-md-4">
                <label for="forma-garantia">Forma de Garantía</label>
                <button type="button" id="btngarantia" class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">Añadir tarjeta</button>
                </div>';

                if (empty($_GET['hab_id'])) {
                    echo ' <div class="form-group col-md-4">
                    <label for="persona-reserva">Persona que reserva</label>
                    <input type="text" class="form-control" id="persona-reserva" required>
                    </div>';
                }else{
                    echo ' <div class="form-group col-md-4">
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
                <textarea class="form-control" id="observaciones" rows="3"></textarea>
            </div>
            <br>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary" onclick="event.preventDefault(); guardarNuevaReservacion('.$_GET['hab_id'].')">Enviar</button>
            </div>
        </form>

        <div id="example"></div>
    </div>
</div>
</div>
';