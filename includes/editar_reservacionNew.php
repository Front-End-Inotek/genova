<?php
  error_reporting(1);
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  include_once("clase_planes_alimentos.php");
  include_once("clase_forma_pago.php");
  include_once("clase_huesped.php");


  $reservacion = new Reservacion($_GET['id']);

  if($reservacion->forzar_tarifa==0 && $reservacion->tarifa!=0){
    $tarifa= NEW Tarifa($reservacion->tarifa);
  }else{
    $tarifa= NEW Tarifa(0);
  }

  $huesped = new Huesped($reservacion->id_huesped);
//   if($reservacion->tarifa!=0){
//     $tarifa= NEW Tarifa($reservacion->tarifa);
//   }


  $forzar_tarifa = $reservacion->forzar_tarifa == 0 ? "" : $reservacion->forzar_tarifa;
  $estado_reserva = $reservacion->estado;
  $id_cuenta = $reservacion->id_cuenta;
$tipo_hab=0;

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
    $tipo_hab = $reservacion->tipo_hab;
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

if($reservacion->plan_alimentos!=0 && $reservacion->plan_alimentos!=null){
    $planes_alimentos = new PlanesAlimentos($reservacion->plan_alimentos);
}else{
    $planes_alimentos = new PlanesAlimentos(0);
}
$preasignada=0;

if($reservacion->estado==1){
    include_once('clase_movimiento.php');
    $datos_mov = $reservacion->saber_id_movimiento($reservacion->id);
    if($datos_mov!=null && $datos_mov['motivo'] == "preasignar" && $datos_mov['id_hab']!=0){
        $preasignada=$datos_mov['id_hab'];
    }
}

$resultado = $reservacion->comprobarFechaReserva(date('Y-m-d',$reservacion->fecha_entrada),date('Y-m-d',$reservacion->fecha_salida),$hab_id,$preasignada,$tipo_hab);

$ruta_regreso="";
if(isset($_GET['ruta_regreso'])){
    $ruta_regreso=$_GET['ruta_regreso'];
}else{
    $ruta_regreso="ver_reservaciones()";
}

$canales_reserva = array("telefono"=>"Telefono","email"=>"Email","web"=>"Web","agencia"=>"Agencia de viajes");

