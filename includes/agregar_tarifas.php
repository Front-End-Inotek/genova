<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  $leyenda= '1 menor de 9 años por habitación, excepto en SUITE, aplican restricciones';
  echo '
  <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregra tarifa hospedaje </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Nombre </span>
            </div>
              <input type="text" id="nombre" name ="nombre" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Precio hospedaje </span>
            </div>
              <input type="number" id="precio_hospedaje" name ="precio_hospedaje" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Cantidad por habitación </span>
            </div>
              <input type="number" id="cantidad_hospedaje" name ="cantidad_hospedaje" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Cantidad máxima ocupacion </span>
            </div>
              <input type="number" id="cantidad_maxima" name ="codigo" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Precio por adulto </span>
            </div>
              <input type="number" id="precio_adulto" name ="precio_adulto" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Precio por junior </span>
            </div>
              <input type="number" id="precio_junior" name ="precio_junior" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Precio por niño </span>
        </div>
          <input type="number" id="precio_infantil" name ="precio_infantil" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
        </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 215px; font-size: 16px;">Régimen Fiscal</label>
                </div>
            <select class="form-control" id="tipo" name = "tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $tarifa->mostrar_tipo();
              echo '
            </select>
            </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 215px; font-size: 16px;"> Leyenda de habitación </span>
        </div>
          <input type="text" id="leyenda" name ="leyenda" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" value="'.$leyenda.'">
        </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <div id="boton_tipo">
            <input type="button" class="btn btn-success btn-block" value="Guardar" onclick="guardar_tarifa()">
          </div>
        </div>
      </div>';
?>
