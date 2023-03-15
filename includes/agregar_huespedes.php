<?php
  date_default_timezone_set('America/Mexico_City');
  $reservacion= 0;
  echo '
  <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregra tipo de habitacion </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body">

        <div class="row">
          <div class="col-sm-2">Nombre:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="nombre" name="nombre" placeholder="Ingresa el nombre del huésped" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Apellido:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="apellido" name="apellido" placeholder="Ingresa el apellido del huésped" maxlength="70">
          </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">Dirección:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="direccion" name="direccion" placeholder="Ingresa la dirección del huésped" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Ciudad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="ciudad" name="ciudad" placeholder="Ingresa la ciudad del huésped" maxlength="30">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Estado:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="estado" name="estado" placeholder="Ingresa el estado del huésped" maxlength="30">
          </div>
          </div>
          <div class="col-sm-2">Código postal:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="codigo_postal" name="codigo_postal" placeholder="Ingresa el código postal del huésped" maxlength="20">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Teléfono:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="telefono" name="telefono" placeholder="Ingresa el teléfono del huésped" maxlength="50">
          </div>
          </div>
          <div class="col-sm-2">Correo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="correo" name="correo" placeholder="Ingresa el correo del huésped" maxlength="200">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Contrato Socio:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="contrato" name="contrato" placeholder="Ingresa el contrato del socio del huésped" maxlength="40">
          </div>
          </div>
          <div class="col-sm-2">Cupón:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="cupon" name="cupon" placeholder="Ingresa el cupón del huésped" maxlength="40">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Preferencias del huésped:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="preferencias" name="preferencias" placeholder="Ingresa las preferencias del huésped">
          </div>
          </div>
          <div class="col-sm-2">Comentarios adicionales:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="comentarios" name="comentarios" placeholder="Ingresa los comentarios adicionales">
          </div>
          </div>
        </div><br>
        <div class="row">
          <div class="col-sm-6"><h4 class="text-dark  margen-1">DATOS TARJETA:</h4></div>
          <div class="col-sm-6"></div>
        </div>
        <div class="row">
          <div class="col-sm-2">Titular de la tarjeta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="titular_tarjeta" name="titular_tarjeta" placeholder="Ingresa el titular de la tarjeta del huésped" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Tipo de la tarjeta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <select class="form-control" id="tipo_tarjeta">
              <option value="0">Selecciona</option>
              <option value="Debito">Debito</option>
              <option value="Credito">Credito</option>
            </select>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Número de la tarjeta:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="numero_tarjeta" name="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Ingresa el número de la tarjeta del huésped" maxlength="16">
          </div>
          </div>
          <div class="col-sm-2">Fecha de vencimiento:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <select class="form-control" id="vencimiento_mes" name="vencimiento_mes">
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
          <div class="col-sm-1">
          <div class="form-group">
            <input class="form-control" type="text" id="vencimiento_ano" name="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="año" maxlength="2">
          </div>
          </div>
          <div class="col-sm-1">mes/año</div>
        </div>
        <div class="row">
          <div class="col-sm-2">Código Seguridad:</div>
          <div class="col-sm-2">
          <div class="form-group">
            <input class="form-control" type="text" id="cvv" name="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Ingresa el CVV" maxlength="3">
          </div>
          </div>
          <div class="col-sm-6"></div>
          <div class="col-sm-2">
          <div id="boton_huesped">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_huesped('.$reservacion.')">
          </div>
          </div>

          <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
          <input type="button" class="btn btn-success btn-block" value="Guardar" onclick="guardar_huesped('.$reservacion.')">
        </div>
        </div>';
?>
<?php
  date_default_timezone_set('America/Mexico_City');
  $reservacion= 0;
  echo '
  <!-- Modal -->
      <div class="modal-content">
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
              <input type="text" id="nombre" name ="nombre" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>

        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Apellido </span>
            </div>
              <input type="text" id="apellido" name="apellido" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
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
              <input type="text" id="ciudad" name="ciudad" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
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
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Tipo de la tarjeta </span>
            </div>
              <input type="text" id="tipo_tarjeta" name="tipo_tarjeta" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
        </div>
        </div>
        </div>

        <div class="row">
        <div class="col-6">
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 130px; font-size: 12px;"> Número de la tarjeta </span>
            </div>
              <input type="text" id="numero_tarjeta" name="numero_tarjeta" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
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
              <input type="text" id="vencimiento_ano" name="vencimiento_ano" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 14px;" >
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
      </div>';
?>