echo '
<div class="form_container">
        <form onsubmit="" id="form-reserva" class="formulario_contenedor">
            <div class="div_adultos"></div>

            <div class="form_title_container">
                <h2 class="form_title_text">'.$titulo_.'</h2> <br>
                <div class="col-sm-1"><button class="btn btn-link" onclick="'.$ruta_regreso.'"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"></path>
                    </svg>
                </button>
            </div>

            </div>


                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input type="text" value="'.$ultimo_id.'" class="form-control custom_input" id="clave-reserva" readonly placeholder="Clave de reserva">
                        <label for="clave-reserva" class="text-right">'.$clv.'</label>
                    </div>

                    ';
                    if (empty($_GET['hab_id'])) {
                        echo '
                         <div class="form-floating input_container">
                            <select class="form-select custom_input" id="tipo-reservacion">
                                <option value="individual">Individual</option>
                                <option value="grupo">Grupo</option>
                                <option value="evento">Evento</option>
                            </select>
                            <label for="tipo-reservacion" >Tipo de reservación</label>
                        </div>';
                    }
                    echo'
                    <div class="form-floating input_container">
                        <input type="number" class="form-control custom_input" id="total" min="0" step="0.01" value='.$reservacion->total.' readonly>
                        <input type="number" class="form-control custom_input" id="tarifa_base" min="0"  value="'.$tarifa->precio_hospedaje.'" step="0.01" readonly hidden>
                        <label for="total">Total de la estancia</label>
                    </div>
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input required '.$inputFechaEn.' value="'.date("Y-m-d",$reservacion->fecha_entrada).'" class="form-control custom_input" type="date"  id="fecha_entrada"  placeholder="Ingresa la fecha de entrada" onchange="calcular_noches('.$hab_id.','.$preasignada.')">
                        <label class="asterisco" for="llegada">Llegada</label>
                    </div>
                    <div class="form-floating input_container">
                        <input required class="form-control custom_input" type="date"  id="fecha_salida" min='.$dia_actual.' value="'.date("Y-m-d",$reservacion->fecha_salida).'" placeholder="Ingresa la fecha de salida" onchange="calcular_noches('.$hab_id.','.$preasignada.');">
                        <label class="asterisco" for="salida">Salida</label>
                    </div>
                    <div class="form-floating input_container">
                        <input class="form-control custom_input" type="number" value="'.$reservacion->noches.'"  id="noches" placeholder="0" onchange="cambiar_adultosNew("",'.$hab_id.');" disabled/>
                        <label for="noches">Noches</label>
                    </div>
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <select '.$require_tarifa.' class="form-control custom_input" id="tarifa" onchange="cambiar_adultosNew(event,'.$hab_id.')">
                            <option value="">Selecciona</option>';
                            $tarifa->mostrar_tarifas_editar($reservacion->tarifa);
                            echo '
                        </select>
                        <label for="tarifa">Tarifa por noche</label>
                        <input type="text" id="tarifa_base" value="'.$tarifa->precio_hospedaje.'" hidden>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" maxlength="10"   onkeypress="validarNumero(event)" class="form-control custom_input" value="'.$forzar_tarifa.'" id="forzar-tarifa" min="0" step="0.01" onchange="cambiar_adultosNew(0,'.$hab_id.')">
                        <label for="tipo-habitacion">Forzar tarifa</label>
                    </div>

                    <div class="form-floating input_container">
                        <select class="form-control custom_input" id="tipo-habitacion" disabled>
                            ';
                            $hab->mostrar_hab_editarTarifa($reservacion->tarifa);
                            echo '
                        </select>
                        <label for="tipo-habitacion">Tipo de habitación</label>
                    </div>
                        <!---
                        <div class="form-group col-md-3">
                            <label class="asterisco" for="no-habitaciones">No. de habitaciones</label>
                            <input type="text" maxlength="2"  onkeypress="validarNumero(event)" class="form-control" id="numero_hab" min="1"  value="'.$reservacion->numero_hab.'" required  onchange="cambiar_adultosNew("",'.$hab_id.')">
                        </div>
                        -->
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input type="number" class="form-control custom_input" id="precio_hospedaje" min="0" disabled value="'.$reservacion->precio_hospedaje.'">
                        <label for="adultos">Precio noche</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" maxlength="2"   onkeypress="validarNumero(event)" class="form-control custom_input" id="extra_adulto" min="0"  value="'.$reservacion->adultos.'"  onchange="editarTotalEstancia(); mostrarAcordeonCompleto('.$reservacion->adultos.')"">
                        <input type="number" id="tarifa_adultos" value="'.$tarifa->precio_adulto.'" hidden>
                        <input type="number" id="cantidad_hospedaje" value="'.$tarifa->cantidad_hospedaje.'" hidden>
                        <input type="number" id="cantidad_maxima" value="'.$tarifa->cantidad_maxima.'" hidden >
                        <label for="adultos">Adultos</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" maxlength="10"   onkeypress="validarNumero(event)" class="form-control custom_input" id="extra_infantil" min="0"  value="'.$reservacion->infantiles.'" onchange="editarTotalEstancia()">
                        <input type="number" id="tarifa_menores" value="'.$tarifa->precio_infantil.'" hidden>
                        <label for="menores">Menores</label>
                    </div>
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input type="number" class="form-control custom_input" id="numero_hab" min="1" value="'.$reservacion->numero_hab.'" required onchange="editarTotalEstancia()">
                        <label type="text" maxlength="2"   onkeypress="validarNumero(event)" class="asterisco" for="no-habitaciones">Número de habitaciones</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" maxlength="10"   onkeypress="validarNumero(event)" class="form-control custom_input" id="pax-extra" min="0" value="'.$reservacion->pax_extra.'"  onchange="editarTotalEstancia()">
                        <label for="pax-extra">Pax extra</label>
                    </div>

                    <div class="form-floating input_container">
                    <select class="form-control custom_input" id="plan-alimentos"  onchange="editarTotalEstancia(event)">
                        <option value="">Seleccione una opción</option>';
                        $planes_alimentos->mostrar_planes_select($reservacion->plan_alimentos);
                        echo'
                        </select>
                        <input type="number" id="costoplan" hidden value="'.$planes_alimentos->costo.'">
                        <label for="plan-alimentos">Plan de alimentos</label>
                    </div>
                </div>
                ';
                if (empty($_GET['hab_id'])) {
                    echo'
                    <div class="inputs_form_container">
                        <div class="form-floating input_container">
                            <select  class="form-control custom_input" id="preasignada">';
                            echo $resultado[1];
                            echo '
                            </select>
                            <label for="hab-preasignada">Habitación preasignada</label>
                        </div>

                        <div class="form-floating input_container">
                                <select class="form-control custom_input" id="canal-reserva" required>
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
                                <label class="asterisco" for="canal-reserva">Canal de reserva</label>
                        </div>

                        <div class="form-check form-switch input_container">
                            <input class="form-check-input"  id="sobrevender" type="checkbox" role="switch" onchange="sobreVenderHab(event)"  id="" />
                            <label class="form-check-label" for="sobrevender">Sobrevender</label>
                        </div>


                    </div>
                ';
                }
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

                <input type="text" id="tomahuespedantes"  hidden value="'.$huesped->id.'">
                <input type="text" id="estadotarjeta" hidden value="'.$huesped->estado_tarjeta.'">
                <input type="text" id="nut"  hidden value="**************">
                <input type="text" id="nt"  hidden value="'.$huesped->titular_tarjeta.'">
                <input type="text" id="mes" hidden value="'.$huesped->vencimiento_mes.'">
                <input type="text" id="year" hidden value="'.$huesped->vencimiento_ano.'">
                <input type="text" id="ccv" hidden value="'.$huesped->cvv.'">
                <input type="text" id="nombre_tarjeta" hidden value="'.$huesped->nombre_tarjeta.'">
                <input type="text" id="estadocredito" value="'.$huesped->estado_credito.'" hidden>
                <input type="text" id="limitecredito" value="'.$huesped->limite_credito.'" hidden>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="nombre" value="'.$huesped->nombre.'" required placeholder="Nombre">
                        <input type="text" class="d-none" id="leer_nombre_sin_editar" value="'.$huesped->nombre.'"readonly/>
                        <label class="asterisco" for="nombre">Nombre</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="apellido"  value="'.$huesped->apellido.'"required placeholder="Apellido">
                        <label class="asterisco" for="apellido">Apellido</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="empresa" value="'.$huesped->empresa.'" placeholder="Empresa / Agencia">
                        <label for="empresa">Empresa / Agencia</label>
                    </div>
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input type="tel" class="form-control custom_input" id="telefono" required value="'.$huesped->telefono.'" placeholder="Telefono">
                        <label class="asterisco" for="telefono">Teléfono</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="pais" value="'.$huesped->pais.'" placeholder="Pais">
                        <label for="pais">País</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="estado" value="'.$huesped->estado.'" placeholder="Estado">
                        <label for="estado">Estado</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="ciudad" required value="'.$huesped->ciudad.'" placeholder="Ciudad">
                        <label class="asterisco" for="ciudad">Ciudad</label>
                    </div>
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="direccion" value="'.$huesped->direccion.'" placeholder="Direccion">
                        <label for="direccion">Dirección</label>
                    </div>

                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="correo" value="'.$huesped->correo.'" placeholder="Correo electronico">
                        <label for="email">Correo electrónico </label>
                    </div>

                    <div class="form-check form-switch input_container">
                        <input class="form-check-input" type="checkbox" role="switch" id="confirmacion" id="confirmacion" >
                        <label class="form-check-label" for="confirmacion">Confirmación</label>
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
                        </div>
                        -->
                    </div>
                </div>

                <div class="d-flex justify-content-between flex-wrap">
                <div class="accordionCustom accordionCustomMostrar" id="acordeonchido">
                    <div class="accordion-itemCustom">
                        <div id="acordeonIcon" onclick="mostrarAcorderon()" class="accordionItemHeaderCustom">
                            <label>Acompañantes</label>
                        </div>';
                        $consulta =  $reservacion->obtener_acompa($reservacion->id);
                        $i=1;
                        echo '<div id="acordeon" class="accordionItemBodyCustom acordeon">';
                        while ($fila = mysqli_fetch_array($consulta)){
                            echo '
                            <div class="accordionItemBodyContentCustom">
                            <label style="width: 100%;text-align: left;">Acompañante '.$i.'</label>
                            <div >
                                <label for="acompañante '.$i.' nombre" class="form-label asterisco" style="width: 90%;text-align: left; margin-left: 1rem;">Nombre</label>
                                <input value="'.$fila['nombre'].'"  type="text" class="form-control nombreExtra" id="acompañante '.$i.' nombre" minlength="5" maxlength="15" required>
                            </div>
                            <div class="mb-3">
                                <label for="acompañante '.$i.' apellido" class="form-label asterisco" style="width: 90%;text-align: left; margin-left: 1rem;">Apellido</label>
                                <input  value="'.$fila['apellido'].'" type="text" class="form-control apellidoExtra" id="acompañante '.$i.' apellido" minlength="5" maxlength="15" required>
                            </div>
                        </div>
                            ';
                            $i++;
                        }
                    echo '</div>
                    </div>
                </div>
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container">
                        <select class="form-control custom_input" id="forma-garantia" required onchange="obtener_garantia(event)">
                        <option value="">Seleccione una opción </option>';
                        $forma_pago->mostrar_forma_pago($huesped->tipo_tarjeta);echo'
                        </select>
                        <label class="asterisco col-12" for="forma-garantia">Forma de Garantía</label>
                    </div>
                    ';
                    if (empty($_GET['hab_id'])) {
                    echo ' 
                    <div class="form-floating input_container">
                        <input type="text" class="form-control custom_input" id="persona-reserva" required value="'.$reservacion->nombre_reserva.'">
                        <label class="asterisco" for="persona-reserva">Persona que reserva</label>
                    </div>';
                    }
                    echo '
                    <!--
                    <div class="form-floating input_container">
                        
                        <button id="btngarantia"  class="btn btn-primary btn-block boton_datos"  onclick="event.preventDefault(); mostrar_modal_garantia()" href="#caja_herramientas" data-toggle="modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card" viewBox="0 0 16 16">
                            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v1h14V4a1 1 0 0 0-1-1H2zm13 4H1v5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V7z"></path>
                            <path d="M2 10a1 1 0 0 1 1-1h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1z"></path>
                        </svg>
                        Añadir tarjeta
                        </button>
                    </div>
                    -->
                </div>

                <div class="inputs_form_container">
                    <div class="form-floating input_container" >
                        <input disabled id="voucher" type="text" class="form-control custom_input" rows="1" placeholder="Voucher" ></input>
                        <label for="voucher">Voucher</label>
                    </div>

                    <div class="form-floating input_container" >
                        <input  type="text" maxlength="10"   onkeypress="validarNumero(event)" class="form-control custom_input" id="garantia_monto" value="'.$reservacion->total_pago.'" placeholder="Monto garantía" >
                        <label for="garantia_monto">Monto garantía</label>
                    </div>
                </div>

                <div class="form-floating input_container">
                    <textarea class="form-control custom_input" id="observaciones" rows="3" placeholder="Observaciones" >'.$huesped->comentarios.'</textarea>
                    <label for="observaciones">Observaciones</label>
                </div>
                <br>
                <div class="d-flex justify-content-end">
                    <button type="submit" id="btn_reservacion" class="btn btn-primary" onclick="event.preventDefault(); guardarNuevaReservacion('.$hab_id.','.$id_cuenta.','.$reservacion->id.')">Actualizar</button>
                </div>
        </form>
        <div id="example"></div>
</div>
';