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
                  echo '<h3>LIMPIEZA - Habitación '.$hab->nombre.'</h3>
                  </div>
                  <div class="col-sm-12">
                  Cambiar la recamarera que hara la limpieza:
                  </div>';
                  break;
              case 4:// En habitacion mantenimiento-edo.4
                  echo '<h3>MANTENIMIENTO - Habitación '.$hab->nombre.'</h3>
                  </div>
                  <div class="col-sm-12">
                  Cambiar el usuario que hara el mantenimiento:
                  </div>';
                  break;
              case 5:// En habitacion supervision-edo.5
                  echo '<h3>SUPERVISION - Habitación '.$hab->nombre.'</h3>
                  </div>
                  <div class="col-sm-12">
                  Cambiar el usuario que hara la supervision:
                  </div>';
                  break;
              default:
                  //echo "Estado indefinido";
                  break;
            }
        echo '</div>
        <button type="button" class="btn btn-light" data-dismiss="modal">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
        </svg>
      </button>
      </div>
      <div class="modal-body">';
        echo '<div class="row">';
          switch($_GET['estado']){
            case 3:// En habitacion limpieza-edo.3
                $usuario_actual= $movimiento->saber_persona_limpio($hab->mov);
                $usuario->select_cambiar_usuario($_GET['hab_id'],$_GET['estado'],$usuario_actual);
                break;
            case 4:// En habitacion mantenimiento-edo.4
                $usuario_actual= $movimiento->saber_detalle_realiza($hab->mov);
                $usuario->select_cambiar_usuario($_GET['hab_id'],$_GET['estado'],$usuario_actual);
                break;
            case 5:// En habitacion supervision-edo.5
                $usuario_actual= $movimiento->saber_detalle_realiza($hab->mov);
                $usuario->select_cambiar_usuario($_GET['hab_id'],$_GET['estado'],$usuario_actual);
                break;
            default:
                //echo "Estado indefinido";
                break;
          }
        echo '</div>';
      echo '</div>
      <div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>
