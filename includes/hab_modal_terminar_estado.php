<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_hab.php");
  $hab= NEW Hab($_GET['hab_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div><br>

    <div class="modal-body">';
        switch ($_GET['estado']) {
          case 2:// En habitacion sucia-edo.2 
              echo '¿Terminar estado sucia de la habitación '.$hab->nombre.'?';
              break;
          default:
              //echo "Estado indefinido";
        }
    echo '</div><br>
    
    <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      <button type="button" class="btn btn-success" onclick="hab_terminar('.$_GET['hab_id'].','.$_GET['estado'].')"> Aceptar</button>
    </div>
  </div>';
?>