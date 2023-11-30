<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_huesped.php");
  $huesped= NEW Huesped($_GET['id']);
  $reservacion= 0;
  echo '
<div class="form_container">
  <form class="formulario_contenedor">

    <div class="form_title_container">
      <h2 class="form_title_text">EDITAR HUÉSPED</h2>
      <button class="btn btn-link" onclick="regresar_editar_huesped()"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
          <path d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1"></path>
        </svg>
      </button>

    </div>
        
        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-select custom_input" type="text" id="nombre" value="'.$huesped->nombre.'" maxlength="70" placeholder="Nombre">
            <label for="nombre" >Nombre</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="apellido" value="'.$huesped->apellido.'" maxlength="70" placeholder="Apellido">
            <label for="apellido" >Apellido</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="direccion" value="'.$huesped->direccion.'" maxlength="60" placeholder="Direccion" >
            <label for="direccion" >Dirección</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="ciudad" value="'.$huesped->ciudad.'" maxlength="30" placeholder="Ciudad" >
            <label for="ciudad" >Ciudad</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="estado" value="'.$huesped->estado.'" maxlength="30" placeholder="Estado">
            <label for="estado" >Estado</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="codigo_postal" value="'.$huesped->codigo_postal.'" maxlength="20" placeholder="Código Postal">
            <label for="codigo_posta" >Código postal</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="telefono" value="'.$huesped->telefono.'" maxlength="50" placeholder="Telefono" >
            <label for="telefono" >Teléfono</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="correo" value="'.$huesped->correo.'" maxlength="200" placeholder="Correo">
            <label for="correo" >Correo</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="contrato" value="'.$huesped->contrato.'" maxlength="40" placeholder="Contrato socio" >
            <label for="contrato" >Contrato socio</label>
          </div>
          
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="cupon" value="'.$huesped->cupon.'" maxlength="40" placeholder="Cupon" >
            <label for="cupon" >Cupón</label>
          </div>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="preferencias" value="'.$huesped->preferencias.'" placeholder="Preferencias del huesped" >
            <label for="preferencias" >Preferencias del huésped</label>
          </div>
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="comentarios" value="'.$huesped->comentarios.'" placeholder="Comentarios" >
            <label for="comentarios" >Comentarios</label>
          </div>
        </div>

        <div class="form_title_container">
          <h2 class="form_title_text">DATOS TARJETA:</h2>
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="titular_tarjeta" value="'.$huesped->titular_tarjeta.'" maxlength="70" placeholder="Titular de la tarjeta" >
            <label for="titular_tarjeta">Titular de la tarjeta</label>
          </div>

          <div class="form-floating input_container">
            <select class="form-control custom_input" id="tipo_tarjeta">';
              if($huesped->indole_tarjeta == "Debito"){echo '
                <option value="" disabled selected >Seleccionar una opción</option>
                <option selected value="Debito">Debito</option>
                <option value="Credito">Credito</option>';
              }elseif ($huesped->indole_tarjeta == "") {echo '
                <option value="" disabled selected >Seleccionar una opción</option>
                <option value="Debito">Debito</option>
                <option value="Credito">Credito</option>';
              }elseif ($huesped->indole_tarjeta=="Credito"){ echo '
                <option value="" disabled selected >Seleccionar una opción</option>
                <option  value="Debito">Debito</option>
                <option selected value="Credito">Credito</option>';
              }echo '
            </select>
            <label for="tipo_tarjeta" >Tipo de tarjeta</label>
          </div>
        </div>

        <div class="inputs_form_container">';
        if($huesped->numero_tarjeta==""){
          echo '  
          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" value="'.$huesped->numero_tarjeta.'" maxlength="16" placeholder="Numero de tarjeta" >
            <label for="numero_tarjeta" >Numero de tarjeta</label>
          </div>';
        }else{
          echo ' 
          <div class="form-floating input_container">
            <input disabled class="form-control custom_input" type="text" id="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)"  value="**************" maxlength="16" placeholder="Numero de tarjeta" >
            <label for="numero_tarjeta" >Numero de tarjeta</label>
          </div>
            <input id="check_tarjeta" onchange="mostrar_tarjeta('.$huesped->id.')" class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
          ';
        }

        echo '
        </div>

        <div class="inputs_form_container">
          <div class="form-floating input_container">
            <select class="form-control custom_input" id="vencimiento_mes">';
              if($huesped->vencimiento_mes == "01"){echo '
                <option value="01">'.$huesped->vencimiento_mes.'</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == ""){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "02"){echo '
                <option value="01">01</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "03"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "04"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "05"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "06"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "07"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "08"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "09"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "10"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="11">11</option>
                <option value="12">12</option>';
              }elseif ($huesped->vencimiento_mes == "11"){echo '
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="12">12</option>';
              }else{ echo '
                <option value="12">'.$huesped->vencimiento_mes.'</option>
                <option value="01">01</option>
                <option value="02">02</option>
                <option value="03">03</option>
                <option value="04">04</option>
                <option value="05">05</option>
                <option value="06">06</option>
                <option value="07">07</option>
                <option value="08">08</option>
                <option value="09">09</option>
                <option value="10">10</option>
                <option value="11">11</option>';
              }echo '
            </select>
            <label for="vencimiento_mes" >Mes de vecimiento </label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input " type="text" id="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" value="'.$huesped->vencimiento_ano.'" maxlength="2" placeholder="Año de vencimiento" >
            <label for="vencimiento_ano" >Año de vencimiento</label>
          </div>

          <div class="form-floating input_container">
            <input class="form-control custom_input" type="text" id="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" value="'.$huesped->cvv.'" maxlength="3" placeholder="CVV">
            <label for="cvv" >CVV</label>
          </div>

        </div>
          
          <div id="boton_huesped">
            <button type="submit" class="btn btn-primary btn-block" value="Guardar" onclick="modificar_huesped('.$_GET['id'].',-1,0)">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-floppy" viewBox="0 0 16 16">
                <path d="M11 2H9v3h2z"/>
                <path d="M1.5 0h11.586a1.5 1.5 0 0 1 1.06.44l1.415 1.414A1.5 1.5 0 0 1 16 2.914V14.5a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 14.5v-13A1.5 1.5 0 0 1 1.5 0M1 1.5v13a.5.5 0 0 0 .5.5H2v-4.5A1.5 1.5 0 0 1 3.5 9h9a1.5 1.5 0 0 1 1.5 1.5V15h.5a.5.5 0 0 0 .5-.5V2.914a.5.5 0 0 0-.146-.353l-1.415-1.415A.5.5 0 0 0 13.086 1H13v4.5A1.5 1.5 0 0 1 11.5 7h-7A1.5 1.5 0 0 1 3 5.5V1H1.5a.5.5 0 0 0-.5.5m3 4a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 .5-.5V1H4zM3 15h10v-4.5a.5.5 0 0 0-.5-.5h-9a.5.5 0 0 0-.5.5z"/>
              </svg>
              Guardar
            </button>
          </div>

  </form>
</div>';
?>
