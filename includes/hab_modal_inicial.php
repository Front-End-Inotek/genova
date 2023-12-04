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
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div><br>';
          echo '<div class="modal-body">';
          echo '<div class="row">
            <div class="col-sm-2">Motivo:</div>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="motivo" placeholder="Ingresa el motivo del matenimiento" maxlength="50">
            </div>
          </div><br>
          </div>';
          echo '<div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
            <button type="button" class=" btn btn-success" onclick="hab_inicial('.$_GET['hab_id'].','.$_GET['estado'].','.$_GET['usuario'].')">Aceptar</button>
          </div>
      </div>';
        break;
    case 5:// Enviar a supervision
        $id = $movimiento->guardar_limpieza($_GET['hab_id'],$_GET['usuario_id'],$_GET['usuario']);
        $hab->cambiohab($_GET['hab_id'],$id,3);
        $logs->guardar_log($_GET['usuario_id'],"Limpieza en habitacion: ". $hab->nombre);
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
              <button type="button" class=" btn btn-success" onclick="hab_inicial('.$_GET['hab_id'].','.$estado.','.$_GET['usuario'].')">Aceptar</button>
            </div>
        </div>';
        break;
    default:
        //echo "Estado indefinido";
  }
?>
