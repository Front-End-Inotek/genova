<?php
  date_default_timezone_set('America/Mexico_City');
  $reservacion= 0;
  echo '
  <!-- Modal -->
      <div class="modal-content" >
      <form id="form-huesped">
        <div class="modal-header">
        <h4 class="modal-title" id="exampleModalLabel">Agregra huesped </h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            &times;
        </button>
        </div>
        <div class="modal-body">

        <div class="row flex-wrap">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Nombre </span>
            </div>
            <input required type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default"  >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3 ">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Apellido </span>
            </div>
            <input required type="text" id="apellido" name="apellido" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Dirección </span>
            </div>
            <input type="text" id="direccion" name="direccion" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default">
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Ciudad </span>
            </div>
            <input required type="text" id="ciudad" name="ciudad" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Estado </span>
            </div>
            <input type="text" id="estado" name="estado" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Código postal </span>
            </div>
            <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Teléfono </span>
            </div>
            <input type="text" id="telefono" name="telefono" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default"  >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Correo </span>
            </div>
            <input type="text" id="correo" name="correo" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Contrato Socio </span>
            </div>
            <input type="text" id="contrato" name="contrato" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default"  >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Cupón </span>
            </div>
            <input type="text" id="cupon" name="cupon" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Preferencias huésped </span>
            </div>
            <input type="text" id="preferencias" name="preferencias" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Comentarios </span>
            </div>
            <input type="text" id="comentarios" name="comentarios" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>
        </div>

        <h4 class="text-dark  margen-1">Datos tarjeta:</h4>

        <div class="row">
        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Titular de la tarjeta </span>
            </div>
            <input type="text" id="titular_tarjeta" name="titular_tarjeta" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  > Tipo de tarjeta </span>
            </div>
            <select class="form-control" id="tipo_tarjeta" name="tipo_tarjeta">
                <option value="0">Selecciona</option>
                <option value="Debito">Debito</option>
                <option value="Credito">Credito</option>
            </select>
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-sm-6 row flex-wrap">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Número de la tarjeta </span>
            </div>
            <input type="text" id="numero_tarjeta" name="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" maxlength="16" >
        </div>
        </div>

        <div class="col-12 col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > Fecha de vencimiento </span>
            </div>
            <select id="vencimiento_mes" name="vencimiento_mes" class="form-control">
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
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-12 col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > mes/año </span>
            </div>
            <input type="text" id="vencimiento_ano" name="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" maxlength="2" >
        </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default" > CCV </span>
            </div>
            <input type="text" id="cvv" name="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="3" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
        </div>
        </div>

        <div class="col-12 col-sm-6">
            <div class="form-check mb-3">
                <input class="form-check-input" type="radio"  id="c_abierto" name="creditoabiertoocerrado">
                <label class="form-check-label" for="c_abierto">Crédito abierto</label>
                <input class="form-check-input" type="radio"  id="c_cerrado" name="creditoabiertoocerrado">
                <label class="form-check-label" for="c_cerrado">Crédito cerrado</label>
            </div>
        </div>

        <div class="col-12 col-sm-6">
        <div class="input-group mb-3">
        <div class="input-group-prepend">
        <span class="input-group-text" id="inputGroup-sizing-default" > Límite de crédito </span>
    </div>
        <input type="number" id="limite_credito" name="limite_credito"  class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" >
    </div>
    </div>


        </div>

        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
        <div id="boton_tipo">
        <input type="button" class="btn btn-success btn-block" value="Guardar" onclick="guardar_huesped('.$reservacion.')">
        </div>
        </div>
        </form>
    </div>';
?>
