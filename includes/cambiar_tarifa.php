<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_tarifa.php");
  $tarifa= NEW Tarifa(0);
  $adultos= $tarifa->mostrar_cantidad_hospedaje	($_GET['tarifa']);
  echo '
      <div class="container blanco">
          <div class="col-sm-2">Adultos:</div>
          <div class="col-sm-2 div_adultos">
          <div class="form-group">
            <input class="form-control" type="number"  id="adultos" placeholder='.$adultos.'>
          </div>
      </div>';
?>
