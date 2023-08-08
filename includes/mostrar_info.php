<?php
include_once('clase_tipo.php');
$tipo = new Tipo(0);
$tipos = $tipo->obtener_tipos();

echo ' <div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title" id="exampleModalLabel">Informacion</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    &times;
  </button>
</div>
<div class="modal-body">
  <ul class="list-group mb-4">
      <li class="list-group-item fw-bolder">Tipos de habitaciones</li>';
      while ($fila = mysqli_fetch_array($tipos))
      {
      $color ="#".$fila['color'];

      echo '<li class="list-group-item" style="background-color: '.$color.'"><p style="color: '.$color.';  filter: invert(1) grayscale(100%); font-weight: 600;">'.$fila['nombre'].'</p></li>';
      }
  echo '
  </ul>
  <ul class="list-group mb-4">
      <li class="list-group-item fw-bolder">Estado de habitaciones</li>
      <li class="list-group-item InfoDisponible">Disponible limpia</li>
      <li class="list-group-item InfoLimpiezaVacia">Limpieza vacia</li>
      <li class="list-group-item InfoOcupadaLimpieza">Limpieza ocupada</li>
      <li class="list-group-item InfoOcupada">Ocupada</li>
      <li class="list-group-item InfoOcupadaSucia">Ocupada sucia</li>
      <li class="list-group-item InfoUsoCasa">Uso casa</li>
      <li class="list-group-item InfoBloqueado">Bloqueado</li>
      <li class="list-group-item InfoMantenimiento">Mantenimiento</li>
      <li class="list-group-item InfoReservaPagada">Reserva pagada</li>
      <li class="list-group-item InfoReservaPendiente">Reserva pendiente pago</li>
  </ul>
  <ul class="list-group mb-0">
      <li class="list-group-item fw-bolder">Estado de limpieza</li>
      <li class="list-group-item d-flex justify-content-between align-items-center" style="margin-bottom: 0;">
          Limpia
          <i class="bx bxs-brush-alt clean2"></i>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center" style="margin-bottom: 0;">
          En limpieza
          <i class="bx bxs-brush-alt cleaning2"></i>
      </li>
      <li class="list-group-item d-flex justify-content-between align-items-center" style="margin-bottom: 0;">
          Sucia
          <i class="bx bxs-brush-alt dirt2"></i>
      </li>
  </ul>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
</div>
</div>';