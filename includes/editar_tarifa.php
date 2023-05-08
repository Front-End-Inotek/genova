<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa($_GET['id']);
      echo '
      <!-- Modal -->
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_editar_tarifas">Editar tipo de habitacion </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Nombre </span>
                </div>
                  <input type="text" id="nombre" name ="nombre" value="'.$tarifa->nombre.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio </span>
                </div>
                  <input type="number" id="precio_hospedaje" name ="precio_hospedaje" value="'.$tarifa->precio_hospedaje.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>
    
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Cantidad habitación </span>
                </div>
                  <input type="number" id="cantidad_hospedaje" name ="cantidad_hospedaje" value="'.$tarifa->cantidad_hospedaje.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Cantidad máxima </span>
                </div>
                  <input type="number" id="cantidad_maxima" name ="cantidad_maxima" value="'.$tarifa->cantidad_maxima.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio adulto </span>
                </div>
                  <input type="number" id="precio_adulto" name ="precio_adulto" value="'.$tarifa->precio_adulto.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio junior </span>
                </div>
                  <input type="number" id="precio_junior" name ="precio_junior" value="'.$tarifa->precio_junior.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Precio infantil </span>
                </div>
                  <input type="number" id="precio_infantil" name ="precio_infantil" value="'.$tarifa->precio_infantil.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 200px; font-size: 16px;">Tipo de habitación</label>
                </div>
              <select class="form-control" id="tipo" name="tipo" class="form-control">
                <option value="0">Selecciona</option>';
                $tarifa->mostrar_tipo_editar($tarifa->tipo);
                echo '
              </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Leyenda de habitación </span>
                </div>
                  <input type="text" id="leyenda" name ="leyenda" value="'.$tarifa->leyenda.'" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="modificar_tarifa('.$_GET['id'].')">
            </div>
            </div>
          </div>';
?>
