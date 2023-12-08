<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_reservacion.php");
  $reservacion= NEW Reservacion($_GET['id']);
  $entrada = date('Y-m-d',$reservacion->fecha_entrada);
  $salida = date('Y-m-d',$reservacion->fecha_salida);
  $tipo_hab = $_GET['tipo_hab'];
  $numero_hab = $_GET['numero_hab'];
  $multiple="";
  // if($numero_hab>1){
  //   $multiple="multiple";
  // }

  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      Preasignar Reservación: '.$_GET['id']; 
      echo '<button type="button" class="btn btn-light" data-dismiss="modal">
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
         <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
      </svg>
   </button>
   </div>

    <div class="modal-body">
        <div class="inputs_form_container">
        <div class="form-floating input_container">
        <select class="form-select custom_input" placeholder="" id="preasignada" '.$multiple.'>';
        
       echo  $reservacion->comprobarFechaReserva($entrada,$salida,0,0,$tipo_hab)[1];
        echo '
        </select>
        <label for="categoria">Habitación</label>     
        </div>
        </div>
     
    
    <div class="modal-footer" id="boton_cancelar_reservacion">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button id="boton_cancelar_reservacion" type="button" class="btn btn-primary" onclick="guardar_preasignar_reservacion('.$_GET['id'].','.$_GET['opcion'].')"> Aceptar</button>
    </div>
    </div>
    </div>
  </div>';
?>
