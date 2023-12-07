<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  include_once("clase_reservacion.php");
  $hab= NEW Hab(0);
  $reservaciones = NEW Reservacion($_GET['id']);
  $tipo_hab= $reservaciones->tipo_hab;
  //new
  $tipo_hab = $reservaciones->obtenerTipoDesdeTarifa($tipo_hab);


  $disponible= $hab->consultar_disponibilidad($tipo_hab);
  $mov = 0;
  if(isset($_GET['mov']) && !empty($_GET['mov'])){
    $mov =$_GET['mov'];
  }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-sm-12">
          <h3>CHECK-IN</h3>
          </div>
          <div class="col-sm-12">
          Selecciona la habitación disponible para asignar la reservación '.$_GET['id'].':
          </div>
        </div>
        <button type="button" class="btn btn-light" data-dismiss="modal">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
          </svg>
        </button>
      </div>

      <div class="modal-body">';
        echo '<div class="contenedor_botones">';
          if($disponible == 0){
            echo '<div class="col-xs-12 col-sm-12 col-md-12 margen-1">';
              echo "¡No existe disponibilidad en ese tipo de habitación!";
            echo '</div>';
          }elseif($disponible < $_GET['numero_hab']){
            echo '<div class="col-xs-12 col-sm-12 col-md-12 margen-1">';
              echo "¡No existen ".$_GET['numero_hab']." habitaciones disponibles en ese tipo de habitación!";
            echo '</div>';
          }else{
            $hab->select_asignar_reservacion($tipo_hab,$_GET['id'],$_GET['numero_hab'],0,$mov);
          }
        echo '</div>';
      echo '</div>

      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>