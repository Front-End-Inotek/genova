<?php
    include_once("clase_hab.php");
    include_once("clase_movimiento.php");
    $movimiento = NEW Movimiento(0);
    $id_hab = $_GET['hab_id'];
    $hab = NEW Hab($id_hab);

    echo '
    <div class="modal-content">
        <div class="modal-header">
            <h3>Reactivar ultimo huesped en la habitacion</h3>
            <button type="button" class="btn btn-light" data-dismiss="modal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z"></path>
                </svg>
            </button>
      </div>
      <div class="modal-body">
        <h4>¿Estas seguro de reactivar el ultimo huesped en esta habitacion?</h4>
        <p>Nombre de la habitación: '.$hab->nombre.'</p>
      </div>
      <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal"> Cancelar</button>
              <button type="button" class="btn btn-primary" onclick="reactivar_habitacion('.$id_hab.')">Aceptar</button>
        
      </div>
    </div>
    
    ';

?>