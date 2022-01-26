<?php
  date_default_timezone_set('America/Mexico_City');
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">AGREGAR CUPÓN</h2></div>
        <div class="row">
          <div class="col-sm-2">Vigencia Inicio:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="vigencia_inicio" placeholder="Ingresa la vigencia de inicio">
          </div>
          </div>
          <div class="col-sm-2">Vigencia Fin:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="vigencia_fin" placeholder="Ingresa la vigencia de fin">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Código:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="codigo" placeholder="Ingresa el código del cupón" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Descripción:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="descripcion" placeholder="Ingresa la descripción del cupón" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Cantidad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="cantidad" placeholder="Ingresa la cantidad del cupón" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Tipo:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="porcentaje_tipo" name="tipo" value="0" checked>Porcentaje
              </label>
            </div>
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="dinero_tipo" name="tipo" value="1">Dinero
              </label>
            </div>
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-10"></div>
          <div class="col-sm-2">
          <div id="boton_cupon">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_cupon()">
          </div>
          </div>
        </div>
      </div>';
?>
