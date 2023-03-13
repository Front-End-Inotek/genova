<?php
  date_default_timezone_set('America/Mexico_City');
  $reservacion= 0;
  echo '
    <form id = "formulario_agregarhuesped">
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR HUÉSPED</h2></div>
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
        </div>
      </div>
      </form>';
?>
