<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_cargo_noche.php");
  $cargo_noche= NEW Cargo_noche(0);
  
  echo ' <div class="container blanco"> 
          <div class="col-sm-12 text-center"><h2 class="text-dark margen-1">CARGOS POR NOCHE</h2></div>
          <div class="row">
            <div class="col-sm-2">Fecha Inicial:</div>
            <div class="col-sm-3">
              <input class="form-control form-control" type="date"  id="inicial"  placeholder="Reservacion inicial" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">Fecha Final:</div>
            <div class="col-sm-3">
              <input class="form-control form-control" type="date" id="final" placeholder="Reservacion final" autofocus="autofocus"/>
            </div>
            <div class="col-sm-2">
              <button class="btn btn-success btn-block btn-default" onclick="busqueda_cargo_noche()">
                Buscar 
              </button>
            </div>
          </div><br>';
          $cargo_noche->mostrar($_GET['usuario_id']);
  echo '
         </div>';
?>
