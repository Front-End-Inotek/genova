<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cupon.php");
  $cupon= NEW Cupon($_GET['id']);
  echo '
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1">EDITAR CUPÓN</h2></div>
        <div class="row">
          <div class="col-sm-2">Vigencia Inicio:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="vigencia_inicio" value="'.date("Y-m-d",$cupon->vigencia_inicio).'">
          </div>
          </div>
          <div class="col-sm-2">Vigencia Fin:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="date"  id="vigencia_fin" value="'.date("Y-m-d",$cupon->vigencia_fin).'">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Código:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="codigo" value="'.$cupon->codigo.'" maxlength="70">
          </div>
          </div>
          <div class="col-sm-2">Descripción:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="text" id="descripcion" value="'.$cupon->descripcion.'" maxlength="70">
          </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-2">Cantidad:</div>
          <div class="col-sm-4">
          <div class="form-group">
            <input class="form-control" type="number" id="cantidad" value="'.$cupon->cantidad.'" maxlength="60">
          </div>
          </div>
          <div class="col-sm-2">Tipo:</div>
          <div class="col-sm-4">
          <div class="form-group">';
          if($cupon->tipo==0){
            echo '<div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="dinero_tipo" name="tipo" value="1">Dinero
              </label>
            </div>
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="porcentaje_tipo" name="tipo" value="0" checked>Porcentaje
              </label>
            </div>';
          }else{
            echo '<div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="dinero_tipo" name="tipo" value="1" checked>Dinero
              </label>
            </div>
            <div class="form-check-inline">
              <label class="form-check-label">
                <input type="radio" class="form-check-input" id="porcentaje_tipo" name="tipo" value="0">Porcentaje
              </label>
            </div>';
          }
          echo '</div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-9"></div>
          <div class="col-sm-2">
          <div id="boton_cupon">
            <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_cupon('.$_GET['id'].',0,0)">
          </div>
          </div>
          <div class="col-sm-1"><button class="btn btn-info btn-block" onclick="regresar_editar_cupon()"> ←</button></div>
        </div>  
      </div>';
?>
