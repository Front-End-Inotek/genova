<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab(0);
  echo '
<<<<<<< HEAD
      <div class="container blanco"> 
        <div class="col-sm-12 text-left"><h2 class="text-dark margen-1 ">AGREGAR HABITACION</h2></div>
        <div class="row">
          <div class="col-sm-3">Número:</div>
          <div class="col-sm-9">
          <div class="form-group">
            <input class="form-control" type="text"  id="nombre" placeholder="Ingresa el numero de la habitación" maxlength="90">
          </div>
          </div>
=======
   <!-- Modal -->
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregra tipo de habitacion </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
>>>>>>> a233a8b204c7f3ee7bf5bf9a9aeb06fd47bcf04a
        </div>
        <div class="modal-body">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Numero </span>
                </div>
                  <input type="text" id="nombre" name ="nombre" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01" style="width: 200px; font-size: 16px;">Tipo de habitación</label>
                </div>
            <select class="form-control" id="tipo" name = "tipo" class="form-control">
              <option value="0">Selecciona</option>';
              $hab->mostrar_hab();
              echo '
            </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="inputGroup-sizing-default"  style="width: 200px; font-size: 16px;"> Leyenda de habitación </span>
                </div>
                  <input type="text" id="comentario" name ="comentario" value="" class="form-control" aria-label="Default" autocomplete="off" aria-describedby="inputGroup-sizing-default" style="font-size: 16px;" >
            </div>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
              <div id="boton_tipo">
              <input type="submit" class="btn btn-success btn-block" value="Guardar" onclick="guardar_hab()">
            </div>
            </div>
          </div>';
?>