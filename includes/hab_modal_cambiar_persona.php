<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once("clase_hab.php");
  include_once("clase_movimiento.php");
  $usuario = NEW Usuario(0);
  $hab= NEW hab($_GET['hab_id']);
  $movimiento = NEW Movimiento(0);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-sm-12">';
            switch($_GET['estado']){
              case 3:// En habitacion limpieza-edo.3
                  echo '<h3>LIMPIEZA - Habitación '.$hab->nombre.'</h3>';
                  break;
              case 4:// En habitacion limpieza-edo.3 ////
                  echo '<h3>LIMPIEZA - Habitación '.$hab->nombre.'</h3>';
                  break;
              default:
                  //echo "Estado indefinido";
            }
          echo '</div>
          <div class="col-sm-12">
          Cambiar la recamarera que hara la limpieza:
          </div>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div><br>

      <div class="modal-body">';
        echo '<div class="row">';
          $usuario_actual= $movimiento->saber_persona_limpio($hab->mov);
          $usuario->select_cambiar_reca($_GET['hab_id'],$_GET['estado'],$usuario_actual);
        echo '</div>';
      echo '</div>

      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>
