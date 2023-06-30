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
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
       

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Nombre </span>
            </div>
              <input required type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Apellido </span>
            </div>
              <input required type="text" id="apellido" name="apellido" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Dirección </span>
            </div>
              <input type="text" id="direccion" name="direccion" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Ciudad </span>
            </div>
              <input required type="text" id="ciudad" name="ciudad" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Estado </span>
            </div>
              <input type="text" id="estado" name="estado" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Código postal </span>
            </div>
              <input type="text" id="codigo_postal" name="codigo_postal" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Teléfono </span>
            </div>
              <input type="text" id="telefono" name="telefono" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Correo </span>
            </div>
              <input type="text" id="correo" name="correo" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Contrato Socio </span>
            </div>
              <input type="text" id="contrato" name="contrato" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Cupón </span>
            </div>
              <input type="text" id="cupon" name="cupon" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Preferencias huésped </span>
            </div>
              <input type="text" id="preferencias" name="preferencias" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Comentarios </span>
            </div>
              <input type="text" id="comentarios" name="comentarios" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <h4 class="text-dark  margen-1">Datos tarjeta:</h4>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Titular de la tarjeta </span>
            </div>
              <input type="text" id="titular_tarjeta" name="titular_tarjeta" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px; text-align: justify;"> Tipo de tarjeta </span>
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
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Número de la tarjeta </span>
            </div>
              <input type="text" id="numero_tarjeta" name="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" maxlength="16" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px; text-align: justify;"> Fecha de vencimiento </span>
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
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> mes/año </span>
            </div>
              <input type="text" id="vencimiento_ano" name="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" maxlength="2" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px; text-align: justify;"> CCV </span>
            </div>
              <input type="text" id="cvv" name="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" maxlength="3" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
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
