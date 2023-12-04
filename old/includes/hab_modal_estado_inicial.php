<?php
  date_default_timezone_set('America/Mexico_City');
  include_once("clase_usuario.php");
  include_once("clase_hab.php");
  $usuario = NEW Usuario(0);
  $hab= NEW  hab($_GET['hab_id']);
  echo '
  <!-- Modal content-->
  <div class="modal-content">
      <div class="modal-header">
        <div class="row">
          <div class="col-sm-12">';
          switch($_GET['nuevo_estado']){
            case 2:// Enviar a limpieza 
              // echo $_GET['nuevo_estado'];
                echo '<h3>LIMPIEZA - Habitación '.$hab->nombre.'</h3>
                    </div>
                    <div class="col-sm-12">
                      Selecciona la recamarera que realizara la limpieza:
                    </div>
                  </div>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><br>

                <div class="modal-body">';
                  echo '<div class="row">';
                    $usuario->select_reca($_GET['hab_id'],$_GET['estado'],$_GET['nuevo_estado']);
                  echo '</div>
                </div>';
                break;
            case 9: case 4: // Enviar a mantenimiento 
                echo '<h3>MANTENIMIENTO - Habitación '.$hab->nombre.'</h3>
                    </div>
                    <div class="col-sm-12">
                      Selecciona quien realizara el mantenimiento:
                    </div>
                  </div>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><br>
          
                <div class="modal-body">';
                  echo '<div class="row">';
                    $usuario->select_reca($_GET['hab_id'],$_GET['estado'],$_GET['nuevo_estado']);
                  echo '</div>
                </div>';
                break;
            case 10: case 5:// Enviar a supervision 
                echo '<h3>SUPERVISION - Habitación '.$hab->nombre.'</h3>
                    </div>
                    <div class="col-sm-12">
                      Selecciona quien realizara la supervision:
                    </div>
                  </div>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div><br>
          
                <div class="modal-body">';
                  echo '<div class="row">';
                    $usuario->select_reca($_GET['hab_id'],$_GET['estado'],$_GET['nuevo_estado']);
                  echo '</div>
                </div>';
                break;
            default:
                //echo "Estado indefinido";
                echo '</div>
                   </div>
                </div>';
                break;
          }

      echo '<div class="modal-footer" id="boton_asignar_huesped">
        <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
      </div>
  </div>';
?>
