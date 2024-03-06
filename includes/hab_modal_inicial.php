<?php
	include_once("clase_movimiento.php");
  include_once("clase_usuario.php");
  include_once("clase_hab.php");
  include_once('clase_log.php');
  $movimiento = NEW Movimiento(0);
  $usuario = NEW Usuario($_GET['usuario']);
  $hab = NEW Hab($_GET['hab_id']);
  $logs = NEW Log(0);
  if($_GET['usuario'] == 0){
    $estado= 6;
  }else{
    $estado= $_GET['estado'];
  }
  /*if($_GET['estado']>0){
    $movimiento->editar_detalle_fin($hab->mov);
    $movimiento->editar_persona_limpio($hab->mov,$_GET['usuario']);
  }*/

  switch($estado){
    case 4:// Enviar a mantenimiento
      // if($_GET['estado']==4){
      //   $aux_estado = 9;
      // }else{
      //   $aux_estado = $_GET['estado'];
      // }
      echo '<!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
            <div class="row">
              <div class="col-sm-12">
                <h3>Asignar a Mantenimiento</h3>
              </div>
              <div class="col-sm-12">
                Selecciona el motivo por el cual  '.$usuario->usuario.' dara mantenimiento a la  habitación '.$hab->nombre.':
              </div>
            </div>
            <button type="button" class="btn btn-light" data-dismiss="modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
         </svg>
      </button>
      </div>';                
          echo '<div class="modal-body">';
          echo '<div class="row">
          <div class="inputs_form_container">
          <div class="form-floating input_container">
              <input type="text" class="form-control custom_input" id="motivo" placeholder="Ingresa el motivo del matenimiento" maxlength="50">
              <label for="motivo">Motivo</label>     
              </div>
          </div>
          </div>';
          echo '<div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
            <button type="button" class=" btn btn-primary" onclick="hab_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['usuario'].')">Aceptar</button>
          </div>
      </div>';
        break;
    case 0:// Enviar a bloqueo
          echo '<!-- Modal content-->
          <div class="modal-content">
              <div class="modal-header">
                <div class="row">
                  <div class="col-sm-12">
                    <h3>Asignar a Bloqueo</h3>
                  </div>
                  <div class="col-sm-12">
                    Selecciona el motivo por el bloqueo a la habitación '.$hab->nombre.':
                  </div>
                </div>
                <button type="button" class="btn btn-light" data-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
            </svg>
          </button>
          </div>';                
              echo '<div class="modal-body">';
              echo '<div class="row">
              <div class="inputs_form_container">
              <div class="form-floating input_container">
                  <input type="text" class="form-control custom_input" id="motivo" placeholder="Ingresa el motivo del matenimiento" maxlength="50">
                  <label for="motivo">Motivo del bloqueo</label>     
                  </div>
              </div>
              </div>';
              echo '<div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
                <button type="button" class=" btn btn-primary" onclick="hab_inicial('.$_GET['hab_id'].', 5,'.$_GET['usuario'].')">Aceptar</button>
              </div>
          </div>';
          break;
    case 6:// Enviar a cancelada
        echo '<!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
              <div class="row">
                <div class="col-sm-12">
                  <h3>Asignar a Cancelar</h3>
                </div>
                <div class="col-sm-12">
                  Selecciona el motivo por el cual se cancelara la habitación '.$hab->nombre.':
                </div>
              </div>
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div><br>';
            echo '<div class="modal-body">';
            echo '<div class="row">
              <div class="col-sm-2">Motivo:</div>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="motivo" placeholder="Ingresa el motivo de cancelar" maxlength="50">
              </div>
            </div><br>
            </div>';
            echo '<div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="hab_inicial('.$_GET['hab_id'].','.$estado.','.$_GET['usuario'].')">Aceptar</button>
            </div>
        </div>';
        break;
    default:
        //echo "Estado indefinido";
  }
?>
