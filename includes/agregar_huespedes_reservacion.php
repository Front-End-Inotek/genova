<?php date_default_timezone_set('America/Mexico_City');$reservacion= 1;?>


<!-- Modal content-->
<div class="modal-content">
<form onsubmit="event.preventDefault(); guardar_huesped('<?php echo $reservacion; ?>');">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div><br>
        <div class="modal-body">
          <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR HUÉSPED</h2></div>

          <div class="row">
            <div class="col-sm-2 asterisco">Nombre:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input required class="form-control" type="text" id="nombre" placeholder="Ingresa el nombre" maxlength="70">
            </div>
            </div>
            <div class="col-sm-2">Apellido:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="apellido" placeholder="Ingresa el apellido" maxlength="70">
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2 asterisco">Dirección:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input required class="form-control" type="text" id="direccion" placeholder="Ingresa la dirección" maxlength="60">
            </div>
            </div>
            <div class="col-sm-2">Ciudad:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="ciudad" placeholder="Ingresa la ciudad" maxlength="30">
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">Estado:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="estado" placeholder="Ingresa el estado" maxlength="30">
            </div>
            </div>
            <div class="col-sm-2">Código postal:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="codigo_postal" placeholder="Ingresa el código postal" maxlength="20">
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">Teléfono:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="telefono" placeholder="Ingresa el teléfono maxlength="50">
            </div>
            </div>
            <div class="col-sm-2">Correo:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="correo" placeholder="Ingresa el correo" maxlength="200">
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">Contrato Socio:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="contrato" placeholder="Ingresa el contrato del socio" maxlength="40">
            </div>
            </div>
            <div class="col-sm-2">Cupón:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="cupon" placeholder="Ingresa el cupón" maxlength="40">
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">Preferencias del huésped:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="preferencias" placeholder="Ingresa las preferencias">
            </div>
            </div>
            <div class="col-sm-2">Comentarios adicionales:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="comentarios" placeholder="Ingresa los comentarios">
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
              <input class="form-control" type="text" id="titular_tarjeta" placeholder="Ingresa el titular de la tarjeta" maxlength="70">
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
              <input class="form-control" type="text" id="numero_tarjeta" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Ingresa el número de tarjeta" maxlength="16">
            </div>
            </div>
            <div class="col-sm-2">Código Seguridad:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <input class="form-control" type="text" id="cvv" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Ingresa el CVV" maxlength="3">
            </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-2">Fecha de vencimiento:</div>
            <div class="col-sm-4">
            <div class="form-group">
              <select class="form-control" id="vencimiento_mes">
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
            <div class="col-sm-2">Mes/año:</div>
            <div class="col-sm-2">
            <div class="form-group">
              <input class="form-control" type="text" id="vencimiento_ano" onkeypress="return (event.charCode >= 48 && event.charCode <= 57)" placeholder="Año" maxlength="2">
            </div>
            </div>
            <div class="col-sm-2"></div><br>
        </div>

        <div class="modal-footer" id="boton_huesped">
          <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
          <button type="submit" class="btn btn-success" onclick=""><span class="glyphicon glyphicon-edit"></span> Guardar</button>
        </div>
      </form>
      </div>