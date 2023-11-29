<?php
  date_default_timezone_set('America/Mexico_City');
  $reservacion= 0;
  echo '
  <!-- Modal -->
      <div class="modal-content" >
      <form id="form-huesped">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Agregar huesped </h5>
        <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
           </svg>
        </button>
        </div>
        <div class="modal-body">
          <div class="inputs_form_container">
            <div class="form-floating input_container">
            <input type="text" id="nombre" name ="nombre" class="form-control custom_input" aria-label="Default" placeholder="Nombre" >
            <label class="asterisco" for="nombre" id="inputGroup-sizing-default"> Nombre </label>
            </div>
            
            <div class="form-floating input_container"> 
            <input required type="text" id="apellido" name="apellido" class="form-control custom_input" placeholder="Apellido" >
                <label class="asterisco" for="apellido" id="inputGroup-sizing-default" > Apellido </label>
          </div>
           </div>

           <div class="inputs_form_container">
             <div class="form-floating input_container">
             <input type="text" id="direccion" name="direccion" class="form-control custom_input" placeholder="Dirección">
                <label for="direccion" id="inputGroup-sizing-default"  > Dirección </label>
            </div>


             <div class="form-floating input_container">
              <input type="text" id="ciudad" name="ciudad" class="form-control custom_input" placeholder="Ciudad" >
              <label class="asterisco" for="ciudad" id="inputGroup-sizing-default" > Ciudad </label>
            </div>
            </div>

              <div class="inputs_form_container">
               <div class="form-floating input_container">
               <input type="text" id="estado" name="estado" class="form-control custom_input" placeholder="Estado">
                <label for="estado" id="inputGroup-sizing-default"> Estado </label>
              </div>

              <div class="form-floating input_container">
               <input type="text" id="codigo_postal" name="codigo_postal" class="form-control custom_input" placeholder="Código postal" >
                <label for="codigo_postal" id="inputGroup-sizing-default" > Código postal </label>
            </div>
           </div>

              <div class="inputs_form_container">
               <div class="form-floating input_container">
                <input type="text" id="telefono" name="telefono" class="form-control custom_input" placeholder="Teléfono" >
                <label for="telefono" id="inputGroup-sizing-default"> Teléfono </label>
             </div>
                 <div class="form-floating input_container">
                 <input type="text" id="correo" name="correo" class="form-control custom_input" placeholder="Correo" >
                <label for="correo" id="inputGroup-sizing-default"  > Correo </label>
             </div>
            </div>
              <div class="inputs_form_container">
                <div class="form-floating input_container">
                <input type="text" id="contrato" name="contrato" class="form-control custom_input" placeholder="Contrato socio">
                <label for="contrato" id="inputGroup-sizing-default" > Contrato Socio </label>
            </div>

               <div class="form-floating input_container">
               <input type="text" id="cupon" name="cupon" class="form-control custom_input" placeholder="Cupón">
                <label for="cupon" id="inputGroup-sizing-default"  > Cupón </label>
            </div>
            </div>

               <div class="inputs_form_container">
               <div class="form-floating input_container">
               <input type="text" id="preferencias" name="preferencias" class="form-control custom_input" placeholder="preferencias">
                <label for="preferencias" id="inputGroup-sizing-default"> Preferencias huésped </label>
            </div>

                <div class="form-floating input_container">
                <input type="text" id="comentarios" name="comentarios" class="form-control custom_input" placeholder="Comentarios">
                <label for="comentarios" id="inputGroup-sizing-default" > Comentarios </label>
               </div>
           </div>
 
        <h5 class="text-dark  margen-1">Datos tarjeta</h5>

             <div class="inputs_form_container">
               <div class="form-floating input_container">
               <input type="text" id="titular_tarjeta" name="titular_tarjeta" class="form-control custom_input" placeholder="Titular de la tarjeta" >
                <label for="titular_tarjeta" id="inputGroup-sizing-default" > Titular de la tarjeta </label>
              </div>
              </div>
              <div class="inputs_form_container">
              <div class="form-floating input_container">
              <input type="text" id="numero_tarjeta" name="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control custom_input" placeholder="Número de tarjeta">
              <label for="numero_tarjeta" id="inputGroup-sizing-default" > Número de la tarjeta </label>
              </div>
              </div>
              
              <div class="inputs_form_container">
              <div class="form-floating input_container">
              <select id="vencimiento_mes" name="vencimiento_mes" class="form-control custom_input" placeholder="Fecha de vencimiento">
              <option value="0">Selecciona mes</option>
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
              <option value="12">12</option>
              </select>
              <label for="vencimiento_mes" id="inputGroup-sizing-default" > Fecha de vencimiento </label>
              </div>
              
              <div class="form-floating input_container">
              <input type="text" id="vencimiento_ano" name="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control custom_input" placeholder="mes/año" >
              <label for="Mes/año" id="inputGroup-sizing-default" > Año </label>
              </div>
              
              
              <div class="form-floating input_container">
              <input type="text" id="cvv" name="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="3" class="form-control custom_input"placeholder="CVV" >
              <label for="cvv" id="inputGroup-sizing-default" > CCV </label>
              </div>
              </div>
                 
              <div class="inputs_form_container">
              <div class="form-floating input_container">
              <input type="number" id="limite_credito" name="limite_credito"  class="form-control custom_input" placeholder="Limite de crédito">
              <label for="limite_credito" id="inputGroup-sizing-default" > Límite de crédito </label>
              </div>
             
              <div class="form-floating input_container">
              <select class="form-control custom_input" id="tipo_tarjeta" name="tipo_tarjeta">
                  <option value="0">Selecciona</option>
                  <option value="Debito">Debito</option>
                  <option value="Credito">Credito</option>
              </select>
               <label for="tipo_tarjeta" id="inputGroup-sizing-default" > Tipo de tarjeta </label>
              </div>
              </div>
              <div class="col-12 col-sm-6">
              <div class="form-check mb-3">
              <input class="form-check-input" type="radio"  id="c_abierto" name="creditoabiertoocerrado">
              <label class="form-check-label" for="c_abierto">Crédito abierto</label>
                 </br>
                 <input class="form-check-input" type="radio"  id="c_cerrado" name="creditoabiertoocerrado">
                 <label class="form-check-label" for="c_cerrado">Crédito cerrado</label>
                 </div>
                 </div>
                 
                 </div>
                 <div class="modal-footer">
                 <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                 <div id="boton_tipo">
                 <input type="button" class="btn btn-primary btn-block" value="Guardar" onclick="guardar_huesped('.$reservacion.')">
                 </div>
                 </div>
                 </form>
                 </div>';
                 ?>

