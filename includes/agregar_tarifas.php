<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  $leyenda= '1 menor de 9 años por habitación, excepto en SUITE, aplican restricciones';
  echo '
        <div class="modal-header">
          <h5 class="modal-title" id="modal_agregar_tarifas"> Agregar tarifas de hospedaje </h5>
          <button type="button" class="btn btn-light" data-dismiss="modal" aria-label="Close">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
              <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
            </svg>
        </button>
        </div>


        <div class="modal-body">

            <div class="inputw_form_container">
                <div class="form-floating input_container">
                  <input type="text" id="nombre" name ="nombre" value="" class="form-control custom_input" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" placeholder="Nombre" >
                  <label for="nombre" > Nombre </label>
                </div>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio </span>
                </div>
                  <input   type="text" maxlength="10"  onkeypress="validarNumero(event)" onkeypress="return event.charCode != 45" min="0"  id="precio_hospedaje" name ="precio_hospedaje" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Cantidad habitación </span>
                </div>
                  <input   type="text" maxlength="2"  onkeypress="validarNumero(event)"  onkeypress="return event.charCode != 45" min="0" id="cantidad_hospedaje" name ="cantidad_hospedaje" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Cantidad máxima </span>
                </div>
                  <input   type="text" maxlength="2"  onkeypress="validarNumero(event)" onkeypress="return event.charCode != 45" min="0" id="cantidad_maxima" name ="cantidad_maxima" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio adulto</span>
                </div>
                  <input  type="text" maxlength="10"  onkeypress="validarNumero(event)" onkeypress="return event.charCode != 45" min="0" id="precio_adulto" name ="precio_adulto" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

           <!--- <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio junior </span>
                </div>
                  <input type="number" id="precio_junior" onkeypress="return event.charCode != 45" min="0" name ="precio_junior" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div> --->

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio infantil </span>
                </div>
                  <input   type="text" maxlength="10"  onkeypress="validarNumero(event)" id="precio_infantil" onkeypress="return event.charCode != 45" min="0" name ="precio_infantil" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 200px; font-size: 16px;">Tipo de habitación</label>
                </div>
            <select class="form-control" id="tipo" name = "tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $tarifa->mostrar_tipo();
              echo '
            </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Leyenda de habitación </span>
                </div>
                  <input type="text" id="leyenda" name ="leyenda" value="'.$leyenda.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <button type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_tarifa()">Guardar</button>
            </div>
            </div>
          ';
?>